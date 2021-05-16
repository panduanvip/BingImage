# Bing Image Extractor

Web extractor for Yahoo Image website

## Installation:

```bash
composer require panduanvip/bing-image
```

### Usage:

```php
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
```

**Result:** 
```
Array
(
    [0] => stdClass Object
        (
            [alt] => Jual Sepatu Roda POWER KING 111 PU Hitam di lapak My Kevin ...
            [image] => https://s2.bukalapak.com/img/212365895/w-1000/Sepatu_Roda_POWER_KING_111_PU_Hitam.jpg
            [thumbnail] => https://tse3.mm.bing.net/th/id/OIP._cSoSkmK_-tDfKTIPwj13QHaHa?w=230
            [source] => https://www.bukalapak.com/p/olahraga/roller-skate/4c024n-jual-sepatu-roda-power-king-111-pu-hitam
        )

    [1] => stdClass Object
        (
            [alt] => Jual Sepatu Roda Bajaj / Sepatu Roda Anak / Inline Skate ...
            [image] => https://ecs7.tokopedia.net/img/cache/700/product-1/2019/1/10/132070881/132070881_8f0c6fb9-9803-44ee-a9df-3f865f76917f_1063_1063.jpg
            [thumbnail] => https://tse3.mm.bing.net/th/id/OIP.9dJ5lSadIKZwUkRi2FDb7wHaHa?w=230
            [source] => https://www.tokopedia.com/cemerlang123/sepatu-roda-bajaj-sepatu-roda-anak-inline-skate
        )

    .........
```
