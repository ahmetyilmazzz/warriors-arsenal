<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit();
}

require_once __DIR__ . '/../classes/database.php';
require_once __DIR__ . '/../classes/weapon.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: list.php?message=invalid_id');
    exit();
}
$id = (int)$_GET['id'];

try {
    $database = new Database();
    $db = $database->getConnection();

    $weaponObj = new Weapon($db);

    if ($weaponObj->deleteWeapon($id)) {
        header('Location: list.php?message=delete_success');
        exit();
    } else {
        header('Location: list.php?message=delete_error');
        exit();
    }
} catch (Exception $e) {
    die("Sistem hatası: " . $e->getMessage());
}