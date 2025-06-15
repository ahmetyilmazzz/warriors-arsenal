<?php
$rootPath = './'; 
require_once 'includes/session_check.php';
require_once 'classes/database.php'; 
require_once 'classes/weapon.php';

$pageTitle = 'Ana Sayfa';

if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login.php');
    exit();
}

try {
    $database = new Database();
    $db = $database->getConnection();
    $weaponObj = new Weapon($db);
    $allWeapons = $weaponObj->getAllWeapons();
    $totalWeapons = count($allWeapons);

    $weaponTypes = [];
    foreach ($allWeapons as $weapon) {
        $type = $weapon['type'] ?? 'Bilinmeyen'; 
        $weaponTypes[$type] = isset($weaponTypes[$type]) ? $weaponTypes[$type] + 1 : 1;
    }

    $recentWeapons = array_slice($allWeapons, 0, 5);

} catch (Exception $e) {
    die("Veritabanı hatası: " . $e->getMessage());
}


include 'includes/header.php';

?>

<div class="row">
    <div class="col-12">
        <div class="jumbotron bg-primary text-white p-5 rounded mb-4">
            <h1 class="display-4">
                <i class="fas fa-shield-alt me-3"></i>Tarihsel Silah Koleksiyonu
            </h1>
            <p class="lead">Tarihin derinliklerinden gelen silahları keşfedin ve kataloglayın</p>
            <hr class="my-4" style="border-color: rgba(255,255,255,0.3);">
            <p>Koleksiyonunuzdaki tarihi silahları yönetin, detaylarını kaydedin ve gelecek nesillere aktarın.</p>
            <a class="btn btn-light btn-lg" href="weapons/add.php" role="button">
                <i class="fas fa-plus me-2"></i>Yeni Silah Ekle
            </a>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-info text-white h-100">
            <div class="card-body text-center">
                <i class="fas fa-list fa-3x mb-3"></i>
                <h3><?php echo htmlspecialchars($totalWeapons); ?></h3>
                <p>Toplam Silah</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white h-100">
            <div class="card-body text-center">
                <i class="fas fa-tags fa-3x mb-3"></i>
                <h3><?php echo htmlspecialchars(count($weaponTypes)); ?></h3>
                <p>Farklı Tür</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white h-100">
            <div class="card-body text-center">
                <i class="fas fa-clock fa-3x mb-3"></i>
                <h3><?php echo htmlspecialchars(count($recentWeapons)); ?></h3>
                <p>Son Eklenen</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white h-100">
            <div class="card-body text-center">
                <i class="fas fa-user fa-3x mb-3"></i>
                <h3><?php echo htmlspecialchars($_SESSION['username'] ?? 'Misafir'); ?></h3>
                <p>Aktif Kullanıcı</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-chart-pie me-2"></i>Türe Göre Dağılım</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($weaponTypes)): ?>
                    <?php foreach ($weaponTypes as $type => $count): ?>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span><?php echo htmlspecialchars($type); ?></span>
                            <span class="badge bg-primary"><?php echo htmlspecialchars($count); ?></span>
                        </div>
                        <div class="progress mb-3" style="height: 8px;">
                            <div class="progress-bar" style="width: <?php echo ($totalWeapons > 0 ? ($count / $totalWeapons) * 100 : 0); ?>%;"></div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted">Henüz silah eklenmemiş.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5><i class="fas fa-history me-2"></i>Son Eklenen Silahlar</h5>
                <a href="weapons/list.php" class="btn btn-sm btn-outline-primary">Tümünü Gör</a>
            </div>
            <div class="card-body">
                <?php if (!empty($recentWeapons)): ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($recentWeapons as $weapon): ?>
                            <a href="weapons/view.php?id=<?php echo htmlspecialchars($weapon['id']); ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1"><?php echo htmlspecialchars($weapon['name']); ?></h6>
                                    <small class="text-muted">
                                        <?php echo htmlspecialchars($weapon['type'] ?? 'Bilinmeyen'); ?> - 
                                        <?php echo htmlspecialchars($weapon['origin_country'] ?? 'Bilinmeyen'); ?>
                                    </small>
                                </div>
                                <span class="badge rounded-pill condition-badge condition-<?php echo str_replace(' ', '-', $weapon['condition_status'] ?? 'Unknown'); ?>">
                                    <?php echo htmlspecialchars($weapon['condition_status'] ?? 'Bilinmeyen'); ?>
                                </span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-muted">Henüz silah eklenmemiş.</p>
                    <a href="weapons/add.php" class="btn btn-primary">İlk Silahı Ekle</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-bolt me-2"></i>Hızlı Eylemler</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="weapons/add.php" class="btn btn-success w-100">
                            <i class="fas fa-plus fa-2x d-block mb-2"></i>
                            Yeni Silah Ekle
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="weapons/list.php" class="btn btn-info w-100">
                            <i class="fas fa-list fa-2x d-block mb-2"></i>
                            Silah Listesi
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="weapons/list.php?search=" class="btn btn-warning w-100">
                            <i class="fas fa-search fa-2x d-block mb-2"></i>
                            Arama Yap
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="auth/logout.php" class="btn btn-danger w-100">
                            <i class="fas fa-sign-out-alt fa-2x d-block mb-2"></i>
                            Çıkış Yap
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>