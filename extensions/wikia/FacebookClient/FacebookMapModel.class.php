<?php

use Wikia\Logger\WikiaLogger;

/**
 * Class FacebookMapModel
 *
 * This class models the mapping between a Wikia user ID and a Facebook user ID
 */
class FacebookMapModel {

	// Provide a way to clear all cached values when/if changing the caching logic
	const cacheKeyVersion = 2;

	const tableName = 'user_fbconnect';
	const columnWikiaUserId = 'user_id';
	const columnFacebookUserId = 'user_fbid';
	const columnFacebookAppId = 'user_fb_app_id';
	const columnFacebookBizToken = 'user_fb_biz_token';

	// Make these often used parameters are constants so they can be checked by the compiler
	const paramWikiaUserId = 'wikiaUserId';
	const paramFacebookUserId = 'facebookUserId';
	const paramUpdateTime = 'updateTime';
	const paramAppId = 'appId';
	const paramBizToken = 'bizToken';

	// Error codes related to user mapping
	const ERROR_FACEBOOK_USER_ID_MISMATCH = 1;
	const ERROR_WIKIA_USER_ID_MISMATCH = 2;

	// This is the App ID given to records created before we started collecting the App ID
	const APP_ID_DEFAULT_V1 = 0;
	// Same as APP_ID_DEFAULT_V1 except these records map a different Wikia ID to an already
	// mapped Facebook ID.  Of the pair, the older of the two is given this App ID
	const APP_ID_DUPLICATE_V1 = 1;

	protected $facebookUserId;
	protected $wikiaUserId;
	protected $lastUpdateTime;
	protected $facebookAppId;
	protected $facebookBizToken;

	/**
	 * Create a new FacebookMapModel object.  If $param is given then the FB and Wikia IDs must be given
	 *
	 * @param array $param Values for the mapping.  Keys are:
	 *
	 * - self::paramFacebookUserId - Required if $param is passed.  The Facebook user ID
	 * - self::paramWikiaUserId - Required is $param is passed.  The Wikia user ID
	 * - self::paramUpdateTime - The time this mapping was created.
	 *
	 * @throws FacebookMapModelInvalidParamException
	 */
	public function __construct( array $param = null ) {
		global $fbAppId;

		// If $param is set, both IDs must be passed
		if ( $param && !isset( $param[self::paramFacebookUserId], $param[self::paramWikiaUserId] ) ) {
			throw new FacebookMapModelInvalidParamException();
		}

		$this->facebookAppId = $fbAppId;
		$this->facebookUserId = $param[self::paramFacebookUserId];
		$this->wikiaUserId = $param[self::paramWikiaUserId];
		$this->facebookBizToken = '';

		if ( isset( $param[self::paramUpdateTime] ) ) {
			$this->lastUpdateTime = $param[ self::paramUpdateTime ];
		}
	}

	/**
	 * Create a new user mapping between a Wikia user account and a FB account
	 *
	 * @param int $wikiaUserId
	 * @param int $fbUserId
	 * @param string $bizToken
	 *
	 * @return FacebookMapModel|null Returns the mapping on success, null otherwise
	 */
	public static function createUserMapping( $wikiaUserId, $fbUserId, $bizToken = '' ) {
		$map = new self();
		$map->setBizToken( $bizToken );
		$map->relate( $wikiaUserId, $fbUserId );
		try {
			$map->save();
		} catch ( \FacebookMapModelException $e ) {
			return null;
		}

		return $map;
	}

	/**
	 * Lookup a mapping where the Wikia user ID is set to the given ID AND the FB App ID
	 * is the current $fbAppId or if not found, an App ID of 0.  If neither is found, no
	 * row is returned.
	 *
	 * @param int $wikiaUserId The Wikia user ID
	 *
	 * @return FacebookMapModel|null The mapping found
	 */
	public static function lookupFromWikiaID( $wikiaUserId ) {
		$map = self::loadWithCache( [ self::paramWikiaUserId => $wikiaUserId ] );

		return $map;
	}

