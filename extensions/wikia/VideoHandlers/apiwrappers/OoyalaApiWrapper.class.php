<?php

class OoyalaApiWrapper extends ApiWrapper {

	protected $ingestion = true;

	protected static $API_URL = 'https://api.ooyala.com';
	protected static $CACHE_KEY = 'ooyalaapi';
	protected static $CACHE_KEY_VERSION = 0.2;
	protected static $aspectRatio = 1.7777778;

	public static function isMatchingHostname( $hostname ) {
		return endsWith($hostname, "ooyala.com") ? true : false;
	}

	public static function newFromUrl( $url ) {
		wfProfileIn( __METHOD__ );

		$url = trim( $url );

		// check for customized video
		$parsed = explode( "?", $url );
		if( is_array($parsed) && !empty($parsed) ) {
			$query = explode( 'videoid=', array_pop($parsed) );
			$videoId = array_pop( $query );

			$apiWrapper = new static( $videoId );
			$apiWrapper->ingestion = false;

			wfProfileOut( __METHOD__ );

			return $apiWrapper;
		}

		wfProfileOut( __METHOD__ );

		return null;
	}

	public function getProvider() {
		if ( !empty($this->metadata['provider']) ) {
			return $this->metadata['provider'];
		}

		return self::getProviderName( $this->interfaceObj['labels'] );
	}

	public static function getProviderName( $labels ) {
		$provider = 'Ooyala';
		foreach( $labels as $label ) {
			if ( empty($label['parent_id']) ) {
				$provider = str_replace( ' ', '', $label['name'] );
				break;
			}
		}

		return strtolower( $provider );
	}

	public function isIngestion() {
		return $this->ingestion;
	}

	public function getDescription() {
		wfProfileIn( __METHOD__ );

		$description = $this->getOriginalDescription();

		wfProfileOut( __METHOD__ );

		return $description;
	}

	public function getThumbnailUrl() {
		if ( !empty($this->metadata['thumbnail']) ) {
			return $this->metadata['thumbnail'];
		}

		if ( !empty($this->interfaceObj['preview_image_url']) ) {
			return $this->interfaceObj['preview_image_url'];
		}

		return '';
	}

	public function getVideoTitle() {
		if ( !empty($this->videoName) ) {
			return $this->videoName;
		}

		if ( !empty($this->interfaceObj['name']) ) {
			return $this->interfaceObj['name'];
		}

		return '';
	}

	protected function getApiUrl() {
		$method = 'GET';
		$reqPath = '/v2/assets/'.$this->videoId;
		return self::getApi( $method, $reqPath );
	}

	public static function getApi( $method, $reqPath, $params = array(), $reqBody = '' ) {
		global $wgOoyalaApiConfig;

		$extra = array(
			'api_key' => $wgOoyalaApiConfig['AppId'],
			'expires' => strtotime("+1 hour"),
			'include' => 'metadata,labels',
		);

		$params = array_merge( $params, $extra );

		$params['signature'] = self::getApiSig( $wgOoyalaApiConfig['AppKey'], $method, $reqPath, $params, $reqBody );
		$url = static::$API_URL.$reqPath.'?'.http_build_query( $params );

		return $url;
	}

	public static function getApiSig( $appKey, $method, $reqPath, $params, $reqBody = '' ) {
		$sig = $appKey.strtoupper($method).$reqPath;

		ksort( $params );
		foreach( $params as $key => $value ) {
			$sig .= $key.'='.$value;
		}

		$sig .= $reqBody;
		$sig = base64_encode( hash( 'sha256', $sig, true ) );
		$sig = substr( $sig, 0, 43 );

		return rtrim( $sig, '=' );
	}

	protected function loadMetadata(array $overrideFields = array()) {
		parent::loadMetadata($overrideFields);

		if ( !isset($metadata['genres']) ) {
			$metadata['genres'] = $this->getGenres();
		}
		if ( !isset($metadata['actors']) ) {
			$metadata['actors'] = $this->getActors();
		}

		$this->metadata = array_merge( $this->metadata, $metadata );
	}

	protected function getOriginalDescription() {
		if ( !empty($this->metadata['description']) ) {
			return $this->metadata['description'];
		}

		if ( !empty($this->interfaceObj['description']) ) {
			return $this->interfaceObj['description'];
		}

		return '';
	}

	protected function getVideoDuration() {
		if ( !empty($this->metadata['duration']) ) {
			return $this->metadata['duration'];
		}

		if ( !empty($this->interfaceObj['duration']) ) {
			return $this->interfaceObj['duration'];
		}

		return '';
	}

	public function getAspectRatio() {
		return self::$aspectRatio;
	}

	protected function getVideoPublished() {
		if ( !empty($this->metadata['published']) ) {
			return $this->metadata['published'];
		}

		if ( !empty($this->interfaceObj['metadata']['published']) ) {
			return strtotime( $this->interfaceObj['metadata']['published'] );
		}

		return '';
	}

	protected function getVideoCategory() {
		if ( !empty($this->metadata['category']) ) {
			return $this->metadata['category'];
		}

		if ( !empty($this->interfaceObj['metadata']['category']) ) {
			return $this->interfaceObj['metadata']['category'];
		}

		return '';
	}

	protected function getVideoKeywords() {
		if ( !empty($this->metadata['keywords']) ) {
			return $this->metadata['keywords'];
		}

		if ( !empty($this->interfaceObj['metadata']['keywords']) ) {
			return $this->interfaceObj['metadata']['keywords'];
		}

		return '';
	}

	protected function getLanguage() {
		if ( !empty($this->metadata['language']) ) {
			return $this->metadata['language'];
		}

		if ( !empty($this->interfaceObj['metadata']['lang']) ) {
			return $this->interfaceObj['metadata']['lang'];
		}

		return '';
	}

	protected function isHdAvailable() {
		if ( !empty($this->metadata['hd']) ) {
			return $this->metadata['hd'];
		}

		if ( !empty($this->interfaceObj['metadata']['hd']) ) {
			return 1;
		}

		return 0;
	}

	protected function isAgeGate() {
		if ( !empty($this->metadata['ageGate']) ) {
			return $this->metadata['ageGate'];
		}

		if ( !empty($this->interfaceObj['metadata']['agegate']) ) {
			return 1;
		}

		return 0;
	}

	protected function getVideoTags() {
		if ( !empty($this->metadata['tags']) ) {
			return $this->metadata['tags'];
		}

		if ( !empty($this->interfaceObj['metadata']['tags']) ) {
			return $this->interfaceObj['metadata']['tags'];
		}

		return '';
	}

	protected function getGenres() {
		if ( !empty($this->metadata['genres']) ) {
			return $this->metadata['genres'];
		}

		if ( !empty($this->interfaceObj['metadata']['genres']) ) {
			return $this->interfaceObj['metadata']['genres'];
		}

		return '';
	}

	protected function getActors() {
		if ( !empty($this->metadata['actors']) ) {
			return $this->metadata['actors'];
		}

		if ( !empty($this->interfaceObj['metadata']['actors']) ) {
			return $this->interfaceObj['metadata']['actors'];
		}

		return '';
	}

}

class WikiawebinarsApiWrapper extends OoyalaApiWrapper {
}
