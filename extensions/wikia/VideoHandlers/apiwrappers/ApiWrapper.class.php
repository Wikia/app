<?php

abstract class ApiWrapper {

	const RESPONSE_FORMAT_JSON = 0;
	const RESPONSE_FORMAT_XML = 1;
	const RESPONSE_FORMAT_PHP = 2;

	protected $videoId;
	protected $videoName;
	protected $interfaceObj = null;

	protected static $API_URL;
	protected static $CACHE_KEY;
	protected static $CACHE_KEY_VERSION = 0.1;
	protected static $CACHE_EXPIRY = 86400;
	protected static $RESPONSE_FORMAT = self::RESPONSE_FORMAT_JSON;
	
	public function __construct( $videoId, $params=array() ) {
		$this->videoId = $this->sanitizeVideoId( $videoId );
		if (!empty($params['videoName'])) {
			$this->videoName = $params['videoName'];
		}
		$this->initializeInterfaceObject();
	}

	public function getTitle() {
		if (!empty($this->videoName)) {
			return $this->videoName;
		}
		
		return $this->getVideoTitle();
	}
	
	abstract protected function getVideoTitle();
	
	abstract public function getDescription();
	
	abstract public function getThumbnailUrl();
	
	public function getVideoId() {
		return $this->videoId;
	}

	protected function postProcess( $return ){
		return $return;
	}
	
	protected function sanitizeVideoId( $videoId ) {
		return $videoId;
	}

	protected function initializeInterfaceObject(){
		$this->interfaceObj = $this->getInterfaceObjectFromType( static::$RESPONSE_FORMAT );
	}

	protected function getInterfaceObjectFromType( $type ) {

		$apiUrl = $this->getApiUrl();
		$memcKey = F::app()->wf->memcKey( static::$CACHE_KEY, static::$CACHE_KEY_VERSION, $apiUrl );
		if ( empty($this->videoId) ){
			throw new EmptyResponseException($apiUrl);
		}
		$response = F::app()->wg->memc->get( $memcKey );
		$cacheMe = false;
		if ( empty( $response ) ){
			$cacheMe = true;
			$req = HttpRequest::factory( $apiUrl );
			$status = $req->execute();
			if( $status->isOK() ) {
				$response = $req->getContent();
				$this->response = $response;	// Only for migration purposes
				if ( empty( $response ) ) {
					throw new EmptyResponseException($apiUrl);
				} else {
					
				}
			} else {
				$this->checkForResponseErrors( $req->status, $req->getContent(), $apiUrl );
			}
		}
		$processedResponse = $this->processResponse( $response, $type );
		if ( $cacheMe ) F::app()->wg->memc->set( $memcKey, $response, static::$CACHE_EXPIRY );
		return $processedResponse;
	}
	
	protected function getApiUrl() {
		$apiUrl = str_replace( '$1', $this->videoId, static::$API_URL );
		return $apiUrl;
	}

	protected function checkForResponseErrors( $status, $content, $apiUrl ){
		throw new NegativeResponseException( $status, $content, $apiUrl );
	}

	protected function processResponse( $response, $type ){
		$return = '';
		switch ( $type ){
			case self::RESPONSE_FORMAT_JSON :
				 $return = json_decode( $response, true );
			break;
			case self::RESPONSE_FORMAT_XML :
				$sp = new SimplePie();
				$sp->set_raw_data( $response );
				$sp->init();
				if ( $sp->error() ) {
					$return = $sp->data;
				} else {
					$oItem = $sp->get_item();
					if ( empty( $oItem ) ) $this->videoNotFound();
					$return = get_object_vars( $oItem->get_enclosure() );
				}
			break;
			case self::RESPONSE_FORMAT_PHP :
				$return = unserialize( $response );
			break;
			default: throw new UnsuportedTypeSpecifiedException();
		}
		
		return $this->postProcess( $return );
	}

	protected function videoNotFound(){
		throw new VideoNotFound();
	}

	// metadata
	public function getMetadata() {
		$metadata = array();

		$metadata['videoId']		= $this->videoId;
		
		// TODO: make common format for published timestamp
		$metadata['published']		= $this->getVideoPublished();
		$metadata['category']		= $this->getVideoCategory();
		$metadata['canEmbed']		= $this->canEmbed();
		$metadata['hd']			= $this->isHdAvailable();
		$metadata['keywords']		= $this->getVideoKeywords();
		$metadata['duration']		= $this->getVideoDuration();
		$metadata['aspectRatio']	= $this->getAspectRatio();
		$metadata['description']	= $this->getOriginalDescription();
	
        // for providers that use diffrent video id for embeded code
        $metadata['altVideoId']      = $this->getAltVideoId();

		return $metadata;
	}


	protected function getVideoPublished(){
		return '';
	}

	protected function getVideoCategory(){
		return '';
	}

	protected function canEmbed(){
		return true;
	}

	protected function getOriginalDescription(){
		return '';
	}

	protected function isHdAvailable(){
		return false;
	}

	protected function getVideoKeywords(){
		return '';
	}

	protected function getVideoDuration(){
		return '';
	}

	protected function getAspectRatio(){
		return '';
	}

	protected function getAltVideoId() {
		return '';
	}
}

class EmptyResponseException extends Exception {
	public function __construct( $apiUrl ) {
		$this->apiUrl = $apiUrl;
	}
}
class NegativeResponseException extends Exception {
	public function __construct( $status, $content, $apiUrl ) {
		$this->status = $status;
		$this->content = $content;
		$this->apiUrl = $apiUrl;
	}
}
class VideoIsPrivateException extends NegativeResponseException {}
class VideoNotFoundException extends NegativeResponseException {}
class VideoQuotaExceededException extends NegativeResponseException {}

class UnsuportedTypeSpecifiedException extends Exception {}
class VideoNotFound extends Exception {}

/**
 * A class that doesn't connect to a video provider's API, but implements
 * ApiWrapper's abstract functions nonetheless. Child classes of PseudoApiWrapper
 * might connect to a database instead of an API.
 */
abstract class PseudoApiWrapper extends ApiWrapper {
	
	protected function getInterfaceObjectFromType( $type ) {
		// override me!
	}
	
	protected function processResponse( $response, $type ) {
		// override me!
	}
}

abstract class WikiaVideoApiWrapper extends PseudoApiWrapper {
	
	protected $videoName;
	protected $provider;
	
	public function __construct( $videoName, $params=array() ) {
		$this->videoName = $videoName;
		$this->initializeInterfaceObject();
	}
	
	protected function getInterfaceObjectFromType( $type ) {
		$title = Title::newFromText($this->videoName, NS_VIDEO);
		$videoPage = new VideoPage($title);
		$videoPage->load();
		$this->videoId = $videoPage->getVideoId();
		$this->provider = $videoPage->getProvider();
		$response = $videoPage->getData();
		$this->response = $response;	// only for migration purposes
		if ( empty( $response ) ) {
			throw new EmptyResponseException();
		} else {

		}
		return $response;
	}
}
