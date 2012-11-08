<?php

class RealgravityVideoHandler extends VideoHandler {

	const REALGRAVITY_PLAYER_AUTOSTART_ID = 'c85a31a4-b327-4b28-b75a-903c4bfecc1c';
	const REALGRAVITY_PLAYER_NO_AUTOSTART_ID = '0654181c-ee9b-4815-8d63-f3d435143fe6';

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
<object id="rg_player_{$playerId}" name="rg_player_{$playerId}" type="application/x-shockwave-flash"
width="{$width}" height="{$height}" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" style="visibility: visible;">
	<param name="movie" value="http://anomaly.realgravity.com/flash/player.swf"></param>
	<param name="allowScriptAccess" value="always"></param>
	<param name="allowNetworking" value="all"></param>
	<param name="menu" value="false"></param>
	<param name="wmode" value="transparent"></param>
	<param name="allowFullScreen" value="true"></param>
	<param name="flashvars" value="config=http://mediacast.realgravity.com/vs/2/players/single/{$playerId}/{$videoId}.xml"></param>
	<!--[if !IE]>-->
	<embed id="{$playerId}" name="{$playerId}" width="{$width}" height="{$height}"
	allowNetworking="all" allowScriptAccess="always" allowFullScreen="true" wmode="transparent"
	flashvars="config=http://mediacast.realgravity.com/vs/2/players/single/{$playerId}/{$videoId}.xml"
	src="http://anomaly.realgravity.com/flash/player.swf"></embed>
	<!--<![endif]-->
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
