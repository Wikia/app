<?php

class CrunchyrollVideoHandler extends VideoHandler {

	/*
	 * TODO: Create a constant to hold the affiliate ID,
	 * Parent class should not access static fields directly
	 */

	protected $apiName = 'CrunchyrollApiWrapper';
	protected static $urlTemplate = "http://www.crunchyroll.com/affiliate_iframeplayer?aff=af-90111-uhny&media_id=$1&video_format=106&video_quality=60";
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
		$autoPlayStr = ( $autoplay ) ? '1' : '0';

		$sizeString = $this->getSizeString( $width, $height, 'inline' );

		$srcUrl = str_replace( "$1", $this->videoId, static::$urlTemplate) . "&auto_play={$autoPlayStr}";

		$html = "<iframe src=\"{$srcUrl}\" {$sizeString}></iframe>";

		return [
			'html' => $html,
			'width' => $width,
			'height' => $height,
		];
	}

}
