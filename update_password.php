<?php
require_once 'config.php';

$email = 'admin@gmail.com';
$newPassword = 'admin';
$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

$stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
$stmt->bind_param("ss", $hashedPassword, $email);
if ($stmt->execute()) {
    echo "Пароль обновлен.";
} else {
    echo "Ошибка обновления пароля.";
}
$stmt->close();
?>