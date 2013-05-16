<?php

class FiveminVideoHandler extends VideoHandler {

	protected $apiName = 'FiveminApiWrapper';
	protected static $urlTemplate = 'http://www.5min.com/Embeded/$1';
	protected static $providerDetailUrlTemplate = 'http://www.5min.com/Video/$1';
	protected static $providerHomeUrl = 'http://www.5min.com/';
	protected static $autoplayParam = "autostart";
	protected static $autoplayValue = "true";

	public function getEmbed( $articleId, $width, $autoplay = false, $isAjax = false, $postOnload = false ) {
		$height =  $this->getHeight( $width );
		$url = $this->getEmbedUrl( $autoplay );
		if ($autoplay) {
			$url .= '/&' . self::$autoplayParam . '=' . self::$autoplayValue;
		}

		$sizeString = $this->getSizeString( $width, $height );

		$html = <<<EOT
<embed src='{$url}' type='application/x-shockwave-flash' $sizeString allowfullscreen='true' allowScriptAccess='always'></embed>
EOT;

		return array( 'html' => $html );
	}

}