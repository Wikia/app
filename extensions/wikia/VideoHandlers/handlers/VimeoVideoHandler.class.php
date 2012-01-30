<?php

class VimeoVideoHandler extends VideoHandler {
	
	protected $apiName = 'VimeoApiWrapper';
	protected static $aspectRatio = 1.7777778;
	protected static $urlTemplate = 'http://vimeo.com/api/v2/video/%s.json';
	
	public function getPlayerAssetUrl() {
		return ''; //JWPlayer::getJavascriptPlayerUrl();
	}
	
	public function getEmbed( $articleId, $width, $autoplay = false, $isAjax = false ) {
		return $this->getEmbedNative( $width, $autoplay );
	}
		
	private function getEmbedNative( $width, $autoplay = false ) {
		$params['autoplay'] = ($autoplay) ? 1 : 0;
		$qs = http_build_query( $params );
		$height =  $this->getHeight( $width );
		return '<iframe src="http://player.vimeo.com/video/'.$this->videoId.'?autoplay=1" width="'.$width.'" height="'.$height.'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
	}	
}