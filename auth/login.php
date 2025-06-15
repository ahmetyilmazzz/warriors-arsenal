<?php
$rootPath = '../'; 
require_once '../includes/session_check.php';
require_once '../classes/database.php';
require_once '../classes/user.php';

$pageTitle = 'Giriş Yap';
checkAlreadyLoggedIn();

$error = '';
$success = '';

if (isset($_GET['message'])) {
    switch ($_GET['message']) {
        case 'register_success':
            $success = 'Kayıt başarılı! Şimdi giriş yapabilirsiniz.';
            break;
        case 'logout_success':
            $success = 'Başarıyla çıkış yaptınız.';
            break;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    if (empty($username) || empty($password)) {
        $error = 'Kullanıcı adı ve şifre boş bırakılamaz!';
    } else {
        try {
            $database = new Database();
            $db_conn = $database->getConnection();
            
            $userObj = new User($db_conn);
            $user = $userObj->login($username, $password);

            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['full_name'] = $user['full_name'];
                
                header('Location: ../index.php');
                exit();
            } else {
                $error = 'Kullanıcı adı veya şifre hatalı!';
            }
        } catch (Exception $e) {
            $error = 'Bir hata oluştu: ' . $e->getMessage();
            error_log('Login Error: ' . $e->getMessage());
        }
    }
}

include '../includes/header.php';
?>
<div class="login-container">
    <div class="form-container">
        <div class="text-center mb-4">
            <i class="fas fa-shield-alt fa-3x text-primary mb-3"></i>
            <h2>Giriş Yap</h2>
            <p class="text-muted">Hesabınıza giriş yapın</p>
        </div>
        
        <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i><?php echo $error; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i><?php echo $success; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="mb-3">
                <label for="username" class="form-label">
                    <i class="fas fa-user me-1"></i>Kullanıcı Adı veya E-posta
                </label>
                <input type="text" class="form-control" id="username" name="username" 
                       value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" 
                       required>
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label">
                    <i class="fas fa-lock me-1"></i>Şifre
                </label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            
            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-sign-in-alt me-2"></i>Giriş Yap
                </button>
            </div>
        </form>
        
        <hr class="my-4">
        
        <div class="text-center">
            <p class="mb-0">Hesabınız yok mu?</p>
            <a href="register.php" class="btn btn-outline-secondary">
                <i class="fas fa-user-plus me-2"></i>Kayıt Ol
            </a>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>