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

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/auth.php';

// Auth instance
$auth = new Auth();

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

        default:
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Endpoint bulunamadı']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Sunucu hatası: ' . $e->getMessage()]);
}

// Auth endpoints
function handleAuth($auth, $method, $path_parts, $input)
{
    $action = $path_parts[1] ?? '';

    switch ($method) {
        case 'POST':
            switch ($action) {

                case 'logout':
                    $result = $auth->logout();
                    echo json_encode($result);
                    break;

                case 'update_session':
                    // .NET'ten login olduktan sonra JS sadece bu endpoint'e güncel veriyi gönderir.
                    $email = $input['email'] ?? '';
                    $role = strtolower($input['role'] ?? 'customer');
                    $fullName = $input['fullName'] ?? 'Kullanıcı';

                    if ($email) {
                        $_SESSION['user_id'] = $email; // Artık ID olarak email'i veya auth0/supabase uid'sini baz alabiliriz.
                        $_SESSION['email'] = $email;
                        $_SESSION['user_role'] = $role;
                        $_SESSION['user_name'] = $fullName;

                        echo json_encode(['success' => true, 'message' => 'Oturum eşitlendi']);
                    } else {
                        http_response_code(400);
                        echo json_encode(['success' => false, 'message' => 'Eksik veri']);
                    }
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