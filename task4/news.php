<?php
$text = <<<TXT
<p class="big">
	Год основания:<b>1589 г.</b> Волгоград отмечает день города в <b>2-е воскресенье сентября</b>. <br>В <b>2023 году</b> эта дата - <b>10 сентября</b>.
</p>
<p class="float">
	<img src="https://www.calend.ru/img/content_events/i0/961.jpg" alt="Волгоград" width="300" height="200" itemprop="image">
	<span class="caption gray">Скульптура «Родина-мать зовет!» входит в число семи чудес России (Фото: Art Konovalov, по лицензии shutterstock.com)</span>
</p>
<p>
	<i><b>Великая Отечественная война в истории города</b></i></p><p><i>Важнейшей операцией Советской Армии в Великой Отечественной войне стала <a href="https://www.calend.ru/holidays/0/0/1869/">Сталинградская битва</a> (17.07.1942 - 02.02.1943). Целью боевых действий советских войск являлись оборона  Сталинграда и разгром действовавшей на сталинградском направлении группировки противника. Победа советских войск в Сталинградской битве имела решающее значение для победы Советского Союза в Великой Отечественной войне.</i>
</p>
TXT;

// Разбиваем текст на слова, сохраняя HTML-теги как отдельные элементы
$words = [];
$currentWord = '';
$insideTag = false;

for ($i = 0; $i < strlen($text); $i++) {
    $char = $text[$i];
    
    if ($char === '<') {
        $insideTag = true;
        if ($currentWord !== '') {
            $words[] = $currentWord;
            $currentWord = '';
        }
        $currentWord .= $char;
    } elseif ($char === '>') {
        $insideTag = false;
        $currentWord .= $char;
        $words[] = $currentWord;
        $currentWord = '';
    } elseif ($insideTag) {
        $currentWord .= $char;
    } else {
        if (ctype_space($char) || $char === ' ') {
            if ($currentWord !== '') {
                $words[] = $currentWord;
                $currentWord = '';
            }
            $words[] = $char; // сохраняем пробелы и переносы
        } else {
            $currentWord .= $char;
        }
    }
}

if ($currentWord !== '') {
    $words[] = $currentWord;
}

// Считаем только реальные слова (не теги и не пробелы)
$realWordsCount = 0;
$resultWords = [];
$tagPatterns = ['<', '>', ' ', "\n", "\t", "\r"];

foreach ($words as $word) {
    $resultWords[] = $word;
    
    // Проверяем, является ли слово реальным словом (не тегом и не пробелом)
    $isRealWord = true;
    if (strpos($word, '<') === 0 || in_array($word, $tagPatterns)) {
        $isRealWord = false;
    }
    
    if ($isRealWord) {
        $realWordsCount++;
        if ($realWordsCount >= 29) {
            // Добавляем многоточие перед закрывающими тегами
            $lastTagPos = -1;
            for ($i = count($resultWords) - 1; $i >= 0; $i--) {
                if (strpos($resultWords[$i], '</') === 0) {
                    $lastTagPos = $i;
                    break;
                }
            }
            
            if ($lastTagPos !== -1) {
                array_splice($resultWords, $lastTagPos, 0, '...');
            } else {
                $resultWords[] = '...';
            }
            break;
        }
    }
}

// Собираем результат
$trimmedText = implode('', $resultWords);

// Закрываем все незакрытые теги (простая реализация без полного парсинга)
$openTags = [];
$result = '';
$i = 0;
$len = strlen($trimmedText);

while ($i < $len) {
    if ($trimmedText[$i] === '<') {
        $j = strpos($trimmedText, '>', $i);
        if ($j === false) break;
        
        $tag = substr($trimmedText, $i, $j - $i + 1);
        $result .= $tag;
        
        if ($tag[1] !== '/') {
            // Открывающий тег
            $spacePos = strpos($tag, ' ');
            $tagName = ($spacePos !== false) 
                ? substr($tag, 1, $spacePos - 1)
                : substr($tag, 1, -1);
            $openTags[] = $tagName;
        } else {
            // Закрывающий тег
            array_pop($openTags);
        }
        
        $i = $j + 1;
    } else {
        $result .= $trimmedText[$i];
        $i++;
    }
}

// Закрываем все оставшиеся теги в обратном порядке
while (!empty($openTags)) {
    $tag = array_pop($openTags);
    $result .= "</$tag>";
}

echo $result;