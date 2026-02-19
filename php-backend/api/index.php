<?php

// Session'ı başlat
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: http://localhost:8080');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Access-Control-Allow-Credentials: true');

// OPTIONS isteklerini handle et (CORS preflight)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/auth.php';

// Database bağlantısı
$database = new Database();
$db = $database->getConnection();

// Auth instance
$auth = new Auth($database);

// URL'yi parse et
$request_uri = $_SERVER['REQUEST_URI'];
$path = parse_url($request_uri, PHP_URL_PATH);
$path = str_replace('/api', '', $path);
$path_parts = explode('/', trim($path, '/'));

$method = $_SERVER['REQUEST_METHOD'];
$endpoint = $path_parts[0] ?? '';

// JSON input'u al
$input = json_decode(file_get_contents('php://input'), true) ?? [];

try {
    switch ($endpoint) {
        case 'auth':
            handleAuth($auth, $method, $path_parts, $input);
            break;
            
        case 'products':
            handleProducts($db, $auth, $method, $path_parts, $input);
            break;
            
        case 'cart':
            handleCart($db, $auth, $method, $path_parts, $input);
            break;
            
        case 'orders':
            handleOrders($db, $auth, $method, $path_parts, $input);
            break;
            
        case 'users':
            handleUsers($db, $auth, $method, $path_parts, $input);
            break;
            
        case 'shops':
            handleShops($db, $auth, $method, $path_parts, $input);
            break;
            
        case 'survey':
            handleSurvey($db, $auth, $method, $path_parts, $input);
            break;
            
        case 'pages':
            handlePages($db, $method, $path_parts, $input);
            break;
            
        case 'categories':
            handleCategories($db, $method, $path_parts, $input);
            break;
            
        case 'favorites':
            handleFavorites($db, $auth, $method, $path_parts, $input);
            break;
            
        case 'admin':
            handleAdmin($db, $auth, $method, $path_parts, $input);
            break;
            
        case 'merchant':
            handleMerchant($db, $auth, $method, $path_parts, $input);
            break;
            
        case 'student':
            handleStudent($db, $auth, $method, $path_parts, $input);
            break;
            
        case 'wallet':
            handleWallet($db, $auth, $method, $path_parts, $input);
            break;
            
        case 'upload':
            include __DIR__ . '/upload.php';
            break;
            
        case 'health':
            echo json_encode(['status' => 'healthy', 'timestamp' => date('Y-m-d H:i:s')]);
            break;
            
        default:
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Endpoint bulunamadı']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Sunucu hatası: ' . $e->getMessage()]);
}

// Auth endpoints
function handleAuth($auth, $method, $path_parts, $input) {
    $action = $path_parts[1] ?? '';
    
    switch ($method) {
        case 'POST':
            switch ($action) {
                case 'register':
                    $result = $auth->register(
                        $input['email'] ?? '',
                        $input['password'] ?? '',
                        $input['full_name'] ?? '',
                        $input['role'] ?? 'customer',
                        $input['phone'] ?? null
                    );
                    echo json_encode($result);
                    break;
                    
                case 'login':
                    $result = $auth->login($input['email'] ?? '', $input['password'] ?? '');
                    echo json_encode($result);
                    break;
                    
                case 'logout':
                    $result = $auth->logout();
                    echo json_encode($result);
                    break;
                    
                default:
                    http_response_code(404);
                    echo json_encode(['success' => false, 'message' => 'Auth action bulunamadı']);
            }
            break;
            
        case 'GET':
            if ($action === 'me') {
                $user = $auth->getCurrentUser();
                if ($user) {
                    echo json_encode(['success' => true, 'user' => $user]);
                } else {
                    http_response_code(401);
                    echo json_encode(['success' => false, 'message' => 'Giriş yapmalısınız']);
                }
            }
            break;
    }
}

