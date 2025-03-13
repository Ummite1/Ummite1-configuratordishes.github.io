<?php
session_start();
require_once 'config.php';

$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$role = 'user'; // По умолчанию роль пользователя

// Вставка нового пользователя в базу данных
$stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $username, $email, $password, $role);

if ($stmt->execute()) {
    $_SESSION['user_id'] = $stmt->insert_id;
    $_SESSION['user_role'] = $role;
    header("Location: profile.php"); // Перенаправление на страницу профиля
    exit();
} else {
    header("Location: register.php?error=1"); // Перенаправление обратно на страницу регистрации с ошибкой
    exit();
}
$stmt->close();
?>