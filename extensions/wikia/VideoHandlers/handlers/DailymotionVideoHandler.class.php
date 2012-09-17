<?php

class DailymotionVideoHandler extends VideoHandler {
	
	protected $apiName = 'DailymotionApiWrapper';

	protected static $providerDetailUrlTemplate = 'http://www.dailymotion.com/video/$1';
	protected static $providerHomeUrl = 'http://www.dailymotion.com/';
	
	public function getEmbed( $articleId, $width, $autoplay = false, $isAjax = false, $postOnload = false ) {
		$height =  $this->getHeight( $width );
		$autoStartParam = $autoplay ? '1' :  '0';
		$code = <<<EOT
<iframe frameborder="0" width="$width" height="$height" src="http://www.dailymotion.com/embed/video/{$this->videoId}?autoPlay={$autoStartParam}" allowfullscreen></iframe>    
EOT;
		return $code;
	}
}