// Products endpoints
function handleProducts($db, $auth, $method, $path_parts, $input) {
    switch ($method) {
        case 'GET':
            if (isset($path_parts[1]) && is_numeric($path_parts[1])) {
                // Tek ürün getir
                $product_id = $path_parts[1];
                $stmt = $db->prepare("
                    SELECT p.*, s.name as shop_name, s.address as shop_address,
                           u.full_name as student_name
                    FROM products p 
                    LEFT JOIN shops s ON p.shop_id = s.id 
                    LEFT JOIN users u ON p.student_id = u.id 
                    WHERE p.id = ? AND p.status = 'active'
                ");
                $stmt->execute([$product_id]);
                $product = $stmt->fetch();
                
                if ($product) {
                    // Images JSON'u parse et
                    $product['images'] = json_decode($product['images'] ?? '[]', true) ?: [];
                    $product['videos'] = json_decode($product['videos'] ?? '[]', true) ?: [];
                    $product['product_metadata'] = json_decode($product['product_metadata'] ?? '{}', true) ?: [];
                    
                    // Debug için log ekle
                    error_log('Product ID: ' . $product['id']);
                    error_log('Raw images: ' . ($product['images'] ? json_encode($product['images']) : 'NULL'));
                    
                    // Shop bilgilerini düzenle
                    $product['shop'] = [
                        'id' => $product['shop_id'] ?? 1,
                        'name' => $product['shop_name'] ?? 'Test Market',
                        'address' => $product['shop_address'] ?? '',
                        'phone' => '',
                        'owner_id' => 0,
                        'is_active' => true,
                        'created_at' => ''
                    ];
                    
                    echo json_encode(['success' => true, 'data' => $product]);
                } else {
                    http_response_code(404);
                    echo json_encode(['success' => false, 'message' => 'Ürün bulunamadı']);
                }
            } else {
                // Ürün listesi - Gelişmiş Filtreleme
                $limit = intval($_GET['limit'] ?? 20);
                $offset = intval($_GET['offset'] ?? 0);
                $search = $_GET['search'] ?? '';
                $category_id = $_GET['category'] ?? '';
                $min_price = $_GET['min_price'] ?? '';
                $max_price = $_GET['max_price'] ?? '';
                $sort_by = $_GET['sort'] ?? 'newest'; // newest, oldest, price_asc, price_desc, name_asc, name_desc
                $shop_id = $_GET['shop_id'] ?? '';
                
                $where_clause = "WHERE p.status = 'active'";
                $params = [];
                
                // Arama filtresi
                if ($search) {
                    $where_clause .= " AND (p.title LIKE ? OR p.description LIKE ?)";
                    $params[] = "%$search%";
                    $params[] = "%$search%";
                }
                
                // Kategori filtresi
                if ($category_id && is_numeric($category_id)) {
                    // Alt kategorileri de dahil et
                    $where_clause .= " AND (p.category_id = ? OR p.category_id IN (SELECT id FROM categories WHERE parent_id = ?))";
                    $params[] = $category_id;
                    $params[] = $category_id;
                }
                
                // Fiyat aralığı filtresi
                if ($min_price !== '' && is_numeric($min_price)) {
                    $where_clause .= " AND p.price >= ?";
                    $params[] = floatval($min_price);
                }
                
                if ($max_price !== '' && is_numeric($max_price)) {
                    $where_clause .= " AND p.price <= ?";
                    $params[] = floatval($max_price);
                }
                
                // Mağaza filtresi
                if ($shop_id && is_numeric($shop_id)) {
                    $where_clause .= " AND p.shop_id = ?";
                    $params[] = $shop_id;
                }
                
                // Sıralama
                $order_clause = match($sort_by) {
                    'oldest' => 'p.created_at ASC',
                    'price_asc' => 'p.price ASC',
                    'price_desc' => 'p.price DESC',
                    'name_asc' => 'p.title ASC',
                    'name_desc' => 'p.title DESC',
                    'popular' => 'p.stock DESC', // Stok fazla olan = popüler varsayalım
                    default => 'p.created_at DESC'
                };
                
                // Toplam ürün sayısını al (pagination için)
                $count_sql = "SELECT COUNT(*) FROM products p $where_clause";
                $count_stmt = $db->prepare($count_sql);
                $count_stmt->execute($params);
                $total_count = $count_stmt->fetchColumn();
                
                // Fiyat aralığını al (filtreleme UI için)
                $price_sql = "SELECT MIN(price) as min_price, MAX(price) as max_price FROM products WHERE status = 'active'";
                $price_stmt = $db->query($price_sql);
                $price_range = $price_stmt->fetch();
                
                $stmt = $db->prepare("
                    SELECT p.*, s.name as shop_name, s.id as shop_id,
                           u.full_name as student_name,
                           c.name as category_name, c.slug as category_slug
                    FROM products p 
                    LEFT JOIN shops s ON p.shop_id = s.id 
                    LEFT JOIN users u ON p.student_id = u.id 
                    LEFT JOIN categories c ON p.category_id = c.id
                    $where_clause
                    ORDER BY $order_clause 
                    LIMIT ? OFFSET ?
                ");
                
                $params[] = $limit;
                $params[] = $offset;
                $stmt->execute($params);
                $products = $stmt->fetchAll();
                
                // Her ürün için shop ve category objesini düzenle
                foreach ($products as &$product) {
                    $product['images'] = json_decode($product['images'] ?? '[]');
                    $product['videos'] = json_decode($product['videos'] ?? '[]');
                    $product['shop'] = [
                        'id' => $product['shop_id'],
                        'name' => $product['shop_name'],
                        'address' => '',
                        'phone' => '',
                        'owner_id' => 0,
                        'is_active' => true,
                        'created_at' => ''
                    ];
                    $product['category'] = [
                        'id' => $product['category_id'] ?? null,
                        'name' => $product['category_name'] ?? 'Genel',
                        'slug' => $product['category_slug'] ?? 'genel'
                    ];
                    // Gereksiz alanları temizle
                    unset($product['shop_name'], $product['shop_id'], $product['student_name'], $product['category_name'], $product['category_slug']);
                }
                
                echo json_encode([
                    'success' => true, 
                    'data' => $products,
                    'meta' => [
                        'total' => intval($total_count),
                        'limit' => $limit,
                        'offset' => $offset,
                        'has_more' => ($offset + $limit) < $total_count,
                        'price_range' => [
                            'min' => floatval($price_range['min_price'] ?? 0),
                            'max' => floatval($price_range['max_price'] ?? 1000)
                        ]
                    ]
                ]);
            }
            break;
            
        case 'POST':
            $user_id = $auth->requireAuth();
            
            // Ürün oluştur (onay bekliyor)
            $stmt = $db->prepare("
                INSERT INTO products (title, description, price, stock, status, student_id, shop_id, images, videos, product_metadata) 
                VALUES (?, ?, ?, ?, 'pending', ?, 1, ?, ?, ?)
            ");
            $stmt->execute([
                $input['title'] ?? '',
                $input['description'] ?? '',
                $input['price'] ?? 0,
                $input['stock'] ?? 0,
                $user_id,
                json_encode($input['images'] ?? []),
                json_encode($input['videos'] ?? []),
                json_encode($input['metadata'] ?? [])
            ]);
            
            $product_id = $db->lastInsertId();
            
            echo json_encode(['success' => true, 'id' => $product_id]);
            break;
    }
}

// Cart endpoints
function handleCart($db, $auth, $method, $path_parts, $input) {
    $user_id = $auth->requireAuth();
    
    switch ($method) {
        case 'GET':
            // Kullanıcının sepetini getir
            $stmt = $db->prepare("
                SELECT ci.*, p.title, p.price, p.images, p.stock,
                       s.name as shop_name
                FROM cart_items ci
                JOIN carts c ON ci.cart_id = c.id
                JOIN products p ON ci.product_id = p.id
                LEFT JOIN shops s ON p.shop_id = s.id
                WHERE c.user_id = ?
                ORDER BY ci.created_at DESC
            ");
            $stmt->execute([$user_id]);
            $items = $stmt->fetchAll();
            
            foreach ($items as &$item) {
                $item['images'] = json_decode($item['images'] ?? '[]');
            }
            
            echo json_encode(['success' => true, 'data' => $items]);
            break;
            
        case 'POST':
            // Sepete ürün ekle
            $product_id = $input['product_id'] ?? 0;
            $quantity = $input['quantity'] ?? 1;
            $donation_percentage = $input['student_donation_percentage'] ?? 0.0;
            

            
            // Ürün kontrolü
            $stmt = $db->prepare("SELECT * FROM products WHERE id = ? AND status = 'active'");
            $stmt->execute([$product_id]);
            $product = $stmt->fetch();
            
            if (!$product) {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Ürün bulunamadı veya aktif değil']);
                break;
            }
            
            // Stok kontrolü
            if ($product['stock'] < $quantity) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Yetersiz stok']);
                break;
            }
            
            // Kullanıcının sepetini bul veya oluştur
            $stmt = $db->prepare("SELECT id FROM carts WHERE user_id = ?");
            $stmt->execute([$user_id]);
            $cart = $stmt->fetch();
            
            if (!$cart) {
                $stmt = $db->prepare("INSERT INTO carts (user_id) VALUES (?)");
                $stmt->execute([$user_id]);
                $cart_id = $db->lastInsertId();
            } else {
                $cart_id = $cart['id'];
            }
            
            // Ürün zaten sepette var mı kontrol et
            $stmt = $db->prepare("SELECT id, quantity FROM cart_items WHERE cart_id = ? AND product_id = ?");
            $stmt->execute([$cart_id, $product_id]);
            $existing_item = $stmt->fetch();
            
            if ($existing_item) {
                // Mevcut ürünün miktarını güncelle
                $new_quantity = $existing_item['quantity'] + $quantity;
                
                // Stok kontrolü
                if ($product['stock'] < $new_quantity) {
                    http_response_code(400);
                    echo json_encode(['success' => false, 'message' => 'Toplam miktar için yetersiz stok']);
                    break;
                }
                
                $stmt = $db->prepare("UPDATE cart_items SET quantity = ?, student_donation_percentage = ? WHERE id = ?");
                $stmt->execute([$new_quantity, $donation_percentage, $existing_item['id']]);
            } else {
                // Yeni ürün ekle
                $stmt = $db->prepare("INSERT INTO cart_items (cart_id, product_id, quantity, student_donation_percentage) VALUES (?, ?, ?, ?)");
                $stmt->execute([$cart_id, $product_id, $quantity, $donation_percentage]);
            }
            
            echo json_encode(['success' => true, 'message' => 'Ürün sepete eklendi']);
            break;
            
        case 'PUT':
            if (isset($path_parts[1])) {
                $item_id = $path_parts[1];
                
                // Kullanıcının sepet itemı mı kontrol et
                $stmt = $db->prepare("
                    SELECT ci.id FROM cart_items ci
                    JOIN carts c ON ci.cart_id = c.id
                    WHERE ci.id = ? AND c.user_id = ?
                ");
                $stmt->execute([$item_id, $user_id]);
                
                if ($stmt->fetch()) {
                    // Güncellenecek alanları al
                    $quantity = $input['quantity'] ?? null;
                    $donation_percentage = $input['student_donation_percentage'] ?? null;
                    
                    $updates = [];
                    $params = [];
                    
                    if ($quantity !== null) {
                        $updates[] = "quantity = ?";
                        $params[] = intval($quantity);
                    }
                    
                    if ($donation_percentage !== null) {
                        $updates[] = "student_donation_percentage = ?";
                        $params[] = floatval($donation_percentage);
                    }
                    
                    if (!empty($updates)) {
                        $params[] = $item_id;
                        $sql = "UPDATE cart_items SET " . implode(", ", $updates) . " WHERE id = ?";
                        $stmt = $db->prepare($sql);
                        $stmt->execute($params);
                    }
                    
                    echo json_encode(['success' => true, 'message' => 'Sepet güncellendi']);
                } else {
                    http_response_code(404);
                    echo json_encode(['success' => false, 'message' => 'Ürün bulunamadı']);
                }
            }
            break;
            
        case 'DELETE':
            if (isset($path_parts[1])) {
                $item_id = $path_parts[1];
                
                // Kullanıcının sepet itemı mı kontrol et
                $stmt = $db->prepare("
                    SELECT ci.id FROM cart_items ci
                    JOIN carts c ON ci.cart_id = c.id
                    WHERE ci.id = ? AND c.user_id = ?
                ");
                $stmt->execute([$item_id, $user_id]);
                
                if ($stmt->fetch()) {
                    $stmt = $db->prepare("DELETE FROM cart_items WHERE id = ?");
                    $stmt->execute([$item_id]);
                    echo json_encode(['success' => true, 'message' => 'Ürün sepetten kaldırıldı']);
                } else {
                    http_response_code(404);
                    echo json_encode(['success' => false, 'message' => 'Ürün bulunamadı']);
                }
            }
            break;
    }
}

// Orders endpoints
function handleOrders($db, $auth, $method, $path_parts, $input) {
    $user_id = $auth->requireAuth();
    
    switch ($method) {
        case 'GET':
            // Tek sipariş detayı getir
            if (isset($path_parts[1]) && is_numeric($path_parts[1])) {
                $order_id = $path_parts[1];
                
                // Siparişi getir
                $stmt = $db->prepare("
                    SELECT o.*, u.full_name as customer_name, u.email as customer_email, u.phone as customer_phone
                    FROM orders o
                    LEFT JOIN users u ON o.customer_id = u.id
                    WHERE o.id = ? AND o.customer_id = ?
                ");
                $stmt->execute([$order_id, $user_id]);
                $order = $stmt->fetch();
                
                if (!$order) {
                    http_response_code(404);
                    echo json_encode(['success' => false, 'message' => 'Sipariş bulunamadı']);
                    break;
                }
                
                // Sipariş ürünlerini getir
                $stmt = $db->prepare("
                    SELECT oi.*, p.title, p.images, p.description,
                           s.name as shop_name, s.id as shop_id,
                           st.full_name as student_name
                    FROM order_items oi
                    LEFT JOIN products p ON oi.product_id = p.id
                    LEFT JOIN shops s ON p.shop_id = s.id
                    LEFT JOIN users st ON p.student_id = st.id
                    WHERE oi.order_id = ?
                ");
                $stmt->execute([$order_id]);
                $items = $stmt->fetchAll();
                
                foreach ($items as &$item) {
                    $item['images'] = json_decode($item['images'] ?? '[]');
                }
                
                // Öğrenci bağışlarını getir
                $stmt = $db->prepare("
                    SELECT sd.*, p.title as product_title
                    FROM student_donations sd
                    LEFT JOIN products p ON sd.product_id = p.id
                    WHERE sd.order_id = ?
                ");
                $stmt->execute([$order_id]);
                $donations = $stmt->fetchAll();
                
                // Toplam bağış hesapla
                $total_donation = 0;
                foreach ($donations as $donation) {
                    $total_donation += floatval($donation['donation_amount']);
                }
                
                // Sipariş detayını döndür
                $order_detail = [
                    'id' => $order['id'],
                    'order_number' => $order['order_number'],
                    'status' => $order['status'],
                    'subtotal' => floatval($order['subtotal']),
                    'tax_amount' => floatval($order['tax_amount'] ?? 0),
                    'shipping_fee' => floatval($order['shipping_fee'] ?? 0),
                    'total_amount' => floatval($order['total_amount']),
                    'student_support_total' => $total_donation,
                    'payment_method' => $order['payment_method'],
                    'payment_id' => $order['payment_id'],
                    'tracking_number' => $order['tracking_number'],
                    'shipping_address' => json_decode($order['shipping_address'] ?? '{}', true),
                    'billing_address' => json_decode($order['billing_address'] ?? '{}', true),
                    'created_at' => $order['created_at'],
                    'shipped_at' => $order['shipped_at'],
                    'delivered_at' => $order['delivered_at'],
                    'customer' => [
                        'name' => $order['customer_name'],
                        'email' => $order['customer_email'],
                        'phone' => $order['customer_phone']
                    ],
                    'items' => $items,
                    'donations' => $donations
                ];
                
                echo json_encode(['success' => true, 'data' => $order_detail]);
                break;
            }
            
            // Tüm siparişleri listele
            $stmt = $db->prepare("
                SELECT o.*, oi.product_id, oi.quantity, oi.unit_price, oi.total_price,
                       p.title as product_title, p.images as product_images
                FROM orders o
                LEFT JOIN order_items oi ON o.id = oi.order_id
                LEFT JOIN products p ON oi.product_id = p.id
                WHERE o.customer_id = ?
                ORDER BY o.created_at DESC
            ");
            $stmt->execute([$user_id]);
            $results = $stmt->fetchAll();
            
            // Her sipariş için öğrenci bağışlarını getir
            $order_donations = [];
            $stmt = $db->prepare("
                SELECT sd.order_id, SUM(sd.donation_amount) as total_donation
                FROM student_donations sd
                JOIN orders o ON sd.order_id = o.id
                WHERE o.customer_id = ?
                GROUP BY sd.order_id
            ");
            $stmt->execute([$user_id]);
            $donation_results = $stmt->fetchAll();
            foreach ($donation_results as $dr) {
                $order_donations[$dr['order_id']] = floatval($dr['total_donation']);
            }
            
            // Siparişleri grupla
            $orders = [];
            foreach ($results as $row) {
                $order_id = $row['id'];
                if (!isset($orders[$order_id])) {
                    $orders[$order_id] = [
                        'id' => $row['id'],
                        'order_number' => $row['order_number'],
                        'status' => $row['status'],
                        'subtotal' => floatval($row['subtotal'] ?? 0),
                        'total_amount' => floatval($row['total_amount']),
                        'student_support_total' => $order_donations[$order_id] ?? 0,
                        'payment_method' => $row['payment_method'],
                        'tracking_number' => $row['tracking_number'],
                        'created_at' => $row['created_at'],
                        'shipped_at' => $row['shipped_at'],
                        'delivered_at' => $row['delivered_at'],
                        'items' => []
                    ];
                }
                
                if ($row['product_id']) {
                    $orders[$order_id]['items'][] = [
                        'product_id' => $row['product_id'],
                        'title' => $row['product_title'],
                        'quantity' => $row['quantity'],
                        'unit_price' => $row['unit_price'],
                        'total_price' => $row['total_price'],
                        'images' => json_decode($row['product_images'] ?? '[]')
                    ];
                }
            }
            
            echo json_encode(['success' => true, 'data' => array_values($orders)]);
            break;
            
        case 'POST':
            // Özel endpoint kontrolü
            if (isset($path_parts[1]) && $path_parts[1] === 'update-status') {
                // Sipariş durumu güncelleme (esnaf için)
                $current_user = $auth->getCurrentUser();
                
                $order_id = $input['order_id'] ?? null;
                $new_status = $input['status'] ?? null;
                
                if (!$order_id || !$new_status) {
                    http_response_code(400);
                    echo json_encode(['success' => false, 'message' => 'Eksik parametreler']);
                    break;
                }
                
                // Esnaf mı kontrol et
                if ($current_user['role'] !== 'merchant') {
                    http_response_code(403);
                    echo json_encode(['success' => false, 'message' => 'Yetkiniz yok']);
                    break;
                }
                
                // Sipariş güncelle
                $stmt = $db->prepare("UPDATE orders SET status = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
                $stmt->execute([$new_status, $order_id]);
                
                // Eğer 'shipped' ise shipped_at güncelle
                if ($new_status === 'shipped') {
                    $stmt = $db->prepare("UPDATE orders SET shipped_at = CURRENT_TIMESTAMP WHERE id = ?");
                    $stmt->execute([$order_id]);
                }
                
                // Eğer 'delivered' ise delivered_at güncelle
                if ($new_status === 'delivered') {
                    $stmt = $db->prepare("UPDATE orders SET delivered_at = CURRENT_TIMESTAMP WHERE id = ?");
                    $stmt->execute([$order_id]);
                }
                
                echo json_encode(['success' => true, 'message' => 'Sipariş durumu güncellendi']);
                break;
            } elseif (isset($path_parts[1]) && $path_parts[1] === 'cancel') {
                // Sipariş iptali (esnaf için)
                $current_user = $auth->getCurrentUser();
                
                $order_id = $input['order_id'] ?? null;
                
                if (!$order_id) {
                    http_response_code(400);
                    echo json_encode(['success' => false, 'message' => 'Sipariş ID gerekli']);
                    break;
                }
                
                // Esnaf veya müşteri kontrolü
                if ($current_user['role'] !== 'merchant' && $current_user['role'] !== 'customer') {
                    http_response_code(403);
                    echo json_encode(['success' => false, 'message' => 'Yetkiniz yok']);
                    break;
                }
                
                // Siparişin iptal edilebilir durumda olup olmadığını kontrol et
                $stmt = $db->prepare("SELECT * FROM orders WHERE id = ? AND status IN ('pending', 'paid')");
                $stmt->execute([$order_id]);
                $order = $stmt->fetch();
                
                if (!$order) {
                    http_response_code(404);
                    echo json_encode(['success' => false, 'message' => 'Sipariş bulunamadı veya iptal edilemez']);
                    break;
                }
                
                // Siparişi iptal et
                $stmt = $db->prepare("UPDATE orders SET status = 'cancelled', updated_at = CURRENT_TIMESTAMP WHERE id = ?");
                $stmt->execute([$order_id]);
                
                // Stokları geri ekle
                $stmt = $db->prepare("
                    SELECT oi.product_id, oi.quantity 
                    FROM order_items oi 
                    WHERE oi.order_id = ?
                ");
                $stmt->execute([$order_id]);
                $order_items = $stmt->fetchAll();
                
                foreach ($order_items as $item) {
                    $stmt = $db->prepare("UPDATE products SET stock = stock + ? WHERE id = ?");
                    $stmt->execute([$item['quantity'], $item['product_id']]);
                }
                
                echo json_encode(['success' => true, 'message' => 'Sipariş iptal edildi ve stoklar geri eklendi']);
                break;
            }
            
            // Sipariş oluştur (varsayılan POST işlemi)
            $order_number = 'ORD-' . time() . '-' . $user_id;
            
            // Önce sepet itemlarını kontrol et
            $stmt = $db->prepare("
                SELECT ci.*, p.title, p.price, p.stock
                FROM cart_items ci
                JOIN carts c ON ci.cart_id = c.id
                JOIN products p ON ci.product_id = p.id
                WHERE c.user_id = ?
            ");
            $stmt->execute([$user_id]);
            $cart_items = $stmt->fetchAll();
            
            if (empty($cart_items)) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Sepetiniz boş']);
                break;
            }
            
            // Stok kontrolü
            foreach ($cart_items as $item) {
                if ($item['stock'] < $item['quantity']) {
                    http_response_code(400);
                    echo json_encode(['success' => false, 'message' => $item['title'] . ' için yetersiz stok']);
                    break 2;
                }
            }
            
            // Toplam hesapla
            $subtotal = 0;
            foreach ($cart_items as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }
            
            // Öğrenci desteği hesapla: %10 doğal kazanç + ekstra destek yüzdesi
            $donation_amount = 0;
            foreach ($cart_items as $item) {
                $item_total = $item['price'] * $item['quantity'];
                $natural_support = $item_total * 0.10; // %10 doğal kazanç
                $extra_support = $item_total * ($item['student_donation_percentage'] ?? 0) / 100;
                $donation_amount += $natural_support + $extra_support;
            }
            
            $total_amount = $subtotal + $donation_amount;
            
            // Sipariş oluştur
            $stmt = $db->prepare("
                INSERT INTO orders (order_number, customer_id, subtotal, total_amount, status, payment_method, payment_id, shipping_address, billing_address) 
                VALUES (?, ?, ?, ?, 'pending', ?, ?, ?, ?)
            ");
            $stmt->execute([
                $order_number,
                $user_id,
                $subtotal,
                $total_amount,
                $input['payment_method'] ?? 'bank_transfer',
                $input['payment_proof'] ?? null,
                json_encode($input['shipping_address'] ?? []),
                json_encode($input['billing_address'] ?? [])
            ]);
            
            $order_id = $db->lastInsertId();
            
            // Sepet itemlarını sipariş itemlarına dönüştür ve stok düş
            foreach ($cart_items as $item) {
                $stmt = $db->prepare("
                    INSERT INTO order_items (order_id, product_id, quantity, unit_price, total_price, product_snapshot) 
                    VALUES (?, ?, ?, ?, ?, ?)
                ");
                $stmt->execute([
                    $order_id,
                    $item['product_id'],
                    $item['quantity'],
                    $item['price'],
                    $item['price'] * $item['quantity'],
                    json_encode(['title' => $item['title'], 'price' => $item['price']])
                ]);
                
                // Stok düş (otomatik)
                $stmt = $db->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
                $stmt->execute([$item['quantity'], $item['product_id']]);
                
                // Öğrenci bağışını kaydet (%10 doğal + ekstra destek)
                $item_total = $item['price'] * $item['quantity'];
                $natural_support = $item_total * 0.10; // %10 doğal kazanç
                $extra_percentage = $item['student_donation_percentage'] ?? 0;
                $extra_support = $item_total * $extra_percentage / 100;
                $total_donation = $natural_support + $extra_support;
                
                // Toplam destek yüzdesi: 10% + ekstra
                $total_percentage = 10 + $extra_percentage;
                
                $stmt = $db->prepare("
                    INSERT INTO student_donations (order_id, product_id, donation_percentage, donation_amount) 
                    VALUES (?, ?, ?, ?)
                ");
                $stmt->execute([
                    $order_id,
                    $item['product_id'],
                    $total_percentage,
                    $total_donation
                ]);
            }
            
            // Sepeti temizle
            $stmt = $db->prepare("DELETE FROM cart_items WHERE cart_id IN (SELECT id FROM carts WHERE user_id = ?)");
            $stmt->execute([$user_id]);
            
            echo json_encode(['success' => true, 'order_id' => $order_id, 'order_number' => $order_number]);
            break;
            
        case 'PUT':
            if (isset($path_parts[1]) && isset($path_parts[2]) && $path_parts[2] === 'cancel') {
                $order_id = $path_parts[1];
                
                // Kullanıcının siparişi mi kontrol et
                $stmt = $db->prepare("SELECT * FROM orders WHERE id = ? AND customer_id = ? AND status = 'pending'");
                $stmt->execute([$order_id, $user_id]);
                $order = $stmt->fetch();
                
                if (!$order) {
                    http_response_code(404);
                    echo json_encode(['success' => false, 'message' => 'Sipariş bulunamadı veya iptal edilemez']);
                    break;
                }
                
                // Siparişi iptal et
                $stmt = $db->prepare("UPDATE orders SET status = 'cancelled' WHERE id = ?");
                $stmt->execute([$order_id]);
                
                // İptal edilen sipariş için stokları geri ekle
                $stmt = $db->prepare("
                    SELECT oi.product_id, oi.quantity 
                    FROM order_items oi 
                    WHERE oi.order_id = ?
                ");
                $stmt->execute([$order_id]);
                $order_items = $stmt->fetchAll();
                
                foreach ($order_items as $item) {
                    $stmt = $db->prepare("UPDATE products SET stock = stock + ? WHERE id = ?");
                    $stmt->execute([$item['quantity'], $item['product_id']]);
                }
                
                echo json_encode(['success' => true, 'message' => 'Sipariş iptal edildi ve stoklar geri eklendi']);
            } elseif (isset($path_parts[1]) && $path_parts[1] === 'update-status') {
                // Sipariş durumu güncelleme (esnaf için)
                $current_user = $auth->getCurrentUser();
                
                $order_id = $input['order_id'] ?? null;
                $new_status = $input['status'] ?? null;
                
                if (!$order_id || !$new_status) {
                    http_response_code(400);
                    echo json_encode(['success' => false, 'message' => 'Eksik parametreler']);
                    break;
                }
                
                // Esnaf mı kontrol et
                if ($current_user['role'] !== 'merchant') {
                    http_response_code(403);
                    echo json_encode(['success' => false, 'message' => 'Yetkiniz yok']);
                    break;
                }
                
                // Sipariş güncelle
                $stmt = $db->prepare("UPDATE orders SET status = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
                $stmt->execute([$new_status, $order_id]);
                
                // Eğer 'shipped' ise shipped_at güncelle
                if ($new_status === 'shipped') {
                    $stmt = $db->prepare("UPDATE orders SET shipped_at = CURRENT_TIMESTAMP WHERE id = ?");
                    $stmt->execute([$order_id]);
                }
                
                // Eğer 'delivered' ise delivered_at güncelle
                if ($new_status === 'delivered') {
                    $stmt = $db->prepare("UPDATE orders SET delivered_at = CURRENT_TIMESTAMP WHERE id = ?");
                    $stmt->execute([$order_id]);
                }
                
                echo json_encode(['success' => true, 'message' => 'Sipariş durumu güncellendi']);
            } elseif (isset($path_parts[1]) && $path_parts[1] === 'cancel') {
                // Sipariş iptali (esnaf için - POST olarak da çalışabilir)
                $current_user = $auth->getCurrentUser();
                
                $order_id = $input['order_id'] ?? null;
                
                if (!$order_id) {
                    http_response_code(400);
                    echo json_encode(['success' => false, 'message' => 'Sipariş ID gerekli']);
                    break;
                }
                
                // Esnaf mı kontrol et
                if ($current_user['role'] !== 'merchant') {
                    http_response_code(403);
                    echo json_encode(['success' => false, 'message' => 'Yetkiniz yok']);
                    break;
                }
                
                // Siparişin iptal edilebilir durumda olup olmadığını kontrol et
                $stmt = $db->prepare("SELECT * FROM orders WHERE id = ? AND status IN ('pending', 'paid')");
                $stmt->execute([$order_id]);
                $order = $stmt->fetch();
                
                if (!$order) {
                    http_response_code(404);
                    echo json_encode(['success' => false, 'message' => 'Sipariş bulunamadı veya iptal edilemez']);
                    break;
                }
                
                // Siparişi iptal et
                $stmt = $db->prepare("UPDATE orders SET status = 'cancelled', updated_at = CURRENT_TIMESTAMP WHERE id = ?");
                $stmt->execute([$order_id]);
                
                // Stokları geri ekle
                $stmt = $db->prepare("
                    SELECT oi.product_id, oi.quantity 
                    FROM order_items oi 
                    WHERE oi.order_id = ?
                ");
                $stmt->execute([$order_id]);
                $order_items = $stmt->fetchAll();
                
                foreach ($order_items as $item) {
                    $stmt = $db->prepare("UPDATE products SET stock = stock + ? WHERE id = ?");
                    $stmt->execute([$item['quantity'], $item['product_id']]);
                }
                
                echo json_encode(['success' => true, 'message' => 'Sipariş iptal edildi ve stoklar geri eklendi']);
            }
            break;
    }
}

// Users endpoints
function handleUsers($db, $auth, $method, $path_parts, $input) {
    $user_id = $auth->requireAuth();
    
    switch ($method) {
        case 'PUT':
            if ($path_parts[1] === 'profile') {
                $result = $auth->updateProfile($user_id, $input);
                echo json_encode($result);
            }
            break;
    }
}

// Shops endpoints
function handleShops($db, $auth, $method, $path_parts, $input) {
    switch ($method) {
        case 'GET':
            if (isset($path_parts[1]) && is_numeric($path_parts[1])) {
                // Tek mağaza getir
                $shop_id = $path_parts[1];
                $stmt = $db->prepare("
                    SELECT s.*, u.full_name as owner_name
                    FROM shops s 
                    LEFT JOIN users u ON s.owner_id = u.id 
                    WHERE s.id = ? AND s.is_active = 1
                ");
                $stmt->execute([$shop_id]);
                $shop = $stmt->fetch();
                
                if ($shop) {
                    // Mağaza ürünlerini getir
                    $stmt = $db->prepare("
                        SELECT * FROM products 
                        WHERE shop_id = ? AND status = 'active' 
                        ORDER BY created_at DESC
                    ");
                    $stmt->execute([$shop_id]);
                    $products = $stmt->fetchAll();
                    
                    foreach ($products as &$product) {
                        $product['images'] = json_decode($product['images'] ?? '[]');
                    }
                    
                    $shop['products'] = $products;
                    
                    echo json_encode(['success' => true, 'data' => $shop]);
                } else {
                    http_response_code(404);
                    echo json_encode(['success' => false, 'message' => 'Mağaza bulunamadı']);
                }
            } else {
                // Mağaza listesi
                $stmt = $db->prepare("
                    SELECT s.*, u.full_name as owner_name,
                           COUNT(p.id) as product_count
                    FROM shops s 
                    LEFT JOIN users u ON s.owner_id = u.id 
                    LEFT JOIN products p ON s.id = p.shop_id AND p.status = 'active'
                    WHERE s.is_active = 1
                    GROUP BY s.id
                    ORDER BY s.created_at DESC
                ");
                $stmt->execute();
                $shops = $stmt->fetchAll();
                
                echo json_encode(['success' => true, 'data' => $shops]);
            }
            break;
    }
}

// Survey endpoints
function handleSurvey($db, $auth, $method, $path_parts, $input) {
    switch ($method) {
        case 'GET':
            if (isset($path_parts[1])) {
                switch ($path_parts[1]) {
                    case 'stats':
                        // Admin kontrolü
                        $auth->requireRole('admin');
                        
                        // Anket istatistikleri
                        $stmt = $db->prepare("
                            SELECT 
                                COUNT(*) as total_responses,
                                SUM(CASE WHEN is_student = 1 THEN 1 ELSE 0 END) as student_responses,
                                SUM(CASE WHEN is_student = 0 THEN 1 ELSE 0 END) as non_student_responses,
                                SUM(CASE WHEN is_student = 1 AND is_interested = 1 THEN 1 ELSE 0 END) as interested_students,
                                SUM(CASE WHEN is_student = 1 AND is_interested = 0 THEN 1 ELSE 0 END) as not_interested_students
                            FROM survey_responses
                        ");
                        $stmt->execute();
                        $stats = $stmt->fetch();
                        
                        // Dönüşüm oranını hesapla
                        $conversion_rate = 0;
                        if ($stats['student_responses'] > 0) {
                            $conversion_rate = ($stats['interested_students'] / $stats['student_responses']) * 100;
                        }
                        $stats['conversion_rate'] = $conversion_rate;
                        
                        echo json_encode(['success' => true, 'data' => $stats]);
                        break;
                        
                    case 'responses':
                        // Admin kontrolü
                        $auth->requireRole('admin');
                        
                        // Detaylı yanıtlar
                        $stmt = $db->prepare("
                            SELECT sr.*, u.full_name as user_name, u.email as user_email, u.role as user_role
                            FROM survey_responses sr
                            JOIN users u ON sr.user_id = u.id
                            ORDER BY sr.created_at DESC
                        ");
                        $stmt->execute();
                        $responses = $stmt->fetchAll();
                        
                        echo json_encode(['success' => true, 'data' => $responses]);
                        break;
                        
                    default:
                        // Aktif anketi getir
                        $stmt = $db->prepare("SELECT * FROM surveys WHERE is_active = 1 ORDER BY created_at DESC LIMIT 1");
                        $stmt->execute();
                        $survey = $stmt->fetch();
                        
                        if ($survey) {
                            echo json_encode(['success' => true, 'data' => $survey]);
                        } else {
                            echo json_encode(['success' => false, 'message' => 'Aktif anket bulunamadı']);
                        }
                }
            } else {
                // Aktif anketi getir
                $stmt = $db->prepare("SELECT * FROM surveys WHERE is_active = 1 ORDER BY created_at DESC LIMIT 1");
                $stmt->execute();
                $survey = $stmt->fetch();
                
                if ($survey) {
                    echo json_encode(['success' => true, 'data' => $survey]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Aktif anket bulunamadı']);
                }
            }
            break;
            
        case 'POST':
            $user_id = $auth->requireAuth();
            
            // Daha önce cevap vermiş mi kontrol et
            $stmt = $db->prepare("SELECT id FROM survey_responses WHERE user_id = ?");
            $stmt->execute([$user_id]);
            if ($stmt->fetch()) {
                echo json_encode(['success' => false, 'message' => 'Bu anketi zaten yanıtladınız']);
                break;
            }
            
            // Anket cevabı kaydet
            $stmt = $db->prepare("
                INSERT INTO survey_responses (survey_id, user_id, is_student, is_interested) 
                VALUES (?, ?, ?, ?)
            ");
            $stmt->execute([
                $input['survey_id'] ?? 1,
                $user_id,
                $input['is_student'] ?? false,
                $input['is_interested'] ?? null
            ]);
            
            echo json_encode(['success' => true, 'message' => 'Anket cevabınız kaydedildi']);
            break;
    }
}

// Pages endpoints
function handlePages($db, $method, $path_parts, $input) {
    if ($method === 'GET' && isset($path_parts[1])) {
        $page_key = $path_parts[1];
        
        $stmt = $db->prepare("SELECT * FROM static_pages WHERE page_key = ?");
        $stmt->execute([$page_key]);
        $page = $stmt->fetch();
        
        if ($page) {
            echo json_encode(['success' => true, 'data' => $page]);
        } else {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Sayfa bulunamadı']);
        }
    }
}

// Favorites endpoints
function handleFavorites($db, $auth, $method, $path_parts, $input) {
    $user_id = $auth->requireAuth();
    
    switch ($method) {
        case 'GET':
            $stmt = $db->prepare("
                SELECT f.id as favorite_id, f.product_id, f.created_at as favorited_at,
                       p.title, p.description, p.price, p.images, p.status,
                       s.id as shop_id, s.name as shop_name
                FROM favorites f
                JOIN products p ON f.product_id = p.id
                LEFT JOIN shops s ON p.shop_id = s.id
                WHERE f.user_id = ?
                ORDER BY f.created_at DESC
            ");
            $stmt->execute([$user_id]);
            $favorites = $stmt->fetchAll();
            
            foreach ($favorites as &$favorite) {
                $favorite['images'] = json_decode($favorite['images'] ?? '[]', true);
                $favorite['shop'] = [
                    'id' => $favorite['shop_id'],
                    'name' => $favorite['shop_name']
                ];
            }
            
            echo json_encode(['success' => true, 'data' => $favorites]);
            break;
            
        case 'POST':
            if (isset($path_parts[1])) {
                $product_id = $path_parts[1];
                
                // Check if already favorited
                $stmt = $db->prepare("SELECT id FROM favorites WHERE user_id = ? AND product_id = ?");
                $stmt->execute([$user_id, $product_id]);
                
                if (!$stmt->fetch()) {
                    $stmt = $db->prepare("INSERT INTO favorites (user_id, product_id) VALUES (?, ?)");
                    $stmt->execute([$user_id, $product_id]);
                    echo json_encode(['success' => true, 'message' => 'Favorilere eklendi']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Zaten favorilerde']);
                }
            }
            break;
            
        case 'DELETE':
            if (isset($path_parts[1])) {
                $product_id = $path_parts[1];
                
                // Önce favoride var mı kontrol et
                $stmt = $db->prepare("SELECT id FROM favorites WHERE user_id = ? AND product_id = ?");
                $stmt->execute([$user_id, $product_id]);
                $favorite = $stmt->fetch();
                
                if (!$favorite) {
                    http_response_code(404);
                    echo json_encode(['success' => false, 'message' => 'Favori bulunamadı']);
                    break;
                }
                
                // Favoriden kaldır
                $stmt = $db->prepare("DELETE FROM favorites WHERE user_id = ? AND product_id = ?");
                $stmt->execute([$user_id, $product_id]);
                
                if ($stmt->rowCount() > 0) {
                    echo json_encode(['success' => true, 'message' => 'Ürün favorilerden kaldırıldı']);
                } else {
                    http_response_code(500);
                    echo json_encode(['success' => false, 'message' => 'Silme işlemi başarısız']);
                }
            } else {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Ürün ID gerekli']);
            }
            break;
    }
}

// Admin endpoints
function handleAdmin($db, $auth, $method, $path_parts, $input) {
    $auth->requireRole('admin');
    
    switch ($method) {
        case 'GET':
            switch ($path_parts[1] ?? '') {
                case 'users':
                    $stmt = $db->prepare("SELECT id, email, full_name, role, is_active, created_at FROM users ORDER BY created_at DESC");
                    $stmt->execute();
                    $users = $stmt->fetchAll();
                    echo json_encode(['success' => true, 'data' => $users]);
                    break;
                    
                case 'products':
                    $stmt = $db->prepare("
                        SELECT p.*, u.full_name as student_name, s.name as shop_name
                        FROM products p
                        LEFT JOIN users u ON p.student_id = u.id
                        LEFT JOIN shops s ON p.shop_id = s.id
                        ORDER BY p.created_at DESC
                    ");
                    $stmt->execute();
                    $products = $stmt->fetchAll();
                    
                    foreach ($products as &$product) {
                        $product['images'] = json_decode($product['images'] ?? '[]');
                    }
                    
                    echo json_encode(['success' => true, 'data' => $products]);
                    break;
                    
                case 'stats':
                    $stats = [];
                    
                    // Basic counts
                    $stmt = $db->prepare("SELECT COUNT(*) as count FROM users");
                    $stmt->execute();
                    $stats['total_users'] = $stmt->fetchColumn();
                    
                    $stmt = $db->prepare("SELECT COUNT(*) as count FROM products WHERE status = 'active'");
                    $stmt->execute();
                    $stats['total_products'] = $stmt->fetchColumn();
                    
                    $stmt = $db->prepare("SELECT COUNT(*) as count FROM products WHERE status = 'pending'");
                    $stmt->execute();
                    $stats['pending_products'] = $stmt->fetchColumn();
                    
                    $stmt = $db->prepare("SELECT COUNT(*) as count FROM orders");
                    $stmt->execute();
                    $stats['total_orders'] = $stmt->fetchColumn();
                    
                    $stmt = $db->prepare("SELECT SUM(total_amount) as total FROM orders WHERE status != 'cancelled'");
                    $stmt->execute();
                    $stats['total_revenue'] = $stmt->fetchColumn() ?? 0;
                    
                    // Today's orders
                    $stmt = $db->prepare("SELECT COUNT(*) as count FROM orders WHERE DATE(created_at) = DATE('now')");
                    $stmt->execute();
                    $stats['today_orders'] = $stmt->fetchColumn();
                    
                    // This month's revenue
                    $stmt = $db->prepare("SELECT SUM(total_amount) as total FROM orders WHERE strftime('%Y-%m', created_at) = strftime('%Y-%m', 'now') AND status != 'cancelled'");
                    $stmt->execute();
                    $stats['month_revenue'] = $stmt->fetchColumn() ?? 0;
                    
                    // User breakdown
                    $stmt = $db->prepare("SELECT role, COUNT(*) as count FROM users GROUP BY role");
                    $stmt->execute();
                    $user_breakdown = $stmt->fetchAll();
                    
                    foreach ($user_breakdown as $row) {
                        $stats[$row['role'] . '_count'] = $row['count'];
                    }
                    
                    echo json_encode(['success' => true, 'data' => $stats]);
                    break;
            }
            break;
            
        case 'PUT':
            // Ürün durumu güncelle
            if ($path_parts[1] === 'products' && isset($path_parts[2])) {
                $product_id = $path_parts[2];
                $action = $path_parts[3] ?? '';
                
                switch ($action) {
                    case 'approve':
                        $stmt = $db->prepare("UPDATE products SET status = 'active', approved_at = CURRENT_TIMESTAMP WHERE id = ?");
                        $stmt->execute([$product_id]);
                        echo json_encode(['success' => true, 'message' => 'Ürün onaylandı']);
                        break;
                        
                    case 'reject':
                        $stmt = $db->prepare("UPDATE products SET status = 'rejected' WHERE id = ?");
                        $stmt->execute([$product_id]);
                        echo json_encode(['success' => true, 'message' => 'Ürün reddedildi']);
                        break;
                        
                    case 'suspend':
                        $stmt = $db->prepare("UPDATE products SET status = 'suspended' WHERE id = ?");
                        $stmt->execute([$product_id]);
                        echo json_encode(['success' => true, 'message' => 'Ürün askıya alındı']);
                        break;
                        
                    case 'activate':
                        $stmt = $db->prepare("UPDATE products SET status = 'active' WHERE id = ?");
                        $stmt->execute([$product_id]);
                        echo json_encode(['success' => true, 'message' => 'Ürün aktifleştirildi']);
                        break;
                        
                    default:
                        http_response_code(400);
                        echo json_encode(['success' => false, 'message' => 'Geçersiz işlem']);
                }
            }
            break;
    }
}

// Merchant endpoints
function handleMerchant($db, $auth, $method, $path_parts, $input) {
    $user_id = $auth->requireRole('merchant');
    
    // Get merchant's shop
    $stmt = $db->prepare("SELECT id FROM shops WHERE owner_id = ?");
    $stmt->execute([$user_id]);
    $shop = $stmt->fetch();
    
    if (!$shop) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Mağaza bulunamadı']);
        return;
    }
    
    $shop_id = $shop['id'];
    
    if ($method === 'GET') {
        switch ($path_parts[1] ?? '') {
            case 'orders':
                // Get orders for merchant's products
                $stmt = $db->prepare("
                    SELECT DISTINCT o.*, u.full_name as customer_name
                    FROM orders o
                    JOIN order_items oi ON o.id = oi.order_id
                    JOIN products p ON oi.product_id = p.id
                    JOIN users u ON o.customer_id = u.id
                    WHERE p.shop_id = ?
                    ORDER BY o.created_at DESC
                ");
                $stmt->execute([$shop_id]);
                $orders = $stmt->fetchAll();
                
                echo json_encode(['success' => true, 'data' => $orders]);
                break;
                
            case 'products':
                $status = $_GET['status'] ?? 'all';
                $where_clause = "WHERE p.shop_id = ?";
                $params = [$shop_id];
                
                if ($status !== 'all') {
                    $where_clause .= " AND p.status = ?";
                    $params[] = $status;
                }
                
                $stmt = $db->prepare("
                    SELECT p.*, u.full_name as student_name
                    FROM products p
                    LEFT JOIN users u ON p.student_id = u.id
                    $where_clause
                    ORDER BY p.created_at DESC
                ");
                $stmt->execute($params);
                $products = $stmt->fetchAll();
                
                foreach ($products as &$product) {
                    $product['images'] = json_decode($product['images'] ?? '[]', true) ?: [];
                    $product['videos'] = json_decode($product['videos'] ?? '[]', true) ?: [];
                    $product['suggested_price'] = $product['price']; // Önerilen fiyat olarak mevcut fiyatı kullan
                }
                
                echo json_encode(['success' => true, 'data' => $products]);
                break;
        }
    } elseif ($method === 'PUT') {
        // Ürün durumu güncelle (merchant için)
        if ($path_parts[1] === 'products' && isset($path_parts[2])) {
            $product_id = $path_parts[2];
            $action = $path_parts[3] ?? '';
            
            // Ürünün bu mağazaya ait olduğunu kontrol et
            $stmt = $db->prepare("SELECT id FROM products WHERE id = ? AND shop_id = ?");
            $stmt->execute([$product_id, $shop_id]);
            if (!$stmt->fetch()) {
                http_response_code(403);
                echo json_encode(['success' => false, 'message' => 'Bu ürüne erişim yetkiniz yok']);
                return;
            }
            
            switch ($action) {
                case 'approve':
                    $price = $input['final_price'] ?? 0;
                    $stock = $input['stock'] ?? 0;
                    
                    $stmt = $db->prepare("UPDATE products SET status = 'active', price = ?, stock = ?, approved_at = CURRENT_TIMESTAMP WHERE id = ?");
                    $stmt->execute([$price, $stock, $product_id]);
                    echo json_encode(['success' => true, 'message' => 'Ürün onaylandı']);
                    break;
                    
                case 'reject':
                    $stmt = $db->prepare("UPDATE products SET status = 'rejected' WHERE id = ?");
                    $stmt->execute([$product_id]);
                    echo json_encode(['success' => true, 'message' => 'Ürün reddedildi']);
                    break;
                    
                case 'suspend':
                    $stmt = $db->prepare("UPDATE products SET status = 'suspended' WHERE id = ?");
                    $stmt->execute([$product_id]);
                    echo json_encode(['success' => true, 'message' => 'Ürün askıya alındı']);
                    break;
                    
                case 'update':
                    $price = $input['price'] ?? 0;
                    $stock = $input['stock'] ?? 0;
                    
                    $stmt = $db->prepare("UPDATE products SET price = ?, stock = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
                    $stmt->execute([$price, $stock, $product_id]);
                    echo json_encode(['success' => true, 'message' => 'Ürün güncellendi']);
                    break;
                    
                case 'activate':
                    $stmt = $db->prepare("UPDATE products SET status = 'active', updated_at = CURRENT_TIMESTAMP WHERE id = ?");
                    $stmt->execute([$product_id]);
                    echo json_encode(['success' => true, 'message' => 'Ürün aktifleştirildi']);
                    break;
                    
                default:
                    http_response_code(400);
                    echo json_encode(['success' => false, 'message' => 'Geçersiz işlem']);
            }
        }
    }
}

// Student endpoints
function handleStudent($db, $auth, $method, $path_parts, $input) {
    $user_id = $auth->requireRole('student');
    
    if ($method === 'GET') {
        switch ($path_parts[1] ?? '') {
            case 'products':
                $stmt = $db->prepare("
                    SELECT p.*, s.name as shop_name,
                           COUNT(oi.id) as sales_count,
                           SUM(oi.total_price * 0.10) as total_earned
                    FROM products p
                    LEFT JOIN shops s ON p.shop_id = s.id
                    LEFT JOIN order_items oi ON p.id = oi.product_id
                    WHERE p.student_id = ?
                    GROUP BY p.id
                    ORDER BY p.created_at DESC
                ");
                $stmt->execute([$user_id]);
                $products = $stmt->fetchAll();
                
                foreach ($products as &$product) {
                    $product['images'] = json_decode($product['images'] ?? '[]');
                    $product['total_earned'] = $product['total_earned'] ?? 0;
                }
                
                echo json_encode(['success' => true, 'data' => $products]);
                break;
                
            case 'earnings':
                $stmt = $db->prepare("
                    SELECT 
                        SUM(oi.total_price * 0.10) as total_earnings,
                        COUNT(DISTINCT p.id) as products_count,
                        COUNT(oi.id) as sales_count
                    FROM products p
                    LEFT JOIN order_items oi ON p.id = oi.product_id
                    WHERE p.student_id = ?
                ");
                $stmt->execute([$user_id]);
                $earnings = $stmt->fetch();
                
                echo json_encode(['success' => true, 'data' => $earnings]);
                break;
        }
    }
}

// Wallet endpoints
function handleWallet($db, $auth, $method, $path_parts, $input) {
    $user_id = $auth->requireAuth();
    
    switch ($method) {
        case 'GET':
            $stmt = $db->prepare("SELECT * FROM wallets WHERE user_id = ?");
            $stmt->execute([$user_id]);
            $wallet = $stmt->fetch();
            
            if (!$wallet) {
                // Create wallet if doesn't exist
                $stmt = $db->prepare("INSERT INTO wallets (user_id) VALUES (?)");
                $stmt->execute([$user_id]);
                
                $stmt = $db->prepare("SELECT * FROM wallets WHERE user_id = ?");
                $stmt->execute([$user_id]);
                $wallet = $stmt->fetch();
            }
            
            echo json_encode(['success' => true, 'data' => $wallet]);
            break;
            
        case 'POST':
            if ($path_parts[1] === 'payout') {
                // Request payout
                $stmt = $db->prepare("INSERT INTO payouts (wallet_id, amount, iban, account_holder) VALUES (?, ?, ?, ?)");
                // Implementation would go here
                echo json_encode(['success' => true, 'message' => 'Para çekme talebi oluşturuldu']);
            }
            break;
    }
}

// Categories endpoints
function handleCategories($db, $method, $path_parts, $input) {
    switch ($method) {
        case 'GET':
            if (isset($path_parts[1]) && is_numeric($path_parts[1])) {
                // Tek kategori getir
                $category_id = $path_parts[1];
                $stmt = $db->prepare("
                    SELECT c.*, 
                           (SELECT COUNT(*) FROM products p WHERE p.category_id = c.id AND p.status = 'active') as product_count
                    FROM categories c 
                    WHERE c.id = ? AND c.is_active = 1
                ");
                $stmt->execute([$category_id]);
                $category = $stmt->fetch();
                
                if ($category) {
                    // Alt kategorileri getir
                    $stmt = $db->prepare("
                        SELECT c.*, 
                               (SELECT COUNT(*) FROM products p WHERE p.category_id = c.id AND p.status = 'active') as product_count
                        FROM categories c 
                        WHERE c.parent_id = ? AND c.is_active = 1 
                        ORDER BY c.sort_order ASC
                    ");
                    $stmt->execute([$category_id]);
                    $category['children'] = $stmt->fetchAll();
                    
                    echo json_encode(['success' => true, 'data' => $category]);
                } else {
                    http_response_code(404);
                    echo json_encode(['success' => false, 'message' => 'Kategori bulunamadı']);
                }
            } else {
                // Tüm kategorileri getir (hiyerarşik)
                $flat = isset($_GET['flat']) && $_GET['flat'] === 'true';
                $with_count = isset($_GET['with_count']) && $_GET['with_count'] === 'true';
                
                if ($flat) {
                    // Düz liste (tüm kategoriler)
                    $sql = "SELECT c.* FROM categories c WHERE c.is_active = 1 ORDER BY c.sort_order ASC, c.name ASC";
                    
                    if ($with_count) {
                        $sql = "
                            SELECT c.*, 
                                   (SELECT COUNT(*) FROM products p WHERE p.category_id = c.id AND p.status = 'active') as product_count
                            FROM categories c 
                            WHERE c.is_active = 1 
                            ORDER BY c.sort_order ASC, c.name ASC
                        ";
                    }
                    
                    $stmt = $db->query($sql);
                    $categories = $stmt->fetchAll();
                    
                    echo json_encode(['success' => true, 'data' => $categories]);
                } else {
                    // Hiyerarşik liste (ana kategoriler ve alt kategorileri)
                    $sql = "
                        SELECT c.*, 
                               (SELECT COUNT(*) FROM products p WHERE (p.category_id = c.id OR p.category_id IN (SELECT id FROM categories WHERE parent_id = c.id)) AND p.status = 'active') as product_count
                        FROM categories c 
                        WHERE c.parent_id IS NULL AND c.is_active = 1 
                        ORDER BY c.sort_order ASC, c.name ASC
                    ";
                    $stmt = $db->query($sql);
                    $main_categories = $stmt->fetchAll();
                    
                    // Her ana kategori için alt kategorileri getir
                    foreach ($main_categories as &$category) {
                        $stmt = $db->prepare("
                            SELECT c.*, 
                                   (SELECT COUNT(*) FROM products p WHERE p.category_id = c.id AND p.status = 'active') as product_count
                            FROM categories c 
                            WHERE c.parent_id = ? AND c.is_active = 1 
                            ORDER BY c.sort_order ASC, c.name ASC
                        ");
                        $stmt->execute([$category['id']]);
                        $category['children'] = $stmt->fetchAll();
                    }
                    
                    echo json_encode(['success' => true, 'data' => $main_categories]);
                }
            }
            break;
            
        case 'POST':
            // Admin only - Kategori oluştur
            // TODO: Admin auth kontrolü ekle
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'Bu işlem için yetkiniz yok']);
            break;
    }
}

?>
