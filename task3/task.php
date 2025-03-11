<?php
$host = 'localhost';
$dbname = 'mydb';
$user = 'root';
$password = 'passwd123';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}

// Обработка формы добавления комментария
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $comment = $_POST['comment'] ?? '';
    if (!empty($username) && !empty($comment)) {
        // Защита от SQL-инъекций с использованием подготовленных выражений
        $stmt = $pdo->prepare("INSERT INTO comments (username, comment) VALUES (:username, :comment)");
        $stmt->execute([
            ':username' => htmlspecialchars($username), 
            ':comment' => htmlspecialchars($comment), 
        ]);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "<p style='color: red;'>Пожалуйста, заполните все поля.</p>";
    }
}

// Получение списка комментариев
$stmt = $pdo->query("SELECT * FROM comments ORDER BY created_at DESC");
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Комментарии</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .comment {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .comment h3 {
            margin: 0 0 5px 0;
        }
        .comment p {
            margin: 0;
        }
        form {
            margin-top: 20px;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h1>Комментарии</h1>
    <form method="POST" action="">
        <input type="text" name="username" placeholder="Ваше имя" required>
        <textarea name="comment" placeholder="Ваш комментарий" rows="4" required></textarea>
        <button type="submit">Добавить комментарий</button>
    </form>
    <div>
        <?php if (empty($comments)): ?>
            <p>Комментариев пока нет.</p>
        <?php else: ?>
            <?php foreach ($comments as $comment): ?>
                <div class="comment">
                    <h3><?= htmlspecialchars($comment['username']) ?></h3>
                    <p><?= htmlspecialchars($comment['comment']) ?></p>
                    <small><?= date('d.m.Y H:i', strtotime($comment['created_at'])) ?></small>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>