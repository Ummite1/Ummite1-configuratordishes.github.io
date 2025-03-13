<?php
require_once 'config.php';

function login($email, $password) {
    global $conn;
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    if (!$stmt) {
        die("Ошибка подготовки запроса: " . $conn->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($userId, $hashedPassword);
    if ($stmt->fetch() && password_verify($password, $hashedPassword)) {
        session_start();
        $_SESSION['user_id'] = $userId;
        return true;
    } else {
        return false;
    }
}

function register($username, $email, $password) {
    global $conn;
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    if (!$stmt) {
        die("Ошибка подготовки запроса (SELECT): " . $conn->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        return "Пользователь с таким email уже существует.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        if (!$stmt) {
            die("Ошибка подготовки запроса (INSERT): " . $conn->error);
        }
        $stmt->bind_param("sss", $username, $email, $hashedPassword);
        if ($stmt->execute()) {
            return true;
        } else {
            return "Ошибка при регистрации пользователя.";
        }
    }
}
?>