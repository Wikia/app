<?php

class OoyalaVideoHandler extends VideoHandler {

	const OOYALA_PLAYER_ID = '52bc289bedc847e3aa8eb2b347644f68';
	const OOYALA_PLAYER_ID_AGEGATE = '5b38887edf80466cae0b5edc918b27e8';

	protected $apiName = 'OoyalaApiWrapper';
	protected static $urlTemplate = 'http://player.ooyala.com/player.swf?embedCode=$1&version=2';
	protected static $providerDetailUrlTemplate = 'http://video.wikia.com/';
	protected static $providerHomeUrl = 'http://video.wikia.com/';

	public function getEmbed( $articleId, $width, $autoplay = false, $isAjax = false, $postOnload=false ) {
		$height = $this->getHeight($width);
		//$url = $this->getEmbedUrl();
		$playerId = 'ooyalaplayer-'.$this->videoId.'-'.intval($isAjax).'-';

		$ooyalaPlayerId = $this->getVideoPlayerId();
		$jsFile = 'http://player.ooyala.com/v3/'.$ooyalaPlayerId;

		$autoPlayStr = ( $autoplay && !$this->isAgeGate() ) ? 'true' : 'false';

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
			),
			'init' => 'wikia.ooyala',
			'scripts' => array(
				$jsFile,
				"extensions/wikia/VideoHandlers/js/handlers/Ooyala.js"
			),
		);
	}

	protected function getVideoPlayerId() {
		$metadata = $this->getMetadata( true );
		if ( !empty($metadata['playerId']) ) {
			return $metadata['playerId'];
		} else if ( $this->isAgeGate() ) {
			return self::OOYALA_PLAYER_ID_AGEGATE;
		}

		return self::OOYALA_PLAYER_ID;
	}
}
