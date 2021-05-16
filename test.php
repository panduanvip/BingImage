<?php

include 'vendor/autoload.php';

use PanduanVIP\WebExtractor\BingImage;

$url = 'https://www.bing.com/images/search?q=sepatu+roda&FORM=HDRSC2';
$user_agent = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.1; WOW64; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; InfoPath.2)';

$options  = array('http' => array('user_agent' => $user_agent));
$context  = stream_context_create($options);
$html = file_get_contents($url, false, $context);

$results = json_decode(BingImage::extractor($html));

echo '<pre>';
print_r($results);