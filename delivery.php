<?php
$pageTitle = "Конфигуратор блюд - Условия доставки";
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
            <h1 class="text-center mb-4">Условия доставки</h1>
            <p>Мы предлагаем различные варианты доставки для вашего удобства. Пожалуйста, ознакомьтесь с нашими условиями доставки ниже:</p>
            <h2>Варианты доставки</h2>
            <ul>
                <li><strong>Доставка:</strong> Доставка осуществляется в течение 3-5 часов.</li>
                <li><strong>Самовывоз:</strong> Вы можете забрать ваш заказ в нашем пункте самовывоза.</li>
            </ul>
            <h2>Стоимость доставки</h2>
            <p>Стоимость доставки зависит от выбранного варианта и вашего местоположения. Точные расценки будут указаны при оформлении заказа.</p>
            <h2>Отслеживание заказа</h2>
            <p>После отправки заказа вы получите номер для отслеживания, с помощью которого вы сможете отслеживать статус доставки вашего заказа.</p>
            <h2>Возврат и обмен</h2>
            <p>Если у вас возникли проблемы с заказом, пожалуйста, свяжитесь с нашей службой поддержки для решения вопроса.</p>
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