<?php

class MetacafeVideoHandler extends VideoHandler {

	protected $apiName = 'MetacafeApiWrapper';
	protected static $urlTemplate = 'http://www.metacafe.com/fplayer/$1/.swf';
	protected static $providerDetailUrlTemplate = 'http://www.metacafe.com/watch/$1';
	protected static $providerHomeUrl = 'http://www.metacafe.com/';
	protected static $autoplayParam = "autoPlay";
	protected static $autoplayValue = "yes";

	public function getEmbed( $width, array $options = [] ) {
		$autoplay = !empty( $options['autoplay'] );
		$articleId = isset( $options['articleId'] ) ? ( int ) $options['articleId'] : null;
		$height =  $this->getHeight( $width );
		$sAutoPlayParam = self::$autoplayParam;
		$sAutoPlayValue = $autoplay  ? self::$autoplayValue : 'no';
		$url = $this->getEmbedUrl();
		$sizeString = $this->getSizeString( $width, $height );

		$html = <<<EOT
<embed flashVars="playerVars={$sAutoPlayParam}={$sAutoPlayValue}" src="{$url}" $sizeString wmode="transparent" allowFullScreen="true" allowScriptAccess="always" name="Metacafe_{$articleId}" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"></embed>
EOT;

		return array(
			'html' => $html,
			'width' => $width,
			'height' => $height,
		);
	}

}