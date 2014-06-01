<?php

class SnappytvVideoHandler extends VideoHandler {

	protected $apiName = 'SnappytvApiWrapper';
	protected static $urlTemplate = 'https://www.snappytv.com/embed_player.swf?id=$1';
	protected static $providerDetailUrlTemplate = 'http://www.snappytv.com/snap/$1';
	protected static $providerHomeUrl = 'http://www.snappytv.com/';

	public function getEmbed( $articleId, $width, $autoplay = false, $isAjax = false, $postOnload = false ) {
		$height = $this->getHeight( $width );
		$autoPlayStr = $autoplay ? 1 : 0 ;

		if ( F::app()->checkSkin( 'wikiamobile' ) ) {
			$url = $this->getProviderDetailUrl();
			$html = <<<EOT
<iframe src='{$url}' frameborder='0' scrolling='no' webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
EOT;
		} else {
			$url = $this->getEmbedUrl().'&autoplay='.$autoPlayStr;
			$html = <<<EOT
<object width='{$width}' height='{$height}'>
	<param name='movie' value='{$url}'></param>
	<param name='allowFullScreen' value='true'></param><param name='allowscriptaccess' value='always'></param>
	<embed src='{$url}' type='application/x-shockwave-flash' allowscriptaccess='always' allowfullscreen='true' width='{$width}' height='{$height}'></embed>
</object>
EOT;
		}

		return array( 'html' => $html );
	}

	public function getEmbedUrl() {
		$id = strstr( $this->videoId, '_', true );
		return str_replace( '$1', $id, static::$urlTemplate );
	}

	public function getProviderDetailUrl() {
		return str_replace( '$1', $this->getUniqueName(), static::$providerDetailUrlTemplate );
	}

	protected function getUniqueName() {
		$metadata = $this->getMetadata( true );
		if ( !empty($metadata['uniqueName']) ) {
			return $metadata['uniqueName'];
		}

		return '';
	}

}