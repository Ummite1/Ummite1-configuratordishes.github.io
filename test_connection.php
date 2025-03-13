<?php
require_once 'config.php';

if ($conn) {
    echo "Успешное подключение к базе данных!";
} else {
    echo "Ошибка подключения к базе данных.";
}
?>