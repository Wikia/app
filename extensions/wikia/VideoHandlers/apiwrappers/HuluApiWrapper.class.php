<?php

class HuluApiWrapper extends ApiWrapper {

	protected static $API_URL = 'https://www.hulu.com/api/oembed.json?url=';
	protected static $WATCH_URL = 'https://www.hulu.com/watch/$1';
	protected static $CACHE_KEY = 'huluapi';
	protected static $aspectRatio = 1.7777778;

	public static function isMatchingHostname( $hostname ) {
		return endsWith($hostname, "hulu.com") ? true : false;
	}

	public static function newFromUrl( $url ) {

		wfProfileIn( __METHOD__ );

		// Hulu goes like
		// http://www.hulu.com/watch/252775/[seo terms]
		$url = trim($url, "/");
		$parsed = explode( "/", $url );
		if( is_array( $parsed ) ) {
			// mId is a number, and it is either last or second to last element of $parsed
			$last = explode('?', array_pop( $parsed ) );
			$last = $last[0];
			if (is_numeric($last)) {
				$videoId = $last;
			}
			else {
				$videoId = array_pop($parsed);
			}
			wfProfileOut( __METHOD__ );
			return new static( $videoId );
		}

		wfProfileOut( __METHOD__ );
		return null;
	}

	public function getDescription() {
	}
	
	public function getThumbnailUrl() {
		return $this->interfaceObj['thumbnail_url'];
	}

	protected function getVideoTitle() {
		return $this->interfaceObj['title'];
	}
	
	protected function getApiUrl() {
		$watchUrl = str_replace( '$1', $this->videoId, static::$WATCH_URL );
		$apiUrl = static::$API_URL . urlencode($watchUrl);
		return $apiUrl;
	}
			
	protected function getAltVideoId() {
		$embedUrlParts = explode('/', $this->interfaceObj['embed_url']);
		return array_pop($embedUrlParts);
	}
	
	protected function getVideoDuration() {
		return (int) $this->interfaceObj['duration'];
	}
	
	protected function getVideoPublished() {
		if (is_string($this->interfaceObj['air_date'])) {
			return strtotime($this->interfaceObj['air_date']);
		}
		else {
			return '';
		}
	}	
	
}