	/**
	 * Find the mapping associated with the given Facebook user ID AND the FB App ID
	 * is the current $fbAppId or if not found, an App ID of 0.  If neither is found, no
	 * row is returned.
	 *
	 * @param int $facebookId
	 *
	 * @return FacebookMapModel|null
	 */
	public static function lookupFromFacebookID( $facebookId ) {
		$map = self::loadWithCache( [ self::paramFacebookUserId => $facebookId ] );

		return $map;
	}

	/**
	 * Retrieve a Wikia/Facebook User mapping based on both Ids
	 * If a two-id match was found, returns the map
	 * If only one Id matched, throws exception with error code
	 * If no matches, returns null
	 *
	 * @param int $wikiaUserId
	 * @param int $facebookId
	 *
	 * @return FacebookMapModel|null
	 *
	 * @throws FacebookMapModelException
	 */
	public static function getUserMapping( $wikiaUserId, $facebookId ) {
		$map = self::lookupFromFacebookID( $facebookId );

		if ( $map && ( $map->wikiaUserId != $wikiaUserId ) ) {
			throw new FacebookMapModelException( '', self::ERROR_WIKIA_USER_ID_MISMATCH );
		}

		return $map;
	}

	protected static function loadWithCache( array $params = [] ) {
		$wg = F::app()->wg;

		$memkey = self::generateMemKey( $params );
		$map = $wg->Memc->get( $memkey );

		// If we got nothing back, try loading from the DB
		if ( empty( $map ) ) {
			$mapData = self::loadFromDB( $params );

			if ( empty( $mapData ) ) {
				return null;
			}

			$map = new FacebookMapModel( $mapData );

			$wg->Memc->set( $memkey, $map );
		}

		return $map;
	}

	/**
	 * Generate Memcache key for the wikia/FB user mapping
	 *
	 * @param array $params
	 * @return string
	 * @throws FacebookMapModelInvalidParamException
	 */
	protected static function generateMemKey( array $params = [] ) {
		if ( !empty( $params[ self::paramWikiaUserId ] ) ) {
			$memkey = wfSharedMemcKey( self::cacheKeyVersion, 'wikiaUserId', $params[ self::paramWikiaUserId ] );
		} elseif ( !empty( $params[ self::paramFacebookUserId ] ) ) {
			$memkey = wfSharedMemcKey( self::cacheKeyVersion, 'facebookUserId', $params[ self::paramFacebookUserId ] );
		} else {
			throw new FacebookMapModelInvalidParamException();
		}

		return $memkey;
	}

	protected static function loadFromDB( array $params = [] ) {
		global $fbAppId;

		// Determine what column to constrain on
		list( $column, $id ) = self::getColumnAndValue( $params );

		$dbr = wfGetDB( DB_SLAVE, null, F::app()->wg->ExternalSharedDB );
		$data = ( new WikiaSQL() )
			->SELECT( '*' )
			->FROM( self::tableName )
			->WHERE( $column )->EQUAL_TO( $id )
			->AND_( self::columnFacebookAppId )->IN( $fbAppId, 0 )
			->ORDER_BY( self::columnFacebookAppId )->DESC()
			->LIMIT( 1 )
			->run( $dbr, function ( $result ) {
				/** @var ResultWrapper $result */
				$row = $result->fetchObject();
				if ( empty( $row ) ) {
					return null;
				}

				return [
					self::paramWikiaUserId => $row->user_id,
					self::paramFacebookUserId => $row->user_fbid,
					self::paramUpdateTime => $row->time,
					self::paramAppId => $row->user_fb_app_id,
					self::paramBizToken => $row->user_fb_biz_token,
				];
			} );

		return $data;
	}

	protected static function getColumnAndValue( array $params = [] ) {
		// Determine what column to constrain on
		if ( !empty( $params[ self::paramFacebookUserId ] ) ) {
			$column = self::columnFacebookUserId;
			$id = $params[ self::paramFacebookUserId ];
		} elseif ( !empty( $params[ self::paramWikiaUserId ] ) ) {
			$column = self::columnWikiaUserId;
			$id = $params[ self::paramWikiaUserId ];
		} else {
			throw new FacebookMapModelInvalidParamException();
		}

		return [ $column, $id ];
	}

