<?php
session_start();
$pageTitle = "Конфигуратор блюд - Профиль";

// Проверка авторизации пользователя (добавьте свою логику авторизации)
$isLoggedIn = isset($_SESSION['user_id']); // Замените на реальную проверку

if (!$isLoggedIn) {
    header('Location: login.php');
    exit;
}

require_once 'config.php';
$userId = $_SESSION['user_id'];

// Получение информации о пользователе
$stmt = $conn->prepare("SELECT username, email, role FROM users WHERE id = ?");
if (!$stmt) {
    die("Ошибка подготовки запроса (SELECT): " . $conn->error);
}
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($userName, $userEmail, $userRole);
$stmt->fetch();
$stmt->close();

// Получение рецептов пользователя
$recipes = [];
$stmt = $conn->prepare("SELECT id, name, image FROM recipes WHERE user_id = ?");
if (!$stmt) {
    die("Ошибка подготовки запроса (SELECT): " . $conn->error);
}
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $recipes[] = $row;
}
$stmt->close();

// Получение рекомендуемых рецептов
$recommendedRecipes = [];
$stmt = $conn->prepare("SELECT id, name, image FROM recommended_recipes");
if (!$stmt) {
    die("Ошибка подготовки запроса (SELECT): " . $conn->error);
}
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $recommendedRecipes[] = $row;
}
$stmt->close();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
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
            <h1 class="text-center mb-4">Профиль пользователя</h1>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Информация о пользователе</h5>
                            <p class="card-text">Имя: <?php echo htmlspecialchars($userName); ?></p>
                            <p class="card-text">Email: <?php echo htmlspecialchars($userEmail); ?></p>
                            <a href="#" class="btn btn-primary">Редактировать профиль</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Рекомендуемые рецепты</h5>
                            <ul class="list-group">
                                <?php foreach ($recommendedRecipes as $recipe): ?>
                                    <li class="list-group-item">
                                        <?php if ($recipe['image']): ?>
                                            <img src="<?php echo htmlspecialchars($recipe['image']); ?>" alt="<?php echo htmlspecialchars($recipe['name']); ?>" class="img-thumbnail" style="max-width: 100px;">
                                        <?php endif; ?>
                                        <?php echo htmlspecialchars($recipe['name']); ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="card mt-4">
                        <div class="card-body">
                            <h5 class="card-title">Мои рецепты</h5>
                            <ul class="list-group">
                                <?php foreach ($recipes as $recipe): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <?php if ($recipe['image']): ?>
                                            <img src="<?php echo htmlspecialchars($recipe['image']); ?>" alt="<?php echo htmlspecialchars($recipe['name']); ?>" class="img-thumbnail" style="max-width: 100px;">
                                        <?php endif; ?>
                                        <?php echo htmlspecialchars($recipe['name']); ?>
                                        <button class="btn btn-danger btn-sm delete-recipe" data-id="<?php echo $recipe['id']; ?>">Удалить</button>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-12 text-center">
                    <form action="logout.php" method="post">
                        <button type="submit" class="btn btn-danger">Выйти из учетной записи</button>
                    </form>
                    <p id="logoutMessage" class="mt-3" style="display: none; color: green;">Выход из учетной записи завершен</p>
                </div>
            </div>
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
    <script>
        document.querySelectorAll('.delete-recipe').forEach(button => {
            button.addEventListener('click', function() {
                const recipeId = this.getAttribute('data-id');
                fetch('delete_recipe.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `recipe_id=${recipeId}`
                })
                .then(response => response.text())
                .then(data => {
                    alert(data);
                    if (data.includes('успешно')) {
                        this.parentElement.remove();
                    }
                });
            });
        });
    </script>
</body>
</html>