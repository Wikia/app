<?php

class YoutubeVideoHandler extends VideoHandler {

	protected $apiName = 'YoutubeApiWrapper';
	protected static $urlTemplate = 'http://www.youtube.com/embed/$1';
	protected static $providerDetailUrlTemplate = 'http://www.youtube.com/watch?v=$1';
	protected static $providerHomeUrl = 'http://www.youtube.com/';
	protected static $autoplayParam = "autoplay";
	protected static $autoplayValue = "1";

	public function getEmbed($articleId, $width, $autoplay=false, $isAjax=false, $postOnload=false) {
		return $this->getEmbedNative($width, $autoplay);
	}

	private function getEmbedNative($width, $autoplay=false) {
		// YouTube parameters: http://code.google.com/apis/youtube/player_parameters.html
		$height =  $this->getHeight( $width );
		$url = $this->getEmbedUrl();
		$params = array('rel'=>0);
		if ($autoplay) $params[self::$autoplayParam] = self::$autoplayValue;
		$qs = http_build_query($params);

		$code = <<<EOT
<iframe width="$width" height="$height" src="{$url}?$qs" frameborder="0" allowfullscreen></iframe>
EOT;
		return $code;
	}

	public function addExtraBorder( $width ){
		if ( $width > 320 ){
			return 15;
		} else {
			return 0;
		}
	}

}
