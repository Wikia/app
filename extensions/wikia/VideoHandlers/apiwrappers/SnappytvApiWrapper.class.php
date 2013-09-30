<?php

class SnappytvApiWrapper extends ApiWrapper {

	protected static $API_URL = 'http://www.snappytv.com/partner_api/v1/timeline/$1.json';
	protected static $WATCH_URL = 'http://www.snappytv.com/snaps/$1';
	protected static $CACHE_KEY = 'snappytvapi';
	protected static $aspectRatio = 1.7777778;

	public static function isMatchingHostname( $hostname ) {
		return endsWith( $hostname, "snpy.tv" ) ? true : false;
	}

	public static function newFromUrl( $url ) {
		wfProfileIn( __METHOD__ );

		$info = self::getInfoFromHtml( $url );
		if ( !empty($info['videoId']) && !empty($info['eventId']) ) {
			$videoId = $info['videoId'].'_'.$info['eventId'];

			wfProfileOut( __METHOD__ );
			return new static( $videoId );
		}

		wfProfileOut( __METHOD__ );
		return null;
	}

	public function getDescription() {
		wfProfileIn( __METHOD__ );

		$description = $this->getOriginalDescription();

		wfProfileOut( __METHOD__ );

		return $description;
	}

	public function getThumbnailUrl() {
		if ( !empty($this->interfaceObj['thumb_320x180']) ) {
			return $this->interfaceObj['thumb_320x180'];
		}

		return '';
	}

	protected function getVideoTitle() {
		if ( !empty($this->interfaceObj['title']) ) {
			return $this->interfaceObj['title'];
		}

		return str_replace( '-', ' ', $this->interfaceObj['friendly_id'] );
	}

	protected function getAltVideoId() {
		if ( !empty($this->interfaceObj['short_url']) ) {
			$embedUrlParts = explode( '/', $this->interfaceObj['short_url'] );
			return array_pop( $embedUrlParts );
		}

		return '';
	}

	protected function getVideoCategory(){
		if ( !empty($this->interfaceObj['channel_friendly_name']) ) {
			 return $this->interfaceObj['channel_friendly_name'];
		}

		return '';
	}

	protected function getVideoName() {
		if ( !empty($this->interfaceObj['event_episode_title']) ) {
			 return $this->interfaceObj['event_episode_title'];
		}

		return '';
	}

	protected function getVideoDuration() {
		return (int) $this->interfaceObj['duration'];
	}

	protected function getVideoPublished() {
		if ( !empty($this->interfaceObj['created_at']) ) {
			return $this->interfaceObj['created_at'];
		}

		return '';
	}

	protected function getVideoKeywords() {
		if ( !empty($this->interfaceObj['tags']) ) {
			$tags = array();
			foreach( $this->interfaceObj['tags'] as $tag ) {
				$tags[] = $tag['tag'];
			}
			return implode( ', ', $tags );
		}

		return '';
	}

	protected function getUniqueName() {
		if ( !empty($this->interfaceObj['friendly_id']) ) {
			return $this->interfaceObj['friendly_id'];
		}

		return '';
	}

	protected function getApiUrl() {
		$apiUrl = str_replace( '$1', $this->getEventIdFromVideoId(), static::$API_URL );
		return $apiUrl;
	}

	protected function getInterfaceObjectFromType( $type ) {
		wfProfileIn( __METHOD__ );

		$apiUrl = $this->getApiUrl();

		if ( empty($this->videoId) ){
			wfProfileOut( __METHOD__ );
			throw new EmptyResponseException( $apiUrl );
		}

		// use video id for memcache key
		$memcKey = wfMemcKey( static::$CACHE_KEY, $this->videoId, static::$CACHE_KEY_VERSION );
		$processedResponse = F::app()->wg->memc->get( $memcKey );
		if ( empty( $processedResponse ) ) {
			$req = MWHttpRequest::factory( $apiUrl );
			$status = $req->execute();
			if( $status->isOK() ) {
				$response = $req->getContent();
				$this->response = $response;	// Only for migration purposes
				if ( empty( $response ) ) {
					wfProfileOut( __METHOD__ );
					throw new EmptyResponseException( $apiUrl );
				} else {
					$processedResponse = $this->processResponse( $response, $type );
					F::app()->wg->memc->set( $memcKey, $processedResponse, static::$CACHE_EXPIRY );
				}
			} else {
				$this->checkForResponseErrors( $req->status, $req->getContent(), $apiUrl );
			}
		}

		wfProfileOut( __METHOD__ );

		return $processedResponse;
	}

	protected function processResponse( $response, $type ){
		wfProfileIn( __METHOD__ );

		$result = '';
		$return = json_decode( $response, true );
		if ( !empty($return['tracks']['0']) ) {
			foreach( $return['tracks']['0'] as $video ) {
				if ( array_key_exists('id', $video) && $video['id'] == $this->videoId ) {
					$result = $video;
					break;
				}
			}
		}

		wfProfileOut( __METHOD__ );

		return $this->postProcess( $result );
	}

	protected function loadMetadata( array $overrideFields = array() ) {
		parent::loadMetadata( $overrideFields );

		if ( $this->isAgeGate() ) {
			throw new WikiaException( wfMessage("videohandler-error-restricted-video")->text() );
		}

		if ( !isset( $this->metadata['uniqueName'] ) ) {
			$this->metadata['uniqueName'] = $this->getUniqueName();
		}
	}

	public static function getRedirectUrl( $url ) {
		wfProfileIn( __METHOD__ );

		$app = F::app();
		$memcKey = wfmemcKey( static::$CACHE_KEY, md5($url), static::$CACHE_KEY_VERSION );
		$redirectUrl = $app->wg->memc->get( $memcKey );
		if ( empty($redirectUrl) ) {
			$req = MWHttpRequest::factory( $url );
			$status = $req->execute();
			if( $status->isOK() ) {
				$response = $req->getContent();
				if ( !empty( $response ) ) {
					if ( preg_match('/<a href="(.+)">/', $response, $matches) ) {
						$redirectUrl = trim( $matches[1] );
						$app->wg->memc->set( $memcKey, $redirectUrl, static::$CACHE_EXPIRY );
					}
				}
			}
		}

		wfProfileOut( __METHOD__ );

		return $redirectUrl;
	}

	public static function getInfoFromHtml( $url ) {
		wfProfileIn( __METHOD__ );

		$info = array();
		$url = self::getRedirectUrl( $url );
		$req = MWHttpRequest::factory( $url );
		$status = $req->execute();
		if( $status->isOK() ) {
			$response = $req->getContent();
			if ( !empty( $response ) ) {
				if ( preg_match('/"id":(\d+),/', $response, $matches) ) {
					$info['videoId'] = trim( $matches[1] );
				}

				if ( preg_match('/"event_id":(\d+),/', $response, $matches) ) {
					$info['eventId'] = trim( $matches[1] );
				}
			}
		}

		wfProfileOut( __METHOD__ );

		return $info;
	}

	protected function getEventIdFromVideoId() {
		$videoId = explode( '_', $this->videoId );
		return array_pop( $videoId );
	}

}