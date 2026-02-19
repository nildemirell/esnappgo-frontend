<?php
/**
 * EsnappGO Database Setup Script
 * Bu script veritabanını oluşturur ve örnek veriler ekler
 */

require_once 'php-backend/config/database.php';
require_once 'php-backend/config/config.php';

echo "EsnappGO Veritabanı Kurulum Başlatılıyor...\n";
echo "=====================================\n\n";

try {
    // Database bağlantısı oluştur
    $database = new Database();
    $db = $database->getConnection();
    
    echo "✓ Veritabanı bağlantısı başarılı\n";
    echo "✓ Tablolar oluşturuldu\n";
    
    // Örnek veriler ekle
    echo "\nÖrnek veriler ekleniyor...\n";
    
    // Admin kullanıcısı oluştur
    $admin_password = password_hash('admin123', PASSWORD_DEFAULT);
    $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $stmt->execute(['admin@esnappgo.com']);
    if ($stmt->fetchColumn() == 0) {
        $stmt = $db->prepare("INSERT INTO users (email, password_hash, full_name, role) VALUES (?, ?, ?, ?)");
        $stmt->execute(['admin@esnappgo.com', $admin_password, 'Admin User', 'admin']);
        echo "✓ Admin kullanıcısı oluşturuldu (email: admin@esnappgo.com, şifre: admin123)\n";
    }
    
    // Test öğrenci oluştur
    $student_password = password_hash('student123', PASSWORD_DEFAULT);
    $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $stmt->execute(['ogrenci@test.com']);
    if ($stmt->fetchColumn() == 0) {
        $stmt = $db->prepare("INSERT INTO users (email, password_hash, full_name, role) VALUES (?, ?, ?, ?)");
        $stmt->execute(['ogrenci@test.com', $student_password, 'Test Öğrenci', 'student']);
        $student_id = $db->lastInsertId();
        
        // Öğrenci için wallet oluştur
        $stmt = $db->prepare("INSERT INTO wallets (user_id) VALUES (?)");
        $stmt->execute([$student_id]);
        echo "✓ Test öğrenci oluşturuldu (email: ogrenci@test.com, şifre: student123)\n";
    } else {
        $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute(['ogrenci@test.com']);
        $student_id = $stmt->fetchColumn();
    }
    
    // Test esnaf oluştur
    $merchant_password = password_hash('esnaf123', PASSWORD_DEFAULT);
    $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $stmt->execute(['esnaf@test.com']);
    if ($stmt->fetchColumn() == 0) {
        $stmt = $db->prepare("INSERT INTO users (email, password_hash, full_name, role) VALUES (?, ?, ?, ?)");
        $stmt->execute(['esnaf@test.com', $merchant_password, 'Test Esnaf', 'merchant']);
        $merchant_id = $db->lastInsertId();
    } else {
        $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute(['esnaf@test.com']);
        $merchant_id = $stmt->fetchColumn();
    }
    
    // Esnaf için wallet oluştur
    $stmt = $db->prepare("SELECT COUNT(*) FROM wallets WHERE user_id = ?");
    $stmt->execute([$merchant_id]);
    if ($stmt->fetchColumn() == 0) {
        $stmt = $db->prepare("INSERT INTO wallets (user_id) VALUES (?)");
        $stmt->execute([$merchant_id]);
    }
    
    // Test mağaza oluştur
    $stmt = $db->prepare("SELECT COUNT(*) FROM shops WHERE owner_id = ?");
    $stmt->execute([$merchant_id]);
    if ($stmt->fetchColumn() == 0) {
        $stmt = $db->prepare("INSERT INTO shops (name, description, address, phone, owner_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            'Test Market',
            'Mahallenizin güvenilir marketi',
            'Test Mahallesi, Test Sokak No:1',
            '0533 616 02 18',
            $merchant_id
        ]);
        $shop_id = $db->lastInsertId();
        echo "✓ Test esnaf ve mağaza oluşturuldu (email: esnaf@test.com, şifre: esnaf123)\n";
    } else {
        $stmt = $db->prepare("SELECT id FROM shops WHERE owner_id = ?");
        $stmt->execute([$merchant_id]);
        $shop_id = $stmt->fetchColumn();
    }
    
    // Test müşteri oluştur
    $customer_password = password_hash('musteri123', PASSWORD_DEFAULT);
    $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $stmt->execute(['musteri@test.com']);
    if ($stmt->fetchColumn() == 0) {
        $stmt = $db->prepare("INSERT INTO users (email, password_hash, full_name, role) VALUES (?, ?, ?, ?)");
        $stmt->execute(['musteri@test.com', $customer_password, 'Test Müşteri', 'customer']);
        $customer_id = $db->lastInsertId();
        
        // Müşteri için cart oluştur
        $stmt = $db->prepare("INSERT INTO carts (user_id) VALUES (?)");
        $stmt->execute([$customer_id]);
        echo "✓ Test müşteri oluşturuldu (email: musteri@test.com, şifre: musteri123)\n";
    } else {
        $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute(['musteri@test.com']);
        $customer_id = $stmt->fetchColumn();
    }
    
    // Mevcut ürün sayısını kontrol et - sadece yoksa ekle
    $stmt = $db->prepare("SELECT COUNT(*) FROM products WHERE status = 'active'");
    $stmt->execute();
    $existing_products = $stmt->fetchColumn();
    
    if ($existing_products > 0) {
        echo "✓ Mevcut ürünler korunuyor (Toplam: $existing_products)\n";
        $add_products = false;
    } else {
        echo "✓ Ürün bulunamadı, yenileri ekleniyor...\n";
        $add_products = true;
    }
    
    // Test mağazası için 5 çalışan ürün oluştur
    $products = [
        [
            'title' => 'Taze Domates',
            'description' => 'Yerel üreticiden taze domates, kilosu',
            'price' => 8.50,
            'stock' => 50,
            'status' => 'active',
            'images' => json_encode(['media/68a658361732a_1755732022.jpg']),
            'student_id' => $student_id,
            'shop_id' => $shop_id
        ],
        [
            'title' => 'Organik Salatalık',
            'description' => 'Pestisitsiz organik salatalık',
            'price' => 6.00,
            'stock' => 30,
            'status' => 'active',
            'images' => json_encode(['media/68a658361732a_1755732022.jpg']),
            'student_id' => $student_id,
            'shop_id' => $shop_id
        ],
        [
            'title' => 'Köy Ekmeği',
            'description' => 'Geleneksel yöntemle yapılan köy ekmeği',
            'price' => 4.00,
            'stock' => 20,
            'status' => 'active',
            'images' => json_encode(['media/68a658361732a_1755732022.jpg']),
            'student_id' => $student_id,
            'shop_id' => $shop_id
        ],
        [
            'title' => 'Taze Süt',
            'description' => 'Çiftlikten taze inek sütü, 1 litre',
            'price' => 12.00,
            'stock' => 25,
            'status' => 'active',
            'images' => json_encode(['media/68a658361732a_1755732022.jpg']),
            'student_id' => $student_id,
            'shop_id' => $shop_id
        ],
        [
            'title' => 'Yerel Bal',
            'description' => 'Doğal çiçek balı, 500g',
            'price' => 45.00,
            'stock' => 15,
            'status' => 'active',
            'images' => json_encode(['media/68a658361732a_1755732022.jpg']),
            'student_id' => $student_id,
            'shop_id' => $shop_id
        ]
    ];
    
    // Sadece ürün yoksa ekle
    if ($add_products) {
        $stmt = $db->prepare("
            INSERT INTO products (title, description, price, stock, status, images, student_id, shop_id, approved_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)
        ");
        
        foreach ($products as $product) {
            $stmt->execute([
                $product['title'],
                $product['description'],
                $product['price'],
                $product['stock'],
                $product['status'],
                $product['images'],
                $product['student_id'],
                $product['shop_id']
            ]);
        }
        
        echo "✓ " . count($products) . " test ürünü oluşturuldu\n";
    }
    
    // Varsayılan static sayfalar güncelle
    $pages = [
        [
            'terms',
            'Kullanım Koşulları',
            '<h2>EsnappGO Kullanım Koşulları</h2>
            <p>Bu platform kullanım koşulları EsnappGO kullanıcıları için geçerlidir.</p>
            <h3>1. Genel Hükümler</h3>
            <p>Bu platformu kullanarak aşağıdaki koşulları kabul etmiş sayılırsınız.</p>
            <h3>2. Kullanıcı Sorumlulukları</h3>
            <p>Kullanıcılar platform kurallarına uymakla yükümlüdür.</p>'
        ],
        [
            'privacy',
            'Gizlilik Politikası',
            '<h2>EsnappGO Gizlilik Politikası</h2>
            <p>Kişisel verilerinizin korunması bizim için önemlidir.</p>
            <h3>1. Toplanan Veriler</h3>
            <p>Platform kullanımı sırasında gerekli veriler toplanır.</p>
            <h3>2. Veri Güvenliği</h3>
            <p>Verileriniz güvenli şekilde saklanır ve işlenir.</p>'
        ],
        [
            'help',
            'Yardım Merkezi',
            '<h2>EsnappGO Yardım Merkezi</h2>
            <p>Platform kullanımı hakkında sıkça sorulan sorular.</p>
            <h3>Nasıl kayıt olurum?</h3>
            <p>Kayıt ol butonuna tıklayarak hesap oluşturabilirsiniz.</p>
            <h3>Nasıl ürün satın alırım?</h3>
            <p>Ürünleri sepete ekleyerek siparişinizi tamamlayabilirsiniz.</p>'
        ],
        [
            'contact',
            'İletişim',
            '<h2>EsnappGO İletişim</h2>
            <p>Bizimle iletişime geçmek için aşağıdaki bilgileri kullanabilirsiniz.</p>
            <p><strong>E-posta:</strong> info@esnappgo.com</p>
            <p><strong>Telefon:</strong> 0533 616 02 18</p>
            <p><strong>Adres:</strong> Test Mahallesi, Test Sokak No:1, İstanbul</p>'
        ]
    ];
    
    foreach ($pages as $page) {
        $stmt = $db->prepare("
            UPDATE static_pages SET title = ?, content = ? WHERE page_key = ?
        ");
        $stmt->execute([$page[1], $page[2], $page[0]]);
    }
    
    echo "✓ Static sayfalar güncellendi\n";
    
    // Örnek anket cevapları ekle
    $stmt = $db->prepare("SELECT COUNT(*) FROM survey_responses");
    $stmt->execute();
    $survey_count = $stmt->fetchColumn();
    
    if ($survey_count == 0) {
        // Ek örnek kullanıcılar oluştur
        $sample_users = [
            ['ali.yilmaz@test.com', 'Ali Yılmaz', 'student'],
            ['ayse.kaya@test.com', 'Ayşe Kaya', 'student'],
            ['mehmet.demir@test.com', 'Mehmet Demir', 'student'],
            ['fatma.celik@test.com', 'Fatma Çelik', 'customer'],
            ['ahmet.ozturk@test.com', 'Ahmet Öztürk', 'customer'],
            ['zeynep.sahin@test.com', 'Zeynep Şahin', 'student'],
            ['murat.yildiz@test.com', 'Murat Yıldız', 'merchant'],
            ['elif.aksoy@test.com', 'Elif Aksoy', 'student'],
            ['burak.kilic@test.com', 'Burak Kılıç', 'student'],
            ['selin.arslan@test.com', 'Selin Arslan', 'customer']
        ];
        
        $user_ids = [];
        foreach ($sample_users as $user_data) {
            $password = password_hash('test123', PASSWORD_DEFAULT);
            $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
            $stmt->execute([$user_data[0]]);
            if ($stmt->fetchColumn() == 0) {
                $stmt = $db->prepare("INSERT INTO users (email, password_hash, full_name, role) VALUES (?, ?, ?, ?)");
                $stmt->execute([$user_data[0], $password, $user_data[1], $user_data[2]]);
                $user_ids[] = $db->lastInsertId();
            }
        }
        
        // Anket cevapları ekle
        $all_responses = [
            [$student_id, 1, 1], // Test öğrenci - ilgili
            [$merchant_id, 0, null], // Test esnaf - öğrenci değil
            [$user_ids[0] ?? null, 1, 1], // Ali - öğrenci, ilgili
            [$user_ids[1] ?? null, 1, 0], // Ayşe - öğrenci, ilgisiz
            [$user_ids[2] ?? null, 1, 1], // Mehmet - öğrenci, ilgili
            [$user_ids[3] ?? null, 0, null], // Fatma - müşteri
            [$user_ids[4] ?? null, 0, null], // Ahmet - müşteri
            [$user_ids[5] ?? null, 1, 1], // Zeynep - öğrenci, ilgili
            [$user_ids[6] ?? null, 0, null], // Murat - esnaf
            [$user_ids[7] ?? null, 1, 1], // Elif - öğrenci, ilgili
            [$user_ids[8] ?? null, 1, 0], // Burak - öğrenci, ilgisiz
            [$user_ids[9] ?? null, 0, null], // Selin - müşteri
        ];
        
        $stmt = $db->prepare("INSERT INTO survey_responses (user_id, is_student, is_interested) VALUES (?, ?, ?)");
        foreach ($all_responses as $response) {
            if ($response[0]) { // Sadece geçerli user_id'ler için
                $stmt->execute($response);
            }
        }
        
        echo "✓ Örnek anket cevapları eklendi (12 yanıt)\n";
    }
    
    echo "\n=====================================\n";
    echo "✅ Veritabanı kurulumu tamamlandı!\n\n";
    
    echo "Test kullanıcıları:\n";
    echo "- Admin: admin@esnappgo.com / admin123\n";
    echo "- Öğrenci: ogrenci@test.com / student123\n";
    echo "- Esnaf: esnaf@test.com / esnaf123\n";
    echo "- Müşteri: musteri@test.com / musteri123\n\n";
    
    echo "Artık projeyi çalıştırabilirsiniz!\n";
    
} catch (Exception $e) {
    echo "❌ Hata oluştu: " . $e->getMessage() . "\n";
    exit(1);
}
?>
