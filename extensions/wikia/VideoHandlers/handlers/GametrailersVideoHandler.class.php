<?php

class GametrailersVideoHandler extends VideoHandler {
	protected $apiName = 'GametrailersApiWrapper';
	protected static $urlTemplate = 'http://media.mtvnservices.com/mgid:moses:video:gametrailers.com:$1';
	protected static $providerDetailUrlTemplate = 'http://www.gametrailers.com/video/play/$1';
	protected static $providerHomeUrl = 'http://www.gametrailers.com/';
	protected static $autoplayParam = "autoplay";
	protected static $autoplayValue = "true";

	public function getEmbed($articleId, $width, $autoplay = false, $isAjax = false, $postOnload = false) {
		$height = $this->getHeight($width);
		$url = $this->getEmbedUrl();
		$autoplayParam = self::$autoplayParam;
		$autoplayValue = $autoplay ? self::$autoplayValue : 'false';

		$sizeString = $this->getSizeString( $width, $height );

		$html = <<<EOT
<embed src="$url" $sizeString type="application/x-shockwave-flash" allowFullScreen="true" allowScriptAccess="always" base="." flashVars="$autoplayParam=$autoplayValue"></embed>
EOT;

		return array( 'html' => $html );
	}

}