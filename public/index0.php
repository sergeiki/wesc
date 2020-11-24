<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use Symfony\Component\DomCrawler\Crawler;


$html = <<<'HTML'
<!DOCTYPE html>
<html>
    <body>
        <h1>h1 text</h1>
        <p class="message">Hello World!</p>
        <p>Hello Crawler!</p>
    </body>
<script>
  zara.behaviour = zara.behaviour || zara.extensions;

  zara.behaviour.unshift(function(){
    zara.mkt.setGlobals(_mkt.g);
  });
</script>    
</html>
HTML;

$html = file_get_contents("../html/page02.html"); //echo '<pre>'; print_r($html); echo '</pre>';

$crawler = new Crawler($html); //echo '<pre>'; print_r($crawler); echo '</pre>';

$crawler = $crawler->filter('script'); //echo '<pre>'; print_r($crawler); echo '</pre>';

foreach ($crawler as $domElement) {
    echo '<pre>'; var_dump($domElement->textContent); echo '</pre>';
}
