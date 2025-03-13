<?php
require_once 'config.php';

$ingredients = [
    'salad' => ['Помидоры', 'Огурцы', 'Листья салата', 'Болгарский перец', 'Красный лук', 'Оливки', 'Фета', 'Авокадо', 'Кукуруза'],
    'soup' => ['Картофель', 'Морковь', 'Куриное филе', 'Лук', 'Чеснок', 'Сельдерей', 'Грибы', 'Фасоль', 'Томатная паста'],
    'main' => ['Говядина', 'Свинина', 'Курица', 'Рис', 'Паста', 'Картофель', 'Брокколи', 'Морковь', 'Лук'],
    'dessert' => ['Шоколад', 'Молоко', 'Сахар', 'Яйца', 'Мука', 'Сливочное масло', 'Ванильный экстракт', 'Фрукты', 'Сливки']
];

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dishName = $_POST['dishName'] ?? '';
    $dishType = $_POST['dishType'] ?? '';
    $selectedIngredients = $_POST['ingredients'] ?? [];
    
    if ($dishName && $dishType && !empty($selectedIngredients)) {
        $stmt = $conn->prepare("INSERT INTO recipes (user_id, name, category_id, description) VALUES (?, ?, ?, ?)");
        $userId = 1; // Замените на реальный ID пользователя
        $categoryId = array_search($dishType, array_keys($ingredients)) + 1;
        $description = ""; // Описание будет содержать ингредиенты и их количество
        $stmt->bind_param("isis", $userId, $dishName, $categoryId, $description);
        $stmt->execute();
        $recipeId = $stmt->insert_id;
        $stmt->close();

        foreach ($selectedIngredients as $ingredient) {
            $amount = $_POST['proportions'][$ingredient] ?? 0;
            $stmt = $conn->prepare("INSERT INTO recipe_ingredients (recipe_id, ingredient_id, amount, unit) VALUES (?, ?, ?, ?)");
            $ingredientId = array_search($ingredient, $ingredients[$dishType]) + 1;
            $unit = "грамм"; // Замените на реальную единицу измерения
            $stmt->bind_param("iiis", $recipeId, $ingredientId, $amount, $unit);
            $stmt->execute();
            $stmt->close();
        }

        $message = "Рецепт \"$dishName\" успешно сохранен!";
    } else {
        $message = "Пожалуйста, заполните все поля и выберите ингредиенты.";
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Конфигуратор блюд - Создание рецепта</title>
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
            <h1 class="text-center mb-4">Создайте свое блюдо</h1>
            <?php if ($message): ?>
                <div class="alert alert-info"><?php echo $message; ?></div>
            <?php endif; ?>
            <form method="POST" action="">
                <div class="row">
                    <!-- Выбор типа блюда -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Шаг 1: Выберите тип блюда</h5>
                                <select class="form-control" id="dishType" name="dishType">
                                    <option value="">Выберите тип блюда</option>
                                    <?php foreach ($ingredients as $type => $items): ?>
                                        <option value="<?php echo $type; ?>"><?php echo ucfirst($type); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Выбор ингредиентов -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Шаг 2: Выберите ингредиенты</h5>
                                <div id="ingredientList" class="ingredient-list"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Настройка пропорций -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Шаг 3: Настройте пропорции</h5>
                                <div id="proportions"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Название блюда и сохранение -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Шаг 4: Назовите ваше блюдо</h5>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="dishName" name="dishName" placeholder="Введите название блюда">
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">Сохранить рецепт</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            
            <!-- Результат -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Ваш рецепт</h5>
                            <div id="recipe"></div>
                        </div>
                    </div>
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
        // Передаем PHP-массив в JavaScript
        const ingredients = <?php echo json_encode($ingredients); ?>;

        // Обработчик изменения типа блюда
        document.getElementById('dishType').addEventListener('change', function() {
            const type = this.value;
            const ingredientList = document.getElementById('ingredientList');
            ingredientList.innerHTML = '';

            if (type && ingredients[type]) {
                ingredients[type].forEach(ingredient => {
                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.name = 'ingredients[]';
                    checkbox.value = ingredient;
                    checkbox.id = ingredient;

                    const label = document.createElement('label');
                    label.htmlFor = ingredient;
                    label.textContent = ingredient;

                    const div = document.createElement('div');
                    div.className = 'form-check';
                    div.appendChild(checkbox);
                    div.appendChild(label);

                    ingredientList.appendChild(div);
                });
            }
        });

        // Обработчик изменения ингредиентов
        document.getElementById('ingredientList').addEventListener('change', function(event) {
            const proportions = document.getElementById('proportions');
            proportions.innerHTML = '';

            const selectedIngredients = document.querySelectorAll('input[name="ingredients[]"]:checked');
            selectedIngredients.forEach(ingredient => {
                const input = document.createElement('input');
                input.type = 'number';
                input.name = `proportions[${ingredient.value}]`;
                input.placeholder = `Количество ${ingredient.value} (грамм)`;
                input.className = 'form-control mt-2';

                proportions.appendChild(input);
            });
        });
    </script>
</body>
</html>