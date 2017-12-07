<?php

class ViddlerApiWrapper extends ApiWrapper {
	protected static $RESPONSE_FORMAT = self::RESPONSE_FORMAT_PHP;
	protected static $API_URL = 'https://api.viddler.com/api/v2/viddler.videos.getDetails.php?add_embed_code=1&url=';
	public static $WATCH_URL = 'https://www.viddler.com/v/$1';
	public static $MAIN_URL = 'https://www.viddler.com/';
	protected static $CACHE_KEY = 'viddlerapi';
	protected static $aspectRatio = 1.56160458;

	public function __construct($videoId, $overrideMetadata = array()) {

		if ( strpos($videoId, '/') ) {

			$trueId = self::getIdFromUrl(self::$MAIN_URL . $videoId);
			return parent::__construct($trueId, $overrideMetadata);
		} else {

			return parent::__construct($videoId, $overrideMetadata);
		}
	}

	public static function isMatchingHostname( $hostname ) {
		return endsWith($hostname, "viddler.com") ? true : false;
	}

	public static function getIdFromUrl( $url ) {

		wfProfileIn( __METHOD__ );

		$url = self::getFinalUrl($url);

		if ( strpos($url, '/v/') !== false ) {

			$parsed = explode( "/", strtolower($url));
			$videoId = array_pop( $parsed );
			wfProfileOut( __METHOD__ );
			return  $videoId;

		} else {

			$parsed = explode( "/explore/", strtolower($url));
			if( is_array( $parsed ) ) {

				$mdata = array_pop( $parsed );
				if ( ('' != $mdata ) && ( false === strpos( $mdata, "?" ) ) ) {
					$videoId = $mdata;
				} else {
					$videoId = array_pop( $parsed );
				}
				$videoId = trim($videoId, '/');
				wfProfileOut( __METHOD__ );
				return $videoId;
			}
		}
		wfProfileOut( __METHOD__ );
		return null;
	}

	public static function newFromUrl( $url ) {

		wfProfileIn( __METHOD__ );

		$videoId = self::getIdFromUrl( $url );

		if ( !empty($videoId) ) {
			wfProfileOut( __METHOD__ );
			return new static( $videoId );
		}

		wfProfileOut( __METHOD__ );
		return null;
	}


	protected function getVideoTitle() {
		return $this->interfaceObj['video']['title'];
	}

	public function getDescription() {

		wfProfileIn( __METHOD__ );

		$description = $this->getOriginalDescription();
		$keywords = $this->getVideoKeywords();
		if (!empty($keywords)) {
			$keywords = 'Keywords: ' . $keywords;
			if (!empty($description)) {
				$description .= "\n\n";
			}
			$description .= $keywords;
		}
		wfProfileOut( __METHOD__ );

		return $description;
	}

	public function getThumbnailUrl() {
		return $this->interfaceObj['video']['thumbnail_url'];
	}


	protected function getApiUrl() {
		$watchUrl = str_replace( '$1', trim($this->videoId, '/'), static::$WATCH_URL );
		$apiUrl = static::$API_URL . urlencode($watchUrl);
		return $apiUrl;
	}

	protected function getAltVideoId() {
		return $this->interfaceObj['video']['id'];
	}

	protected function getVideoDuration() {
		return $this->interfaceObj['video']['length'];
	}

	protected function getOriginalDescription() {
		return $this->interfaceObj['video']['description'];
	}

	protected function getVideoPublished() {
		return $this->interfaceObj['video']['made_public_time'];
	}

	protected function getVideoKeywords() {

		wfProfileIn( __METHOD__ );

		$keywords = array();
		if (!empty($this->interfaceObj['video']['tags']) && is_array($this->interfaceObj['video']['tags'])) {
			foreach ($this->interfaceObj['video']['tags'] as $tagArr) {
				$keywords[] = $tagArr['text'];
			}
		}

		wfProfileOut( __METHOD__ );

		return implode(', ', $keywords);
	}

	public function getAspectRatio() {

		wfProfileIn( __METHOD__ );

		$embed_code = $this->interfaceObj['video']['embed_code'];
		$matches = array();
		$width = $height = null;
		if (preg_match('/width="(\d+)"/', $embed_code, $matches)) {
			$width = $matches[1];
			$matches = array();
			if (preg_match('/height="(\d+)"/', $embed_code, $matches)) {
				$height = $matches[1];
			}
		}

		if ($width && $height) {

			wfProfileOut( __METHOD__ );
			return $width / $height;
		}

		wfProfileOut( __METHOD__ );
		return parent::getAspectRatio();
	}

	function getFinalUrl($url){

		wfProfileIn( __METHOD__ );

		$options = array(
			'timeout'=>'default',
			'headersOnly'=>true,
			'noProxy' => true,
		);
		$req = MWHttpRequest::factory( $url, $options );
		$status = $req->execute();
		$finalUrl = $req->getFinalUrl();

		wfProfileOut( __METHOD__ );

		return $finalUrl;
	}

}