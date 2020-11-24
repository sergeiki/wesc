<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use Goutte\Client;


function getKeyVal($key, $ar, $skip = 0): ?array
{
    static $res = null;
    foreach ($ar as $k => $v) {
        if ($k === $key and $skip-- == 0) $res = $v;
        if (is_array($v)) getKeyVal($key, $v, $skip);
    }
    return $res;
}


$client = new Client();
$crawler = $client->request('GET', 'https://www.zara.com/pl/en/kids-babyboy-special-prices-l69.html?v1=1626226');
$scripts = $crawler->filterXPath('//body/script[@type="text/javascript"]');

foreach ($scripts as $item) {
    $start = strpos($item->textContent, '{"seoCloud":');
    if ($start === false) continue;
    $end = strrpos($item->textContent, '};');
    $ar = substr($item->textContent, $start, $end - $start + 1);
    //echo '<pre>'; print_r($ar); echo '</pre>';

    $ar = str_replace('{', '[', $ar);
    $ar = str_replace('}', ']', $ar);
    $ar = str_replace(':', '=>', $ar);
    $ar = str_replace('https=>', 'https:', $ar);
    $ar = str_replace('http=>', 'http:', $ar);


    //$ar = '[0,1,2,3,4,5]';
    eval('$ar = ' . $ar . ';');

    $pr = getKeyVal("products", $ar);
    echo '<pre>'; var_dump($pr[0]); echo '</pre>';

    foreach ($pr as $p) {
        //echo '<pre>'; var_dump($p['name']); echo '</pre>';
    }
}
