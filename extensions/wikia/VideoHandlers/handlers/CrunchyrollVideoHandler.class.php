<?php

class CrunchyrollVideoHandler extends VideoHandler {

	/*
	 * TODO: Create a constant to hold the affiliate ID,
	 * Parent class should not access static fields directly
	 */

	protected $apiName = 'CrunchyrollApiWrapper';
	protected static $urlTemplate = "http://www.crunchyroll.com/affiliate_iframeplayer?aff=$2&media_id=$1&video_format=106&video_quality=60";
	protected static $providerHomeUrl = 'http://www.crunchyroll.com/';

	/**
	 * @inheritdoc
	 */
	public function getProviderDetailUrl() {
		$metadata = $this->getMetadata( true );
		$url = $metadata['videoUrl'];

		return $url;
	}

	/**
	 * @inheritdoc
	 */
	public function getEmbed( $articleId, $width, $autoplay = false, $isAjax = false, $postOnload = false ) {
		$height =  $this->getHeight( $width );
		$sizeString = $this->getSizeString( $width, $height, 'inline' );

		$srcUrl = $this->getEmbedUrl();
		if ( $autoplay ) {
			$srcUrl = $srcUrl."&auto_play=1";
		}

		$html = "<iframe src=\"{$srcUrl}\" {$sizeString}></iframe>";

		return [
			'html' => $html,
			'width' => $width,
			'height' => $height,
		];
	}

	public function getEmbedUrl() {
		global $wgCrunchyrollConfig;

		$url = str_replace( '$1', $this->videoId, static::$urlTemplate );
		$url = str_replace( '$2', $wgCrunchyrollConfig['affiliate_code'], $url );

		return $url;
	}

}
