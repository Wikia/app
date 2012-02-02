<?php

class DailymotionVideoHandler extends VideoHandler {
	
	protected $apiName = 'DailymotionApiWrapper';
	protected static $aspectRatio = 1.7777778;
	
	public function getEmbed( $articleId, $width, $autoplay = false, $isAjax = false ) {
		$height =  $this->getHeight( $width );
		$autoStartParam = $autoplay ? '1' :  '0';
		$code = <<<EOT
<iframe frameborder="0" width="$width" height="$height" src="http://www.dailymotion.com/embed/video/{$this->videoId}?autoPlay={$autoStartParam}" allowfullscreen></iframe>    
EOT;
		return $code;
	}
}
