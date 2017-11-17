<?php

class YoutubeVideoHandler extends VideoHandler {

	protected $apiName = 'YoutubeApiWrapper';
	protected static $urlTemplate = 'https://www.youtube.com/embed/$1';
	protected static $providerDetailUrlTemplate = 'https://www.youtube.com/watch?v=$1';
	protected static $providerHomeUrl = 'https://www.youtube.com/';
	protected static $autoplayParam = "autoplay";
	protected static $autoplayValue = "1";

	public function getEmbed( $width, array $options = [] ) {
		$autoplay = empty( $options['isInline'] ) ? false : !empty( $options['autoplay'] );
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

		return array(
			'html' => "<div id='youtubeVideoPlayer' {$sizeString}></div>",
			'width' => $width,
			'height' => $height,
			'init' => 'wikia.videohandler.youtube',
			'jsParams' => array(
				'videoId' => $this->videoId,
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
