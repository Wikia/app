<?php

class FiveminVideoHandler extends VideoHandler {

	protected $apiName = 'FiveminApiWrapper';
	protected static $urlTemplate = 'https://www.5min.com/Embeded/$1';
	protected static $providerDetailUrlTemplate = 'https://www.5min.com/Video/$1';
	protected static $providerHomeUrl = 'https://www.5min.com/';
	protected static $autoplayParam = "autostart";
	protected static $autoplayValue = "true";

	public function getEmbed( $width, array $options = [] ) {
		$autoplay = !empty( $options['autoplay'] );
		$height =  $this->getHeight( $width );
		$url = $this->getEmbedUrl( $autoplay );
		if ($autoplay) {
			$url .= '/&' . self::$autoplayParam . '=' . self::$autoplayValue;
		}

		$sizeString = $this->getSizeString( $width, $height );

		$html = <<<EOT
<embed src='{$url}' type='application/x-shockwave-flash' $sizeString allowfullscreen='true' allowScriptAccess='always'></embed>
EOT;

		return array(
			'html' => $html,
			'width' => $width,
			'height' => $height,
		);
	}

}