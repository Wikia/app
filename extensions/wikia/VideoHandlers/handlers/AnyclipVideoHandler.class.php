<?php

class AnyclipVideoHandler extends VideoHandler {

	protected $apiName = 'AnyclipApiWrapper';
	protected static $urlTemplate = 'http://player.anyclip.com/AnyClipPlayer.swf?clipid=$1';
	protected static $providerDetailUrlTemplate = 'http://www.anyclip.com/$1/';
	protected static $providerHomeUrl = 'http://www.anyclip.com';

	public function getProviderDetailUrl() {
		$metadata = $this->getMetadata( true );
		$url = $metadata['videoUrl'];

		return $url;
	}

	public function getEmbed( $articleId, $width, $autoplay = false, $isAjax = false, $postOnload = false ) {
		$height =  $this->getHeight( $width );
		$autoPlayStr = ( $autoplay ) ? 'true' : 'false';
		$ajaxStr = (bool) $isAjax;

		$playerId = 'AnyClipPlayer-' . $this->videoId . '-' . $ajaxStr;
		$jsFile = 'http://player.anyclip.com/embed/AnyClipPlayer.js';
		$sizeString = $this->getSizeString( $width, $height, 'inline' );

		$html = <<<EOT
<div id="{$playerId}" {$sizeString}></div>
EOT;

		return array(
			'html' => $html,
			'jsParams' => array(
				'playerId'=> $playerId,
				'videoId'=> $this->videoId,
				'width'=> $width,
				'height'=> $height,
				'autoPlay'=> $autoPlayStr,
			),
			'init' => 'wikia.videohandler.anyclip',
			'scripts' => array(
				$jsFile,
				"extensions/wikia/VideoHandlers/js/handlers/Anyclip.js"
			),
		);
	}

}