	/**
	 * Relate a Wikia user ID to a Facebook user ID
	 *
	 * @param int $wikiaUserId A Wikia user ID
	 * @param int $facebookUserId A Facebook user ID
	 */
	public function relate( $wikiaUserId, $facebookUserId ) {
		$this->wikiaUserId = $wikiaUserId;
		$this->facebookUserId = $facebookUserId;
	}

	/**
	 * Check existence of user mapping between a Wikia user account and a FB account
	 *
	 * @param $wikiaUserId
	 * @param $fbUserId
	 * @return bool True if there is such wikia/fb mapping
	 */
	public static function hasUserMapping( $wikiaUserId, $fbUserId ) {
		$map = self::lookupFromWikiaID( $wikiaUserId );

		if ( empty( $map ) ) {
			return false;
		}

		// If we have a mapping, verify that the FB user ID is the one we're looking for
		return $map->facebookUserId == $fbUserId;
	}

	/**
	 * Delete all mappings that have the given Wikia user ID
	 *
	 * @param int $wikiaId A Wikia User ID
	 *
	 * @return bool
	 */
	public static function deleteFromWikiaID( $wikiaId ) {
		$map = self::lookupFromWikiaID( $wikiaId );
		if ( !empty( $map ) ) {
			$map->delete();
			return true;
		}

		return false;
	}

	/**
	 * Delete all mappings that have the given Facebook user ID
	 *
	 * @param int $facebookId A Facebook user ID
	 *
	 * @return bool
	 */
	public static function deleteFromFacebookID( $facebookId ) {
		$map = self::lookupFromFacebookID( $facebookId );
		if ( !empty( $map ) ) {
			$map->delete();
			return true;
		}

		return false;
	}

	/**
	 * Returns the Wikia user ID for this instance, if set
	 *
	 * @return int
	 */
	public function getWikiaUserId() {
		return $this->wikiaUserId;
	}

	/**
	 * Returns the Facebook user ID for this instance, if set
	 *
	 * @return int
	 */
	public function getFacebookUserId() {
		return $this->facebookUserId;
	}

	/**
	 * Returns the App ID associated with this mapping
	 *
	 * @return int
	 */
	public function getAppId() {
		return $this->facebookAppId;
	}

	/**
	 * Returns whether the App ID is the default App ID given to user mappings created before
	 * we started collecting App IDs.
	 *
	 * @return bool
	 */
	public function isDefaultAppId() {
		return $this->facebookAppId == self::APP_ID_DEFAULT_V1;
	}

	/**
	 * Returns the Business Token associated with this mapping
	 *
	 * @return int
	 */
	public function getBizToken() {
		return $this->facebookBizToken;
	}

	/**
	 * Sets the Business Token for this mapping
	 *
	 * @param string $token The business token for this user
	 */
	public function setBizToken( $token ) {
		$this->facebookBizToken = $token;
	}

	/**
	 * Check that the required values for a mapping are set
	 *
	 * @throws FacebookMapModelInvalidDataException
	 */
	protected function assertValidMapping() {
		if ( !$this->getWikiaUserId() || !$this->getFacebookUserId() ) {
			throw new FacebookMapModelInvalidDataException();
		}
	}

	/**
	 * Saves a mapping to the database
	 *
	 * @throws FacebookMapModelInvalidParamException
	 * @throws FacebookMapModelInvalidDataException
	 */
	public function save() {
		// Can't save if we haven't set the proper IDs on this instance
		$this->assertValidMapping();

		$this->saveToDatabase();
		$this->saveToCache();
	}

