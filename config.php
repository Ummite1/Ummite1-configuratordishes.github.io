<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "configurator_dishes";

// Создание подключения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка подключения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}
?>