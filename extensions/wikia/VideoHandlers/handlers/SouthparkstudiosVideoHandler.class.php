<?php

class SouthparkstudiosVideoHandler extends VideoHandler {
	protected $apiName = 'SouthparkstudiosApiWrapper';
	protected static $urlTemplate = 'http://media.mtvnservices.com/mgid:cms:item:southparkstudios.com:$1';
	protected static $providerDetailUrlTemplate = 'http://www.southparkstudios.com/clips/$1';
	protected static $providerHomeUrl = 'http://www.southparkstudios.com/';
	protected static $autoplayParam = "autoPlay";
	protected static $autoplayValue = "true";

	public function getEmbed($articleId, $width, $autoplay = false, $isAjax = false, $postOnload=false) {
		$height = $this->getHeight($width);
		$url = $this->getEmbedUrl();
		$autoplayStrParam = self::$autoplayParam;
		$autoplayStrValue = $autoplay ? self::$autoplayValue : 'false';
		$sizeString = $this->getSizeString( $width, $height );

		$html = <<<EOT
<embed src="$url" $sizeString type="application/x-shockwave-flash" allowFullScreen="true" allowScriptAccess="always" base="." flashVars="$autoplayStrParam=$autoplayStrValue"></embed>
EOT;

		return array( 'html' => $html );
	}

}