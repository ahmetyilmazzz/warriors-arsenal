<?php
$rootPath = '../';
session_start();
require_once __DIR__ . '/../classes/database.php';
require_once __DIR__ . '/../classes/weapon.php';

$pageTitle = 'Yeni Silah Ekle';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit();
}

try {
    $db = new Database();
    $conn = $db->getConnection();
    $weaponObj = new Weapon($conn);
} catch (Exception $e) {
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'name' => trim($_POST['name'] ?? ''),
        'type' => trim($_POST['type'] ?? ''),
        'origin_country' => trim($_POST['origin_country'] ?? ''),
        'manufacture_year' => empty($_POST['manufacture_year']) ? null : trim($_POST['manufacture_year']),
        'historical_period' => trim($_POST['historical_period'] ?? ''),
        'material' => trim($_POST['material'] ?? ''),
        'length_cm' => empty($_POST['length_cm']) ? null : trim($_POST['length_cm']),
        'weight_kg' => empty($_POST['weight_kg']) ? null : trim($_POST['weight_kg']),
        'condition_status' => trim($_POST['condition_status'] ?? 'İyi'),
        'description' => trim($_POST['description'] ?? ''),
        'acquisition_date' => empty($_POST['acquisition_date']) ? null : trim($_POST['acquisition_date']),
        'estimated_value' => empty($_POST['estimated_value']) ? null : trim($_POST['estimated_value']),
        'image_url' => trim($_POST['image_url'] ?? ''),
        'created_by' => $_SESSION['user_id']
    ];

    if (empty($data['name']) || empty($data['type'])) {
        $error = 'Silah adı ve türü zorunludur!';
    } else {
        try {
            $result = $weaponObj->addWeapon($data);
            if ($result) {
                $success = 'Silah başarıyla eklendi! Liste sayfasına yönlendiriliyorsunuz...';
                header('Refresh: 2; url=list.php');
            } else {
                $error = 'Silah eklenirken bir hata oluştu!';
            }
        } catch (Exception $e) {
            $error = 'Hata: ' . $e->getMessage();
        }
    }
}

include __DIR__ . '/../includes/header.php';
?>

<div class="container form-container">
    <h2><i class="fas fa-plus me-2"></i>Yeni Silah Ekle</h2>
    <p>Tarihsel silah koleksiyonuna yeni bir silah ekleyin</p>
    
    <?php if ($error): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($error); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <?php if ($success): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($success); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form action="add.php" method="POST" id="weaponForm" class="needs-validation">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="name" class="form-label">Silah Adı *</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="type" class="form-label">Tür *</label>
                <input type="text" class="form-control" id="type" name="type" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="origin_country" class="form-label">Menşei Ülke</label>
                <input type="text" class="form-control" id="origin_country" name="origin_country">
            </div>
            <div class="col-md-6 mb-3">
                <label for="manufacture_year" class="form-label">Üretim Yılı</label>
                <input type="number" class="form-control" id="manufacture_year" name="manufacture_year" min="0" max="<?php echo date('Y'); ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label for="historical_period" class="form-label">Tarihsel Dönem</label>
                <input type="text" class="form-control" id="historical_period" name="historical_period">
            </div>
            <div class="col-md-6 mb-3">
                <label for="material" class="form-label">Malzeme</label>
                <input type="text" class="form-control" id="material" name="material">
            </div>
            <div class="col-md-6 mb-3">
                <label for="length_cm" class="form-label">Uzunluk (cm)</label>
                <input type="number" step="0.01" class="form-control" id="length_cm" name="length_cm">
            </div>
            <div class="col-md-6 mb-3">
                <label for="weight_kg" class="form-label">Ağırlık (kg)</label>
                <input type="number" step="0.01" class="form-control" id="weight_kg" name="weight_kg">
            </div>
            <div class="col-md-6 mb-3">
                <label for="condition_status" class="form-label">Durum</label>
                <select class="form-select" id="condition_status" name="condition_status">
                    <option value="Mükemmel">Mükemmel</option>
                    <option value="İyi" selected>İyi</option>
                    <option value="Orta">Orta</option>
                    <option value="Kötü">Kötü</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="acquisition_date" class="form-label">Edinme Tarihi</label>
                <input type="date" class="form-control" id="acquisition_date" name="acquisition_date">
            </div>
            <div class="col-md-6 mb-3">
                <label for="estimated_value" class="form-label">Tahmini Değer ($)</label>
                <input type="number" step="0.01" class="form-control" id="estimated_value" name="estimated_value">
            </div>
            <div class="col-md-6 mb-3">
                <label for="image_url" class="form-label">Resim URL</label>
                <input type="url" class="form-control" id="image_url" name="image_url" onchange="previewImage(this)">
                <img id="imagePreview" style="display:none; max-width:200px; margin-top:10px;" class="img-thumbnail mt-2" alt="Resim Önizleme">
            </div>
            <div class="col-12 mb-3">
                <label for="description" class="form-label">Açıklama</label>
                <textarea class="form-control" id="description" name="description" rows="4"></textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Kaydet</button>
        <a href="list.php" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i>Geri</a>
    </form>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>