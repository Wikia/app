<?php

class MetacafeApiWrapper extends ApiWrapper {
	
	protected static $RESPONSE_FORMAT = self::RESPONSE_FORMAT_XML;
	protected static $API_URL = 'http://www.metacafe.com/api/item/$1/';
	protected static $CACHE_KEY = 'metacafeapi';

	public static function isHostnameFromProvider( $hostname ) {
		return endsWith($hostname, "METACAFE.COM") ? true : false;
	}

	public static function newFromUrl( $url ) {
		$standard_url = strpos( strtoupper( $url ), "HTTP://WWW.METACAFE.COM/WATCH/" );
		if( false !== $standard_url ) {
			$id = substr( $url , $standard_url+ strlen("HTTP://WWW.METACAFE.COM/WATCH/") , strlen($url) );
			$last_char = substr( $id,-1 ,1 );

			if($last_char == "/"){
				$id = substr( $id , 0 , strlen($id)-1 );
			}

			if ( !( false !== strpos( $id, ".SWF" ) ) ) {
				$id .= ".swf";
			}

			$data = explode( "/", $id );
			if (is_array( $data ) ) {
				return static( $data[0]);
			}
		}

		return null;
	}
	
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