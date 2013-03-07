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
		$playerId = 'ooyalaplayer-'.$this->videoId.'-'.time().'-'.intval($isAjax);
		$jsFile = 'http://player.ooyala.com/v3/'.self::OOYALA_PLAYER_ID;

		$autoPlayStr = ( $autoplay ) ? 'true' : 'false';

		$embed = <<<EOT
<script src='{$jsFile}'></script>
<div id='{$playerId}' style='width:{$width}px;height:{$height}px;'></div>
<script>
    OO.ready(function() { OO.Player.create('{$playerId}','{$this->videoId}', { autoplay:{$autoPlayStr} }); });
</script>
EOT;

		return $embed;
	}

}
