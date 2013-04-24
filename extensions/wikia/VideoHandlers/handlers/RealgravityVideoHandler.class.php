<?php

class RealgravityVideoHandler extends VideoHandler {

	const DEFAULT_VET_WIDTH = 350;  // defined in VideoEmbedTool_setup.php, but that extension may not be enabled!
	const REALGRAVITY_PLAYER_AUTOSTART_ID = 'ac330d90-cb46-012e-f91c-12313d18e962';
	const REALGRAVITY_PLAYER_NO_AUTOSTART_ID = '63541030-a4fd-012e-7c44-1231391272da';
	const REALGRAVITY_PLAYER_VIDEOEMBEDTOOL_ID = '49321a60-d897-012e-f9bf-12313d18e962';

	protected $apiName = 'RealgravityApiWrapper';
	protected static $urlTemplate = 'http://anomaly.realgravity.com/flash/player.swf';
	protected static $providerDetailUrlTemplate = 'http://www.realgravity.com/';
	protected static $providerHomeUrl = 'http://www.realgravity.com/';

	public function getEmbed( $articleId, $width, $autoplay = false, $isAjax = false, $postOnload=false ) {

		$height = $this->getHeight($width);
		$url = $this->getEmbedUrl();
		$videoId = $this->getEmbedVideoId();

		if ( $width == self::DEFAULT_VET_WIDTH ) {
			$playerId = self::REALGRAVITY_PLAYER_VIDEOEMBEDTOOL_ID;
		} else if ( $autoplay ) {
			$playerId = self::REALGRAVITY_PLAYER_AUTOSTART_ID;
		} else {
			$playerId = self::REALGRAVITY_PLAYER_NO_AUTOSTART_ID;
		}

		$sizeString = $this->getSizeString( $width, $height );

		$html = <<<EOT

<object id="rg_player_{$playerId}" name="rg_player_{$playerId}" type="application/x-shockwave-flash"
$sizeString classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" style="visibility: visible;">
	<param name="movie" value="http://anomaly.realgravity.com/flash/player.swf"></param>
	<param name="allowScriptAccess" value="always"></param>
	<param name="allowNetworking" value="all"></param>
	<param name="menu" value="false"></param>
	<param name="wmode" value="transparent"></param>
	<param name="allowFullScreen" value="true"></param>
	<param name="flashvars" value="config=http://mediacast.realgravity.com/vs/2/players/single/{$playerId}/{$videoId}.xml"></param>
	<!--[if !IE]>-->
	<embed id="{$playerId}" name="{$playerId}" $sizeString"
	allowNetworking="all" allowScriptAccess="always" allowFullScreen="true" wmode="transparent"
	flashvars="config=http://mediacast.realgravity.com/vs/2/players/single/{$playerId}/{$videoId}.xml"
	src="http://anomaly.realgravity.com/flash/player.swf"></embed>
	<!--<![endif]-->
</object>
EOT;

		return array( 'html' => $html );
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
