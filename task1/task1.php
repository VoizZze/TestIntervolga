<?php

$data = [
    ['Иванов', 'Математика', 5],
    ['Иванов', 'Математика', 4],
    ['Иванов', 'Математика', 5],
    ['Петров', 'Математика', 5],
    ['Сидоров', 'Физика', 4],
    ['Иванов', 'Физика', 4],
    ['Петров', 'ОБЖ', 4],
];

// Создаем массив для хранения сумм баллов
$result = [];

// Обрабатываем исходные данные
foreach ($data as $item) {
    list($student, $subject, $grade) = $item;
    if (!isset($result[$student])) {
        $result[$student] = [];
    }
    if (!isset($result[$student][$subject])) {
        $result[$student][$subject] = 0;
    }
    $result[$student][$subject] += $grade;
}

// Собираем все уникальные предметы
$subjects = [];
foreach ($result as $student => $grades) {
    $subjects = array_merge($subjects, array_keys($grades));
}
$subjects = array_unique($subjects);
sort($subjects);

// Сортируем учеников
ksort($result);

// Выводим результат в виде таблицы
echo '<table border="1">';
echo '<tr><th>Ученик</th>';
foreach ($subjects as $subject) {
    echo '<th>' . htmlspecialchars($subject) . '</th>';
}
echo '</tr>';

foreach ($result as $student => $grades) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($student) . '</td>';
    foreach ($subjects as $subject) {
        echo '<td>' . ($grades[$subject] ?? '') . '</td>';
    }
    echo '</tr>';
}
echo '</table>';
