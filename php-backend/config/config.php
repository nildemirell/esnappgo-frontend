<?php

class Config {
    // Database
    public static $database_url = "sqlite:esnappgo.db";
    
    // JWT
    public static $jwt_secret_key = "your-super-secret-jwt-key-change-this-in-production";
    public static $jwt_algorithm = "HS256";
    public static $access_token_expire_minutes = 30;
    public static $refresh_token_expire_days = 7;
    
    // CORS
    public static $cors_origins = ["http://localhost:3000", "http://127.0.0.1:3000", "http://localhost:8080"];
    
    // File Upload
    public static $media_root = "./media";
    public static $max_file_size = 10485760; // 10MB
    public static $allowed_extensions = ["jpg", "jpeg", "png", "webp", "mp4", "mov"];
    
    // Business Settings
    public static $platform_rate = 10.0; // %10
    public static $student_rate = 10.0;  // %10
    public static $merchant_rate = 75.0; // %75
    
    // Site Settings
    public static $site_name = "EsnappGO";
    public static $site_description = "Öğrenci Destekli E-ticaret Platformu";
    public static $site_url = "http://localhost:8080";
    
    // API Base URL
    public static $api_base_url = "http://localhost:8080/api";
    
    // Media URL
    public static $media_url = "http://localhost:8080/media";
    
    public static function init() {
        // Media klasörünü oluştur
        if (!file_exists(self::$media_root)) {
            mkdir(self::$media_root, 0755, true);
        }
        
        // Session başlat
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
}

// Config'i başlat
Config::init();

?>
