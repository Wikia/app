<?php

class YoutubeApiWrapper extends ApiWrapper {

	protected static $API_URL = 'http://gdata.youtube.com/feeds/api/videos/$1?v=2&alt=json';
	protected static $CACHE_KEY = 'youtubeapi';
	protected static $aspectRatio = 1.7777778;

	public static function isMatchingHostname( $hostname ) {
		return endsWith($hostname, "youtube.com")
			|| endsWith($hostname, "youtu.be" ) ? true : false;
	}

	public static function newFromUrl( $url ) {

		wfProfileIn( __METHOD__ );

		$aData = array();

		$id = '';
		$parsedUrl = parse_url( $url );
		if ( !empty( $parsedUrl['query'] ) ){
			parse_str( $parsedUrl['query'], $aData );
		};
		if ( isset( $aData['v'] ) ){
			$id = $aData['v'];
		}

		if ( empty( $id ) ){
			$parsedUrl = parse_url( $url );

			$aExploded = explode( '/', $parsedUrl['path'] );
			$id = array_pop( $aExploded );
		}

		if ( false !== strpos( $id, "&" ) ){
			$parsedId = explode("&",$id);
			$id = $parsedId[0];
		}

		if ( $id ) {
			wfProfileOut( __METHOD__ );
			return new static( $id );
		}

		wfProfileOut( __METHOD__ );
		return null;
	}

	public function getDescription() {

		wfProfileIn( __METHOD__ );

		$text = '';
		if ( $this->getVideoCategory() ) $text .= 'Category: ' . $this->getVideoCategory();
		if ( $this->getVideoKeywords() ) $text .= "\n\nKeywords: {$this->getVideoKeywords()}";

		wfProfileOut( __METHOD__ );

		return $text;
	}

	public function getThumbnailUrl() {

		wfProfileIn( __METHOD__ );

		$lowresUrl = '';
		$hiresUrl = '';

		$thumbnailDatas = $this->getVideoThumbnails();
		foreach ( $thumbnailDatas as $thumbnailData ) {
			switch ( $thumbnailData['yt$name'] ) {
				case 'default':
					$lowresUrl = $thumbnailData['url'];
					break;
				case 'hqdefault':
					$hiresUrl = $thumbnailData['url'];
					break;
			}
		}

		wfProfileOut( __METHOD__ );

		return !empty($hiresUrl) ? $hiresUrl : $lowresUrl;
	}

	/**
	 * returns array of thumbnail data. Thumbnails taken from different
	 * points of video. Elements: time, height, width, url
	 * @return array
	 */
	protected function getVideoThumbnails() {
		if ( !empty($this->interfaceObj['entry']['media$group']['media$thumbnail']) ) {

			return $this->interfaceObj['entry']['media$group']['media$thumbnail'];
		}

		return array();
	}

	/**
	 * Title
	 * @return string
	 */
	protected function getVideoTitle() {
		if ( !empty($this->interfaceObj['entry']['title']['$t']) ) {

			return $this->interfaceObj['entry']['title']['$t'];
		}

		return '';
	}

	/**
	 * User-defined description
	 * @return string
	 */
	protected function getOriginalDescription() {
		if ( !empty($this->interfaceObj['entry']['media$group']['media$description']['$t']) ) {

			return $this->interfaceObj['entry']['media$group']['media$description']['$t'];
		}

		return '';
	}

	/**
	 * User-defined keywords
	 * @return array
	 */
	protected function getVideoKeywords() {
		if ( !empty($this->interfaceObj['entry']['media$group']['media$keywords']['$t']) ) {

			return $this->interfaceObj['entry']['media$group']['media$keywords']['$t'];
		}

		return '';
	}

	/**
	 * YouTube category
	 * @return string
	 */
	protected function getVideoCategory() {
		if ( !empty($this->interfaceObj['entry']['media$group']['media$category'][0]['$t']) ) {

			return $this->interfaceObj['entry']['media$group']['media$category'][0]['$t'];
		}

		return '';
	}

	/**
	 * Time that this feed entry was created, in UTC
	 * @return string
	 */
	protected function getVideoPublished() {
		if ( !empty($this->interfaceObj['entry']['published']['$t']) ) {

			return strtotime($this->interfaceObj['entry']['published']['$t']);
		}

		return '';
	}

	/**
	 * Video duration, in seconds
	 * @return int
	 */
	protected function getVideoDuration() {
		if ( !empty($this->interfaceObj['entry']['media$group']['yt$duration']['seconds']) ) {

			return $this->interfaceObj['entry']['media$group']['yt$duration']['seconds'];
		}

		return '';
	}

	/**
	 * Is resolution of 720 or higher available
	 * @return boolean
	 */
	protected function isHdAvailable() {
		return isset($this->interfaceObj['entry']['yt$hd']);
	}

	/**
	 * Can video be embedded
	 * @return boolean
	 */
	protected function canEmbed() {
		if ( !empty($this->interfaceObj['entry']['yt$accessControl']) ) {
			foreach ($this->interfaceObj['entry']['yt$accessControl'] as $accessControl) {
				if ($accessControl['action'] == 'embed') {
					return $accessControl['permission'] == 'allowed';
				}
			}
		}

		return true;
	}

	protected function sanitizeVideoId( $videoId ) {
		if ( ($pos = strpos( $videoId, '?' )) !== false ) {
			$videoId = substr( $videoId, 0, $pos );
		}
		if ( ($pos = strpos( $videoId, '&' )) !== false ) {
			$videoId = substr( $videoId, 0, $pos );
		}
		return $videoId;
	}

	/**
	 * Handle response errors
	 * @param $status - The response status object
	 * @param $content - XML content from the provider
	 * @param $apiUrl - The URL for the providers API
	 * @throws VideoNotFoundException - Video cannot be found
	 * @throws VideoIsPrivateException - Video is private and cannot be viewed
	 * @throws VideoQuotaExceededException - The quota for video owner has been exceeded
	 */
	protected function checkForResponseErrors( $status, $content, $apiUrl ) {

		wfProfileIn( __METHOD__ );

		// check if still exists
		$code = empty( $status->errors[0]['params'][0] ) ? null : $status->errors[0]['params'][0];

		if ( $code == 404 ) {
			wfProfileOut( __METHOD__ );
			throw new VideoNotFoundException($status, $content, $apiUrl);
		}

		// interpret error XML response
		$sp = new SimplePie();
		$sp->set_raw_data( $content );
		$sp->init();

		// check if private
		$googleShemas ='http://schemas.google.com/g/2005';
		if ( isset( $sp->data['child'][$googleShemas] ) ) {
			$err = $sp->data['child'][$googleShemas]['errors'][0]['child'][$googleShemas]['error'][0]['child'][$googleShemas]['internalReason'][0]['data'];
			if( $err == 'Private video' ) {
				wfProfileOut( __METHOD__ );
				throw new VideoIsPrivateException( $status, $content, $apiUrl );
			}
		}

		// check if quota exceeded
		if ( isset( $sp->data['child'][''] ) ) {
			$err = $sp->data['child']['']['errors'][0]['child']['']['error'][0]['child']['']['code'][0]['data'];
			if( $err == 'too_many_recent_calls' ) {
				wfProfileOut( __METHOD__ );
				throw new VideoQuotaExceededException( $status, $content, $apiUrl );
			}
		}

		wfProfileOut( __METHOD__ );

		// return default
		parent::checkForResponseErrors($status, $content, $apiUrl);
	}
}
