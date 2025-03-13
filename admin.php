<?php
session_start();
require_once 'config.php';

// Проверка авторизации и роли пользователя
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Получение списка ингредиентов
$stmt = $conn->prepare("SELECT id, name, category FROM ingredients");
$stmt->execute();
$result = $stmt->get_result();
$ingredients = [];
while ($row = $result->fetch_assoc()) {
    $ingredients[] = $row;
}
$stmt->close();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Конфигуратор блюд - Админ-панель</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
        }
        .wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .navbar {
            background-color: #343a40;
        }   
        .content {
            flex: 1;
        }
        .footer {
            background-color: #343a40;
            color: white;
            padding: 10px 0;
            position: relative;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <?php include 'navbar.php'; ?>

        <!-- Основной контент -->
        <div class="container mt-5 content">
            <h1 class="text-center mb-4">Админ-панель</h1>
            <h2>Ингредиенты</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Название</th>
                        <th>Категория</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ingredients as $ingredient): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($ingredient['id']); ?></td>
                        <td><?php echo htmlspecialchars($ingredient['name']); ?></td>
                        <td><?php echo htmlspecialchars($ingredient['category']); ?></td>
                        <td>
                            <a href="edit_ingredient.php?id=<?php echo $ingredient['id']; ?>" class="btn btn-warning btn-sm">Редактировать</a>
                            <a href="delete_ingredient.php?id=<?php echo $ingredient['id']; ?>" class="btn btn-danger btn-sm">Удалить</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="add_ingredient.php" class="btn btn-primary">Добавить ингредиент</a>
        </div>

        <!-- Подвал -->
        <footer class="footer text-center mt-5">
            <div class="container">
                <p>© <?php echo date('Y'); ?> Конфигуратор блюд. Все права защищены.</p>
                <a href="#" class="text-white">Политика конфиденциальности</a> |
                <a href="#" class="text-white">Условия использования</a>
            </div>
        </footer>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>