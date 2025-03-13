<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];
$uploadDir = 'uploads/';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $categoryId = $_POST['category_id'] ?? '';
    $description = $_POST['description'] ?? '';
    $image = $_FILES['image'] ?? null;

    if ($name && $categoryId && $description && $image) {
        $imagePath = $uploadDir . basename($image['name']);
        if (move_uploaded_file($image['tmp_name'], $imagePath)) {
            $stmt = $conn->prepare("INSERT INTO recipes (user_id, name, category_id, description, image) VALUES (?, ?, ?, ?, ?)");
            if (!$stmt) {
                die("Ошибка подготовки запроса (INSERT): " . $conn->error);
            }
            $stmt->bind_param("isiss", $userId, $name, $categoryId, $description, $imagePath);
            if ($stmt->execute()) {
                header('Location: profile.php');
                exit;
            } else {
                $error = "Ошибка при создании рецепта.";
            }
            $stmt->close();
        } else {
            $error = "Ошибка при загрузке изображения.";
        }
    } else {
        $error = "Пожалуйста, заполните все поля.";
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Создание рецепта</title>
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
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Создание рецепта</h1>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST" action="create_recipe.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Название</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="category_id">Категория</label>
                <select class="form-control" id="category_id" name="category_id" required>
                    <!-- Заполните категории из базы данных -->
                    <?php
                    $result = $conn->query("SELECT id, name FROM dish_categories");
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="description">Описание</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="image">Изображение</label>
                <input type="file" class="form-control-file" id="image" name="image" required>
            </div>
            <button type="submit" class="btn btn-primary">Создать рецепт</button>
        </form>
    </div>

    <footer class="footer text-center mt-5">
        <div class="container">
            <p>© <?php echo date('Y'); ?> Конфигуратор блюд. Все права защищены.</p>
            <a href="#" class="text-white">Политика конфиденциальности</a> |
            <a href="#" class="text-white">Условия использования</a>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>