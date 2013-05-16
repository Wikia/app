<?php

class GamestarVideoHandler extends VideoHandler {

	protected $apiName = 'GameStarApiWrapper';
	protected static $urlTemplate = 'http://www.gamestar.de/jw5/player.swf?config=http://www.gamestar.de/emb/getVideoData71.cfm?vid=$1';
	protected static $providerDetailUrlTemplate = 'http://www.gamestar.de/index.cfm?pid=1589&pk=$1';
	protected static $providerHomeUrl = 'http://www.gamestar.de/';
	protected static $autoplayParam = "autoStart";
	protected static $autoplayValue = "1";

	public function getEmbed( $articleId, $width, $autoplay = false, $isAjax = false, $postOnload = false ) {
		$height =  $this->getHeight( $width );
		$url = $this->getEmbedUrl();
		$autoStartParam = self::$autoplayParam;
		$autoStartValue = ( $autoplay ) ? self::$autoplayValue : 0 ;

		$sizeString = $this->getSizeString( $width, $height );

		$html = <<<EOT
<object $sizeString>
	<param name="movie" value="$url"></param>
	<param name="flashVars" value="$autoStartParam=$autoStartValue"></param>
	<param name="allowFullScreen" value="true"></param>
	<param name="allowscriptaccess" value="always"></param>
	<embed src="$url" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" flashVars="$autoStartParam=$autoStartValue" $sizeString></embed>
</object>
EOT;

		return array( 'html' => $html );
	}

}
