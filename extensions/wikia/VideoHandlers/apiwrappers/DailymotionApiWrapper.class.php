<?php

class DailymotionApiWrapper extends ApiWrapper {

	protected static $API_URL = 'https://api.dailymotion.com/video/$1?fields=id,title,tags,created_time,duration,channel,description,thumbnail_url,thumbnail_large_url,aspect_ratio';
	protected static $CACHE_KEY = 'dailymotionapi';
	protected static $aspectRatio = 1.7777778;
	

	public static function isMatchingHostname( $hostname ) {
		return strpos($hostname, "www.dailymotion")!==false ? true : false;
	}

	public static function newFromUrl( $url ) {
		$parsed = explode( '/', parse_url($url, PHP_URL_PATH) );
		return is_array( $parsed ) ? new static( array_pop( $parsed ) ) : null;
	}

	public function getDescription() {

		wfProfileIn( __METHOD__ );
		$text = '';
		if ( $this->getOrignalDescription() )
			$text .= $this->getOrignalDescription() . "\n\n";
		if ( $this->getVideoCategory() )
			$text .= 'Category: ' . $this->getVideoCategory();
		if ( $this->getVideoKeywords() )
			$text .= "\n\nKeywords: {$this->getVideoKeywords()}";

		wfProfileOut( __METHOD__ );
		return $text;
	}

	public function getThumbnailUrl() {

		$thumbnailDatas = $this->getVideoThumbnails();

		return !empty( $thumbnailDatas['max']['url'] ) ? $thumbnailDatas['max']['url'] : $thumbnailDatas['large']['url'];
	}

	/**
	 * returns array of thumbnail data. 
	 * @return array
	 */
	protected function getVideoThumbnails() {

		$thumbs = array();
		if ( !empty( $this->interfaceObj['thumbnail_url'] ) ) {

			$thumbs['max'] = array("url" => $this->interfaceObj['thumbnail_url']);
		}
		if ( !empty( $this->interfaceObj['thumbnail_large_url'] ) ) {

			$thumbs['large'] = array("url" => $this->interfaceObj['thumbnail_large_url']);
		}

		return $thumbs;
	}

	/**
	 * Title
	 * @return string
	 */
	protected function getVideoTitle() {
		if ( !empty( $this->interfaceObj['title'] ) ) {

			return $this->interfaceObj['title'];
		}

		return '';
	}

	/**
	 * User-defined description
	 * @return string
	 */
	protected function getOrignalDescription() {
		if ( !empty( $this->interfaceObj['description'] ) ) {

			return $this->interfaceObj['description'];
		}

		return '';
	}

	/**
	 * User-defined keywords
	 * @return array
	 */
	protected function getVideoKeywords() {
		if ( is_array( $this->interfaceObj['tags'] ) ) {

			return implode( ", ", $this->interfaceObj['tags'] );
		}

		return '';
	}

	/**
	 * Video category
	 * @return string
	 */
	protected function getVideoCategory() {
		if ( !empty( $this->interfaceObj['channel'] ) ) {

			return $this->interfaceObj['channel'];
		}

		return '';
	}

	/**
	 * Time that this feed entry was created, (timestamp)
	 * @return string
	 */
	protected function getVideoPublished() {
		if ( !empty( $this->interfaceObj['created_time'] ) ) {

			return $this->interfaceObj['created_time'];
		}

		return '';
	}

	/**
	 * Video duration, in seconds
	 * @return int
	 */
	protected function getVideoDuration() {
		if ( !empty( $this->interfaceObj['duration'] ) ) {

			return $this->interfaceObj['duration'];
		}

		return '';
	}

	public function getAspectRatio() {
		if ( !empty( $this->interfaceObj['aspect_ratio'] ) ) {
			return $this->interfaceObj['aspect_ratio'];
		}
		return parent::getAspectRatio();
	}
}