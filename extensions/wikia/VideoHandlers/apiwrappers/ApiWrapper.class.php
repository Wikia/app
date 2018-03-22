<?php
abstract class ApiWrapper {

	protected static $aspectRatio = 1.7777778;

	protected $videoId;
	protected $metadata;
	protected $interfaceObj = null;
	protected $videoName = '';

	protected static $API_URL;
	protected static $CACHE_KEY;
	protected static $CACHE_KEY_VERSION = 0.1;
	protected static $CACHE_EXPIRY = 86400;

	/**
	 * Get appropriate ApiWrapper for the given URL
	 * @param string $url url without opening "http://"
	 * @return mixed ApiWrapper or null
	 */
	public static function newFromUrl( $url ) {
		// if $url is from this provider, return object
		return null;
	}

	/**
	 * Does hostname match a URL from this video provider
	 * @param string $hostname in lower case
	 * @return boolean
	 */
	public static function isMatchingHostname( $hostname ) {
		return false;
	}

	/**
	 * @param string $videoId
	 */
	public function __construct( $videoId ) {
		$this->videoId = $this->sanitizeVideoId( $videoId );

		$this->initializeInterfaceObject();

		$this->loadMetadata();
	}

	/**
	 *
	 * @return string
	 */
	public function getTitle() {
		if ( !empty( $this->metadata['title'] ) ) {
			return $this->metadata['title'];
		}
		return $this->getVideoTitle();
	}

	abstract protected function getVideoTitle();

	abstract public function getDescription();

	abstract public function getThumbnailUrl();

	public function getProvider() {
		return strtolower(str_replace('ApiWrapper', '', get_class($this)));
	}

	public function getMimeType() {
		return 'video/'.strtolower( $this->getProvider() );
	}

	public function getVideoId() {
		if (!$this->videoId) {
			if (isset($this->metadata['videoId'])) {
				$this->videoId = $this->metadata['videoId'];
			}
		}

		return $this->videoId;
	}

	public function videoExists() {
		return true;
	}

	public function getNonemptyMetadata() {
		$meta = $this->getMetadata();
		// get rid of empty fields - no need to store them in db
		foreach( $meta as $k => $v) {
			if($v === '') {
				unset($meta[$k]);
			}
		}
		return $meta;
	}

	protected function postProcess( $return ){
		return $return;
	}

	protected function sanitizeVideoId( $videoId ) {
		return $videoId;
	}

	protected function initializeInterfaceObject() {
		$this->interfaceObj = $this->getInterfaceObjectFromType();
	}

	protected function getInterfaceObjectFromType() {

		wfProfileIn( __METHOD__ );

		$apiUrl = $this->getApiUrl();
		// use URL's hash to avoid going beyond 250 characters limit of memcache key
		$memcKey = wfMemcKey( static::$CACHE_KEY, md5($apiUrl), static::$CACHE_KEY_VERSION );
		if ( empty($this->videoId) ){
			wfProfileOut( __METHOD__ );
			throw new EmptyResponseException($apiUrl);
		}
		$response = F::app()->wg->memc->get( $memcKey );
		$cacheMe = false;
		if ( empty( $response ) ){
			$cacheMe = true;
			$req = MWHttpRequest::factory( $apiUrl, array( 'noProxy' => true ) );
			$status = $req->execute();
			if( $status->isOK() ) {
				$response = $req->getContent();
				$this->response = $response;	// Only for migration purposes
				if ( empty( $response ) ) {
					wfProfileOut( __METHOD__ );
					throw new EmptyResponseException($apiUrl);
				}
			} else {
				$this->checkForResponseErrors( $req->status, $req->getContent(), $apiUrl );
			}
		}
		$processedResponse = $this->processResponse( $response );
		if ( $cacheMe ) F::app()->wg->memc->set( $memcKey, $response, static::$CACHE_EXPIRY );
		wfProfileOut( __METHOD__ );
		return $processedResponse;
	}

	protected function getApiUrl() {
		$apiUrl = str_replace( '$1', $this->videoId, static::$API_URL );
		return $apiUrl;
	}

	protected function checkForResponseErrors( $status, $content, $apiUrl ){
		if (is_array($status->errors)) {
			foreach ($status->errors as $error) {
				if (!empty($error['params']) && is_array($error['params'])) {
					switch ($error['params'][0]) {
						case '403':
							throw new VideoIsPrivateException($status, $content, $apiUrl);
							break;
						case '404':
							throw new VideoNotFoundException($status, $content, $apiUrl);
							break;
						default:
					}
				}
			}
		}

		throw new NegativeResponseException( $status, $content, $apiUrl );
	}

	protected function processResponse( $response ){
		$return = json_decode( $response, true );
		return $this->postProcess( $return );
	}

	protected function videoNotFound(){
		throw new VideoNotFound();
	}

	// metadata
	public function getMetadata() {
		if (empty($this->metadata)) {
			$this->loadMetadata();
		}

		return $this->metadata;
	}

