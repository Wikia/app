<?php

class GamestarApiWrapper extends ApiWrapper {

	protected static $API_URL = 'http://www.gamestar.de/index.cfm?pid=1589&pk=$1';
	protected static $CACHE_KEY = 'gamestarapi';
	protected static $CACHE_KEY_VERSION = 0.2;
	protected static $aspectRatio = 1.7777778;
	protected static $REQUEST_USER_AGENT = '';

	public static function isMatchingHostname( $hostname ) {
		return endsWith( $hostname, "gamestar.de" ) ? true : false;
	}

	public static function newFromUrl( $url ) {
		wfProfileIn( __METHOD__ );

		$url = trim( $url, ".html" );
		$parsed = explode( "/", $url );
		if( is_array( $parsed ) ) {
			$last = explode( ",", array_pop( $parsed ), 2 );
			$videoId = array_pop( $last );
			if ( is_numeric( $videoId ) ) {
				wfProfileOut( __METHOD__ );

				return new static( $videoId );
			}
		}

		wfProfileOut( __METHOD__ );

		return null;
	}

	public function getDescription() {
		return $this->getOriginalDescription();
	}

	protected function getOriginalDescription() {
		return $this->interfaceObj['description'];
	}

	public function getThumbnailUrl() {
		return $this->interfaceObj['image'];
	}

	protected function getVideoTitle() {
		return $this->interfaceObj['title'];
	}

	protected function getInterfaceObjectFromType() {
		wfProfileIn( __METHOD__ );

		$apiUrl = $this->getApiUrl();
		if ( empty( $this->videoId ) ){
			throw new EmptyResponseException($apiUrl);
		}

		$memcKey = wfMemcKey( static::$CACHE_KEY, $apiUrl, static::$CACHE_KEY_VERSION );
		$processedResponse = F::app()->wg->memc->get( $memcKey );
		if ( empty( $processedResponse ) ) {
			$req = MWHttpRequest::factory( $apiUrl, array( 'noProxy' => true ) );
			$req->setHeader( 'User-Agent', self::$REQUEST_USER_AGENT );
			$status = $req->execute();
			if( $status->isOK() ) {
				$response = $req->getContent();
				$this->response = $response;	// Only for migration purposes
				if ( empty( $response ) ) {
					throw new EmptyResponseException($apiUrl);
				} else if ( $req->getStatus() == 301 ) {
					throw new VideoNotFoundException( $req->getStatus(), $this->videoId.' Moved Permanently.' , $apiUrl );
				}
			} else {
				$this->checkForResponseErrors( $req->status, $req->getContent(), $apiUrl );
			}

			$processedResponse = $this->processResponse( $response );
			F::app()->wg->memc->set( $memcKey, $processedResponse, static::$CACHE_EXPIRY );
		}

		wfProfileOut( __METHOD__ );

		return $processedResponse;
	}

	protected function processResponse( $response ) {
		wfProfileIn( __METHOD__ );

		$return = '';
		if ( preg_match( '/\<title\>(.*)\<\/title>/', $response, $matches ) ) {
			$title = trim( $matches[1] );
			$title = preg_replace( '/[vV]ideo [bB]ei [gG]ame[sS]tar.de$|[vV]ideo [oO]n [gG]ame[sS]tar.de$/', '', $title );
			$title = trim( $title, " -" );
			if ( !empty($title) ) {
				$return = array(
					'title' => $title,
					'description' => '',
					'image' => '',
				);

				// description
				if ( preg_match('/<meta name=[\'\"]description[\'\"] content=(.*)\/\>/', $response, $matches) ) {
					$return['description'] = trim( $matches[1], ' \'\"' );
				}

				// thumbnail url
				$thumbnail = $this->getThumbnail();
				if ( !empty( $thumbnail ) ) {
					$return['image'] = $thumbnail;
				}
			}
		}

		wfProfileOut( __METHOD__ );

		return $this->postProcess( $return );
	}

	public function getThumbnail() {
		wfProfileIn( __METHOD__ );

		$thumbnail = '';
		$url = 'http://www.gamestar.de/emb/getVideoData5.cfm?vid='.$this->videoId;
		$options = array(
			'noProxy' => true,
			'userAgent' => self::$REQUEST_USER_AGENT,
		);
		$response = Http::request( 'GET', $url, $options );
		if ( $response !== false ) {
			$response = trim( $response );
			if ( !empty( $response ) ) {
				$xml = @simplexml_load_string( $response );
				if ( isset( $xml->image ) ) {
					$thumbnail = (string) $xml->image;
				}
			}
		}

		wfProfileOut( __METHOD__ );

		return $thumbnail;
	}

}
