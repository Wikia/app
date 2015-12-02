<?php

class UstreamVideoHandler extends VideoHandler {

	protected $apiName = 'UstreamApiWrapper';
	protected static $urlTemplate = 'http://www.ustream.tv/embed/recorded/$1?v=3&wmode=direct';
	protected static $providerDetailUrlTemplate = 'http://www.ustream.tv/recorded/$1';
	protected static $providerHomeUrl = 'http://www.ustream.tv/';

	public function getEmbed( $width, array $options = [] ) {
		$autoplay = !empty( $options['autoplay'] );
		$height = $this->getHeight( $width );
		$sizeString = $this->getSizeString( $width, $height );

		$url = $this->getEmbedUrl();
		if ( $autoplay ) {
			$url .= '&autoplay=true';
		}

		$html = <<<EOT
<iframe $sizeString src="{$url}" scrolling="no" frameborder="0" style="border: 0px none transparent;"> </iframe>
EOT;

		return array(
			'html' => $html,
			'width' => $width,
			'height' => $height,
			'scripts' => array(
				"extensions/wikia/VideoHandlers/js/handlers/uStream.js",
			),
		);
	}

	/**
	 * Get the video id that is used for embed code
	 * @return string
	 */
	protected function getEmbedVideoId() {
		$metadata = $this->getVideoMetadata(true);

		if ( !empty( $metadata['altVideoId'] ) ) {
			return $metadata['altVideoId'];
		}

		$embedVideoId = preg_replace( '/(\d+)HID(\d+)/', "$1/highlight/$2", $this->videoId );

		return $embedVideoId;
	}

	/**
	 * get provider detail url
	 * @return string
	 */
	public function getProviderDetailUrl() {
		return str_replace( '$1', $this->getEmbedVideoId(), static::$providerDetailUrlTemplate );
	}

}