	/**
	 * Sets the business token for a user.  This is only needed while updating existing
	 * mappings to have this value.  New records will be created with this value from the start.
	 *
	 * @TODO Remove this method once every row with a non-zero App ID has a business token, i.e. this is zero:
	 *
	 * select count(*) from user_fbconnect where user_fb_app_id != 0 and user_fb_biz_token = '';
	 *
	 * @param string $token
	 *
	 * @throws FacebookMapModelDbException
	 */
	public function updateBizToken( $token ) {
		$this->setBizToken( $token );

		$dbw = wfGetDB( DB_MASTER, null, F::app()->wg->ExternalSharedDB );
		try {
			( new WikiaSQL() )
				->UPDATE( self::tableName )
				->SET( self::columnFacebookBizToken, $this->getBizToken() )
				->WHERE( self::columnFacebookUserId )->EQUAL_TO( $this->getFacebookUserId() )
				->AND_( self::columnFacebookAppId)->EQUAL_TO( $this->getAppId() )
				->run( $dbw );
		} catch ( \Exception $e ) {
			WikiaLogger::instance()->warning( 'Failed to update business token', [
				'wikiaUserId' => $this->getWikiaUserId(),
				'fbUserId' => $this->getFacebookUserId(),
				'fbAppId' => $this->getAppId(),
				'fbBizToken' => $this->getBizToken(),
				'errorMessage' => $e->getMessage(),
			] );

			throw new FacebookMapModelDbException( $e->getMessage() );
		}

		$this->saveToCache();
	}

	protected function saveToDatabase() {
		$dbw = wfGetDB( DB_MASTER, null, F::app()->wg->ExternalSharedDB );
		try {
			( new WikiaSQL() )
				->INSERT( self::tableName )
				->SET( self::columnWikiaUserId, $this->getWikiaUserId() )
				->SET( self::columnFacebookUserId, $this->getFacebookUserId() )
				->SET( self::columnFacebookAppId, $this->getAppId() )
				->SET( self::columnFacebookBizToken, $this->getBizToken() )
				->run( $dbw );
		} catch ( \Exception $e ) {
			WikiaLogger::instance()->warning( 'Failed to create user mapping', [
				'wikiaUserId' => $this->getWikiaUserId(),
				'fbUserId' => $this->getFacebookUserId(),
				'fbAppId' => $this->getAppId(),
				'fbBizToken' => $this->getBizToken(),
				'errorMessage' => $e->getMessage(),
			] );

			throw new FacebookMapModelDbException( $e->getMessage() );
		}
	}

	protected function saveToCache() {
		$memkey = self::generateMemKey( [
			self::paramFacebookUserId => $this->getFacebookUserId()
		] );
		F::app()->wg->Memc->set( $memkey, $this );

		$memkey = self::generateMemKey( [
			self::paramWikiaUserId => $this->getWikiaUserId()
		] );
		F::app()->wg->Memc->set( $memkey, $this );
	}

	/**
	 * Delete this Wikia user ID <=> Facebook user ID mapping
	 */
	public function delete() {
		$this->deleteMemcachedKeys();
		$this->deleteFromDatabase();
	}

	protected function deleteMemcachedKeys() {
		// Delete the Wikia user ID based key
		$memkey = self::generateMemKey( [ self::paramWikiaUserId => $this->getWikiaUserId() ] );
		F::app()->wg->Memc->delete( $memkey );

		// Delete this Facebook user ID based key
		$memkey = self::generateMemKey( [ self::paramFacebookUserId => $this->getFacebookUserId() ] );
		F::app()->wg->Memc->delete( $memkey );
	}

	protected function deleteFromDatabase() {
		$dbw = wfGetDB( DB_MASTER, null, F::app()->wg->ExternalSharedDB );
		( new WikiaSQL() )
			->DELETE( self::tableName )
			->WHERE( self::columnWikiaUserId )->EQUAL_TO( $this->getWikiaUserId() )
			->AND_( self::columnFacebookUserId )->EQUAL_TO( $this->getFacebookUserId() )
			->AND_( self::columnFacebookAppId )->IN( $this->getAppId(), 0 )
			->run( $dbw );
	}
}

/**
 * Class FacebookMapModelException
 *
 * Generic FacebookMapModel Exception
 */
class FacebookMapModelException extends \Exception { }

/**
 * Class FacebookMapModelInvalidParamException
 *
 * Thrown when the parameters needed for methods in the FacebookMapModel are not given or invalid
 */
class FacebookMapModelInvalidParamException extends FacebookMapModelException { }

/**
 * Class FaceBookMapModelInvalidDataException
 *
 * Thrown when the data in a FacebookMapModel is invalid
 */
class FacebookMapModelInvalidDataException extends FacebookMapModelException { }

/**
 * Class FacebookMapModelDbException
 *
 * Thrown when database error occurs
 */
class FacebookMapModelDbException extends FacebookMapModelException { }
