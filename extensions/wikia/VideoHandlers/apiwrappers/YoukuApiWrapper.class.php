<?php

class YoukuApiWrapper extends ApiWrapper {

	protected  static $API_KEY = '481ddfdf1bc0960f';
	protected static $API_URL = "https://openapi.youku.com/v2/videos/show.json";
	protected static $CACHE_KEY = 'youkuapi';
	protected static $aspectRatio = 1.7777778;

	public static function isMatchingHostname( $hostname ) {
		return endsWith( $hostname, "v.youku.com" ) ? true : false;
	}

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
	// TODO Implement!!!! Ask Chen to translate the "settings" gear on the video used to change the resolution
	// Also, check what we do with that information (whether something is HD or not).
	protected function isHdAvailable() {
		return null;
		//return isset($this->interfaceObj['entry']['yt$hd']);
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

	// TODO is saying that this is created in UTC accurate?
	/**
	 * Time that this feed entry was created, in UTC
	 * @return string
	 */
	protected function getVideoPublished() {
		if ( !empty( $this->interfaceObj['published'] ) ) {
			return strtotime( $this->interfaceObj['published'] );
		}
		return '';
	}

	/**
	 * Description of the video
	 * @return string
	 */
	protected function getOriginalDescription() {
		if ( !empty( $this->interfaceObj['description'] ) ) {
			return $this->interfaceObj['description'];
		}
		return '';
	}

	/**
	 * @return string
	 */
	protected function getVideoName() {
		if ( !empty( $this->interfaceObj['title'] ) ) {
			return $this->interfaceObj['title'];
		}
		return '';
	}

	/**
	 * @return string
	 */
	protected function getVideoCategory() {
		if ( !empty( $this->interfaceObj['category'] ) ) {
			return $this->interfaceObj['category'];
		}
		return '';
	}

	/**
	 * @return mixed|string
	 */
	// TODO check with chen if there these keywords should actually not have a space following the comma
	protected function getVideoKeywords() {
		if ( !empty( $this->interfaceObj['keywords'] ) ) {
			return str_replace(',', ', ', $this->interfaceObj['keywords'] );
		}
		return '';
	}

	/**
	 * @return string
	 */
	// TODO Try and get the api to actually return an audiolang dictionary...
	protected function getLanguage() {
		if ( !empty( $this->interfaceObj['audiolang']['lang'] ) ) {
			return $this->interfaceObj['audiolang']['lang'];
		}
		return '';
	}

	/**
	 * @return string
	 */
	protected function getSeries() {
		if ( !empty( $this->interfaceObj['show']['name'] ) ) {
			return $this->interfaceObj['show']['name'];
		}
		return '';
	}

	// TODO check with Chen if this is returning the character name, or the actor name
	protected function getCharacters() {
		if ( !empty( $this->interfaceObj['dvd']['person']['name'] ) ) {
			return $this->interfaceObj['dvd']['person']['name'];
		}
		return '';
	}

	// TODO check if ['show']['seq'] represents the number of videos, or if it's actually the season

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
	 * @return string
	 */
	public function getDescription() {
		return "This is a very generic description";
	}

	/**
	 * @return mixed
	 */
	public function getThumbnailUrl() {

		wfProfileIn( __METHOD__ );

		return !empty( $this->interfaceObj['bigThumbnail'] ) ? $this->interfaceObj['bigThumbnail'] :  $this->interfaceObj['thumbnail'];

		wfProfileOut( __METHOD__ );

	}

	/**
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

}