<?php

class YoukuApiWrapper extends ApiWrapper {

	protected static $API_URL = "https://openapi.youku.com/v2/videos/show.json";
	protected static $CACHE_KEY = 'youkuapi';
	protected static $aspectRatio = 1.7777778;
	const VIDEO_NOT_FOUND_ERROR = 120020001;

	/**
	 * Determine if the given url is from Youku
	 * @param string $hostname
	 * @return bool
	 */
	public static function isMatchingHostname( $hostname ) {
		return endsWith( $hostname, "youku.com" ) ? true : false;
	}

	/**
	 * Create an api wrapper from a given url
	 * @param string $url
	 * @return mixed|null|static
	 */
	public static function newFromUrl( $url ) {

		wfProfileIn( __METHOD__ );

		$id = '';
		$parsedUrl = parse_url( $url );
		if ( !empty( $parsedUrl['path'] ) ){
			// Translates a url like this: http://v.youku.com/v_show/id_XNjg3Mzc4MDMy.html?f=22039479&ev=2
			// into this: XNjg3Mzc4MDMy
			$id = explode( ".html", explode( "id_", $parsedUrl["path"] )[1] )[0];
		};

		if ( $id ) {
			wfProfileOut( __METHOD__ );
			return new static( $id );
		}

		wfProfileOut( __METHOD__ );

		return null;
	}

	/**
	 * Is resolution of 720 or higher available
	 * @return boolean
	 */
	protected function isHdAvailable() {
		return in_array( "hd", $this->interfaceObj['streamtypes'] );
	}

	/**
	 * Video duration, in seconds
	 * @return int
	 */
	protected function getVideoDuration() {
		if ( !empty( $this->interfaceObj['duration'] ) ) {
			// Youku returns seconds to decimal points, eg: 661.49
			return round( $this->interfaceObj['duration'] );
		}
		return '';
	}

	/**
	 * Time that this feed entry was created
	 * @return string
	 */
	protected function getVideoPublished() {
		if ( !empty( $this->interfaceObj['published'] ) ) {
			return strtotime( $this->interfaceObj['published'] );
		}
		return '';
	}

	/**
	 * Description of the video provided by Youku
	 * @return string
	 */
	protected function getOriginalDescription() {
		if ( !empty( $this->interfaceObj['description'] ) ) {
			return $this->interfaceObj['description'];
		}
		return '';
	}

	/**
	 * Video Category
	 * @return string
	 */
	protected function getVideoCategory() {
		if ( !empty( $this->interfaceObj['category'] ) ) {
			return $this->interfaceObj['category'];
		}
		return '';
	}

	/**
	 * Keywords of the video
	 * @return mixed|string
	 */
	protected function getVideoKeywords() {
		if ( !empty( $this->interfaceObj['tags'] ) ) {
			return $this->interfaceObj['tags'];
		}
		return '';
	}

	/**
	 * Language of the video
	 * @return string
	 */
	protected function getLanguage() {
		if ( !empty( $this->interfaceObj['audiolang']['lang'] ) ) {
			return $this->interfaceObj['audiolang']['lang'];
		}
		return '';
	}

	/**
	 * Name of the series
	 * @return string
	 */
	protected function getSeries() {
		if ( !empty( $this->interfaceObj['show']['name'] ) ) {
			return $this->interfaceObj['show']['name'];
		}
		return '';
	}

	/**
	 * Characters in the scene
	 * @return string
	 */
	protected function getCharacters() {
		if ( !empty( $this->interfaceObj['dvd']['person']['name'] ) ) {
			return $this->interfaceObj['dvd']['person']['name'];
		}
		return '';
	}

	/**
	 * Aspect ratio of the video
	 * @return float
	 */
	public function getAspectRatio() {
		if ( isset( $this->interfaceObj['file_meta'] ) ) {
			return $this->interfaceObj['file_meta']['width'] / $this->interfaceObj['file_meta']['height'];
		}
		return parent::getAspectRatio();
	}

	/**
	 * Title
	 * @return string
	 */
	protected function getVideoTitle() {
		if ( !empty( $this->interfaceObj['title'] ) ) {
			return $this->interfaceObj['title'];
		}
		return '';
	}

	/**
	 * Description with video category and and keywords if available
	 * @return string
	 */
	public function getDescription() {
		$desc = $this->getOriginalDescription();

		if ( $this->getVideoCategory() ) {
			$desc . "\n\nCategory: " . $this->getVideoCategory();
		}
		if ( $this->getVideoKeywords() ) {
			$desc . "\n\nKeyWords: " . $this->getVideoKeywords();
		}
	}

	/**
	 * Url of video thumbnail
	 * @return mixed
	 */
	public function getThumbnailUrl() {
		return !empty( $this->interfaceObj['bigThumbnail'] ) ? $this->interfaceObj['bigThumbnail'] :  $this->interfaceObj['thumbnail'];
	}

	/**
	 * Get url for API. Note: file_meta, audiolang, and show have the API return info for
	 * aspect ratio, language of video, and characters in video respectively. More information:
	 * http://open.youku.com/docs/tech_doc.html (warning, it's in Chinese...)
	 * @return mixed|string
	 */
	protected function getApiUrl() {

		$params = [
			"video_id" 	=> $this->videoId,
			"client_id" => F::app()->wg->YoukuConfig['AppKey'],
			"ext" 		=> "file_meta,audiolang,show"
		];

		return static::$API_URL . "?" . http_build_query( $params );
	}

	/**
	 * Handle response errors
	 * @param $status - The response status object
	 * @param $content - Json content from the provider
	 * @param $apiUrl - The URL for the providers API
	 * @throws VideoNotFoundException - Video cannot be found
	 */
	protected function checkForResponseErrors( $status, $content, $apiUrl ) {

		// true parameter here has json_decode return an array, rather than an object
		$error_code = json_decode( $content, true )['error']['code'];

		if ( $error_code == self::VIDEO_NOT_FOUND_ERROR ) {
			throw new VideoNotFoundException( $status, $content, $apiUrl );
		}

		parent::checkForResponseErrors( $status, $content, $apiUrl );
	}

}