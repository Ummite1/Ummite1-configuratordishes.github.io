<?php
require_once 'config.php';

$pageTitle = "Конфигуратор блюд - Главная";
$features = [
    ['icon' => '🥗', 'title' => 'Подбор ингредиентов', 'description' => 'Выбирайте из тысячи ингредиентов или добавляйте свои собственные.'],
    ['icon' => '📊', 'title' => 'Расчет пропорций', 'description' => 'Автоматический расчет пропорций для идеального вкуса и консистенции.'],
    ['icon' => '📱', 'title' => 'Сохранение рецептов', 'description' => 'Сохраняйте свои любимые рецепты и делитесь ими с друзьями.']
];
$steps = [
    ['icon' => 'https://img.icons8.com/color/96/000000/choose.png', 'title' => '1. Выберите тип блюда', 'description' => 'Определитесь с категорией блюда, которое хотите приготовить.'],
    ['icon' => 'https://img.icons8.com/color/96/000000/ingredients.png', 'title' => '2. Добавьте ингредиенты', 'description' => 'Выберите ингредиенты из нашей базы или добавьте свои.'],
    ['icon' => 'https://img.icons8.com/color/96/000000/scales.png', 'title' => '3. Настройте пропорции', 'description' => 'Укажите количество каждого ингредиента или воспользуйтесь автоматическим расчетом.'],
    ['icon' => 'https://img.icons8.com/color/96/000000/cookbook.png', 'title' => '4. Получите рецепт', 'description' => 'Сохраните готовый рецепт или поделитесь им с друзьями.']
];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2ecc71;
            --background-color: #ecf0f1;
            --text-color: #34495e;
        }
        
        body, html {
            height: 100%;
            margin: 0;
        }
        .wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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
        
        .navbar {
            background-color: #343a40;
        }
        
        .navbar-brand, .nav-link {
            color: #fff !important;
        }
        
        .navbar-brand:hover, .nav-link:hover {
            color: var(--secondary-color) !important;
        }
        
        h1, h2, h3, h4, h5 {
            color: var(--primary-color);
        }
        
        .btn-primary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .btn-primary:hover {
            background-color: #27ae60;
            border-color: #27ae60;
        }
        
        .jumbotron {
            background-image: url('https://images.unsplash.com/photo-1543353071-087092ec393a');
            background-size: cover;
            background-position: center;
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
        
        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }
        
        .footer {
            background-color: #343a40;
            color: #fff;
            padding: 20px 0;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <!-- Основной контент -->
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4">Создайте свое идеальное блюдо</h1>
            <p class="lead">Наш конфигуратор поможет вам создать уникальные рецепты, подобрать ингредиенты и рассчитать пропорции.</p>
            <a href="configurator.php" class="btn btn-primary btn-lg">Начать готовить</a>
        </div>
    </div>

    <div class="container">
        <h2 class="text-center mb-4">Возможности конфигуратора</h2>
        <div class="row">
            <?php foreach ($features as $feature): ?>
            <div class="col-md-4 text-center mb-4">
                <div class="feature-icon"><?php echo $feature['icon']; ?></div>
                <h3><?php echo $feature['title']; ?></h3>
                <p><?php echo $feature['description']; ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Как это работает</h2>
        <div class="row">
            <?php foreach ($steps as $step): ?>
            <div class="col-md-3 text-center mb-3">
                <img src="<?php echo $step['icon']; ?>" alt="<?php echo $step['title']; ?>" class="mb-3">
                <h4><?php echo $step['title']; ?></h4>
                <p><?php echo $step['description']; ?></p>
            </div>
            <?php endforeach; ?>
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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>