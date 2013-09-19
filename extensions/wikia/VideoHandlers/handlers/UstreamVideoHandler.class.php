<?php

class UstreamVideoHandler extends VideoHandler {

	protected $apiName = 'UstreamApiWrapper';
	protected static $urlTemplate = 'http://www.ustream.tv/embed/recorded/$1?v=3&wmode=direct';
	protected static $providerDetailUrlTemplate = 'http://www.ustream.tv/recorded/$1';
	protected static $providerHomeUrl = 'http://www.ustream.tv/';

	public function getEmbed( $articleId, $width, $autoplay = false, $isAjax = false, $postOnload = false ) {
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
			'scripts' => array(
				"extensions/wikia/VideoHandlers/js/handlers/uStream.js",
			),
		);
	}

}