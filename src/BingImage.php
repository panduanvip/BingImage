<?php

namespace PanduanVIP\WebExtractor;

class BingImage
{

	public static function get($keyword, $proxy='')
    {
		$html = self::curl($keyword, $proxy);

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

	private static function curl($keyword, $proxy='')
	{
		if (!function_exists('curl_version')) {
			die('cURL extension is disabled on your server!');
		}

		$keyword = str_replace(' ', '+', $keyword);
		$url = "https://www.bing.com/images/search?q=$keyword&qft=+filterui:imagesize-large&FORM=HDRSC2";
		
		$user_agent = 'Mozilla/4.0 (compatible; MSIE 6.0b; Windows NT 5.1; DigExt)';
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);	
		curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
		if (isset($_SERVER['HTTP_REFERER'])) {
			curl_setopt($ch, CURLOPT_REFERER, $_SERVER['HTTP_REFERER']);
		}
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		if (!empty($proxy)) {
			curl_setopt($ch, CURLOPT_PROXY, $proxy);
		}
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}
  
}