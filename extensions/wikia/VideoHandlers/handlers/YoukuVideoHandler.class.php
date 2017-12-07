<?php

class YoukuVideoHandler extends VideoHandler {

	protected $apiName = 'YoukuApiWrapper';
	protected static $urlTemplate = 'https://player.youku.com/embed/$1';
	protected static $providerDetailUrlTemplate = "https://v.youku.com/v_show/id_$1.html";
	protected static $providerHomeUrl = 'https://www.youku.com/';

	public function getEmbed( $width, array $options = [] ) {
		$height =  $this->getHeight( $width );
		$sizeString = $this->getSizeString( $width, $height );
		$url = $this->getEmbedUrl();
		$html = "<iframe src='$url' $sizeString frameborder=0 allowfullscreen></iframe>";

		return array(
			'html'	=> $html,
			'width' => $width,
			'height' => $height,
		);
	}

}
