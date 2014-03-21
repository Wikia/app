<?php

class YoukuVideoHandler extends VideoHandler {

	protected $apiName = 'YoukuApiWrapper';
	protected static $urlTemplate = 'http://player.youku.com/player.php/sid/$1/v.swf';
	protected static $providerDetailUrlTemplate = "http://v.youku.com/v_show/id_$1.html";
	protected static $providerHomeUrl = 'http://www.youku.com/';

	public function getEmbed($articleId, $width, $autoplay=false, $isAjax=false, $postOnload=false) {

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
