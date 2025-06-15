<?php
session_start();

function checkLogin() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: ../auth/login.php');
        exit();
    }
}

function checkAlreadyLoggedIn() {
    if (isset($_SESSION['user_id'])) {
        header('Location: ../index.php');
        exit();
    }
}

function logout() {
    session_unset();
    session_destroy();
    header('Location: ../auth/login.php');
    exit();
}

function redirect($url) {
    header("Location: $url");
    exit();
}
?>