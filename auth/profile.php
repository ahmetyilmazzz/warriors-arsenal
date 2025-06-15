<?php
require_once '../includes/session_check.php';
require_once '../classes/database.php';
require_once '../classes/user.php';

checkLogin();

$pageTitle = 'Profilim';
$rootPath = '../'; 

$db = new Database();
$userObj = new User($db->getConnection());
$userId = $_SESSION['user_id'];

$info_error = '';
$info_success = '';
$pass_error = '';
$pass_success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_info'])) {
        $fullName = trim($_POST['full_name']);
        $email = trim($_POST['email']);

        if (empty($fullName) || empty($email)) {
            $info_error = 'Ad soyad ve e-posta alanları boş bırakılamaz.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $info_error = 'Lütfen geçerli bir e-posta adresi girin.';
        } else {
            $result = $userObj->updateProfile($userId, $fullName, $email);
            if ($result['success']) {
                $info_success = 'Profil bilgileriniz başarıyla güncellendi.';
                $_SESSION['full_name'] = $fullName;
                $_SESSION['email'] = $email;
            } else {
                $info_error = $result['error'];
            }
        }
    }

    if (isset($_POST['update_password'])) {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
            $pass_error = 'Tüm şifre alanları doldurulmalıdır.';
        } elseif (strlen($new_password) < 6) {
            $pass_error = 'Yeni şifre en az 6 karakter olmalıdır.';
        } elseif ($new_password !== $confirm_password) {
            $pass_error = 'Yeni şifreler eşleşmiyor.';
        } else {
            $result = $userObj->updatePassword($userId, $current_password, $new_password);
            if ($result['success']) {
                $pass_success = 'Şifreniz başarıyla değiştirildi.';
            } else {
                $pass_error = $result['error'];
            }
        }
    }
}

$currentUser = $userObj->getUserById($userId);

include '../includes/header.php';
?>

<div class="container">
    <h2><i class="fas fa-user-edit me-2"></i>Profil Bilgilerini Düzenle</h2>
    <p class="text-muted">Kişisel bilgilerinizi ve şifrenizi buradan güncelleyebilirsiniz.</p>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Kişisel Bilgiler</h5>
                </div>
                <div class="card-body">
                    <?php if ($info_error): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($info_error); ?></div>
                    <?php endif; ?>
                    <?php if ($info_success): ?>
                        <div class="alert alert-success"><?php echo htmlspecialchars($info_success); ?></div>
                    <?php endif; ?>
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="username" class="form-label">Kullanıcı Adı</label>
                            <input type="text" class="form-control" id="username" value="<?php echo htmlspecialchars($currentUser['username']); ?>" disabled>
                            <small class="form-text text-muted">Kullanıcı adınız değiştirilemez.</small>
                        </div>
                        <div class="mb-3">
                            <label for="full_name" class="form-label">Ad Soyad</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo htmlspecialchars($currentUser['full_name']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">E-posta Adresi</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($currentUser['email']); ?>" required>
                        </div>
                        <button type="submit" name="update_info" class="btn btn-primary">Bilgileri Güncelle</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Şifre Değiştir</h5>
                </div>
                <div class="card-body">
                    <?php if ($pass_error): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($pass_error); ?></div>
                    <?php endif; ?>
                    <?php if ($pass_success): ?>
                        <div class="alert alert-success"><?php echo htmlspecialchars($pass_success); ?></div>
                    <?php endif; ?>
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Mevcut Şifre</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">Yeni Şifre</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Yeni Şifre (Tekrar)</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        <button type="submit" name="update_password" class="btn btn-danger">Şifreyi Değiştir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>