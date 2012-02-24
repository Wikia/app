<?php

class MetacafeApiWrapper extends ApiWrapper {
	
	protected static $RESPONSE_FORMAT = self::RESPONSE_FORMAT_XML;
	protected static $API_URL = 'http://www.metacafe.com/api/item/$1/';
	protected static $CACHE_KEY = 'metacafeapi';
	
	public function getVideoTitle() {
		return $this->interfaceObj['title'];
	}
	
	public function getDescription() {
		$text = $this->getOriginalDescription();
		if ($this->getVideoKeywords()) $text .= "\n\nKeywords: {$this->getVideoKeywords()}";
		return $text;
	}

	protected function getOriginalDescription() {
		return $this->interfaceObj['description'];
	}

	public function getThumbnailUrl() {
		if ( !empty( $this->interfaceObj ) ) {
			$thumbnails = $this->interfaceObj['thumbnails'];
			return $this->getFirstThumbnailUrl( $thumbnails );
		}
		return '';
	}

	private function getFirstThumbnailUrl( $thumbnails ) {
		if ( is_array( $thumbnails ) ) {
			foreach ($thumbnails as $thumbnail) {
				return $thumbnail;
			}
		}
		return $thumbnails;
	}

	
	protected function getAspectRatio(){
		if (!empty($this->interfaceObj)) {
			return ( $this->interfaceObj['width'] / $this->interfaceObj['height'] );
		}

		return '';
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