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

$tpl = '../tpl/t2';

$client = new Client();

//print_r($_GET); die();

switch (@$_GET['menu']) {
    case 'woman-special-prices':
        $www = 'https://www.zara.com/pl/en/woman-special-prices-l1314.html?v1=1550291';
        break;
    /*case 'woman-sweatshirts':
        $www = 'https://www.zara.com/pl/en/woman-sweatshirts-l1320.html?v1=1549172';
        break;*/

    case 'kids-babyboy-special-prices':
        $www = 'https://www.zara.com/pl/en/kids-babyboy-special-prices-l69.html?v1=1626226';
        break;

    case 'kids-babygirl-special-prices':
        $www = 'https://www.zara.com/pl/en/kids-babygirl-special-prices-l152.html?v1=1625727';
        break;
    case 'kids-girl-special-prices':
        $www = 'https://www.zara.com/pl/en/kids-girl-special-prices-l427.html?v1=1538238';
        break;

    default:
        $www = 'https://www.zara.com/pl/en/man-special-prices-l806.html?v1=1548584';
}

$crawler = $client->request('GET', $www);
$scripts = $crawler->filterXPath('//body/script[@type="text/javascript"]');

foreach ($scripts as $item) {
    $start = strpos($item->textContent, '{"seoCloud":');
    if ($start === false) continue;
    $end = strrpos($item->textContent, '};');
    $ar = substr($item->textContent, $start, $end - $start + 1);
    //echo '<pre>'; var_dump($ar); echo '</pre>';

    $ar = str_replace('{', '[', $ar);
    $ar = str_replace('}', ']', $ar);
    $ar = str_replace(':', '=>', $ar);
    $ar = str_replace('https=>', 'https:', $ar);
    $ar = str_replace('http=>', 'http:', $ar);


    //$ar = '[0,1,2,3,4,5]';
    eval('$ar = ' . $ar . ';');

    $pr = getKeyVal("products", $ar);
    //echo '<pre>'; var_dump($pr[0]); echo '</pre>';
}


$loader = new \Twig\Loader\FilesystemLoader($tpl);
$twig = new \Twig\Environment($loader, [
    //'cache' => '../var',
    //'debug' => true,
]);

echo $twig->render('index.html', [
    'pr' => $pr,
]);
