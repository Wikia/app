<?php

class WikiaVideoHandler extends VideoHandler {

	protected $apiName = 'WikiaApiWrapper';
	protected static $urlTemplate = 'http://video.wikia.com/';
	protected static $providerDetailUrlTemplate = 'http://video.wikia.com/$1';
	protected static $providerHomeUrl = 'http://video.wikia.com/';

	public function getEmbed($articleId, $width, $autoplay=false, $isAjax=false, $postOnload=false) {
		$code = <<<EOT
PLEASE PUT EMBED CODE HERE! ;-)
EOT;
		return $code;
	}

	public function addExtraBorder( $width ){
		if ( $width > 320 ){
			return 15;
		} else {
			return 0;
		};
	}
}
