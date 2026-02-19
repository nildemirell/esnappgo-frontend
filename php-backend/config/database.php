<?php

class Database {
    private $host = 'localhost';
    private $db_name = 'esnappgo.db';
    private $pdo;
    
    public function __construct() {
        try {
            // SQLite bağlantısı
            $this->pdo = new PDO("sqlite:" . __DIR__ . "/../" . $this->db_name);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
            // Foreign key constraints'i etkinleştir
            $this->pdo->exec("PRAGMA foreign_keys = ON");
            
            // Tabloları oluştur
            $this->createTables();
            
        } catch(PDOException $e) {
            echo "Bağlantı hatası: " . $e->getMessage();
        }
    }
    
    public function getConnection() {
        return $this->pdo;
    }
    
    private function createTables() {
        $sql = "
        -- Users table
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            email TEXT UNIQUE NOT NULL,
            password_hash TEXT NOT NULL,
            full_name TEXT NOT NULL,
            phone TEXT,
            role TEXT NOT NULL DEFAULT 'customer',
            kyc_status TEXT DEFAULT 'pending',
            is_active BOOLEAN DEFAULT 1,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
        
        -- Shops table
        CREATE TABLE IF NOT EXISTS shops (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            description TEXT,
            address TEXT,
            phone TEXT,
            owner_id INTEGER,
            is_active BOOLEAN DEFAULT 1,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (owner_id) REFERENCES users(id)
        );
        
        -- Products table
        CREATE TABLE IF NOT EXISTS products (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            description TEXT,
            price REAL NOT NULL,
            stock INTEGER DEFAULT 0,
            status TEXT DEFAULT 'pending',
            images TEXT, -- JSON array
            videos TEXT, -- JSON array
            product_metadata TEXT, -- JSON
            student_id INTEGER,
            shop_id INTEGER,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            approved_at DATETIME,
            FOREIGN KEY (student_id) REFERENCES users(id),
            FOREIGN KEY (shop_id) REFERENCES shops(id)
        );
        
        -- Carts table
        CREATE TABLE IF NOT EXISTS carts (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id)
        );
        
        -- Cart Items table
        CREATE TABLE IF NOT EXISTS cart_items (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            cart_id INTEGER,
            product_id INTEGER,
            quantity INTEGER DEFAULT 1,
            student_donation_percentage REAL DEFAULT 0.0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (cart_id) REFERENCES carts(id) ON DELETE CASCADE,
            FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
        );
        
