<?php

class GamestarVideoHandler extends VideoHandler {
	
	protected $apiName = 'GameStarApiWrapper';
	protected static $urlTemplate = 'http://www.gamestar.de/jw5/player.swf?config=http://www.gamestar.de/emb/getVideoData71.cfm?vid=$1';
	protected static $providerDetailUrlTemplate = 'http://www.gamestar.de/index.cfm?pid=1589&pk=$1';
	protected static $providerHomeUrl = 'http://www.gamestar.de/';
	
	public function getEmbed( $articleId, $width, $autoplay = false, $isAjax = false, $postOnload = false ) {
		$height =  $this->getHeight( $width );
		$url = str_replace('$1', $this->getEmbedVideoId(), static::$urlTemplate);
		$autoStart = ( $autoplay ) ? 1 : 0 ;

		$html = <<<EOT
<object width="$width" height="$height">
	<param name="movie" value="$url"></param>
	<param name="flashVars" value="autoStart=$autoStart"></param>
	<param name="allowFullScreen" value="true"></param>
	<param name="allowscriptaccess" value="always"></param>
	<embed src="$url" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" flashVars="autoStart=$autoStart" width="$width" height="$height"></embed>
</object>
EOT;

		return $html;
	}

}
