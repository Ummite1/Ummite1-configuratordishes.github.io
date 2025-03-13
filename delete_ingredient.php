<?php
session_start();
require_once 'config.php';

// Проверка авторизации и роли пользователя
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM ingredients WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

header('Location: admin.php');
exit;
?>