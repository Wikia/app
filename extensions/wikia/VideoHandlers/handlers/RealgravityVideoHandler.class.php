<?php

class RealgravityVideoHandler extends VideoHandler {

	protected $apiName = 'RealgravityApiWrapper';
	protected static $aspectRatio = 1.3333333;
	protected static $urlTemplate = 'http://www.totaleclips.com/Player/Bounce.aspx?';

	public function getEmbed($articleId, $width, $autoplay = false, $isAjax = false) {

		$height = $this->getHeight($width);

		$videoId = $this->getVideoId();

		if ( $width == RealgravityApiWrapper::DEFAULT_VET_WIDTH ) {
			$playerId = RealgravityApiWrapper::REALGRAVITY_PLAYER_VIDEOEMBEDTOOL_ID;
		} elseif ( $autoplay ) {
			$playerId = RealgravityApiWrapper::REALGRAVITY_PLAYER_AUTOSTART_ID;
		} else {
			$playerId = RealgravityApiWrapper::REALGRAVITY_PLAYER_NO_AUTOSTART_ID;
		}

		$embed =
			'<object id="rg_player_' . $playerId . '" name="rg_player_' . $playerId . '" type="application/x-shockwave-flash"
			width="' . $width . '" height="' . $height . '" classid="clsid:' . $playerId . '" style="visibility: visible;"
			data="http://anomaly.realgravity.com/flash/player.swf">
			<param name="allowscriptaccess" value="always"></param>
			<param name="allowNetworking" value="all"></param>
			<param name="menu" value="false"></param>
			<param name="wmode" value="transparent"></param>
			<param name="allowFullScreen" value="true"></param>
			<param name="flashvars" value="&config=http://mediacast.realgravity.com/vs/api/playerxml/' . $playerId . '"></param>
			<embed id="' . $playerId . '" name="' . $playerId . '" width="' . $width . '" height="' . $height . '"
			allowNetworking="all" allowscriptaccess="always" allowfullscreen="true" wmode="transparent"
			flashvars="config=http://mediacast.realgravity.com/vs/api/playerxml/' . $playerId . '?video_guid=' . $videoId . '"
			src="http://anomaly.realgravity.com/flash/player.swf"></embed>
			</object>';

		return $embed;
	}

}
