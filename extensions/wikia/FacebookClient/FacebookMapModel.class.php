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

	// Make these often used parameters are constants so they can be checked by the compiler
	const paramWikiaUserId = 'wikiaUserId';
	const paramFacebookUserId = 'facebookUserId';
	const paramUpdateTime = 'updateTime';
	const paramAppId = 'appId';
	const paramBizToken = 'bizToken';

	private $facebookUserId;
	private $wikiaUserId;
	private $lastUpdateTime;

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
		// If $param is set, both IDs must be passed
		if ( $param && !isset( $param[self::paramFacebookUserId], $param[self::paramWikiaUserId] ) ) {
			throw new FacebookMapModelInvalidParamException();
		}

		$this->facebookUserId = $param[self::paramFacebookUserId];
		$this->wikiaUserId = $param[self::paramWikiaUserId];

		if ( isset( $param[self::paramUpdateTime] ) ) {
			$this->lastUpdateTime = $param[ self::paramUpdateTime ];
		}
	}

	/**
	 * Lookup a mapping where the Wikia user ID is set to the given ID.
	 *
	 * @param int $wikiaUserId The Wikia user ID
	 *
	 * @return FacebookMapModel The mapping found
	 */
	public static function lookupFromWikiaID( $wikiaUserId ) {
		$map = self::loadWithCache( [ self::paramWikiaUserId => $wikiaUserId ] );

		return $map;
	}

	/**
	 * Find the mapping associated with the given Facebook user ID
	 *
	 * @param int $facebookId
	 *
	 * @return FacebookMapModel
	 */
	public static function lookupFromFacebookID( $facebookId ) {
		$map = self::loadWithCache( [ self::paramFacebookUserId => $facebookId ] );

		return $map;
	}

	private static function loadWithCache( array $params = [] ) {
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
	 * Create a new user mapping between a Wikia user account and a FB account
	 *
	 * @param $wikiaUserId
	 * @param $fbUserId
	 * @return FacebookMapModel|null Returns the mapping on success, null otherwise
	 * @throws FacebookMapModelInvalidParamException
	 */
	public static function createUserMapping( $wikiaUserId, $fbUserId ) {
		// TODO: refactor callers to only call this for connection or FB sign up actions
		$map = self::lookupFromWikiaID( $wikiaUserId );
		if ( !empty( $map ) ) {
			return $map;
		}

		$map = new self();
		$map->relate( $wikiaUserId, $fbUserId );
		try {
			$map->save();
		} catch ( FacebookMapModelException $e ) {
			WikiaLogger::instance()->warning( 'Failed to create user mapping', [
				'wikiaUserId' => $wikiaUserId,
				'fbUserId' => $fbUserId,
			] );

			return null;
		}

		return $map;
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
	 */
	public static function deleteFromWikiaID( $wikiaId ) {
		$map = self::lookupFromWikiaID( $wikiaId );
		$map->delete();
	}

	/**
	 * Delete all mappings that have the given Facebook user ID
	 *
	 * @param int $facebookId A Facebook user ID
	 */
	public static function deleteFromFacebookID( $facebookId ) {
		$map = self::lookupFromFacebookID( $facebookId );
		$map->delete();
	}

	private static function loadFromDB( array $params = [] ) {
		global $fbAppId;

		// Determine what column to constrain on
		list( $column, $id ) = self::getColumnAndValue( $params );

		$dbr = wfGetDB( DB_SLAVE, null, F::app()->wg->ExternalSharedDB );
		$data = ( new WikiaSQL() )
			->SELECT( '*' )
			->FROM( 'user_fbconnect' )
			->WHERE( $column )->EQUAL_TO( $id )
			->AND_( 'user_fb_app_id' )->IN( $fbAppId, 0 )
			->runLoop( $dbr, function ( &$data, $row ) {
				$data[] = [
					self::paramWikiaUserId => $row->user_id,
					self::paramFacebookUserId => $row->user_fbid,
					self::paramUpdateTime => $row->time,
					self::paramAppId => $row->user_fb_app_id,
					self::paramBizToken => $row->user_fb_biz_token,
				];
			} );

		if ( is_array( $data ) ) {
			// If we get more than one result back, one of them has the right app ID and the other has zero.
			// Return the version with the app ID.
			if ( count( $data ) > 1 ) {
				foreach ( $data as $mapping ) {
					if ( $mapping[self::paramAppId] == $fbAppId ) {
						return $mapping;
					}
				}
			}

			return $data[0];
		} else {
			return null;
		}
	}

	private static function generateMemKey( array $params = [] ) {
		if ( !empty( $params[ self::paramWikiaUserId ] ) ) {
			$memkey = wfSharedMemcKey( self::cacheKeyVersion, 'wikiaUserId', $params[ self::paramWikiaUserId ] );
		} elseif ( !empty( $params[ self::paramFacebookUserId ] ) ) {
			$memkey = wfSharedMemcKey( self::cacheKeyVersion, 'facebookUserId', $params[ self::paramFacebookUserId ] );
		} else {
			throw new FacebookMapModelInvalidParamException();
		}

		return $memkey;
	}

	private static function getColumnAndValue( array $params = [] ) {
		// Determine what column to constrain on
		if ( !empty( $params[ self::paramFacebookUserId ] ) ) {
			$column = 'user_fbid';
			$id = $params[ self::paramFacebookUserId ];
		} elseif ( !empty( $params[ self::paramWikiaUserId ] ) ) {
			$column = 'user_id';
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
	 * Saves a mapping to the database
	 *
	 * @throws FacebookMapModelInvalidParamException
	 * @throws FacebookMapModelInvalidDataException
	 */
	public function save() {
		global $fbAppId;

		// Can't save if we haven't set the proper IDs on this instance
		if ( !$this->wikiaUserId || !$this->facebookUserId ) {
			throw new FacebookMapModelInvalidDataException();
		}

		$dbw = wfGetDB( DB_MASTER, null, F::app()->wg->ExternalSharedDB );
		try {
			( new WikiaSQL() )
				->INSERT( 'user_fbconnect' )
				->SET( 'user_id', $this->wikiaUserId )
				->SET( 'user_fbid', $this->facebookUserId )
				->SET( 'user_fb_app_id', $fbAppId )
				->run( $dbw );
		} catch ( \Exception $e ) {
			throw new FacebookMapModelDbException( $e->getMessage() );
		}

		$memkey = self::generateMemKey( [
			self::paramFacebookUserId => $this->facebookUserId
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

	private function deleteMemcachedKeys() {
		// Delete the Wikia user ID based key
		$memkey = self::generateMemKey( [ self::paramWikiaUserId => $this->getWikiaUserId() ] );
		F::app()->wg->Memc->delete( $memkey );

		// Delete this Facebook user ID based key
		$memkey = self::generateMemKey( [ self::paramFacebookUserId => $this->getFacebookUserId() ] );
		F::app()->wg->Memc->delete( $memkey );
	}

	private function deleteFromDatabase() {
		global $fbAppId;

		$dbw = wfGetDB( DB_MASTER, null, F::app()->wg->ExternalSharedDB );
		( new WikiaSQL() )
			->DELETE( 'user_fbconnect' )
			->WHERE( 'user_id' )->EQUAL_TO( $this->wikiaUserId )
			->AND_( 'user_fbid' )->EQUAL_TO( $this->facebookUserId )
			->AND_( 'user_fb_app_id' )->IN( $fbAppId, 0 )
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
