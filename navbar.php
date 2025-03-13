<?php
session_start();
$userRole = $_SESSION['user_role'] ?? '';
?>
<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="index.php">
        <img src="https://img.icons8.com/color/48/000000/chef-hat.png" alt="Логотип" style="height: 30px; width: 30px; margin-right: 10px;">
        Конфигуратор блюд
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Главная</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="configurator.php">Конфигуратор</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="recipes.php">Рецепты</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="profile.php">Профиль</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="register.php">Регистрация</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="login.php">Вход</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="about.php">О нас</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="delivery.php">Условия доставки</a>
            </li>
            <?php if ($userRole === 'admin'): ?>
            <li class="nav-item">
                <a class="nav-link" href="admin.php">Админ-панель</a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>