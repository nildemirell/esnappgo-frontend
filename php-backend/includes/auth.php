<?php

require_once __DIR__ . '/../config/config.php';

class Auth {
    private $db;
    
    public function __construct($database) {
        $this->db = $database->getConnection();
    }
    
    public function register($email, $password, $full_name, $role = 'customer', $phone = null) {
        try {
            // Email kontrolü
            $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                return ['success' => false, 'message' => 'Bu email adresi zaten kayıtlı'];
            }
            
            // Şifreyi hashle
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            
            // Kullanıcı oluştur
            $stmt = $this->db->prepare("
                INSERT INTO users (email, password_hash, full_name, role, phone) 
                VALUES (?, ?, ?, ?, ?)
            ");
            $stmt->execute([$email, $password_hash, $full_name, $role, $phone]);
            
            $user_id = $this->db->lastInsertId();
            
            // Cüzdan oluştur
            $stmt = $this->db->prepare("INSERT INTO wallets (user_id) VALUES (?)");
            $stmt->execute([$user_id]);
            
            // Cart oluştur
            $stmt = $this->db->prepare("INSERT INTO carts (user_id) VALUES (?)");
            $stmt->execute([$user_id]);
            
            // Kullanıcı bilgilerini al
            $user = $this->getUserById($user_id);
            
            return ['success' => true, 'user' => $user];
            
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Kayıt sırasında hata oluştu: ' . $e->getMessage()];
        }
    }
    
    public function login($email, $password) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ? AND is_active = 1");
            $stmt->execute([$email]);
            $user = $stmt->fetch();
            
            if (!$user || !password_verify($password, $user['password_hash'])) {
                return ['success' => false, 'message' => 'Email veya şifre hatalı'];
            }
            
            // Session'a kullanıcı bilgilerini kaydet
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['user_name'] = $user['full_name'];
            
            // Token oluştur (basit implementasyon)
            $token = $this->generateToken($user['id']);
            
            unset($user['password_hash']); // Şifreyi response'dan çıkar
            
            return [
                'success' => true, 
                'user' => $user,
                'token' => $token
            ];
            
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Giriş sırasında hata oluştu: ' . $e->getMessage()];
        }
    }
    
    public function logout() {
        session_destroy();
        return ['success' => true, 'message' => 'Çıkış yapıldı'];
    }
    
    public function getCurrentUser() {
        if (isset($_SESSION['user_id'])) {
            return $this->getUserById($_SESSION['user_id']);
        }
        return null;
    }
    
    public function getUserById($user_id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch();
        
        if ($user) {
            unset($user['password_hash']);
        }
        
        return $user;
    }
    
    public function requireAuth() {
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Giriş yapmalısınız']);
            exit;
        }
        return $_SESSION['user_id'];
    }
    
    public function requireRole($required_role) {
        $user_id = $this->requireAuth();
        
        if ($_SESSION['user_role'] !== $required_role) {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'Yetkiniz yok']);
            exit;
        }
        
        return $user_id;
    }
    
    private function generateToken($user_id) {
        // Basit token implementasyonu
        return base64_encode($user_id . ':' . time() . ':' . Config::$jwt_secret_key);
    }
    
    public function updateProfile($user_id, $data) {
        try {
            $fields = [];
            $values = [];
            
            if (isset($data['full_name'])) {
                $fields[] = "full_name = ?";
                $values[] = $data['full_name'];
            }
            
            if (isset($data['phone'])) {
                $fields[] = "phone = ?";
                $values[] = $data['phone'];
            }
            
            if (empty($fields)) {
                return ['success' => false, 'message' => 'Güncellenecek alan bulunamadı'];
            }
            
            $fields[] = "updated_at = CURRENT_TIMESTAMP";
            $values[] = $user_id;
            
            $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute($values);
            
            $user = $this->getUserById($user_id);
            
            return ['success' => true, 'user' => $user];
            
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Profil güncellenirken hata oluştu: ' . $e->getMessage()];
        }
    }
}

?>
