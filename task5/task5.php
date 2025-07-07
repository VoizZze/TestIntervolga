<?php
    function counter($n, $m){
    if ($n < 1) {
        echo "<div class='result' style='color: red;'>Количество сестер должно быть не меньше 1.</div>";
    } elseif ($m < 0) {
        echo "<div class='result' style='color: red;'>Количество братьев должно быть не меньше 0.</div>";
    } else {
        $sistersCount = $n - 1;
        echo "<div class='result'>";
        echo "<strong>Количество сестер у брата Алисы:</strong> " . $sistersCount;
        echo "</div>";
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $n = intval($_POST['sisters']);
    $m = intval($_POST['brothers']);
    counter($n,$m);
}