<?php

class MetacafeApiWrapper extends ApiWrapper {
	
	protected static $RESPONSE_FORMAT = self::RESPONSE_FORMAT_XML;
	protected static $API_URL = 'http://www.metacafe.com/api/item/$1/';
	protected static $CACHE_KEY = 'metacafeapi';

	public static function isMatchingHostname( $hostname ) {
		return endsWith($hostname, "metacafe.com") ? true : false;
	}

	public static function newFromUrl( $url ) {

		wfProfileIn( __METHOD__ );
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
				wfProfileOut( __METHOD__ );
				return new static( $data[0]);
			}
		}
		wfProfileOut( __METHOD__ );
		return null;
	}
	
	public function getVideoTitle() {
		return $this->interfaceObj['title'];
	}
	
	public function getDescription() {
		wfProfileIn( __METHOD__ );
		$text = $this->getOriginalDescription();
		if ($this->getVideoKeywords()) $text .= "\n\nKeywords: {$this->getVideoKeywords()}";
		wfProfileOut( __METHOD__ );
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

	
	public function getAspectRatio(){
		if (!empty($this->interfaceObj)) {
			return ( $this->interfaceObj['width'] / $this->interfaceObj['height'] );
		}

		return parent::getAspectRatio();
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