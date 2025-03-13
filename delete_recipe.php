<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    echo "Ошибка: пользователь не авторизован.";
    exit;
}

$userId = $_SESSION['user_id'];
$recipeId = $_POST['recipe_id'] ?? '';

if ($recipeId) {
    // Удаление связанных строк из таблицы recipe_ingredients
    $stmt = $conn->prepare("DELETE FROM recipe_ingredients WHERE recipe_id = ?");
    if (!$stmt) {
        die("Ошибка подготовки запроса (DELETE recipe_ingredients): " . $conn->error);
    }
    $stmt->bind_param("i", $recipeId);
    if (!$stmt->execute()) {
        die("Ошибка при удалении ингредиентов рецепта: " . $stmt->error);
    }
    $stmt->close();

    // Удаление рецепта из таблицы recipes
    $stmt = $conn->prepare("DELETE FROM recipes WHERE id = ? AND user_id = ?");
    if (!$stmt) {
        die("Ошибка подготовки запроса (DELETE recipes): " . $conn->error);
    }
    $stmt->bind_param("ii", $recipeId, $userId);
    if ($stmt->execute()) {
        echo "Рецепт успешно удален.";
    } else {
        echo "Ошибка при удалении рецепта: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Ошибка: не указан ID рецепта.";
}
exit;
?>