<?php

class DailymotionVideoHandler extends VideoHandler {
	
	protected $apiName = 'DailymotionApiWrapper';
	protected static $urlTemplate = 'http://www.dailymotion.com/embed/video/$1';
	protected static $providerDetailUrlTemplate = 'http://www.dailymotion.com/video/$1';
	protected static $providerHomeUrl = 'http://www.dailymotion.com/';
	protected static $autoplayParam = "autoPlay";
	protected static $autoplayValue = "1";

	public function getEmbed( $articleId, $width, $autoplay = false, $isAjax = false, $postOnload = false ) {
		$height =  $this->getHeight( $width );
		$url = $this->getEmbedUrl( $autoplay );
		if($autoplay) {
			$url .= '?' . self::$autoplayParam . '=' . self::$autoplayValue;
		}
		$code = <<<EOT
<iframe frameborder="0" width="$width" height="$height" src="$url" allowfullscreen></iframe>
EOT;
		return $code;
	}

}
