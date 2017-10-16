<?php

class DailymotionVideoHandler extends VideoHandler {

	protected $apiName = 'DailymotionApiWrapper';
	protected static $urlTemplate = 'http://www.dailymotion.com/embed/video/$1';
	protected static $providerDetailUrlTemplate = 'http://www.dailymotion.com/video/$1';
	protected static $providerHomeUrl = 'http://www.dailymotion.com/';
	protected static $autoplayParam = "autoPlay";
	protected static $autoplayValue = "1";

	public function getEmbed( $width, array $options = [] ) {
		$autoplay = !empty( $options['autoplay'] );
		$height =  $this->getHeight( $width );
		$url = $this->getEmbedUrl( $autoplay );
		if ($autoplay) {
			$url .= '?' . self::$autoplayParam . '=' . self::$autoplayValue;
		}

		$sizeString = $this->getSizeString( $width, $height );

		$html = <<<EOT
<iframe frameborder="0" $sizeString src="{$url}" allowfullscreen></iframe>
EOT;

		return array(
			'html' => $html,
			'width' => $width,
			'height' => $height,
		);
	}

}
