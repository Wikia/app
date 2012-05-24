<?php

class FiveminApiWrapper extends ApiWrapper {

	protected static $RESPONSE_FORMAT = self::RESPONSE_FORMAT_XML;
	protected static $API_URL = 'http://api.5min.com/video/$1/info.xml?thumbnail_sizes=true';
	protected static $CACHE_KEY = 'fivemin';
	protected static $aspectRatio = 1.3636;	// 480 x 352

	public static function isMatchingHostname( $hostname ) {
		return endsWith($hostname, "5min.com") ? true : false;
	}

	public static function newFromUrl( $url ) {

		wfProfileIn( __METHOD__ );
		$parsed = explode( "/", $url );
		if( is_array( $parsed ) ) {
			$ids = array_pop( $parsed );
			$parsed_twice = explode( "-", $ids );
			wfProfileOut( __METHOD__ );
			return new static( array_pop( $parsed_twice ) );
		}
		wfProfileOut( __METHOD__ );
		return null;
	}


	public function getVideoTitle() {
		return $this->interfaceObj['title'];
	}
	
	public function getDescription() {
		if ($this->getVideoKeywords()) $text = "\n\nKeywords: {$this->getVideoKeywords()}";
		return $text;
	}

	public function getThumbnailUrl() {
		if ( !empty( $this->interfaceObj ) ) {
			$thumbnails = $this->interfaceObj['thumbnails'];
			return $this->getFirstThumbnailUrl( $thumbnails );
		}
		return '';
	}

	private function getFirstThumbnailUrl( $thumbnails ) {
		return $thumbnails[2];
	}

	
	protected function getVideoKeywords() {
		if (!empty($this->interfaceObj)) {
			return implode(', ' , $this->interfaceObj['keywords']);
		}

		return '';
	}
	
	protected function getVideoDuration() {
		return $this->interfaceObj['duration'];
	}	
}