        -- Addresses table
        CREATE TABLE IF NOT EXISTS addresses (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER,
            title TEXT,
            full_name TEXT,
            phone TEXT,
            address_line1 TEXT,
            address_line2 TEXT,
            city TEXT,
            district TEXT,
            postal_code TEXT,
            is_default BOOLEAN DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id)
        );
        
        -- Orders table
        CREATE TABLE IF NOT EXISTS orders (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            order_number TEXT UNIQUE,
            customer_id INTEGER,
            status TEXT DEFAULT 'pending',
            subtotal REAL,
            tax_amount REAL DEFAULT 0,
            shipping_fee REAL DEFAULT 0,
            total_amount REAL,
            shipping_address TEXT, -- JSON
            billing_address TEXT, -- JSON
            payment_id TEXT,
            payment_method TEXT,
            tracking_number TEXT,
            shipped_at DATETIME,
            delivered_at DATETIME,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (customer_id) REFERENCES users(id)
        );
        
        -- Order Items table
        CREATE TABLE IF NOT EXISTS order_items (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            order_id INTEGER,
            product_id INTEGER,
            quantity INTEGER,
            unit_price REAL,
            total_price REAL,
            product_snapshot TEXT, -- JSON
            FOREIGN KEY (order_id) REFERENCES orders(id),
            FOREIGN KEY (product_id) REFERENCES products(id)
        );
        
        -- Wallets table
        CREATE TABLE IF NOT EXISTS wallets (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER UNIQUE,
            balance REAL DEFAULT 0.0,
            pending_balance REAL DEFAULT 0.0,
            total_earned REAL DEFAULT 0.0,
            total_withdrawn REAL DEFAULT 0.0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            iban TEXT,
            bank_name TEXT,
            account_holder TEXT,
            FOREIGN KEY (user_id) REFERENCES users(id)
        );
        
        -- Wallet Transactions table
        CREATE TABLE IF NOT EXISTS wallet_transactions (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            wallet_id INTEGER,
            transaction_type TEXT,
            amount REAL,
            description TEXT,
            reference_id TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (wallet_id) REFERENCES wallets(id)
        );
        
        -- Payouts table
        CREATE TABLE IF NOT EXISTS payouts (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            wallet_id INTEGER,
            amount REAL,
            status TEXT DEFAULT 'requested',
            iban TEXT,
            bank_name TEXT,
            account_holder TEXT,
            reference_number TEXT,
            processed_at DATETIME,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (wallet_id) REFERENCES wallets(id)
        );
        
        -- Returns table
        CREATE TABLE IF NOT EXISTS returns (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            order_id INTEGER,
            reason TEXT,
            description TEXT,
            status TEXT DEFAULT 'requested',
            rma_code TEXT UNIQUE,
            return_address TEXT, -- JSON
            tracking_number TEXT,
            approved_at DATETIME,
            rejected_at DATETIME,
            completed_at DATETIME,
            admin_notes TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (order_id) REFERENCES orders(id)
        );
        
        -- Favorites table
        CREATE TABLE IF NOT EXISTS favorites (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER,
            product_id INTEGER,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id),
            FOREIGN KEY (product_id) REFERENCES products(id)
        );
        
        -- Survey table
        CREATE TABLE IF NOT EXISTS surveys (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            description TEXT,
            is_active BOOLEAN DEFAULT 1,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
        
        -- Survey Responses table
        CREATE TABLE IF NOT EXISTS survey_responses (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            survey_id INTEGER,
            user_id INTEGER NOT NULL,
            is_student BOOLEAN NOT NULL,
            is_interested BOOLEAN,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (survey_id) REFERENCES surveys(id),
            FOREIGN KEY (user_id) REFERENCES users(id)
        );
        
        -- Student Donations table
        CREATE TABLE IF NOT EXISTS student_donations (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            order_id INTEGER,
            product_id INTEGER,
            donation_percentage REAL NOT NULL,
            donation_amount REAL NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (order_id) REFERENCES orders(id),
            FOREIGN KEY (product_id) REFERENCES products(id)
        );
        
        -- Static Pages table
        CREATE TABLE IF NOT EXISTS static_pages (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            page_key TEXT UNIQUE,
            title TEXT,
            content TEXT,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
        
        -- Categories table
        CREATE TABLE IF NOT EXISTS categories (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            slug TEXT UNIQUE NOT NULL,
            description TEXT,
            icon TEXT,
            parent_id INTEGER,
            sort_order INTEGER DEFAULT 0,
            is_active BOOLEAN DEFAULT 1,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (parent_id) REFERENCES categories(id)
        );
        ";
        
        try {
            $this->pdo->exec($sql);
            
            // Products tablosuna category_id sütunu ekle (eğer yoksa)
            $this->addCategoryToProducts();
            
            // Varsayılan kategorileri oluştur
            $this->createDefaultCategories();
            
            // Varsayılan anket oluştur
            $this->createDefaultSurvey();
            
            // Varsayılan static sayfalar oluştur
            $this->createDefaultPages();
            
        } catch(PDOException $e) {
            echo "Tablo oluşturma hatası: " . $e->getMessage();
        }
    }
    
    private function addCategoryToProducts() {
        // Products tablosunda category_id sütunu var mı kontrol et
        $stmt = $this->pdo->query("PRAGMA table_info(products)");
        $columns = $stmt->fetchAll();
        $hasCategory = false;
        
        foreach ($columns as $column) {
            if ($column['name'] === 'category_id') {
                $hasCategory = true;
                break;
            }
        }
        
        if (!$hasCategory) {
            $this->pdo->exec("ALTER TABLE products ADD COLUMN category_id INTEGER REFERENCES categories(id)");
        }
    }
    
    private function createDefaultCategories() {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM categories");
        $stmt->execute();
        $count = $stmt->fetchColumn();
        
        if ($count == 0) {
            $categories = [
                ['Gıda & Market', 'gida-market', 'Taze sebze, meyve, bakkaliye ürünleri', '🍎', null, 1],
                ['Sebze & Meyve', 'sebze-meyve', 'Taze sebze ve meyveler', '🥬', 1, 1],
                ['Süt & Kahvaltılık', 'sut-kahvaltilik', 'Süt, peynir, yumurta ve kahvaltılık ürünler', '🥛', 1, 2],
                ['Ekmek & Unlu Mamul', 'ekmek-unlu-mamul', 'Ekmek, pasta, börek ve unlu mamuller', '🥖', 1, 3],
                ['Temel Gıda', 'temel-gida', 'Makarna, pirinç, un ve temel gıdalar', '🍚', 1, 4],
                ['İçecekler', 'icecekler', 'Su, meyve suyu ve içecekler', '🥤', 1, 5],
                ['Atıştırmalık', 'atistirmalik', 'Cips, çikolata ve atıştırmalıklar', '🍪', 1, 6],
                ['Ev & Yaşam', 'ev-yasam', 'Ev ve yaşam ürünleri', '🏠', null, 2],
                ['Temizlik', 'temizlik', 'Temizlik ürünleri', '🧹', 8, 1],
                ['Kişisel Bakım', 'kisisel-bakim', 'Kişisel bakım ürünleri', '🧴', 8, 2],
                ['Kırtasiye', 'kirtasiye', 'Kırtasiye ve ofis malzemeleri', '📚', null, 3],
                ['Elektronik', 'elektronik', 'Elektronik aksesuar ve ürünler', '📱', null, 4],
                ['Giyim', 'giyim', 'Giyim ve aksesuar', '👕', null, 5],
                ['Spor & Outdoor', 'spor-outdoor', 'Spor ve outdoor ürünleri', '⚽', null, 6],
                ['Diğer', 'diger', 'Diğer ürünler', '📦', null, 99]
            ];
            
            $stmt = $this->pdo->prepare("
                INSERT INTO categories (name, slug, description, icon, parent_id, sort_order) 
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            
            foreach ($categories as $category) {
                $stmt->execute($category);
            }
            
            // Mevcut ürünlere varsayılan kategori ata
            $this->pdo->exec("UPDATE products SET category_id = 1 WHERE category_id IS NULL");
        }
    }
    
    private function createDefaultSurvey() {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM surveys");
        $stmt->execute();
        $count = $stmt->fetchColumn();
        
        if ($count == 0) {
            $stmt = $this->pdo->prepare("
                INSERT INTO surveys (title, description, is_active) 
                VALUES (?, ?, ?)
            ");
            $stmt->execute([
                'Öğrenci Gelir Modeli Anketi',
                'Öğrencilerin platform üzerinden gelir elde etme konusundaki görüşlerini öğrenmek için yapılan anket.',
                1
            ]);
        }
    }
    
    private function createDefaultPages() {
        $pages = [
            ['terms', 'Kullanım Koşulları', 'Bu sayfa henüz güncellenmemiştir.'],
            ['privacy', 'Gizlilik Politikası', 'Bu sayfa henüz güncellenmemiştir.'],
            ['help', 'Yardım Merkezi', 'Bu sayfa henüz güncellenmemiştir.'],
            ['contact', 'İletişim', 'Bu sayfa henüz güncellenmemiştir.'],
            ['about', 'Hakkımızda', 'EsnappGO, Türkiye\'nin ilk öğrenci destekli e-ticaret platformudur.']
        ];
        
        foreach ($pages as $page) {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM static_pages WHERE page_key = ?");
            $stmt->execute([$page[0]]);
            $count = $stmt->fetchColumn();
            
            if ($count == 0) {
                $stmt = $this->pdo->prepare("
                    INSERT INTO static_pages (page_key, title, content) 
                    VALUES (?, ?, ?)
                ");
                $stmt->execute($page);
            }
        }
    }
}

?>
