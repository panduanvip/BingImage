<?php

include 'vendor/autoload.php';

use PanduanVIP\WebExtractor\BingImage;

$keyword = 'sepatu roda';
$results = json_decode(BingImage::get($keyword));

echo '<pre>';
print_r($results);