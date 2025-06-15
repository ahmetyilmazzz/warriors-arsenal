<?php
$rootPath = '../';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit();
}

require_once __DIR__ . '/../classes/database.php';
require_once __DIR__ . '/../classes/weapon.php';

try {
    $database = new Database();
    $db = $database->getConnection();
    $weaponObj = new Weapon($db);
} catch (Exception $e) {
    die("Sistem hatası: Veritabanına bağlanılamadı. Detay: " . $e->getMessage());
}

$pageTitle = 'Silah Listesi';
$searchTerm = $_GET['search'] ?? '';

try {
    if (!empty($searchTerm)) {
        $pageTitle = "'$searchTerm' Arama Sonuçları";
        $weapons = $weaponObj->searchWeapons($searchTerm);
    } else {
        $weapons = $weaponObj->getAllWeapons();
    }
} catch (Exception $e) {
    $weapons = []; 
    $error = "Silahlar listelenirken bir hata oluştu: " . $e->getMessage();
}

include __DIR__ . '/../includes/header.php';
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-list-ul me-2"></i><?php echo htmlspecialchars($pageTitle); ?></h2>
        <a href="add.php" class="btn btn-success"><i class="fas fa-plus me-2"></i>Yeni Silah Ekle</a>
    </div>

    <div class="row mb-4">
        <div class="col-md-6 offset-md-3">
            <div class="input-group">
                <input type="text" class="form-control" id="searchInput" placeholder="Silah adı, türü veya açıklamada ara..." value="<?php echo htmlspecialchars($searchTerm); ?>" onkeypress="handleSearchKeyPress(event)">
                <button class="btn btn-primary" type="button" onclick="searchWeapons()">
                    <i class="fas fa-search"></i> Ara
                </button>
            </div>
        </div>
    </div>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover" id="weaponsTable">
            <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Resim</th>
                    <th scope="col" style="cursor: pointer;" onclick="sortTable(2)">İsim <i class="fas fa-sort"></i></th>
                    <th scope="col" style="cursor: pointer;" onclick="sortTable(3)">Tür <i class="fas fa-sort"></i></th>
                    <th scope="col">Menşei</th>
                    <th scope="col">Yıl</th>
                    <th scope="col">Durum</th>
                    <th scope="col">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($weapons)): ?>
                    <tr>
                        <td colspan="8" class="text-center">
                            <?php if (!empty($searchTerm)): ?>
                                '<?php echo htmlspecialchars($searchTerm); ?>' için sonuç bulunamadı.
                            <?php else: ?>
                                Gösterilecek silah bulunmuyor.
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($weapons as $index => $weapon): ?>
                        <tr>
                            <th scope="row"><?php echo $index + 1; ?></th>
                            <td>
                                <img src="<?php echo !empty($weapon['image_url']) ? htmlspecialchars($weapon['image_url']) : '../images/default_weapon.png'; ?>" alt="<?php echo htmlspecialchars($weapon['name']); ?>" class="img-thumbnail" style="width: 100px; height: 75px; object-fit: cover;">
                            </td>
                            <td><?php echo htmlspecialchars($weapon['name']); ?></td>
                            <td><?php echo htmlspecialchars($weapon['type']); ?></td>
                            <td><?php echo htmlspecialchars($weapon['origin_country']); ?></td>
                            <td><?php echo htmlspecialchars($weapon['manufacture_year']); ?></td>
                            <td>
                                <span class="badge rounded-pill condition-<?php echo htmlspecialchars($weapon['condition_status']); ?>">
                                    <?php echo htmlspecialchars($weapon['condition_status']); ?>
                                </span>
                            </td>
                            <td>
                                <a href="view.php?id=<?php echo $weapon['id']; ?>" class="btn btn-info btn-sm" title="Görüntüle"><i class="fas fa-eye"></i></a>
                                <a href="edit.php?id=<?php echo $weapon['id']; ?>" class="btn btn-warning btn-sm" title="Düzenle"><i class="fas fa-edit"></i></a>
                                <a href="delete.php?id=<?php echo $weapon['id']; ?>" class="btn btn-danger btn-sm" title="Sil" onclick="return confirmDelete('<?php echo htmlspecialchars($weapon['name'], ENT_QUOTES); ?>')"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>