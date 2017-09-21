<?php

use Wikia\Logger\WikiaLogger;

class YoutubeApiWrapper extends ApiWrapper {

	protected static $API_URL = 'https://www.googleapis.com/youtube/v3/videos';
	protected static $CACHE_KEY = 'youtubeapi';
	protected static $aspectRatio = 1.7777778;

	public static function isMatchingHostname( $hostname ) {
		return endsWith( $hostname, "youtube.com" )
			|| endsWith( $hostname, "youtu.be" ) ? true : false;
	}

	public static function newFromUrl( $url ) {

		wfProfileIn( __METHOD__ );

		$aData = array();

		$id = '';
		$parsedUrl = parse_url( $url );
		if ( !empty( $parsedUrl['query'] ) ) {
			parse_str( $parsedUrl['query'], $aData );
		}
		if ( isset( $aData['v'] ) ) {
			$id = $aData['v'];
		}

		if ( empty( $id ) ) {
			$parsedUrl = parse_url( $url );

			$aExploded = explode( '/', $parsedUrl['path'] );
			$id = array_pop( $aExploded );
		}

		if ( false !== strpos( $id, "&" ) ) {
			$parsedId = explode( "&", $id );
			$id = $parsedId[0];
		}

		if ( $id ) {
			wfProfileOut( __METHOD__ );
			return new static( $id );
		}

		wfProfileOut( __METHOD__ );
		return null;
	}

	/**
	 * Before Youtube API update it was build from keywords and categories.
	 * After Youtube API update to V3, categories are no longer returned and support for keywords is dropped.
	 * For now let's return an empty string.
	 * If it's not enough let's revisit.
	 * @return string
	 */
	public function getDescription() {
		return '';
	}

	public function getThumbnailUrl() {
		wfProfileIn( __METHOD__ );

		$thumbnailData = $this->getVideoThumbnails();

		if ( array_key_exists( 'high', $thumbnailData ) ) {
			wfProfileOut( __METHOD__ );
			return $thumbnailData['high']['url'];
		} else if ( array_key_exists( 'medium', $thumbnailData ) ) {
			wfProfileOut( __METHOD__ );
			return $thumbnailData['medium']['url'];
		} else if ( array_key_exists( 'default', $thumbnailData ) ) {
			wfProfileOut( __METHOD__ );
			return $thumbnailData['default']['url'];
		}

		wfProfileOut( __METHOD__ );
		return '';
	}

	public function videoExists() {
		return !empty( $this->interfaceObj['snippet']['title'] );
	}

	/**
	 * returns array of thumbnail data. Thumbnails taken from different
	 * points of video. Elements: time, height, width, url
	 * @return array
	 */
	protected function getVideoThumbnails() {
		if ( !empty( $this->interfaceObj['snippet']['thumbnails'] ) ) {
			return $this->interfaceObj['snippet']['thumbnails'];
		}

		return array();
	}

	/**
	 * Title
	 * @return string
	 */
	protected function getVideoTitle() {
		if ( !empty( $this->interfaceObj['snippet']['title'] ) ) {
			return $this->interfaceObj['snippet']['title'];
		}

		return '';
	}

	/**
	 * User-defined description
	 * @return string
	 */
	protected function getOriginalDescription() {
		if ( !empty( $this->interfaceObj['snippet']['description'] ) ) {
			return $this->interfaceObj['snippet']['description'];
		}

		return '';
	}

	/**
	 * Time that this feed entry was created, in UTC
	 * @return string
	 */
	protected function getVideoPublished() {
		if ( !empty( $this->interfaceObj['snippet']['publishedAt'] ) ) {
			return strtotime( $this->interfaceObj['snippet']['publishedAt'] );
		}

		return '';
	}

	/**
	 * Video duration, in seconds
	 * @return int
	 */
	protected function getVideoDuration() {
		if ( !empty( $this->interfaceObj['contentDetails']['duration'] ) ) {
			$dateInterval = new DateInterval( $this->interfaceObj['contentDetails']['duration'] );
			$seconds = (int) $dateInterval->format( '%s' );
			$minutes = (int) $dateInterval->format( '%i' );
			$hours = (int) $dateInterval->format( '%h' );
			$durationInSeconds = $seconds + ( 60 * $minutes ) + ( 60 * 60 * $hours );

			return $durationInSeconds;
		}

		return '';
	}

	/**
	 * Is resolution of 720 or higher available
	 * @return boolean
	 */
	protected function isHdAvailable() {
		return !empty( $this->interfaceObj['contentDetails']['definition'] )
			&& ( $this->interfaceObj['contentDetails']['definition'] == 'hd' );
	}

	/**
	 * Can video be embedded
	 * Youtube video can always be embedded because we ask for embeddable ones via API
	 * @return boolean
	 */
	protected function canEmbed() {
		return true;
	}

	protected function sanitizeVideoId( $videoId ) {
		if ( ( $pos = strpos( $videoId, '?' ) ) !== false ) {
			$videoId = substr( $videoId, 0, $pos );
		}
		if ( ( $pos = strpos( $videoId, '&' ) ) !== false ) {
			$videoId = substr( $videoId, 0, $pos );
		}
		return $videoId;
	}

	/**
	 * Handle response errors
	 * @param $status - The response status object
	 * @param $content - content from the provider
	 * @param $apiUrl - The URL for the providers API
	 * @throws NegativeResponseException
	 * @throws VideoIsPrivateException - Video is private and cannot be viewed
	 * @throws VideoNotFoundException - Video cannot be found
	 * @throws VideoWrongApiCall - Youtube returns 400 response error code
	 */
	protected function checkForResponseErrors( $status, $content, $apiUrl ) {
		wfProfileIn( __METHOD__ );

		if ( isset( $content['error']['code'] ) && $content['error']['code'] === 400 ) {
			wfProfileOut( __METHOD__ );
			WikiaLogger::instance()->error( 'Youtube API call  returns 400', [
				'content' => $content
			] );
			throw new VideoWrongApiCall( $status, $content, $apiUrl );
		}

		wfProfileOut( __METHOD__ );

		// return default
		parent::checkForResponseErrors( $status, $content, $apiUrl );
	}

	/**
	 * Override method from parent class.
	 * Firstly, set the value for $this->interfaceObj - by calling the parent method.
	 * Secondly, check if 'items' key exists and if yes update value of $this->interfaceObj.
	 */
	protected function initializeInterfaceObject() {
		parent::initializeInterfaceObject();
		if ( !empty( $this->interfaceObj['items'][0] ) ) {
			$this->interfaceObj = $this->interfaceObj['items'][0];
		}
	}

	/**
	 * Get url for API.
	 * More information: https://developers.google.com/youtube/2.0/developers_guide_protocol
	 * @return string
	 */
	protected function getApiUrl() {
		global $wgYoutubeConfig;

		$params = [
			'part' => 'snippet,contentDetails',
			'id' => $this->videoId,
			'maxResults' => '1',
			'videoEmbeddable' => true,
			'type' => 'video',
			'key' => $wgYoutubeConfig['DeveloperKeyApiV3']
		];

		return self::$API_URL . '?' . http_build_query( $params );
	}
}
