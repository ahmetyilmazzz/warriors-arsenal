<?php
$rootPath = '../'; 
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../classes/database.php';
require_once __DIR__ . '/../classes/user.php';

if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit();
}

$pageTitle = 'Kayıt Ol';
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $full_name = trim($_POST['full_name']);
    if (empty($username) || empty($email) || empty($password) || empty($full_name)) {
        $error = 'Tüm alanları doldurun.';
    } elseif (strlen($username) < 3) {
        $error = 'Kullanıcı adı en az 3 karakter olmalıdır.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Geçerli bir e-posta adresi girin.';
    } elseif (strlen($password) < 6) {
        $error = 'Şifre en az 6 karakter olmalıdır.';
    } elseif ($password !== $confirm_password) {
        $error = 'Şifreler eşleşmiyor.';
    } else {
        try {
            $database = new Database();
            $db = $database->getConnection();
            $user = new User($db);
            $result = $user->register($username, $email, $password, $full_name);

            if ($result['success']) {
                header('Location: login.php?message=register_success');
                exit();
            } else {
                $error = $result['error'];
            }
        } catch (Exception $e) {
            $error = 'Sistem hatası: ' . $e->getMessage();
        }
    }
}

include '../includes/header.php';
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card register-card mt-5">
                <div class="card-header text-center bg-secondary text-white">
                    <h2>Kayıt Ol</h2>
                    <p class="mb-0">Tarihsel Silah Katalogu</p>
                </div>
                <div class="card-body p-4">
                    <?php if ($error): ?>
                        <div class="alert alert-danger">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($success): ?>
                        <div class="alert alert-success">
                            <?php echo htmlspecialchars($success); ?>
                        </div>
                    <?php endif; ?>

                    <form action="register.php" method="POST" id="registerForm" class="needs-validation">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Ad Soyad" value="<?php echo isset($_POST['full_name']) ? htmlspecialchars($_POST['full_name']) : ''; ?>" required>
                            <label for="full_name">Ad Soyad</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Kullanıcı Adı" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required>
                            <label for="username">Kullanıcı Adı</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="E-posta" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                            <label for="email">E-posta Adresi</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Şifre" required>
                            <label for="password">Şifre</label>
                        </div>

                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Şifre Tekrar" required>
                            <label for="confirm_password">Şifre Tekrar</label>
                        </div>

                        <button class="btn btn-primary btn-lg w-100" type="submit">Kayıt Ol</button>
                    </form>
                    <div class="login-link mt-4 text-center">
                        <p class="mb-0">Zaten hesabınız var mı? <a href="login.php">Giriş Yap</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>