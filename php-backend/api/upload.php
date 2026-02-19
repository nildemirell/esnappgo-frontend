<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: http://localhost:8080');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Access-Control-Allow-Credentials: true');

// Session'ı başlat
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/database.php';

// Database bağlantısı
$database = new Database();
$auth = new Auth($database);

// OPTIONS isteklerini handle et
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}

try {
    // Authentication kontrol
    $user_id = $auth->requireAuth();
    
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Sadece POST metodu desteklenir']);
        exit;
    }
    
    if (!isset($_FILES['file'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Dosya bulunamadı']);
        exit;
    }
    
    $file = $_FILES['file'];
    
    // Dosya hatası kontrolü
    if ($file['error'] !== UPLOAD_ERR_OK) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Dosya yükleme hatası']);
        exit;
    }
    
    // Dosya boyutu kontrolü
    if ($file['size'] > Config::$max_file_size) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Dosya çok büyük']);
        exit;
    }
    
    // Dosya türü kontrolü
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($extension, Config::$allowed_extensions)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Desteklenmeyen dosya türü']);
        exit;
    }
    
    // Dosya adı oluştur
    $filename = uniqid() . '_' . time() . '.' . $extension;
    $filepath = Config::$media_root . '/' . $filename;
    
    // Media klasörünü oluştur
    if (!file_exists(Config::$media_root)) {
        mkdir(Config::$media_root, 0755, true);
    }
    
    // Dosyayı taşı
    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        $file_url = Config::$media_url . '/' . $filename;
        
        echo json_encode([
            'success' => true,
            'data' => [
                'filename' => $filename,
                'url' => $file_url,
                'size' => $file['size'],
                'type' => $file['type']
            ]
        ]);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Dosya kaydedilemedi']);
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Sunucu hatası: ' . $e->getMessage()]);
}

?>
