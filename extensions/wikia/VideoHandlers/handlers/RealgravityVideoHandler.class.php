<?php

class RealgravityVideoHandler extends VideoHandler {

	const REALGRAVITY_PLAYER_AUTOSTART_ID = 'ac330d90-cb46-012e-f91c-12313d18e962';
	const REALGRAVITY_PLAYER_NO_AUTOSTART_ID = '63541030-a4fd-012e-7c44-1231391272da';

	protected $apiName = 'RealgravityApiWrapper';
	protected static $urlTemplate = 'http://anomaly.realgravity.com/flash/player.swf';
	protected static $providerDetailUrlTemplate = 'http://www.realgravity.com/';
	protected static $providerHomeUrl = 'http://www.realgravity.com/';

	public function getEmbed( $articleId, $width, $autoplay = false, $isAjax = false, $postOnload=false ) {

		$height = $this->getHeight($width);
		$url = $this->getEmbedUrl();
		$videoId = $this->getEmbedVideoId();

		if ( $autoplay ) {
			$playerId = self::REALGRAVITY_PLAYER_AUTOSTART_ID;
		} else {
			$playerId = self::REALGRAVITY_PLAYER_NO_AUTOSTART_ID;
		}

		$embed = <<<EOT
<object id="rg_player_$playerId" name="rg_player_$playerId" type="application/x-shockwave-flash"
width="$width" height="$height" classid="clsid:$playerId" style="visibility: visible;" data="$url">
	<param name="allowscriptaccess" value="always"></param>
	<param name="allowNetworking" value="all"></param>
	<param name="menu" value="false"></param>
	<param name="wmode" value="transparent"></param>
	<param name="allowFullScreen" value="true"></param>
	<param name="flashvars" value="&config=http://mediacast.realgravity.com/vs/api/playerxml/$playerId"></param>
	<embed id="$playerId" name="$playerId" width="$width" height="$height"
	allowNetworking="all" allowscriptaccess="always" allowfullscreen="true" wmode="transparent"
	flashvars="config=http://mediacast.realgravity.com/vs/2/players/single/$playerId/$videoId.xml"
	src="$url"></embed>
</object>
EOT;

		return $embed;
	}

	public function getEmbedSrcData() {
		$playerId = self::REALGRAVITY_PLAYER_NO_AUTOSTART_ID;
		$videoId = $this->getEmbedVideoId();

		$data = array();
		$data['autoplayParam'] = $this->getAutoplayString();
		$data['srcParam'] = $this->getEmbedUrl()."?config=http://mediacast.realgravity.com/vs/2/players/single/{$playerId}/{$videoId}.xml";
		$data['srcType'] = 'player';
		$data['canEmbed'] = 0;

		return $data;
	}

	public function getEmbedUrl() {
		return static::$urlTemplate;
	}

}
