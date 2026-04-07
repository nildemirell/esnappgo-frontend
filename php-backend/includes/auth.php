<?php

require_once __DIR__ . '/../config/config.php';

class Auth
{


   
  

    public function logout()
    {
        session_destroy();
        return ['success' => true, 'message' => 'Çıkış yapıldı'];
    }
    public function getCurrentUser()
    {
        if (isset($_SESSION['user_id'])) {
            return [
                'id' => $_SESSION['user_id'],
                'email' => $_SESSION['email'] ?? '',
                'role' => $_SESSION['user_role'] ?? 'customer', // DÜZELTME: user_role olarak değiştirdik
                'full_name' => $_SESSION['user_name'] ?? 'Kullanıcı' // DÜZELTME: user_name
            ];
        }
        return null;
    }



    public function requireAuth()
    {
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Giriş yapmalısınız']);
            exit;
        }
        return $_SESSION['user_id'];
    }

    public function requireRole($required_role)
    {
        $user_id = $this->requireAuth();

        if ($_SESSION['user_role'] !== $required_role) {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'Yetkiniz yok']);
            exit;
        }

        return $user_id;
    }

    
}

?>