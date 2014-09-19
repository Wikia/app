<?php

class UstreamApiWrapper extends ApiWrapper {

	protected static $API_URL = 'http://api.ustream.tv/json/video/$1/getInfo?key=$2';
	protected static $WATCH_URL = 'http://www.ustream.tv/recorded/$1';
	protected static $CACHE_KEY = 'ustreamapi';
	protected static $aspectRatio = 1.7777778;

	protected $sourceId = null;

	public static function isMatchingHostname( $hostname ) {
		return endsWith( $hostname, "ustream.tv" ) ? true : false;
	}

	public static function newFromUrl( $url ) {
		wfProfileIn( __METHOD__ );

		// check permission
		if ( !self::isAllowed() ) {
			wfProfileOut( __METHOD__ );
			return null;
		}

		if ( preg_match( '/recorded\/(\d+)(\/highlight\/(\d+))?/', $url, $matches ) ) {
			$videoId = $matches[1];

			// new video id for highlight video
			if ( !empty( $matches[3] ) ) {
				$videoId .= 'HID'.$matches[3];
			}

			wfProfileOut( __METHOD__ );
			return new static( $videoId );
		}

		wfProfileOut( __METHOD__ );
		return null;
	}

	/**
	 * get provider
	 * @return string
	 */
	public function getProvider() {
		return 'uStream';
	}

	/**
	 * get description
	 * @return string
	 */
	public function getDescription() {
		wfProfileIn( __METHOD__ );

		$description = $this->getOriginalDescription();

		wfProfileOut( __METHOD__ );

		return $description;
	}

	/**
	 * load metadata
	 * @param array $overrideFields
	 */
	protected function loadMetadata( array $overrideFields = array() ) {
		parent::loadMetadata( $overrideFields );

		if ( !isset( $this->metadata['sourceId'] ) ) {
			$this->metadata['sourceId'] = $this->getSourceId();
		}
	}

	/**
	 * get original description
	 * @return string
	 */
	protected function getOriginalDescription(){
		if ( !empty( $this->interfaceObj['results']['description'] ) ) {
			return $this->interfaceObj['results']['description'];
		}

		return '';
	}

	/**
	 * get thumbnail url
	 * @return string
	 */
	public function getThumbnailUrl() {
		if ( !empty( $this->interfaceObj['results']['imageUrl']['medium'] ) ) {
			return $this->interfaceObj['results']['imageUrl']['medium'];
		}

		if ( !empty( $this->interfaceObj['results']['imageUrl']['small'] ) ) {
			return $this->interfaceObj['results']['imageUrl']['small'];
		}

		return '';
	}

	/**
	 * get video title
	 * @return string
	 */
	protected function getVideoTitle() {
		if ( !empty( $this->interfaceObj['results']['title'] ) ) {
			$prefix = ( $this->getSourceId() == '' ) ? '' : 'Highlight - ';
			return $prefix.$this->interfaceObj['results']['title'];
		}

		return '';
	}

	/**
	 * get category
	 * @return string
	 */
	protected function getVideoCategory(){
		return 'Games';
	}

	/**
	 * get duration
	 * @return integer
	 */
	protected function getVideoDuration() {
		if ( !empty( $this->interfaceObj['results']['lengthInSecond'] ) && $this->getSourceId() == '' ) {
			return (int) $this->interfaceObj['results']['lengthInSecond'];
		}

		return 0;
	}

	/**
	 * get published time
	 * @return string
	 */
	protected function getVideoPublished() {
		if ( !empty( $this->interfaceObj['results']['createdAt'] ) ) {
			return strtotime( $this->interfaceObj['results']['createdAt'] );
		}

		return '';
	}

	/**
	 * get keywords
	 * @return string
	 */
	protected function getVideoKeywords() {
		$keywords = array();
		if ( !empty( $this->interfaceObj['results']['tags'] ) ) {
			$keywords = $this->interfaceObj['results']['tags'];
		}

		if ( !empty( $this->interfaceObj['results']['user']['userName'] ) ) {
			$keywords[] = $this->interfaceObj['results']['user']['userName'];
		}

		return implode( ', ', $keywords );
	}

	/**
	 * get api url
	 * @return string $apiUrl
	 */
	protected function getApiUrl() {
		$videoId = $this->getSourceId();
		if ( empty( $videoId ) ) {
			$videoId = $this->videoId;
		}

		$apiUrl = str_replace( '$1', $videoId, static::$API_URL );
		$apiUrl = str_replace( '$2', F::app()->wg->UstreamApiConfig['appKey'], $apiUrl );

		return $apiUrl;
	}

	/**
	 * get source video id for highlight video
	 * @return string $videoId
	 */
	protected function getSourceId() {
		if ( is_null( $this->sourceId ) ) {
			if ( preg_match( '/(\d+)HID(\d+)/', $this->videoId, $matches ) ) {
				$this->sourceId = $matches[1];
			} else {
				$this->sourceId = '';
			}
		}

		return $this->sourceId;
	}

}