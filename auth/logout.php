<?php
$rootPath = '../'; 
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    session_destroy();
    header('Location: login.php?message=logout_success');
    exit();
}

$pageTitle = 'Çıkış Yap';
include '../includes/header.php';
?>

<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg">
                <div class="card-header bg-danger text-white text-center">
                    <h2 class="mb-0"><i class="fas fa-sign-out-alt"></i> Çıkış Yap</h2>
                </div>
                <div class="card-body p-4 text-center">
                    <p class="lead">Çıkış yapmak istediğinizden emin misiniz?</p>
                    <p class="text-muted">Oturumunuz sonlandırılacak ve tekrar giriş yapmanız gerekecektir.</p>
                    <div class="d-grid gap-2 mt-4">
                        <a href="logout.php?confirm=yes" class="btn btn-danger btn-lg">Evet, Çıkış Yap</a>
                        <a href="<?php echo isset($_SERVER['HTTP_REFERER']) ? htmlspecialchars($_SERVER['HTTP_REFERER']) : '../index.php'; ?>" class="btn btn-secondary">İptal</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>