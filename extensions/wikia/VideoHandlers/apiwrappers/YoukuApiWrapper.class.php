<?php

class YoukuApiWrapper extends ApiWrapper {

	protected static $API_URL = 'https://openapi.youku.com/v2/videos/show.json?client_id=481ddfdf1bc0960f&video_id=$1&ext=file_meta';
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
			// Translates something like this: http://v.youku.com/v_show/id_XNjg3Mzc4MDMy.html?f=22039479&ev=2
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
	// TODO Implement!!!!
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

	protected function getVideoName() {
		if ( !empty( $this->interfaceObj['title'] ) ) {
			return $this->interfaceObj['title'];
		}
		return '';
	}

	protected function getVideoCategory() {
		if ( !empty( $this->interfaceObj['category'] ) ) {
			return $this->interfaceObj['category'];
		}
		return '';
	}

	// TODO check with chen if there these keywords should actually not have a space following the comma
	protected function getVideoKeywords() {
		if ( !empty( $this->interfaceObj['keywords'] ) ) {
			return str_replace(',', ', ', $this->interfaceObj['keywords'] );
		}
		return '';
	}

	protected function getVideoTitle() {
		return true;
	}

	public function getDescription() {
		return true;
	}

	public function getThumbnailUrl() {
		return true;
	}

}