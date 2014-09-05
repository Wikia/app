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
	public function getEmbed( $width, array $options = [] ) {
		$autoplay = !empty( $options['autoplay'] );
		$isInline = !empty( $options['isInline'] );
		$height =  $this->getHeight( $width );
		$sizeString = $this->getSizeString( $width, $height, 'inline' );

		$srcUrl = $this->getEmbedUrl();
		if ( $autoplay ) {
			$srcUrl = $srcUrl."&auto_play=1";
		}

		$iframe = "<iframe src=\"{$srcUrl}\" {$sizeString}></iframe>";

		if ( $isInline ) {
			$html = $iframe;
		} else {
			$widget = F::app()->renderView( 'VideoHandlerController', 'videoAffiliate', ['provider' => 'crunchyroll'] );
			$html = '<div class="crunchyroll-container">' . $widget . $iframe . '</div>';
		}

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
