<?php

class GametrailersVideoHandler extends VideoHandler {
	protected $apiName = 'GametrailersApiWrapper';
	// HTTPS-note - www.gametrailers.com does not yet support HTTPS, to handle in (PLATFORM-3284)
	protected static $urlTemplate = 'http://media.mtvnservices.com/mgid:moses:video:gametrailers.com:$1';
	protected static $providerDetailUrlTemplate = 'http://www.gametrailers.com/video/play/$1';
	protected static $providerHomeUrl = 'http://www.gametrailers.com/';
	protected static $autoplayParam = "autoplay";
	protected static $autoplayValue = "true";

	public function getEmbed( $width, array $options = [] ) {
		$autoplay = !empty( $options['autoplay'] );
		$height = $this->getHeight( $width );
		$url = $this->getEmbedUrl();
		$autoplayParam = self::$autoplayParam;
		$autoplayValue = $autoplay ? self::$autoplayValue : 'false';

		$sizeString = $this->getSizeString( $width, $height );

		$html = <<<EOT
<embed src="$url" $sizeString type="application/x-shockwave-flash" allowFullScreen="true" allowScriptAccess="always" base="." flashVars="$autoplayParam=$autoplayValue"></embed>
EOT;

		return array(
			'html' => $html,
			'width' => $width,
			'height' => $height,
		);
	}

}