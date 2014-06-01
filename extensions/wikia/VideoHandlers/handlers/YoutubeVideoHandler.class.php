<?php

class YoutubeVideoHandler extends VideoHandler {

	protected $apiName = 'YoutubeApiWrapper';
	protected static $urlTemplate = 'http://www.youtube.com/embed/$1';
	protected static $providerDetailUrlTemplate = 'http://www.youtube.com/watch?v=$1';
	protected static $providerHomeUrl = 'http://www.youtube.com/';
	protected static $autoplayParam = "autoplay";
	protected static $autoplayValue = "1";

	public function getEmbed($articleId, $width, $autoplay=false, $isAjax=false, $postOnload=false) {
		// YouTube parameters: http://code.google.com/apis/youtube/player_parameters.html
		$height =  $this->getHeight( $width );
		$playerVars = array(
			'rel' => 0,
			'wmode' => 'opaque',
			'allowfullscreen' => 1,
		);
		if ( $autoplay ) {
			$playerVars[self::$autoplayParam] = self::$autoplayValue;
		}
		$sizeString = $this->getSizeString( $width, $height, 'inline' );

		$html = <<<EOT
<div id="youtubeVideoPlayer" $sizeString></div>
EOT;
		return array(
			'html' => $html,
			'init' => 'wikia.videohandler.youtube',
			'jsParams' => array(
				'width' => $width,
				'height' => $height,
				'videoId'=> $this->videoId,
				'playerVars' => $playerVars,
			),
			'scripts' => array(
				'extensions/wikia/VideoHandlers/js/handlers/Youtube.js',
			),
		);
	}

	public function addExtraBorder( $width ){
		if ( $width > 320 ){
			return 15;
		} else {
			return 0;
		}
	}

}
