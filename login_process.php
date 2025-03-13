<?php
session_start();
require_once 'config.php';

$email = $_POST['email'];
$password = $_POST['password'];

// Проверка пользователя в базе данных
$stmt = $conn->prepare("SELECT id, password, role FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($userId, $hashedPassword, $userRole);
$stmt->fetch();
$stmt->close();

if (password_verify($password, $hashedPassword)) {
    $_SESSION['user_id'] = $userId;
    $_SESSION['user_role'] = $userRole;
    header("Location: profile.php"); // Перенаправление на страницу профиля
    exit();
} else {
    header("Location: login.php?error=1"); // Перенаправление обратно на страницу входа с ошибкой
    exit();
}
?>