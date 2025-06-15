<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$basePath = '';

if ($host == 'localhost') {
    $basePath = '/historical-weapons-catalog/'; 
    

} else {
    $basePath = '/~st22360859044/';
}

$fullBaseUrl = rtrim($protocol . $host . $basePath, '/') . '/';

?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) . ' - ' : ''; ?>Tarihsel Silah Kataloğu</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo $fullBaseUrl; ?>css/style.css">
</head>
<body>

<div class="main-wrapper">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?php echo $fullBaseUrl; ?>index.php">
                <i class="fas fa-shield-alt me-2"></i>Tarihsel Silah Koleksiyonu
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                       <a class="nav-link" href="<?php echo $fullBaseUrl; ?>index.php">
                            <i class="fas fa-home me-1"></i>Ana Sayfa
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $fullBaseUrl; ?>weapons/list.php">
                            <i class="fas fa-list me-1"></i>Silah Listesi
                        </a>
                    </li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $fullBaseUrl; ?>weapons/add.php">
                            <i class="fas fa-plus me-1"></i>Yeni Silah Ekle
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-1"></i><?php echo htmlspecialchars($_SESSION['username']); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="<?php echo $fullBaseUrl; ?>auth/profile.php">
                                    <i class="fas fa-user-cog me-1"></i>Profilim
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="<?php echo $fullBaseUrl; ?>auth/logout.php">
                                    <i class="fas fa-sign-out-alt me-1"></i>Çıkış Yap
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <?php else: ?>
                    <ul class="navbar-nav">
                         <li class="nav-item">
                             <a class="nav-link" href="<?php echo $fullBaseUrl; ?>auth/login.php">Giriş Yap</a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" href="<?php echo $fullBaseUrl; ?>auth/register.php">Kayıt Ol</a>
                         </li>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    
    <main class="container mt-4">