<?php

class OoyalaVideoHandler extends VideoHandler {

	const OOYALA_PLAYER_ID_AGEGATE = '5b38887edf80466cae0b5edc918b27e8';

	protected $apiName = 'OoyalaApiWrapper';
	protected static $urlTemplate = 'http://player.ooyala.com/player.swf?embedCode=$1&version=2';
	protected static $providerDetailUrlTemplate = 'http://video.wikia.com/';
	protected static $providerHomeUrl = 'http://video.wikia.com/';

	public function getEmbed( $articleId, $width, $autoplay = false, $isAjax = false, $postOnload=false ) {
		$height = $this->getHeight($width);
		$playerId = 'ooyalaplayer-'.$this->videoId.'-'.intval($isAjax);

		$ooyalaPlayerId = F::app()->wg->OoyalaApiConfig['playerId'];
		$jsFile = 'http://player.ooyala.com/v3/'.$ooyalaPlayerId;

		$autoPlayStr = ( $autoplay ) ? 'true' : 'false';

		$html = <<<EOT
<div id='{$playerId}' style="width:{$width}px; height:{$height}px"></div>
EOT;

		return array(
			'html' => $html,
			'jsParams' => array(
				'playerId'=> $playerId,
				'videoId'=> $this->videoId,
				'width'=> $width,
				'height'=> $height,
				'autoPlay'=> $autoPlayStr,
				'title'=> $this->title,
				'jsFile' => array(
					$jsFile,
					"extensions/wikia/VideoHandlers/js/handlers/OoyalaModule.js",
				),
			),
			'init' => 'wikia.videohandler.ooyala',
			'scripts' => array(
				"extensions/wikia/VideoHandlers/js/handlers/Ooyala.js"
			),
		);
	}

}
