<?php

function getKeyVal($ar)
{
    foreach ($ar as $k => $v) {
        if ($k === "products") {
            echo '<pre>';
            var_dump($k);
            print_r($v);
            echo '</pre>';
        }
        if (is_array($v)) getKeyVal($v);
    }
}

$doc_url = "https://www.zara.com/pl/en/kids-babyboy-special-prices-l69.html?v1=1626226";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "$doc_url");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$result = curl_exec($ch);
$http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http=="200") {
    $doc = new DOMDocument;

    libxml_use_internal_errors(true);
    //$doc->loadHTMLFile("..\html\page02.html");
    $doc->loadHTML($result);
    libxml_clear_errors();

    $xpath = new DOMXPath($doc);

    $scripts = $xpath->query('//body/script[@type="text/javascript"]');

    foreach ($scripts as $item) {
        $start = strpos($item->textContent, '{"seoCloud":');
        if ($start === false) continue;
        $end = strrpos($item->textContent, '};');
        $ar = substr($item->textContent, $start, $end - $start + 1);
        echo '<pre>';
        var_dump($ar);
        echo '</pre>';

        $ar = str_replace('{', '[', $ar);
        $ar = str_replace('}', ']', $ar);
        $ar = str_replace(':', '=>', $ar);
        $ar = str_replace('https=>', 'https:', $ar);
        $ar = str_replace('http=>', 'http:', $ar);


        //$ar = '[0,1,2,3,4,5]';
        eval('$ar = ' . $ar . ';');

        getKeyVal($ar);

        //echo '<pre>'; var_dump($ar); echo '</pre>';
    }
} else {
    echo "ERROR $http";
}