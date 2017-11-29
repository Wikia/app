<?php

class FiveminApiWrapper extends ApiWrapper {

	protected static $RESPONSE_FORMAT = self::RESPONSE_FORMAT_XML;
	protected static $API_URL = 'https://api.5min.com/video/$1/info.xml?thumbnail_sizes=true';
	protected static $CACHE_KEY = 'fiveminapi';
	protected static $aspectRatio = 1.3636;	// 480 x 352

	/**
	 * check if hostname is matched
	 * @param string $hostname
	 * @return boolean
	 */
	public static function isMatchingHostname( $hostname ) {
		return endsWith( $hostname, "on.aol.com" ) ? true : false;
	}

	/**
	 * get ApiWrapper from url
	 * @param string $url
	 * @return ApiWrapper|null
	 */
	public static function newFromUrl( $url ) {
		wfProfileIn( __METHOD__ );

		// remove query string
		$parsed = explode( '?', $url );
		$url = array_shift( $parsed );

		// get videoId
		$parsed = explode( '/', rtrim( $url, '/' ) );
		if ( is_array( $parsed ) ) {
			$last = explode( '-', array_pop( $parsed ) );
			$videoId = array_pop( $last );
			if ( is_numeric( $videoId ) ) {
				wfProfileOut( __METHOD__ );
				return new static( $videoId );
			}
		}

		wfProfileOut( __METHOD__ );
		return null;
	}

	/**
	 * get video title
	 * @return string
	 */
	public function getVideoTitle() {
		if ( !empty( $this->interfaceObj['title'] ) ) {
			return $this->interfaceObj['title'];
		}

		return '';
	}

	/**
	 * get video description
	 * @return string
	 */
	public function getDescription() {
		$description = $this->getOriginalDescription();
		if ( $this->getVideoKeywords() ) {
			$description .= "\n\nKeywords: {$this->getVideoKeywords()}";
		}

		return $description;
	}

	/**
	 * get thumbnail url
	 * @return string
	 */
	public function getThumbnailUrl() {
		// get embed standard thumbnail url
		if ( !empty( $this->interfaceObj['thumbnails'][2] ) ) {
			return $this->interfaceObj['thumbnails'][2];
		}
		return '';
	}

	/**
	 * get video keywords
	 * @return string
	 */
	protected function getVideoKeywords() {
		if ( !empty( $this->interfaceObj['keywords'] ) ) {
			return implode( ', ' , $this->interfaceObj['keywords'] );
		}

		return '';
	}

	/**
	 * get original description
	 * @return string
	 */
	protected function getOriginalDescription() {
		if ( !empty( $this->interfaceObj['description'] ) ) {
			if ( preg_match( '/&lt;p&gt;(.*)&lt;\/p&gt;/', $this->interfaceObj['description'], $matches ) ) {
				return ( !empty( $matches[1] ) ) ? $matches[1] : '' ;
			}
		}

		return '';
	}

	/**
	 * get video duration
	 * @return string
	 */
	protected function getVideoDuration() {
		if ( !empty( $this->interfaceObj['duration'] ) ) {
			return $this->interfaceObj['duration'];
		}

		return '';
	}

}