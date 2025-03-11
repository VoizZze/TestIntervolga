<?php
$host = 'localhost'; 
$dbname = 'mydb'; 
$user = 'root'; 
$password = 'passwd123'; 
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo 'Контакт установлен :)';
} catch (PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}


// Таблица категории
$stmt = $pdo->query("SELECT * FROM categories");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "<h2>Категории</h2>";
echo "<table border='1'>";
echo "<tr><th>ID</th><th>Название</th></tr>";
foreach ($categories as $category) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($category['id']) . "</td>";
    echo "<td>" . htmlspecialchars($category['title']) . "</td>";
    echo "</tr>";
}
echo "</table>";


// Таблица товары
$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "<h2>Товары</h2>";
echo "<table border='1'>";
echo "<tr><th>ID</th><th>Название</th><th>Категория ID</th></tr>";
foreach ($products as $product) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($product['id']) . "</td>";
    echo "<td>" . htmlspecialchars($product['title']) . "</td>";
    echo "<td>" . htmlspecialchars($product['category_id']) . "</td>";
    echo "</tr>";
}
echo "</table>";


// Таблица склады
$stmt = $pdo->query("SELECT * FROM stocks");
$stocks = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "<h2>Склады</h2>";
echo "<table border='1'>";
echo "<tr><th>ID</th><th>Название</th></tr>";
foreach ($stocks as $stock) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($stock['id']) . "</td>";
    echo "<td>" . htmlspecialchars($stock['title']) . "</td>";
    echo "</tr>";
}
echo "</table>";


// Таблица Наличие товаров
$stmt = $pdo->query("SELECT * FROM availabilities");
$availabilities = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "<h2>Наличие товаров на складах</h2>";
echo "<table border='1'>";
echo "<tr><th>ID</th><th>Количество</th><th>Товар ID</th><th>Склад ID</th></tr>";
foreach ($availabilities as $availability) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($availability['id']) . "</td>";
    echo "<td>" . htmlspecialchars($availability['amount']) . "</td>";
    echo "<td>" . htmlspecialchars($availability['product_id']) . "</td>";
    echo "<td>" . htmlspecialchars($availability['stock_id']) . "</td>";
    echo "</tr>";
}
echo "</table>";

// Общая таблица
$stmt = $pdo->query("
    SELECT 
        a.id, 
        a.amount, 
        p.title AS product_title, 
        s.title AS stock_title
    FROM availabilities a
    JOIN products p ON a.product_id = p.id
    JOIN stocks s ON a.stock_id = s.id
");
$availabilities = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "<h2>Наличие товаров на складах (с названиями)</h2>";
echo "<table border='1'>";
echo "<tr><th>ID</th><th>Количество</th><th>Товар</th><th>Склад</th></tr>";
foreach ($availabilities as $availability) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($availability['id']) . "</td>";
    echo "<td>" . htmlspecialchars($availability['amount']) . "</td>";
    echo "<td>" . htmlspecialchars($availability['product_title']) . "</td>";
    echo "<td>" . htmlspecialchars($availability['stock_title']) . "</td>";
    echo "</tr>";
}
echo "</table>";