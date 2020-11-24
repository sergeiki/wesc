<?php

// Convert javascript array
function cjsa($s)
{
    $start = strpos($s, '[');

    do {
        $end = strpos($s, ']', $start);
        $ss = substr($s, $start + 1, $end - $start - 1);

        echo '<pre>'; var_dump($ss); echo '</pre>';
    } while ($start = strpos($s, '[', $end));
}

$doc = new DOMDocument;

libxml_use_internal_errors(true);

$doc->loadHTMLFile("..\html\page02.html");

libxml_clear_errors();

$scripts = $doc->getElementsByTagName('script');

$xpath = new DOMXPath($doc);

$scripts = $xpath->query('//body/script[@type="text/javascript"]');

foreach ($scripts as $item) {
    $start = strpos($item->textContent, '{"seoCloud":');
    if ($start === false) continue;
    $end = strpos($item->textContent, '};');
    $end = strpos($item->textContent, '};', $end + 1);
    $json = substr($item->textContent, $start, $end - $start + 1);
    echo '<pre>'; var_dump($json); echo '</pre>';

    cjsa('{"seoCloud":[],"isReactView":false,"logoSection":"Kids","category":{"id":1626226,"key":"I2020-NINOS-BEBENINO-PROMO_PL","name":"SPECIAL PRICES","layoutWeb":"products-category-view","layoutApp":"list","sectionName":"KID","type":"46","viewCategoryId":0,"subcategories":[],"seo":{"keyword":"kids-babyboy-special-prices","keyWordI18n":[{"langId":-1,"keyword":"kids-babyboy-special-prices"},{"langId":-22,"keyword":"dzieci-dziecko-chlopiec-specjalne-ceny"}],"title":"SPECIAL PRICES-BABY BOY-KIDS | ZARA Poland","metaDescription":"SPECIAL PRICES","mainHeader":"SPECIAL PRICES","description":"","bannerPosition":-1,"breadCrumb":[{"text":"KIDS","keyword":"kids","id":1591570,"seoCategoryId":1,"seo":{"');

    $json = str_replace(':","', ':"."', $json);

    $json = str_replace('["small","large"]', '["small":1,"large":1]', $json);
    $json = str_replace('["app","store","web","web_mobile","web-mobile","wechat-minip"]', '["app":1,"store":1,"web":1,"web_mobile":1,"web-mobile":1,"wechat-minip":1]', $json);
    $json = str_replace(',"extraInfo":{}}', '', $json);
    $json = str_replace('["40% OFF","+2 Colours"]', '["tag1":"40% OFF","tag2":"+2 Colours"]', $json);

    $json = str_replace('["web","web_mobile","app"]', '["web":1,"web_mobile":1,"app":1]', $json);
    $json = str_replace('["WOMAN","MAN","KID"]', '["WOMAN":1,"MAN":1,"KID":1]', $json);
    $json = str_replace('["WOMAN","HOME"]', '["WOMAN":1,"HOME":1]', $json);
    $json = str_replace('HH:mm:ss', 'HH-mm-ss', $json);
    $json = str_replace('HH:mm', 'HH-mm', $json);
    $json = str_replace('{', '{"', $json);
    $json = str_replace('\'', '"', $json);
    $json = str_replace(',', ',"', $json);
    $json = str_replace(':', '":', $json);
    $json = str_replace('""', '"', $json);
    $json = str_replace('https"', 'https', $json);
    $json = str_replace('http"', 'http', $json);
    $json = str_replace(':",', ':"",', $json);
    $json = str_replace('!', '', $json);
    $json = str_replace('[{', '{', $json);
    $json = str_replace('}]', '}', $json);
    $json = str_replace('[', '{', $json);
    $json = str_replace(']', '}', $json);
    $json = str_replace('#,"##0.00 ¤¤', '#.##0.00 ¤¤', $json);
    $json = str_replace(',"{"', ',"zara1": {"', $json);
    $json = str_replace('{"large"}', '"large"', $json);

    $json_data = json_decode($json, true);
    //echo '<pre>'; var_dump($item->textContent); echo '</pre>';
    echo '<pre>'; var_dump($json); echo '</pre>';
    echo '<pre>'; var_dump($json_data); echo '</pre>';
    echo '<pre>'; echo json_last_error(); echo '</pre>';
    echo '<pre>'; echo json_last_error_msg(); echo '</pre>';
}

//echo '<pre>'; var_dump($script); echo '</pre>';