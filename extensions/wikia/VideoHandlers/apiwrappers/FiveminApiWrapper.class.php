<?php

class FiveminApiWrapper extends ApiWrapper {

	protected static $RESPONSE_FORMAT = self::RESPONSE_FORMAT_XML;
	protected static $API_URL = 'http://api.5min.com/video/$1/info.xml?thumbnail_sizes=true';
	protected static $CACHE_KEY = 'fivemin';

	public function getTitle() {
		return $this->getVideoTitle();
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