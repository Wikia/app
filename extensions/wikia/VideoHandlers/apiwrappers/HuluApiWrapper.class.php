<?php

class HuluApiWrapper extends ApiWrapper {

	protected static $API_URL = 'http://www.hulu.com/api/oembed.json?url=';
	protected static $WATCH_URL = 'http://www.hulu.com/watch/$1';
	protected static $CACHE_KEY = 'huluapi';
	
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
		return strtotime($this->interfaceObj['air_date']);
	}	
	
}