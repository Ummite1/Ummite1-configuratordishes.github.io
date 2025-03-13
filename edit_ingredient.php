<?php
session_start();
require_once 'config.php';

// Проверка авторизации и роли пользователя
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $category = $_POST['category'];

    $stmt = $conn->prepare("UPDATE ingredients SET name = ?, category = ? WHERE id = ?");
    $stmt->bind_param("ssi", $name, $category, $id);
    $stmt->execute();
    $stmt->close();

    header('Location: admin.php');
    exit;
} else {
    $stmt = $conn->prepare("SELECT name, category FROM ingredients WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($name, $category);
    $stmt->fetch();
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Конфигуратор блюд - Редактировать ингредиент</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Редактировать ингредиент</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="name">Название</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
            </div>
            <div class="form-group">
                <label for="category">Категория</label>
                <input type="text" class="form-control" id="category" name="category" value="<?php echo htmlspecialchars($category); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form>
    </div>
</body>
</html>