<?php
require_once 'config.php';

// Получение рекомендуемых рецептов
$recommendedRecipes = [];
$sql = "SELECT r.id, r.name, c.name AS category 
        FROM recommended_recipes r 
        JOIN dish_categories c ON r.category_id = c.id";

if ($stmt = $conn->prepare($sql)) {
    $stmt->execute();
    $stmt->bind_result($id, $name, $category);
    while ($stmt->fetch()) {
        $recommendedRecipes[] = [
            'id' => $id,
            'name' => $name,
            'category' => $category,
            'ingredients' => []
        ];
    }
    $stmt->close();
} else {
    die("Ошибка подготовки запроса: " . $conn->error);
}

// Получение ингредиентов для каждого рекомендуемого рецепта
foreach ($recommendedRecipes as &$recipe) {
    $ingredientSql = "SELECT i.name, ri.amount, ri.unit 
                      FROM recipe_ingredients ri 
                      JOIN ingredients i ON ri.ingredient_id = i.id 
                      WHERE ri.recipe_id = ?";
    if ($ingredientStmt = $conn->prepare($ingredientSql)) {
        $ingredientStmt->bind_param("i", $recipe['id']);
        $ingredientStmt->execute();
        $ingredientStmt->bind_result($ingredientName, $amount, $unit);
        while ($ingredientStmt->fetch()) {
            $recipe['ingredients'][] = "$ingredientName: $amount $unit";
        }
        $ingredientStmt->close();
    } else {
        die("Ошибка подготовки запроса ингредиентов: " . $conn->error);
    }
}

// Получение рецептов пользователей
$userRecipes = [];
$sql = "SELECT r.id, r.name, c.name AS category 
        FROM recipes r 
        JOIN dish_categories c ON r.category_id = c.id";

if ($stmt = $conn->prepare($sql)) {
    $stmt->execute();
    $stmt->bind_result($id, $name, $category);
    while ($stmt->fetch()) {
        $userRecipes[] = [
            'id' => $id,
            'name' => $name,
            'category' => $category,
            'ingredients' => []
        ];
    }
    $stmt->close();
} else {
    die("Ошибка подготовки запроса: " . $conn->error);
}

// Получение ингредиентов для каждого рецепта пользователя
foreach ($userRecipes as &$recipe) {
    $ingredientSql = "SELECT i.name, ri.amount, ri.unit 
                      FROM recipe_ingredients ri 
                      JOIN ingredients i ON ri.ingredient_id = i.id 
                      WHERE ri.recipe_id = ?";
    if ($ingredientStmt = $conn->prepare($ingredientSql)) {
        $ingredientStmt->bind_param("i", $recipe['id']);
        $ingredientStmt->execute();
        $ingredientStmt->bind_result($ingredientName, $amount, $unit);
        while ($ingredientStmt->fetch()) {
            $recipe['ingredients'][] = "$ingredientName: $amount $unit";
        }
        $ingredientStmt->close();
    } else {
        die("Ошибка подготовки запроса ингредиентов: " . $conn->error);
    }
}

$pageTitle = "Конфигуратор блюд - Рецепты";
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #343a40;
        }
        .footer {
            background-color: #343a40;
            color: white;
            padding: 10px 0;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <!-- Основной контент -->
    <div class="container mt-5">
        <h1 class="text-center mb-4">Рекомендуемые рецепты</h1>
        
        <!-- Список рекомендуемых рецептов -->
        <div class="row" id="recommendedRecipeList">
            <?php foreach ($recommendedRecipes as $recipe): ?>
            <div class="col-md-4 mb-4" data-category="<?php echo htmlspecialchars($recipe['category']); ?>">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($recipe['name']); ?></h5>
                        <p class="card-text">
                            <strong>Ингредиенты:</strong><br>
                            <?php foreach ($recipe['ingredients'] as $ingredient): ?>
                                <?php echo htmlspecialchars($ingredient); ?><br>
                            <?php endforeach; ?>
                        </p>
                        <a href="#" class="btn btn-primary">Подробнее</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <h1 class="text-center mb-4">Рецепты пользователей</h1>
        
        <!-- Список рецептов пользователей -->
        <div class="row" id="userRecipeList">
            <?php foreach ($userRecipes as $recipe): ?>
            <div class="col-md-4 mb-4" data-category="<?php echo htmlspecialchars($recipe['category']); ?>">
                <div class="card">
                    <?php if ($recipe['image']): ?>
                        <img src="<?php echo htmlspecialchars($recipe['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($recipe['name']); ?>">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($recipe['name']); ?></h5>
                        <p class="card-text">
                            <strong>Ингредиенты:</strong><br>
                            <?php foreach ($recipe['ingredients'] as $ingredient): ?>
                                <?php echo htmlspecialchars($ingredient); ?><br>
                            <?php endforeach; ?>
                        </p>
                        <a href="#" class="btn btn-primary">Подробнее</a>
                    </div>
                </div>
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