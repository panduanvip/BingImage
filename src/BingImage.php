<?php

namespace PanduanVIP\WebExtractor;

use PanduanVIP\Helpers\Please;

class BingImage
{

	public static function get($keyword, $proxy='')
    {
        $keyword = str_replace(' ', '+', $keyword);
		$url = "https://www.bing.com/images/search?q=$keyword&qft=+filterui:imagesize-large&FORM=HDRSC2";
		
		$userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0b; Windows NT 5.1; DigExt)';

		$html = Please::getWebContent($url, $proxy, $userAgent);

		$dom = new \DOMDocument('1.0', 'UTF-8');
		@$dom->loadHTML($html);
		$xpath = new \DOMXPath($dom);

		$results = [];

		$blocks = $xpath->query('//div[@class="content"]/div[@class="row"]/div[@class="item"]');

		if(count($blocks)==0){
		  return json_encode($results);
		}
		
		foreach ($blocks as $block) {

			// alt

			$meta = $xpath->query('div[@class="meta"]/div[@class="des"]', $block);
			$alt = $meta->item(0)->textContent ?? '';

			// image

			$thumb = $xpath->query('a[@class="thumb"]', $block);
			$image = $thumb->item(0)->getAttribute('href') ?? '';

			// thumbnail

			$thumb = $xpath->query('a[@class="thumb"]/div[@class="cico"]/img', $block);
			$thumbnail = $thumb->item(0)->getAttribute('src') ?? '';
			if(!empty($thumbnail)){
				$thumbnail = explode('&', $thumbnail);
				$thumbnail = array_shift($thumbnail);
			}

			// source

			$meta = $xpath->query('div[@class="meta"]/a[@class="tit"]', $block);
			$source = ($meta->length > 0) ? $meta->item(0)->getAttribute('href') : '';

			if (!empty($alt) && !empty($image) && !empty($thumbnail) && !empty($source)) {
				$results[] = array('alt' => $alt, 'image' => $image, 'thumbnail' => $thumbnail, 'source' => $source);
			}
		}

		return json_encode($results);
	}
  
}