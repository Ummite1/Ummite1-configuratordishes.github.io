<?php
$pageTitle = "Конфигуратор блюд - О нас";
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">
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
            <h1 class="text-center mb-4">О нас</h1>
            <p>Добро пожаловать в Конфигуратор блюд! Мы команда энтузиастов, которая стремится сделать приготовление пищи проще и увлекательнее. Наш сайт предлагает вам возможность создавать и делиться рецептами, а также находить новые и интересные блюда для приготовления.</p>
            <p>Наша миссия - помочь вам наслаждаться процессом приготовления пищи и открывать для себя новые кулинарные горизонты. Мы верим, что каждый может стать отличным поваром, и мы здесь, чтобы помочь вам на этом пути.</p>
            <p>Спасибо, что выбрали наш сайт. Мы надеемся, что вам понравится пользоваться нашим Конфигуратором блюд!</p>

            <!-- Контакты -->
            <section class="mb-5">
                <h2 class="text-center">Контакты</h2>
                <p class="text-center">Вы можете связаться с нами по телефону или электронной почте.</p>
                <ul class="list-unstyled text-center">
                    <li>Телефон: +7 911-111-11-11</li>
                    <li>Дополнительный номер телефона: +7 911-111-11-22</li>
                    <li>Email: info@gmail.com</li>
                </ul>
            </section>

            <!-- Наше местоположение -->
            <section class="mb-5">
                <h2 class="text-center">Наше местоположение</h2>
                <p class="text-center">Вы можете найти нас на карте ниже:</p>
                <div class="ratio ratio-16x9">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d786.4498936049583!2d47.26047890320021!3d56.11531815226015!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x415a37ea9d8e5a3b%3A0x9f8d9117a881ce7c!2z0L_RgC4g0JvQtdC90LjQvdCwLCDQp9C10LHQvtC60YHQsNGA0YssINCn0YPQstCw0YjRgdC60LDRjyDQoNC10YHQvy4sIDQyODAwMw!5e0!3m2!1sru!2sru!4v1727786322457!5m2!1sru!2sru" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </section>
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