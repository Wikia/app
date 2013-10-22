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

		$provider = self::getProviderName( $this->interfaceObj['labels'] );
		$provider = self::formatProviderName( $provider );

		return $provider;
	}

	public static function getProviderName( $labels ) {
		$provider = '';
		foreach( $labels as $label ) {
			if ( !empty($label['full_name']) && preg_match('/\/Providers\/([\w\s]+)/', $label['full_name'], $matches) ) {
				$provider = $matches[1];
				break;
			}
		}

		return $provider;
	}

	public static function formatProviderName( $name ) {
		$provider = 'ooyala';
		if ( !empty($name) ) {
			$provider .= '/'.strtolower( preg_replace( '/[\s\W]+/', '', $name ) );
		}

		return $provider;
	}

	public function getMimeType() {
		return 'video/ooyala';
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
		);

		if ( $method == 'GET' ) {
			$extra['include'] = 'metadata,labels';
		}

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

	protected function loadMetadata( array $overrideFields = array() ) {
		parent::loadMetadata( $overrideFields );

		if ( !isset( $this->metadata['source'] ) ) {
			$this->metadata['source'] = $this->getSource();
		}
		if ( !isset( $this->metadata['sourceId'] ) ) {
			$this->metadata['sourceId'] = $this->getSourceId();
		}
		if ( !isset( $this->metadata['startDate'] ) ) {
			$this->metadata['startDate'] = $this->getVideoStartDate();
		}
		if ( !isset( $this->metadata['pageCategories'] ) ) {
			$this->metadata['pageCategories'] = $this->getPageCategories();
		}
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
			return ( $this->interfaceObj['duration']/1000 );
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

	/**
	 * get subtitle
	 * @return string
	 */
	protected function getSubtitle() {
		if ( !empty( $this->metadata['subtitle'] ) ) {
			return $this->metadata['subtitle'];
		}

		if ( !empty( $this->interfaceObj['metadata']['subtitle'] ) ) {
			return $this->interfaceObj['metadata']['subtitle'];
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

	protected function getIndustryRating() {
		if ( !empty($this->metadata['industryRating']) ) {
			return $this->metadata['industryRating'];
		}

		if ( !empty($this->interfaceObj['metadata']['industryrating']) ) {
			return $this->interfaceObj['metadata']['industryrating'];
		}

		return '';
	}

	protected function isAgeGate() {
		if ( !empty( $this->metadata['ageGate'] ) || !empty( $this->metadata['ageRequired'] ) ) {
			return true;
		}

		if ( !empty( $this->interfaceObj['metadata']['agegate'] ) || !empty( $this->interfaceObj['metadata']['age_required'] )  ) {
			return true;
		}

		return false;
	}

	/**
	 * get age required
	 * @return int
	 */
	protected function getAgeRequired() {
		if ( !empty( $this->metadata['ageRequired'] ) ) {
			return $this->metadata['ageRequired'];
		}

		if ( !empty( $this->interfaceObj['metadata']['age_required'] ) ) {
			return $this->interfaceObj['metadata']['age_required'];
		}

		return 0;
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

	protected function getVideoStartDate() {
		if ( !empty($this->metadata['startDate']) ) {
			return $this->metadata['startDate'];
		}

		if ( !empty($this->interfaceObj['time_restrictions']['start_date']) ) {
			return strtotime( $this->interfaceObj['time_restrictions']['start_date'] );
		}

		return '';
	}

	protected function getVideoExpirationDate() {
		if ( !empty($this->metadata['expirationDate']) ) {
			return $this->metadata['expirationDate'];
		}

		if ( !empty($this->interfaceObj['metadata']['expirationdate']) ) {
			return strtotime( $this->interfaceObj['metadata']['expirationdate'] );
		}

		return '';
	}

	/**
	 * get target country
	 * @return string
	 */
	protected function getTargetCountry() {
		if ( !empty( $this->metadata['targetCountry'] ) ) {
			return $this->metadata['targetCountry'];
		}

		if ( !empty( $this->interfaceObj['metadata']['targetcountry'] ) ) {
			return $this->interfaceObj['metadata']['targetcountry'];
		}

		return '';
	}

	/**
	 * get source
	 * @return string
	 */
	protected function getSource() {
		if ( !empty( $this->metadata['source'] ) ) {
			return $this->metadata['source'];
		}

		if ( !empty( $this->interfaceObj['metadata']['source'] ) ) {
			return $this->interfaceObj['metadata']['source'];
		}

		return '';
	}

	/**
	 * get source id (video id from source)
	 * @return string
	 */
	protected function getSourceId() {
		if ( !empty( $this->metadata['sourceId'] ) ) {
			return $this->metadata['sourceId'];
		}

		if ( !empty( $this->interfaceObj['metadata']['sourceid'] ) ) {
			return $this->interfaceObj['metadata']['sourceid'];
		}

		return '';
	}

	/**
	 * get series
	 * @return string
	 */
	protected function getSeries() {
		if ( !empty( $this->metadata['series'] ) ) {
			return $this->metadata['series'];
		}

		if ( !empty( $this->interfaceObj['metadata']['series'] ) ) {
			return $this->interfaceObj['metadata']['series'];
		}

		return '';
	}

	/**
	 * get season
	 * @return string
	 */
	protected function getSeason() {
		if ( !empty( $this->metadata['season'] ) ) {
			return $this->metadata['season'];
		}

		if ( !empty( $this->interfaceObj['metadata']['season'] ) ) {
			return $this->interfaceObj['metadata']['season'];
		}

		return '';
	}

	/**
	 * get episode
	 * @return string
	 */
	protected function getEpisode() {
		if ( !empty( $this->metadata['episode'] ) ) {
			return $this->metadata['episode'];
		}

		if ( !empty( $this->interfaceObj['metadata']['episode'] ) ) {
			return $this->interfaceObj['metadata']['episode'];
		}

		return '';
	}

	/**
	 * get page categories
	 * @return string
	 */
	protected function getPageCategories() {
		if ( !empty( $this->metadata['pageCategories'] ) ) {
			return $this->metadata['pageCategories'];
		}

		if ( !empty( $this->interfaceObj['metadata']['pagecategories'] ) ) {
			return $this->interfaceObj['metadata']['pagecategories'];
		}

		return '';
	}

	/**
	 * get resolution
	 * @return string
	 */
	protected function getResolution() {
		if ( !empty( $this->metadata['resolution'] ) ) {
			return $this->metadata['resolution'];
		}

		if ( !empty( $this->interfaceObj['metadata']['resolution'] ) ) {
			return $this->interfaceObj['metadata']['resolution'];
		}

		return '';
	}

	/**
	 * get characters
	 * @return string
	 */
	protected function getCharacters() {
		if ( !empty( $this->metadata['characters'] ) ) {
			return $this->metadata['characters'];
		}

		if ( !empty( $this->interfaceObj['metadata']['characters'] ) ) {
			return $this->interfaceObj['metadata']['characters'];
		}

		return '';
	}

	/**
	 * get video type
	 * @return string
	 */
	protected function getVideoType() {
		if ( !empty( $this->metadata['type'] ) ) {
			return $this->metadata['type'];
		}

		if ( !empty( $this->interfaceObj['metadata']['type'] ) ) {
			return $this->interfaceObj['metadata']['type'];
		}

		return '';
	}

	/**
	 * get video name
	 * @return string
	 */
	protected function getVideoName() {
		if ( !empty( $this->metadata['name'] ) ) {
			return $this->metadata['name'];
		}

		if ( !empty( $this->interfaceObj['metadata']['name'] ) ) {
			return $this->interfaceObj['metadata']['name'];
		}

		return '';
	}

}
