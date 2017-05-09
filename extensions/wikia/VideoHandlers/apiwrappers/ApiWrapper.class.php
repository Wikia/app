<?php
abstract class ApiWrapper {

	const RESPONSE_FORMAT_JSON = 0;
	const RESPONSE_FORMAT_XML = 1;
	const RESPONSE_FORMAT_PHP = 2;

	protected static $aspectRatio = 1.7777778;

	protected $videoId;
	protected $metadata;
	protected $interfaceObj = null;
	protected $videoName = '';

	protected static $API_URL;
	protected static $CACHE_KEY;
	protected static $CACHE_KEY_VERSION = 0.1;
	protected static $CACHE_EXPIRY = 86400;
	protected static $RESPONSE_FORMAT = self::RESPONSE_FORMAT_JSON;

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
	 *
	 * @param string $videoId
	 * @param array $overrideMetadata one or more metadata fields that override API response
	 * In this case, metadata is passed through constructor, so $orverrideMetadata should be set.
	 */
	public function __construct( $videoId, $overrideMetadata = array() ) {

		wfProfileIn( __METHOD__ );

		$this->videoId = $this->sanitizeVideoId( $videoId );

		if ( !is_array( $overrideMetadata ) ) {
			$overrideMetadata = array();
		}

		if ( empty($overrideMetadata) ) {
			$this->initializeInterfaceObject();
		} else {
			if( isset($overrideMetadata['destinationTitle']) ) {
				$this->videoName = $overrideMetadata['destinationTitle'];
				// make sure that this field is not saved in the metadata
				unset( $overrideMetadata['destinationTitle'] );
			} else {
				// this if just a fallback, shouldn't happen
				$this->videoName = $this->getProvider() . '-' . $videoId;
			}
		}

		$this->loadMetadata( $overrideMetadata );
		wfProfileOut( __METHOD__ );
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

	public function isIngestion() {
		return false;
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

		wfProfileIn( __METHOD__ );
		switch ( static::$RESPONSE_FORMAT ){
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
				$return = unserialize( $response, [ 'allowed_classes' => false ] );
			break;
			default: throw new UnsuportedTypeSpecifiedException();
		}

		wfProfileOut( __METHOD__ );

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

	protected function loadMetadata(array $overrideFields=array()) {

		wfProfileIn( __METHOD__ );

		$metadata = $overrideFields;	// $overrideFields may have more fields
						// than the standard ones, listed below.
						// This is ok.
		$this->metadata = $metadata;	// must do this to facilitate getters below
						// $this->metadata will be reset at end of this function

		if ( !isset($metadata['videoId']) ) {
			$metadata['videoId'] = $this->videoId;
		}
		// for providers that use diffrent video id for embeded code
		if ( !isset($metadata['altVideoId']) ) {
			$metadata['altVideoId'] = $this->getAltVideoId();
		}
		if ( !isset($metadata['hd']) ) {
			$metadata['hd'] = $this->isHdAvailable();
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
		if ( !isset( $metadata['name'] ) ) {
			$metadata['name'] = $this->getVideoName();
		}
		if ( !isset( $metadata['type'] ) ) {
			$metadata['type'] = $this->getVideoType();
		}
		if ( !isset($metadata['category']) ) {
			$metadata['category'] = $this->getVideoCategory();
		}
		if ( !isset($metadata['keywords']) ) {
			$metadata['keywords'] = $this->getVideoKeywords();
		}
		if ( !isset($metadata['industryRating']) ) {
			$metadata['industryRating'] = $this->getIndustryRating();
		}
		if ( !isset($metadata['ageGate']) ) {
			$metadata['ageGate'] = $this->isAgeGate();
		}
		if ( !isset( $metadata['ageRequired'] ) ) {
			$metadata['ageRequired'] = $this->getAgeRequired();
		}
		if ( !isset($metadata['provider']) ) {
			$metadata['provider'] = $this->getProvider();
		}
		if ( !isset($metadata['language']) ) {
			$metadata['language'] = $this->getLanguage();
		}
		if ( !isset( $metadata['subtitle'] ) ) {
			$metadata['subtitle'] = $this->getSubtitle();
		}
		if ( !isset( $metadata['genres'] ) ) {
			$metadata['genres'] = $this->getGenres();
		}
		if ( !isset( $metadata['actors'] ) ) {
			$metadata['actors'] = $this->getActors();
		}
		if ( !isset( $metadata['targetCountry'] ) ) {
			$metadata['targetCountry'] = $this->getTargetCountry();
		}
		if ( !isset( $metadata['series'] ) ) {
			$metadata['series'] = $this->getSeries();
		}
		if ( !isset( $metadata['season'] ) ) {
			$metadata['season'] = $this->getSeason();
		}
		if ( !isset( $metadata['episode'] ) ) {
			$metadata['episode'] = $this->getEpisode();
		}
		if ( !isset( $metadata['characters'] ) ) {
			$metadata['characters'] = $this->getCharacters();
		}
		if ( !isset( $metadata['resolution'] ) ) {
			$metadata['resolution'] = $this->getResolution();
		}
		// set to default if empty
		if ( empty( $metadata['aspectRatio'] ) ) {
			$metadata['aspectRatio'] = $this->getAspectRatio();
		}
		if ( empty( $metadata['expirationDate'] ) ) {
			$metadata['expirationDate'] = $this->getVideoExpirationDate();
		}
		if ( empty( $metadata['regionalRestrictions'] ) ) {
			$metadata['regionalRestrictions'] = $this->getRegionalRestrictions();
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

	protected function isHdAvailable(){
		return false;
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

	protected function getAltVideoId() {
		return '';
	}

	/**
	 * Rating from industry board. (include MPAA trailer)
	 * Examples MPAA trailer rating (e.g. "greenband", "redband")
	 * Examples from MPAA: R, PG-13
	 * Examples from ESRB: E, T, AO
	 * @return string
	 */
	protected function getIndustryRating() {
		return '';
	}

	/**
	 * Is clip age-gated?
	 * @return boolean
	 */
	protected function isAgeGate() {
		return false;
	}

	/**
	 * Get age required
	 * @return integer
	 */
	protected function getAgeRequired() {
		return 0;
	}

	/**
	 * Get language
	 * @return string
	 */
	protected function getLanguage() {
		return '';
	}

	/**
	 * Get subtitle
	 * @return string
	 */
	protected function getSubtitle() {
		return '';
	}

	/**
	 * Get genres
	 * @return string
	 */
	protected function getGenres() {
		return '';
	}

	/**
	 * Get actors
	 * @return string
	 */
	protected function getActors() {
		return '';
	}

	/**
	 * Get expiration date
	 * @return string
	 */
	protected function getVideoExpirationDate() {
		return '';
	}

	/**
	 * Get regional restrictions
	 * @return string
	 */
	protected function getRegionalRestrictions() {
		return '';
	}

	/**
	 * Get target country
	 * @return string
	 */
	protected function getTargetCountry() {
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
	 * Get season
	 * @return string
	 */
	protected function getSeason() {
		return '';
	}

	/**
	 * Get episode
	 * @return string
	 */
	protected function getEpisode() {
		return '';
	}

	/**
	 * Get resolution
	 * @return string
	 */
	protected function getResolution() {
		return '';
	}

	/**
	 * Get characters
	 * @return string
	 */
	protected function getCharacters() {
		return '';
	}

	/**
	 * Get video type
	 * @return string
	 */
	protected function getVideoType() {
		return '';
	}

	/**
	 * Get video name
	 * @return string
	 */
	protected function getVideoName() {
		return '';
	}

	/**
	 * Check if valid permisions
	 * @return boolean
	 */
	protected static function isAllowed() {
		$user = F::app()->wg->User;
		if ( !$user->isLoggedIn() ) {
			return false;
		}

		if ( !$user->isAllowed( 'uploadpremiumvideo' ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Get content for the url
	 * @param string $url
	 * @return mixed
	 */
	protected static function getUrlContent( $url ) {
		wfProfileIn( __METHOD__ );

		$req = MWHttpRequest::factory( $url, [ 'noProxy' => true ] );
		$status = $req->execute();
		if ( $status->isGood() ) {
			$result = json_decode( $req->getContent(), true );
		} else {
			$result = false;
			print( "ERROR: problem downloading content (".$status->getMessage().").\n" );
		}

		wfProfileOut( __METHOD__ );

		return $result;
	}
}

class EmptyResponseException extends Exception {
	public function __construct( $apiUrl ) {
		$this->apiUrl = $apiUrl;
		$this->message = "Empty response from URL '".$apiUrl."'";
	}
}
class NegativeResponseException extends Exception {
	public function __construct( $status, $content, $apiUrl ) {
		$this->status = $status;
		$this->content = $content;
		$this->apiUrl = $apiUrl;
		$this->errors = $status->errors;

		$message = "Negative response from URL '".$apiUrl."'";

		// Add the error message if there is one
		if ( !empty( $this->errors ) && ( count( $this->errors ) > 0 ) ) {
			$firstError = $this->errors[0];
			if ( !empty( $firstError['message'] ) ) {
				$message .= ' - '.$firstError['message'];
			}
		}

		$this->message = $message;

		Wikia\Logger\WikiaLogger::instance()->error(
			__CLASS__,
			[ 'ooyala_response' => [
				'status' => $this->status,
				'content' => $this->content,
				'apiUrl' => $this->apiUrl,
				'errors' => $this->errors
			] ]
		);

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
 * Class used by feed ingestion (does not connect, just initializes data)
 */
abstract class IngestionApiWrapper extends PseudoApiWrapper {

	protected $videoName;

	public function __construct( $videoId, array $overrideMetadata=array() ) {
		wfProfileIn( __METHOD__ );

		if (!is_array($overrideMetadata)) {
			$overrideMetadata = array();
		}

		$this->videoId = $this->sanitizeVideoId( $videoId );
		if(isset($overrideMetadata['destinationTitle'])) {
			$this->videoName = $overrideMetadata['destinationTitle'];
			// make sure that this field is not saved in the metadata
			unset($overrideMetadata['destinationTitle']);
		} else {
			// this if just a fallback, shouldn't happen
			$this->videoName = $this->getProvider() . '-' . $videoId;
		}
		$this->loadMetadata($overrideMetadata);

		wfProfileOut( __METHOD__ );
	}

	protected function getVideoTitle() {
		return $this->videoName;
	}

	public function isIngestion() {
		return true;
	}

	/**
	 * Get video published
	 * @return string
	 */
	protected function getVideoPublished(){
		return $this->getMetaValue( 'published' );
	}

	/**
	 * Get category
	 * @return string
	 */
	protected function getVideoCategory() {
		return $this->getMetaValue( 'category' );
	}

	/**
	 * Get description
	 * @return string
	 */
	protected function getOriginalDescription() {
		return $this->getMetaValue( 'description' );
	}

	/**
	 * Is hd video
	 * @return boolean
	 */
	protected function isHdAvailable() {
		$hd = $this->getMetaValue( 'hd', false );
		return empty( $hd ) ? false : true;
	}

	/**
	 * List of keywords, separated by comma
	 * @return string
	 */
	protected function getVideoKeywords() {
		return $this->getMetaValue( 'keywords' );
	}

	/**
	 * Get duration
	 * @return string
	 */
	protected function getVideoDuration() {
		return $this->getMetaValue( 'duration' );
	}

	/**
	 * Get altVideoId
	 * @return string
	 */
	protected function getAltVideoId() {
		return $this->getMetaValue( 'altVideoId' );
	}

	/**
	 * Rating from industry board. (include MPAA trailer)
	 * Examples MPAA trailer rating (e.g. "greenband", "redband")
	 * Examples from MPAA: R, PG-13
	 * Examples from ESRB: E, T, AO
	 * @return string
	 */
	protected function getIndustryRating() {
		return $this->getMetaValue( 'industryRating' );
	}

	/**
	 * Is video age gated?
	 * @return boolean
	 */
	protected function isAgeGate() {
		$ageGate = $this->getMetaValue( 'ageGate', false );
		return empty( $ageGate ) ? false : true;
	}

	/**
	 * Get age required
	 * @return integer
	 */
	protected function getAgeRequired() {
		return $this->getMetaValue( 'ageRequired', 0 );
	}

	/**
	 * Get language
	 * @return string
	 */
	protected function getLanguage() {
		return $this->getMetaValue( 'language' );
	}

	/**
	 * Get subtitle
	 * @return string
	 */
	protected function getSubtitle() {
		return $this->getMetaValue( 'subtitle' );
	}

	/**
	 * Get genres
	 * @return string
	 */
	protected function getGenres() {
		return $this->getMetaValue( 'genres' );
	}

	/*
	 * Get actors
	 * @return string
	 */
	protected function getActors() {
		return $this->getMetaValue( 'actors' );
	}

	/**
	 * Get expiration date
	 * @return string
	 */
	protected function getVideoExpirationDate() {
		return $this->getMetaValue( 'expirationDate' );
	}

	/**
	 * Get regional restrictions
	 * @return string
	 */
	protected function getRegionalRestrictions() {
		return $this->getMetaValue( 'regionalRestrictions' );
	}

	/**
	 * Get target country
	 * @return string
	 */
	protected function getTargetCountry() {
		return $this->getMetaValue( 'targetCountry' );
	}

	/**
	 * Get series
	 * @return string
	 */
	protected function getSeries() {
		return $this->getMetaValue( 'series' );
	}

	/**
	 * Get season
	 * @return string
	 */
	protected function getSeason() {
		return $this->getMetaValue( 'season' );
	}

	/**
	 * Get episode
	 * @return string
	 */
	protected function getEpisode() {
		return $this->getMetaValue( 'episode' );
	}

	/**
	 * Get resolution
	 * @return string
	 */
	protected function getResolution() {
		return $this->getMetaValue( 'resolution' );
	}

	/**
	 * Get characters
	 * @return string
	 */
	protected function getCharacters() {
		return $this->getMetaValue( 'characters' );
	}

	/**
	 * Get video type
	 * @return string
	 */
	protected function getVideoType() {
		return $this->getMetaValue( 'type' );
	}

	/**
	 * Get video name
	 * @return string
	 */
	protected function getVideoName() {
		return $this->getMetaValue( 'name' );
	}

}

/**
 * ApiWrapper for a video provider that has no API. This class does not attempt
 * to connect to any API.
 *
 * those are only used by video migration scripts and serve no other purpose
 */
abstract class LegacyVideoApiWrapper extends PseudoApiWrapper {
	//@todo change this url
	static $THUMBNAIL_URL = 'http://community.wikia.com/extensions/wikia/VideoHandlers/images/NoThumbnailBg.png';

	public function __construct($videoId, array $overrideMetadata=array()) {

		wfProfileIn( __METHOD__ );

		$this->videoId = $this->sanitizeVideoId( $videoId );
		if (!is_array($overrideMetadata)) {
			$overrideMetadata = array();
		}
		$this->loadMetadata($overrideMetadata);

		wfProfileOut( __METHOD__ );
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
		return self::$THUMBNAIL_URL;
	}

}
