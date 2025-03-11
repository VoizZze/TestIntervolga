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

function trimWordsWithHtml($html, $wordCount) {
    $words = preg_split('/(<[^>]+>|\s+)/u', $html, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
    $result = '';
    $wordCounter = 0;
    foreach ($words as $word) {
        if (preg_match('/^\s*$/u', $word)) {
            $result .= $word;
        } elseif (!preg_match('/^<[^>]+>$/u', $word)) {
            $wordCounter++;
            if ($wordCounter > $wordCount) {
                break;
            }
            $result .= $word;
        } else {
            $result .= $word; 
        }
    }
    if ($wordCounter > $wordCount) {
        $result .= '...';
    }

    return $result;
}
$trimmedText = trimWordsWithHtml($text, 29);
echo $trimmedText;
?>