	protected function loadMetadata() {

		wfProfileIn( __METHOD__ );

		$metadata = [];
		$this->metadata = $metadata;	// must do this to facilitate getters below
						// $this->metadata will be reset at end of this function

		if ( !isset($metadata['videoId']) ) {
			$metadata['videoId'] = $this->videoId;
		}

		if ( !isset($metadata['duration']) ) {
			$metadata['duration'] = $this->getVideoDuration();
		}
		if ( !isset($metadata['published']) ) {
			$metadata['published'] = $this->getVideoPublished();
		}
		if ( !isset($metadata['description']) ) {
			$metadata['description'] = $this->getOriginalDescription();
		}

		if ( !isset($metadata['category']) ) {
			$metadata['category'] = $this->getVideoCategory();
		}
		if ( !isset($metadata['keywords']) ) {
			$metadata['keywords'] = $this->getVideoKeywords();
		}

		if ( !isset($metadata['provider']) ) {
			$metadata['provider'] = $this->getProvider();
		}
		if ( !isset($metadata['language']) ) {
			$metadata['language'] = $this->getLanguage();
		}

		if ( !isset( $metadata['series'] ) ) {
			$metadata['series'] = $this->getSeries();
		}

		if ( !isset( $metadata['characters'] ) ) {
			$metadata['characters'] = $this->getCharacters();
		}

		// set to default if empty
		if ( empty( $metadata['aspectRatio'] ) ) {
			$metadata['aspectRatio'] = $this->getAspectRatio();
		}

		if ( !isset($metadata['title']) ) {
			$metadata['title'] = $this->getTitle();
		}
		if ( !isset($metadata['canEmbed']) ) {
			$metadata['canEmbed'] = $this->canEmbed();
		}

		$this->metadata = $metadata;

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Get metadata value
	 * @param string $name
	 * @param string $defaultValue
	 * @return type
	 */
	protected function getMetaValue( $name, $defaultValue = '' ) {
		if ( !empty( $this->metadata[$name] ) ) {
			return $this->metadata[$name];
		}

		return $defaultValue;
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

	/**
	 * List of keywords, separated by comma
	 * @return string
	 */
	protected function getVideoKeywords(){
		return '';
	}

	protected function getVideoDuration(){
		return '';
	}

	public function getAspectRatio(){
		return static::$aspectRatio;
	}

	/**
	 * Get language
	 * @return string
	 */
	protected function getLanguage() {
		return '';
	}

	/**
	 * Get series
	 * @return string
	 */
	protected function getSeries() {
		return '';
	}

	/**
	 * Get characters
	 * @return string
	 */
	protected function getCharacters() {
		return '';
	}
}

class EmptyResponseException extends Exception {
	public function __construct( $apiUrl ) {
		$this->apiUrl = $apiUrl;
		$this->message = "Empty response from URL '".$apiUrl."'";
	}
}
class NegativeResponseException extends Exception {
	/**
	 * NegativeResponseException constructor.
	 * @param \Status $status
	 * @param int $content
	 * @param Exception $apiUrl
	 */
	public function __construct( $status, $content, $apiUrl ) {
		$this->status = $status;
		$this->content = $content;
		$this->apiUrl = $apiUrl;
		$this->errors = $status instanceof \Status ? $status->errors : [];

		$message = 'Negative response from URL';

		// Add the error message if there is one
		if ( !empty( $this->errors ) && ( count( $this->errors ) > 0 ) ) {
			$firstError = $this->errors[0];
			if ( !empty( $firstError['message'] ) ) {
				$message .= ' - '.$firstError['message'];
			}
		}

		$this->message = $message;
	}

	/**
	 * Returns the http status code of the first error
	 * @return null|int
	 */
	public function getStatusCode() {

		$statusCode = null;
		if ( is_array( $this->errors) ) {
			$statusCode = $this->errors[0]['params'][0];
		}

		return $statusCode;
	}
}
class VideoIsPrivateException extends NegativeResponseException {}
class VideoNotFoundException extends NegativeResponseException {}
class VideoQuotaExceededException extends NegativeResponseException {}
class VideoWrongApiCall extends NegativeResponseException {}

class UnsuportedTypeSpecifiedException extends Exception {}
class VideoNotFound extends Exception {}

/**
 * A class that doesn't connect to a video provider's API, but implements
 * ApiWrapper's abstract functions nonetheless. Child classes of PseudoApiWrapper
 * might connect to a database instead of an API.
 */
abstract class PseudoApiWrapper extends ApiWrapper {

	protected function getInterfaceObjectFromType() {
		// override me!
	}

	protected function processResponse( $response ) {
		// override me!
	}

}

/**
 * ApiWrapper for a video provider that has no API. This class does not attempt
 * to connect to any API.
 *
 * those are only used by video migration scripts and serve no other purpose
 */
abstract class LegacyVideoApiWrapper extends PseudoApiWrapper {
	static $THUMBNAIL_PATH = '/extensions/wikia/VideoHandlers/images/NoThumbnailBg.png';

	public function __construct($videoId) {
		$this->videoId = $this->sanitizeVideoId( $videoId );
		$this->loadMetadata();
	}

	protected function getVideoTitle() {
		$classname = get_class($this);
		$provider = substr($classname, 0, strlen($classname)-strlen('ApiWrapper'));
		return wfMsg('videohandler-unknown-title') . " ($provider $this->videoId)";
	}

	public function getDescription() {
		return '';
	}

	public function getThumbnailUrl() {
		return self::getLegacyThumbnailUrl();
	}

	public static function getLegacyThumbnailUrl() {
		global $wgResourceBasePath;
		return $wgResourceBasePath . self::$THUMBNAIL_PATH;
	}

}
