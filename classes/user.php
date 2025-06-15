<?php
$logDir = __DIR__ . '/../logs'; 
if (!is_dir($logDir)) {
    if (!mkdir($logDir, 0755, true) && !is_dir($logDir)) {
        error_log("Logs klasörü oluşturulamadı: $logDir", 0);
    }
}
if (is_dir($logDir) && is_writable($logDir)) {
    define('LOG_FILE', $logDir . '/error.log');
} else {
    define('LOG_FILE', null);
    error_log("Logs klasörü yazılabilir değil: $logDir", 0);
}

class User {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function register($username, $email, $password, $full_name) {
        if ($this->userExists($username, $email)) {
            return ['success' => false, 'error' => 'Bu kullanıcı adı veya e-posta zaten kullanılıyor'];
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, email, password_hash, full_name) VALUES (:username, :email, :password_hash, :full_name)";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password_hash', $hashedPassword);
            $stmt->bindParam(':full_name', $full_name);
            $result = $stmt->execute();
            if (!$result) {
                $errorInfo = $stmt->errorInfo();
                $this->logError("Kullanıcı kaydı başarısız: " . json_encode($errorInfo) . " | Girdi: username=$username, email=$email, full_name=$full_name");
                return ['success' => false, 'error' => 'Kayıt işlemi başarısız: Veritabanı hatası - ' . $errorInfo[2]];
            }
            return ['success' => true];
        } catch (Exception $e) {
            $this->logError("Kullanıcı kaydı hatası: " . $e->getMessage() . " | Girdi: username=$username, email=$email, full_name=$full_name");
            return ['success' => false, 'error' => 'Kayıt hatası: ' . $e->getMessage()];
        }
    }

    public function login($username, $password) {
        $sql = "SELECT * FROM users WHERE username = :username OR email = :email";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $username); 
            $stmt->execute();
            $user = $stmt->fetch();
            if ($user && password_verify($password, $user['password_hash'])) {
                return $user;
            }
            $this->logError("Giriş başarısız: Geçersiz kimlik bilgileri | Girdi: username=$username");
            return false;
        } catch (Exception $e) {
            $this->logError("Giriş hatası: " . $e->getMessage() . " | Girdi: username=$username");
            return false;
        }
    }

    public function userExists($username, $email) {
        $sql = "SELECT COUNT(*) FROM users WHERE username = :username OR email = :email";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        } catch (Exception $e) {
            $this->logError("Kullanıcı kontrol hatası: " . $e->getMessage() . " | Girdi: username=$username, email=$email");
            return false;
        }
    }

    public function getUserById($id) {
        $sql = "SELECT id, username, email, full_name, created_at FROM users WHERE id = :id";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch();
        } catch (Exception $e) {
            $this->logError("Kullanıcı getir hatası: " . $e->getMessage() . " | Girdi: id=$id");
            return false;
        }
    }

    public function updateProfile($id, $fullName, $email) {
        $sql_check = "SELECT id FROM users WHERE email = :email AND id != :id";
        try {
            $stmt_check = $this->conn->prepare($sql_check);
            $stmt_check->bindParam(':email', $email);
            $stmt_check->bindParam(':id', $id);
            $stmt_check->execute();
            if ($stmt_check->fetch()) {
                return ['success' => false, 'error' => 'Bu e-posta adresi başka bir hesap tarafından kullanılıyor'];
            }

            $sql = "UPDATE users SET full_name = :full_name, email = :email WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':full_name', $fullName);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return ['success' => true];
        } catch (Exception $e) {
            $this->logError("Profil güncelleme hatası: " . $e->getMessage() . " | Girdi: id=$id");
            return ['success' => false, 'error' => 'Profil güncellenirken hata oluştu'];
        }
    }

    public function updatePassword($id, $currentPassword, $newPassword) {
        $sql_fetch = "SELECT password_hash FROM users WHERE id = :id";
        try {
            $stmt_fetch = $this->conn->prepare($sql_fetch);
            $stmt_fetch->bindParam(':id', $id);
            $stmt_fetch->execute();
            $user = $stmt_fetch->fetch();
            if (!$user || !password_verify($currentPassword, $user['password_hash'])) {
                return ['success' => false, 'error' => 'Mevcut şifreniz hatalı'];
            }

            $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $sql_update = "UPDATE users SET password_hash = :password_hash WHERE id = :id";
            $stmt_update = $this->conn->prepare($sql_update);
            $stmt_update->bindParam(':password_hash', $newHashedPassword);
            $stmt_update->bindParam(':id', $id);
            $stmt_update->execute();
            return ['success' => true];
        } catch (Exception $e) {
            $this->logError("Şifre güncelleme hatası: " . $e->getMessage() . " | Girdi: id=$id");
            return ['success' => false, 'error' => 'Şifre güncellenirken hata oluştu'];
        }
    }

    private function logError($message) {
        if (defined('LOG_FILE') && LOG_FILE) {
            error_log($message, 3, LOG_FILE);
        } else {
            error_log($message, 0);
        }
    }
}