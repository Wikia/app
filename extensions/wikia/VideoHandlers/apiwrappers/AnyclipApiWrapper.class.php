<?php

class AnyclipApiWrapper extends ApiWrapper {

	protected $ingestion = true;

	protected static $API_URL = 'http://apis.anyclip.com/api/clip/$1/';
	protected static $CACHE_KEY = 'anyclipapi';
	protected static $CACHE_KEY_VERSION = 0.2;
	protected static $aspectRatio = 1.7777778;

	public static function isMatchingHostname( $hostname ) {
		return endsWith($hostname, "anyclip.com") ? true : false;
	}

	public static function newFromUrl( $url ) {
		wfProfileIn( __METHOD__ );

		$url = trim( $url );

		// check for customized video
		$parsed = explode( "?", $url );
		if( is_array($parsed) && !empty($parsed) ) {
			$query = explode( 'clipid=', array_pop($parsed) );
			$videoId = array_pop( $query );

			$apiWrapper = new static( $videoId );
			$apiWrapper->ingestion = false;

			wfProfileOut( __METHOD__ );

			return $apiWrapper;
		}

		wfProfileOut( __METHOD__ );

		return null;
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

		if ( !empty($this->interfaceObj['thumbnail']) ) {
			return $this->interfaceObj['thumbnail'];
		}

		return '';
	}

	public function getVideoTitle() {
		if ( !empty($this->videoName) ) {
			return $this->videoName;
		}

		return self::getClipName( $this->interfaceObj );
	}

	public static function getClipName( $content ) {
		$videoName = '';
		if ( !empty($content['title']['name']) ) {
			$videoName = $content['title']['name'];
		}

		if ( !empty($content['name']) ) {
			if ( !empty($videoName) ) {
				$videoName .= ' - ';
			}
			$videoName .= $content['name'];
		}

		return $videoName;
	}

	protected function getApiUrl() {
		$params = array(
			'tf' => 524,	// 4(plot)+8(Release_date,Duration)+512(genres)
			'filter' => 2063,	//2(URL)+4(actors)+8(Restrictions)+2048(tags)
		);

		return self::getApi( $this->videoId, $params );
	}

	public static function getApi( $code, $params = array() ) {
		global $wgAnyclipApiConfig;

		$extra = array(
			'cid' => $wgAnyclipApiConfig['AppId'],
			'format' => 'JSON',
		);

		$params = array_merge( $params, $extra );

		$url = str_replace( '$1', $code, static::$API_URL );
		$params['sig'] = self::getApiSig( $wgAnyclipApiConfig['AppKey'], $url, $params );
		$url .= '?'.http_build_query( $params );

		return $url;
	}

	protected static function getApiSig( $appKey, $url, $params ) {
		$input = explode( '.com', $url );
		if ( !is_array($input) ) {
			return '';
		}

		$input = array_pop( $input );
		$params['appKey'] = $appKey;
		ksort( $params );
		$input .= '?'.http_build_query( $params );

		return sha1( $input );
	}

	protected function loadMetadata(array $overrideFields = array()) {
		parent::loadMetadata($overrideFields);

		if ( $this->isAgeGate() ) {
			throw new WikiaException( wfMsg("videohandler-error-restricted-video") );
		}

		if ( !isset( $this->metadata['uniqueName'] ) ) {
			$this->metadata['uniqueName'] = $this->getUniqueName();
		}
		if ( !isset( $this->metadata['videoUrl'] ) ) {
			$this->metadata['videoUrl'] = $this->getVideoUrl();
		}
	}

	protected function getOriginalDescription() {
		if ( !empty($this->metadata['description']) ) {
			return $this->metadata['description'];
		}

		if ( !empty($this->interfaceObj['title']['plots'][0]['text']) ) {
			return $this->interfaceObj['title']['plots'][0]['text'];
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

		if ( !empty($this->interfaceObj['title']['releaseDate']) ) {
			return ( $this->interfaceObj['title']['releaseDate']/1000 );
		}

		return '';
	}

	protected function getVideoCategory() {
		if ( !empty($this->metadata['category']) ) {
			return $this->metadata['category'];
		}

		return 'Movies';
	}

	protected function getVideoName() {
		if ( !empty($this->metadata['name']) ) {
			return $this->metadata['name'];
		}

		if ( !empty($this->interfaceObj['title']['name']) ) {
			return $this->interfaceObj['title']['name'];
		}

		return '';
	}

	protected function getIndustryRating() {
		if ( !empty($this->metadata['industryRating']) ) {
			return $this->metadata['industryRating'];
		}

		if ( !empty($this->interfaceObj['title']['mpaaRating']) ) {
			return $this->interfaceObj['title']['mpaaRating'];
		}

		return '';
	}

	protected function getLanguage() {
		if ( !empty($this->metadata['language']) ) {
			return $this->metadata['language'];
		}

		if ( !empty($this->interfaceObj['language']) ) {
			return $this->interfaceObj['language'];
		}

		return '';
	}

	protected function isHdAvailable() {
		if ( !empty($this->metadata['hd']) ) {
			return $this->metadata['hd'];
		}

		return 0;
	}

	protected function getAgeRequired() {
		if ( !empty( $this->metadata['ageRequired'] ) ) {
			return $this->metadata['ageRequired'];
		}

		// set default age required
		if ( !empty( $this->interfaceObj['restrictions'] ) ) {
			return 18;
		}

		return 0;
	}

	protected function isAgeGate() {
		if ( !empty( $this->metadata['ageGate'] ) ) {
			return true;
		}

		if ( !empty($this->interfaceObj['restrictions']) ) {
			return true;
		}

		return false;
	}

	protected function getVideoKeywords() {
		if ( !empty($this->metadata['keywords']) ) {
			return $this->metadata['keywords'];
		}

		if ( !empty($this->interfaceObj['tags']) ) {
			$tags = array();
			if ( is_array($this->interfaceObj['tags']) ) {
				foreach ( $this->interfaceObj['tags'] as $tag ) {
					$tags[] = $tag['val'];
				}
			}

			return implode( ', ', $tags );
		}

		return '';
	}

	protected function getGenres() {
		if ( !empty($this->metadata['genres']) ) {
			return $this->metadata['genres'];
		}

		if ( !empty($this->interfaceObj['title']['genres']) ) {
			if ( is_array($this->interfaceObj['title']['genres']) ) {
				return implode( ', ', $this->interfaceObj['title']['genres'] );
			}
		}

		return '';
	}

	protected function getActors() {
		if ( !empty($this->metadata['actors']) ) {
			return $this->metadata['actors'];
		}

		if ( !empty($this->interfaceObj['actors']) ) {
			if ( is_array($this->interfaceObj['actors']) ) {
				$actors = array();
				foreach( $this->interfaceObj['actors'] as $actor ) {
					$actors[] = $actor['name'];
				}
				return implode( ', ', $actors );
			}
		}

		return '';
	}

	protected function getUniqueName() {
		if ( !empty($this->metadata['uniqueName']) ) {
			return $this->metadata['uniqueName'];
		}

		if ( !empty($this->interfaceObj['uniqueName']) ) {
			return $this->interfaceObj['uniqueName'];
		}

		return '';
	}

	protected function getVideoUrl() {
		if ( !empty($this->metadata['videoUrl']) ) {
			return $this->metadata['videoUrl'];
		}

		if ( !empty($this->interfaceObj['urls'][0]['url']) ) {
			return $this->interfaceObj['urls'][0]['url'];
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

		return 'Clip';
	}

}