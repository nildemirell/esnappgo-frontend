<?php
// Giriş kontrolü
if (!$current_user) {
    header('Location: /login?redirect=/dashboard');
    exit;
}
?>

<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                Hoş geldiniz, <?php echo htmlspecialchars(explode(' ', $current_user['full_name'])[0]); ?>!
            </h1>
            <p class="text-gray-600">
                <?php
                switch ($current_user['role']) {
                    case 'student':
                    case 'ogrenci':
                        echo 'Öğrenci dashboard\'unuzdan kazançlarınızı ve ürünlerinizi takip edebilirsiniz.';
                        break;
                    case 'merchant':
                    case 'esnaf':
                        echo 'Esnaf dashboard\'unuzdan mağazanızı ve siparişlerinizi yönetebilirsiniz.';
                        break;
                    default:
                        echo 'Dashboard\'unuzdan siparişlerinizi ve hesap bilgilerinizi yönetebilirsiniz.';
                }
                ?>
            </p>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <?php if ($current_user['role'] === 'customer' || $current_user['role'] === 'musteri'): 
                // Müşteri için gerçek istatistikleri çek
                $db = $database->getConnection();
                $customer_id = $current_user['id'];
                
                // Toplam sipariş sayısı
                $total_orders = $db->query("SELECT COUNT(*) FROM orders WHERE customer_id = {$customer_id}")->fetchColumn();
                
                // Toplam harcama
                $total_spent_query = $db->query("SELECT SUM(total_amount) FROM orders WHERE customer_id = {$customer_id}");
                $total_spent = $total_spent_query->fetchColumn() ?: 0;
                
                // Favori ürün sayısı
                $total_favorites = $db->query("SELECT COUNT(*) FROM favorites WHERE user_id = {$customer_id}")->fetchColumn();
                
                // Öğrenci desteği (donations toplamı)
                $student_support_query = $db->query("
                    SELECT SUM(sd.donation_amount) 
                    FROM student_donations sd 
                    INNER JOIN orders o ON sd.order_id = o.id 
                    WHERE o.customer_id = {$customer_id}
                ");
                $student_support = $student_support_query->fetchColumn() ?: 0;
            ?>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Toplam Sipariş</p>
                            <p class="text-2xl font-bold text-gray-900"><?php echo $total_orders; ?></p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Toplam Harcama</p>
                            <p class="text-2xl font-bold text-gray-900">₺<?php echo number_format($total_spent, 2); ?></p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Favoriler</p>
                            <p class="text-2xl font-bold text-gray-900"><?php echo $total_favorites; ?></p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Öğrenci Desteği</p>
                            <p class="text-2xl font-bold text-gray-900">₺<?php echo number_format($student_support, 2); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($current_user['role'] === 'student' || $current_user['role'] === 'ogrenci'): 
                // Öğrenci için gerçek istatistikleri çek
                $db = $database->getConnection();
                $student_id = $current_user['id'];
                
                // Wallet bilgilerini al
                $wallet_query = $db->prepare("SELECT total_earned, balance FROM wallets WHERE user_id = ?");
                $wallet_query->execute([$student_id]);
                $wallet = $wallet_query->fetch();
                $total_earnings = $wallet ? $wallet['total_earned'] : 0;
                $current_balance = $wallet ? $wallet['balance'] : 0;
                
                // Toplam ürün sayısı
                $total_products = $db->query("SELECT COUNT(*) FROM products WHERE student_id = {$student_id}")->fetchColumn();
                
                // Onaylanan ürünler (active)
                $approved_products = $db->query("SELECT COUNT(*) FROM products WHERE student_id = {$student_id} AND status = 'active'")->fetchColumn();
                
                // Bekleyen ürünler (pending)
                $pending_products = $db->query("SELECT COUNT(*) FROM products WHERE student_id = {$student_id} AND status = 'pending'")->fetchColumn();
            ?>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Toplam Kazanç</p>
                            <p class="text-2xl font-bold text-gray-900">₺<?php echo number_format($total_earnings, 2); ?></p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Ürün Sayısı</p>
                            <p class="text-2xl font-bold text-gray-900"><?php echo $total_products; ?></p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Onaylanan</p>
                            <p class="text-2xl font-bold text-gray-900"><?php echo $approved_products; ?></p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Beklemede</p>
                            <p class="text-2xl font-bold text-gray-900"><?php echo $pending_products; ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
                        <?php if ($current_user['role'] === 'merchant' || $current_user['role'] === 'esnaf'): 
                $db = $database->getConnection();
                $merchant_id = $current_user['id'];
                
                // Esnafın mağazasını bul
                $shop_query = $db->prepare("SELECT id FROM shops WHERE owner_id = ?");
                $shop_query->execute([$merchant_id]);
                $shop = $shop_query->fetch();
                
                $total_shop_orders = 0;
                $total_shop_revenue = 0;
                $pending_shop_orders = 0;
                
                if ($shop) {
                    $shop_id = $shop['id'];
                    
                    // Mağazanın toplam sipariş sayısı (Benzersiz siparişler)
                    $total_shop_orders = $db->query("
                        SELECT COUNT(DISTINCT o.id) 
                        FROM orders o 
                        INNER JOIN order_items oi ON o.id = oi.order_id 
                        INNER JOIN products p ON oi.product_id = p.id 
                        WHERE p.shop_id = {$shop_id}
                    ")->fetchColumn() ?: 0;
                    
                    // Mağazanın bekleyen siparişleri
                    $pending_shop_orders = $db->query("
                        SELECT COUNT(DISTINCT o.id) 
                        FROM orders o 
                        INNER JOIN order_items oi ON o.id = oi.order_id 
                        INNER JOIN products p ON oi.product_id = p.id 
                        WHERE p.shop_id = {$shop_id} AND o.status = 'pending'
                    ")->fetchColumn() ?: 0;
                    
                    // Mağazanın toplam kazancı (Sadece bu mağazaya ait satılan ürünlerin tutarı)
                    $total_shop_revenue = $db->query("
                        SELECT SUM(oi.quantity * oi.unit_price) 
                        FROM order_items oi 
                        INNER JOIN products p ON oi.product_id = p.id 
                        INNER JOIN orders o ON oi.order_id = o.id
                        WHERE p.shop_id = {$shop_id} AND o.status IN ('paid', 'shipped', 'delivered')
                    ")->fetchColumn() ?: 0;
                }
            ?>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Toplam Sipariş</p>
                            <p class="text-2xl font-bold text-gray-900"><?php echo $total_shop_orders; ?></p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Toplam Ciro</p>
                            <p class="text-2xl font-bold text-gray-900">₺<?php echo number_format($total_shop_revenue, 2); ?></p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Bekleyen Sipariş</p>
                            <p class="text-2xl font-bold text-gray-900"><?php echo $pending_shop_orders; ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Activity -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Son Aktiviteler</h3>
                <div class="space-y-4">
                    <?php
                    // Gerçek son aktiviteleri çek
                    $activities = [];
                    $user_id = $current_user['id'];
                    
                    if ($current_user['role'] === 'student' || $current_user['role'] === 'ogrenci') {
                        // Öğrenci aktiviteleri: Son eklenen ürünler
                        $stmt = $db->prepare("
                            SELECT 'product' as type, title as message, created_at, status
                            FROM products 
                            WHERE student_id = ? 
                            ORDER BY created_at DESC 
                            LIMIT 5
                        ");
                        $stmt->execute([$user_id]);
                        $products = $stmt->fetchAll();
                        
                        foreach ($products as $product) {
                            $status_text = $product['status'] === 'active' ? 'onaylandı' : 'bekleniyor';
                            $activities[] = [
                                'type' => 'product',
                                'message' => $product['message'] . ' ürünü ' . $status_text,
                                'time' => $product['created_at'],
                                'icon' => 'camera'
                            ];
                        }
                        
                    } elseif ($current_user['role'] === 'customer' || $current_user['role'] === 'musteri') {
                        // Müşteri aktiviteleri: Son siparişler ve favoriler
                        $stmt = $db->prepare("
                            SELECT 'order' as type, order_number as message, created_at, status
                            FROM orders 
                            WHERE customer_id = ? 
                            ORDER BY created_at DESC 
                            LIMIT 3
                        ");
                        $stmt->execute([$user_id]);
                        $orders = $stmt->fetchAll();
                        
                        foreach ($orders as $order) {
                            $activities[] = [
                                'type' => 'order',
                                'message' => $order['message'] . ' sipariş oluşturuldu',
                                'time' => $order['created_at'],
                                'icon' => 'shopping-bag'
                            ];
                        }
                        
                        // Favoriler
                        $stmt = $db->prepare("
                            SELECT f.created_at, p.title
                            FROM favorites f
                            INNER JOIN products p ON f.product_id = p.id
                            WHERE f.user_id = ?
                            ORDER BY f.created_at DESC
                            LIMIT 2
                        ");
                        $stmt->execute([$user_id]);
                        $favorites = $stmt->fetchAll();
                        
                        foreach ($favorites as $fav) {
                            $activities[] = [
                                'type' => 'favorite',
                                'message' => $fav['title'] . ' favorilere eklendi',
                                'time' => $fav['created_at'],
                                'icon' => 'heart'
                            ];
                        }
                    }
                                        elseif ($current_user['role'] === 'merchant' || $current_user['role'] === 'esnaf') {
                        // 1. Önce esnafın mağazasını (shop_id) buluyoruz (Doğrudan bağlantı yerine ilişki kuruyoruz)
                        $shop_stmt = $db->prepare("SELECT id, name FROM shops WHERE owner_id = ?");
                        $shop_stmt->execute([$user_id]);
                        $shop = $shop_stmt->fetch();
                        
                        if ($shop) {
                            $shop_id = $shop['id'];
                            
                            // 2. Bu mağazaya (shop_id) ait olan son 5 siparişi çekiyoruz
                            // order_items tablosu üzerinden sipariş -> ürün -> mağaza ilişkisi kuruluyor
                            $stmt = $db->prepare("
                                SELECT DISTINCT o.id, o.order_number, o.created_at, o.status, u.full_name as customer_name
                                FROM orders o
                                INNER JOIN order_items oi ON o.id = oi.order_id
                                INNER JOIN products p ON oi.product_id = p.id
                                INNER JOIN users u ON o.customer_id = u.id
                                WHERE p.shop_id = ?
                                ORDER BY o.created_at DESC
                                LIMIT 5
                            ");
                            $stmt->execute([$shop_id]);
                            $orders = $stmt->fetchAll();
                            
                            foreach ($orders as $order) {
                                // Sipariş durumunu Türkçeleştir
                                $status_text = 'yeni sipariş';
                                if ($order['status'] === 'paid') $status_text = 'hazırlanıyor';
                                if ($order['status'] === 'shipped') $status_text = 'kargoya verildi';
                                if ($order['status'] === 'delivered') $status_text = 'teslim edildi';
                                
                                $activities[] = [
                                    'type' => 'order',
                                    'message' => $order['customer_name'] . ' adlı müşteriden ' . $status_text . ' (#' . $order['order_number'] . ')',
                                    'time' => $order['created_at'],
                                    'icon' => 'shopping-bag'
                                ];
                            }
                        }
                    }

                    // Profil güncellemesi (tüm kullanıcılar için)
                    if ($current_user['updated_at']) {
                        $activities[] = [
                            'type' => 'profile',
                            'message' => 'Profil bilgileri güncellendi',
                            'time' => $current_user['updated_at'],
                            'icon' => 'user'
                        ];
                    }
                    
                    // Zamana göre sırala
                    usort($activities, function($a, $b) {
                        return strtotime($b['time']) - strtotime($a['time']);
                    });
                    
                    // En son 5 aktiviteyi göster
                    $activities = array_slice($activities, 0, 5);
                    
                    // Zaman farkını hesaplayan fonksiyon
                    function timeAgo($datetime) {
                        $time = strtotime($datetime);
                        $diff = time() - $time;
                        
                        if ($diff < 60) return 'Az önce';
                        if ($diff < 3600) return floor($diff / 60) . ' dakika önce';
                        if ($diff < 86400) return floor($diff / 3600) . ' saat önce';
                        if ($diff < 604800) return floor($diff / 86400) . ' gün önce';
                        return date('d M Y', $time);
                    }
                    
                    if (empty($activities)): ?>
                        <div class="text-center py-8 text-gray-500">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p>Henüz aktivite bulunmuyor</p>
                        </div>
                    <?php else: 
                        foreach ($activities as $activity): 
                            $icon_class = 'text-blue-600';
                            $bg_class = 'bg-blue-100';
                            
                            if ($activity['type'] === 'favorite') {
                                $icon_class = 'text-pink-600';
                                $bg_class = 'bg-pink-100';
                            } elseif ($activity['type'] === 'profile') {
                                $icon_class = 'text-purple-600';
                                $bg_class = 'bg-purple-100';
                            } elseif ($activity['type'] === 'product') {
                                $icon_class = 'text-green-600';
                                $bg_class = 'bg-green-100';
                            }
                    ?>
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 <?php echo $bg_class; ?> rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 <?php echo $icon_class; ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <?php if ($activity['icon'] === 'shopping-bag'): ?>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    <?php elseif ($activity['icon'] === 'heart'): ?>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    <?php elseif ($activity['icon'] === 'camera'): ?>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                    <?php else: ?>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    <?php endif; ?>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate"><?php echo htmlspecialchars($activity['message']); ?></p>
                                <p class="text-xs text-gray-500"><?php echo timeAgo($activity['time']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; endif; ?>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Hızlı İşlemler</h3>
                <div class="space-y-3">
                    <?php if ($current_user['role'] === 'customer' || $current_user['role'] === 'musteri'): ?>
                        <a href="/products" class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                            <svg class="w-5 h-5 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            <span>Ürünleri İncele</span>
                        </a>
                        
                        <a href="/cart" class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                            <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M7 13l-1.5 6m0 0h9m-9 0V19a2 2 0 002 2h6a2 2 0 002-2v-4"></path>
                            </svg>
                            <span>Sepetim</span>
                        </a>
                        
                        <a href="/orders" class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                            <svg class="w-5 h-5 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <span>Siparişlerim</span>
                        </a>
                        
                        <a href="/favorites" class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                            <svg class="w-5 h-5 text-pink-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            <span>Favorilerim</span>
                        </a>
                    <?php endif; ?>
                    
                    <?php if ($current_user['role'] === 'merchant' || $current_user['role'] === 'esnaf'): ?>
                        <a href="/merchant/orders" class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                            <svg class="w-5 h-5 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <span>Siparişlerim</span>
                        </a>
                        
                        <a href="/merchant/products" class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                            <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <span>Ürün Onayları</span>
                        </a>
                        
                        <a href="/merchant/shop" class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                            <svg class="w-5 h-5 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <span>Mağaza Ayarları</span>
                        </a>
                    <?php endif; ?>

                    <?php if ($current_user['role'] === 'student' || $current_user['role'] === 'ogrenci'): ?>
                        <a href="/student/create-product" class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                            <svg class="w-5 h-5 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span>Yeni Ürün Ekle</span>
                        </a>
                        
                        <a href="/student/earnings" class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                            <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                            <span>Kazançlarım</span>
                        </a>
                        
                        <a href="/student/products" class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                            <svg class="w-5 h-5 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <span>Ürünlerim</span>
                        </a>
                        
                        <a href="/student/wallet" class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                            <svg class="w-5 h-5 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <span>Cüzdanım</span>
                        </a>
                    <?php endif; ?>
                    
                    <a href="/profile" class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 text-gray-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>Profil Ayarları</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadDashboardData();
});

async function loadDashboardData() {
    // Tüm veriler PHP'den geliyor, sadece console log
    console.log('Dashboard data loaded from PHP');
}

async function loadCustomerStats() {
    // Müşteri istatistikleri PHP'den geliyor, JavaScript'e gerek yok
    console.log('Customer stats loaded from PHP');
}

function loadStudentStats() {
    // Öğrenci istatistikleri PHP'den geliyor, JavaScript'e gerek yok
    console.log('Student stats loaded from PHP');
}
</script>
