<?php
$rootPath = '../';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit();
}

require_once __DIR__ . '/../classes/database.php';
require_once __DIR__ . '/../classes/weapon.php';
require_once __DIR__ . '/../classes/user.php'; 

$pageTitle = 'Silah Detayı';
$weapon = null;

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: list.php?message=invalid_id');
    exit();
}
$id = (int)$_GET['id'];

try {
    $database = new Database();
    $db = $database->getConnection();

    $weaponObj = new Weapon($db);
    
    $weapon = $weaponObj->getWeaponById($id);

} catch (Exception $e) {
    die("Sistem hatası: " . $e->getMessage());
}

if (!$weapon) {
    header('Location: list.php?message=not_found');
    exit();
}

include __DIR__ . '/../includes/header.php';
?>

<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="row g-0">
            <div class="col-lg-5">
                <img src="<?php echo !empty($weapon['image_url']) ? htmlspecialchars($weapon['image_url']) : '../images/default_weapon.png'; ?>" class="img-fluid rounded-start" alt="<?php echo htmlspecialchars($weapon['name']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <div class="col-lg-7">
                <div class="card-header bg-dark text-white">
                    <h2 class="card-title mb-0"><?php echo htmlspecialchars($weapon['name']); ?></h2>
                    <p class="card-text text-muted mb-0"><?php echo htmlspecialchars($weapon['type']); ?></p>
                </div>
                <div class="card-body">
                    <p class="card-text"><?php echo nl2br(htmlspecialchars($weapon['description'])); ?></p>
                    
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Menşei:</strong> <?php echo htmlspecialchars($weapon['origin_country']); ?></li>
                        <li class="list-group-item"><strong>Üretim Yılı:</strong> <?php echo htmlspecialchars($weapon['manufacture_year']); ?></li>
                        <li class="list-group-item"><strong>Tarihsel Dönem:</strong> <?php echo htmlspecialchars($weapon['historical_period']); ?></li>
                        <li class="list-group-item"><strong>Malzeme:</strong> <?php echo htmlspecialchars($weapon['material']); ?></li>
                        <li class="list-group-item"><strong>Durum:</strong> <span class="badge rounded-pill condition-<?php echo htmlspecialchars($weapon['condition_status']); ?>"><?php echo htmlspecialchars($weapon['condition_status']); ?></span></li>
                        <li class="list-group-item"><strong>Ekleyen:</strong> <?php echo htmlspecialchars($weapon['created_by_username']); ?></li>
                        <li class="list-group-item"><strong>Eklenme Tarihi:</strong> <?php echo date('d/m/Y H:i', strtotime($weapon['created_at'])); ?></li>
                    </ul>
                </div>
                <div class="card-footer text-end">
                    <a href="list.php" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i>Listeye Dön</a>
                    <a href="edit.php?id=<?php echo $weapon['id']; ?>" class="btn btn-warning"><i class="fas fa-edit me-2"></i>Düzenle</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>