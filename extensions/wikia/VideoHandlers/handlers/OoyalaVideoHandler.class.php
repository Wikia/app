<?php

class OoyalaVideoHandler extends VideoHandler {

	const OOYALA_PLAYER_ID_AGEGATE = '5b38887edf80466cae0b5edc918b27e8';

	protected $apiName = 'OoyalaApiWrapper';
	protected static $urlTemplate = 'http://player.ooyala.com/player.swf?embedCode=$1&version=2';
	protected static $providerDetailUrlTemplate = 'http://video.wikia.com/';
	protected static $providerHomeUrl = 'http://video.wikia.com/';

	public function getEmbed( $width, array $options = [] ) {
		$wg = F::app()->wg;

		$autoplay = !empty( $options['autoplay'] );
		$isAjax = !empty( $options['isAjax'] );
		$height = $this->getHeight($width);
		$playerId = 'ooyalaplayer-'.$this->videoId.'-'.intval($isAjax);

		$ooyalaPlayerId = $wg->OoyalaApiConfig['playerId'];
		$jsFile = 'http://player.ooyala.com/v3/' . $ooyalaPlayerId;
		if ( $wg->OoyalaPreferHtml5 || $wg->Request->getBool( 'ooyalahtml5' ) ) {
			$jsFile .= '?platform=html5-priority';
		}

		$autoPlayStr = ( $autoplay ) ? 'true' : 'false';

		$html = <<<EOT
<div id='{$playerId}' style="width:{$width}px; height:{$height}px"></div>
EOT;

		return array(
			'html' => $html,
			'width' => $width,
			'height' => $height,
			'jsParams' => array(
				'playerId' => $playerId,
				'videoId' => $this->videoId,
				'autoPlay' => $autoPlayStr,
				'title' => $this->title,
				'jsFile' => array(
					$jsFile,
					"extensions/wikia/VideoHandlers/js/handlers/lib/OoyalaAgeGate.js",
				),
			),
			'init' => 'wikia.videohandler.ooyala',
			'scripts' => array(
				"extensions/wikia/VideoHandlers/js/handlers/Ooyala.js",
			),
		);
	}

}
