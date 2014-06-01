<?php

class ViddlerVideoHandler extends VideoHandler {
	protected $apiName = 'ViddlerApiWrapper';
	protected static $urlTemplate = 'http://www.viddler.com/player/$1/';
	protected static $providerDetailUrlTemplate = 'http://www.viddler.com/v/$1';
	protected static $providerHomeUrl = 'http://www.viddler.com/';
	protected static $autoplayParam = "autoplay";
	protected static $autoplayValue = "t";

	public function getEmbed($articleId, $width, $autoplay = false, $isAjax = false, $postOnload = false) {
		$height = $this->getHeight($width);
		$url = $this->getEmbedUrl();
		$embedVideoId = $this->getEmbedVideoId();
		$flashVars = '';
		$sizeString = $this->getSizeString( $width, $height );

		$html = <<<EOT
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" $sizeString id="viddler_$embedVideoId">
EOT;
		if($autoplay) {
			$flashVars = ' flashvars="'.self::$autoplayParam.'='.self::$autoplayValue.'"';
			$html .= <<<EOT
	<param name="flashvars" value="autoplay=t" />
EOT;
		}
		$html .= <<<EOT
	<param name="movie" value="{$url}" />
	<param name="allowScriptAccess" value="always" />
	<param name="allowFullScreen" value="true" />
	<embed src="$url" $sizeString type="application/x-shockwave-flash" allowScriptAccess="always"{$flashVars} allowFullScreen="true" name="viddler_$embedVideoId"></embed>
</object>
EOT;

		return array( 'html' => $html );
	}

}