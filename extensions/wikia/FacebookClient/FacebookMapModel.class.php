<?php

use Wikia\Logger\WikiaLogger;

/**
 * Class FacebookMapModel
 *
 * This class models the mapping between a Wikia user ID and a Facebook user ID
 */
class FacebookMapModel {

	// Make these often used parameters are constants so they can be checked by the compiler
	const paramWikiaUserId = 'wikiaUserId';
	const paramFacebookUserId = 'facebookUserId';
	const paramUpdateTime = 'updateTime';

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
	 * Lookup all mappings where the Wikia user ID is set to the given ID.  There will usually only be one
	 * but there can be many (if they login to custom domains such as wowwiki where we have separate FB apps)
	 *
	 * @param int $wikiaUserId The Wikia user ID
	 *
	 * @return array All mappings found
	 */
	public static function lookupFromWikiaID( $wikiaUserId ) {
		$mappings = self::loadWithCache( [ self::paramWikiaUserId => $wikiaUserId ] );

		return $mappings;
	}

	/**
	 * Find the mapping associated with the given Facebook user ID
	 *
	 * @param int $facebookId
	 *
	 * @return FacebookMapModel
	 */
	public static function lookupFromFacebookID( $facebookId ) {
		$mappings = self::loadWithCache( [ self::paramFacebookUserId => $facebookId ] );

		if ( empty( $mappings[0] ) ) {
			return null;
		} else {
			return $mappings[0];
		}
	}

	/**
	 * Delete all mappings that have the given Wikia user ID
	 *
	 * @param int $wikiaId A Wikia User ID
	 */
	public static function deleteFromWikiaID( $wikiaId ) {
		$maps = self::lookupFromWikiaID( $wikiaId );

		// Delete all Facebook user ID based keys
		/** @var FacebookMapModel $map */
		foreach ( $maps as $map ) {
			$memkey = self::generateMemKey( [ self::paramFacebookUserId => $map->getFacebookUserId() ] );
			F::app()->wg->Memc->delete( $memkey );
		}

		// Delete the Wikia user ID based key
		$memkey = self::generateMemKey( [ self::paramWikiaUserId => $wikiaId ] );
		F::app()->wg->Memc->delete( $memkey );


		self::deleteMapping( [ self::paramWikiaUserId => $wikiaId ] );
	}

	/**
	 * Delete all mappings that have the given Facebook user ID
	 *
	 * @param int $facebookId A Facebook user ID
	 */
	public static function deleteFromFacebookID( $facebookId ) {
		$map = self::lookupFromFacebookID( $facebookId );

		// Delete the Wikia user ID based key
		$memkey = self::generateMemKey( [ self::paramWikiaUserId => $map->getWikiaUserId() ] );
		F::app()->wg->Memc->delete( $memkey );

		// Delete this Facebook user ID based key
		$memkey = self::generateMemKey( [ self::paramWikiaUserId => $facebookId ] );
		F::app()->wg->Memc->delete( $memkey );

		self::deleteMapping( [ self::paramFacebookUserId => $facebookId ] );
	}

	private static function loadWithCache( array $params = [] ) {
		$wg = F::app()->wg;

		$memkey = self::generateMemKey( $params );
		$mappings = $wg->Memc->get( $memkey );

		// If we got nothing back, try loading from the DB
		if ( !is_array( $mappings ) ) {
			$data = self::loadFromDB( $params );

			// Return now with an empty array if its not found
			if ( !is_array( $data ) ) {
				return [];
			}

			// Construct objects to send back
			foreach ( $data as $mapping ) {
				$map = new FacebookMapModel( $mapping );
				$mappings[] = $map;
			}

			$wg->Memc->set( $memkey, $mappings );
		}

		return $mappings;
	}

	private static function loadFromDB( array $params = [] ) {

		// Determine what column to constrain on
		list( $column, $id ) = self::getColumnAndValue( $params );

		$dbr = wfGetDB( DB_SLAVE, null, F::app()->wg->ExternalSharedDB );
		$data = ( new WikiaSQL() )
			->SELECT( '*' )
			->FROM( 'user_fbconnect' )
			->WHERE( $column )->EQUAL_TO( $id )
			->runLoop( $dbr, function ( &$data, $row ) {
				$data[] = [
					self::paramWikiaUserId => $row->user_id,
					self::paramFacebookUserId => $row->user_fbid,
					self::paramUpdateTime => $row->time,
				];
			} );

		return $data;
	}

	private static function generateMemKey( array $params = [] ) {
		if ( !empty( $params[ self::paramWikiaUserId ] ) ) {
			$memkey = wfSharedMemcKey( 'wikiaUserId', $params[ self::paramWikiaUserId ] );
		} elseif ( !empty( $params[ self::paramFacebookUserId ] ) ) {
			$memkey = wfSharedMemcKey( 'facebookUserId', $params[ self::paramFacebookUserId ] );
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

	private static function deleteMapping( array $params ) {
		$memc = F::app()->wg->Memc;

		// Load all the mappings we can find for the parameters given
		$mappings = self::loadWithCache( $params );

		// If we have a mapping use it to clear out all possible keys
		if ( is_array( $mappings ) && count( $mappings ) > 0 ) {
			// Use the first mapping to purge based on the Wikia user ID
			/** @var FacebookMapModel $firstMap */
			$firstMap = $mappings[ 0 ];

			// Delete the Wikia ID based memcached keys
			$wikiaUserId = $firstMap->getWikiaUserId();
			$memkey = self::generateMemKey( [ self::paramWikiaUserId => $wikiaUserId ] );
			$memc->delete( $memkey );

			// Delete all facebook ID based memcached keys (can be one or more)
			foreach ( $mappings as $map ) {
				/** @var FacebookMapModel $map */
				$facebookUserId = $map->getFacebookUserId();
				$memkey = self::generateMemKey( [ self::paramFacebookUserId => $facebookUserId ] );
				$memc->delete( $memkey );
			}
		}

		// Determine what column to constrain on
		list( $column, $id ) = self::getColumnAndValue( $params );

		$dbw = wfGetDB( DB_MASTER, null, F::app()->wg->ExternalSharedDB );
		( new WikiaSQL() )
			->DELETE( 'user_fbconnect' )
			->WHERE( $column )->EQUAL_TO( $id )
			->run( $dbw );
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
				->run( $dbw );
		} catch ( \Exception $e ) {
			throw new FacebookMapModelDbException( $e->getMessage() );
		}

		$memkey = self::generateMemKey( [
			self::paramFacebookUserId => $this->facebookUserId
		] );

		F::app()->wg->Memc->set( $memkey, [ $this ] );
	}

	/**
	 * Create a new user mapping between a Wikia user account and a FB account
	 *
	 * @param $wikiaUserId
	 * @param $fbUserId
	 * @return bool True on success, False on failure
	 * @throws FacebookMapModelInvalidParamException
	 */
	public static function createUserMapping( $wikiaUserId, $fbUserId ) {
		// TODO: refactor callers to only call this for connection or FB sign up actions
		if ( self::hasUserMapping( $wikiaUserId, $fbUserId ) ) {
			return true;
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

			return false;
		}

		return true;
	}

	/**
	 * Check existence of user mapping between a Wikia user account and a FB account
	 *
	 * @param $wikiaUserId
	 * @param $fbUserId
	 * @return bool True if there is such wikia/fb mapping
	 */
	public static function hasUserMapping( $wikiaUserId, $fbUserId ) {
		$dbr = wfGetDB( DB_SLAVE, null, F::app()->wg->ExternalSharedDB );
		$data = ( new WikiaSQL() )
			->SELECT( '*' )
			->FROM( 'user_fbconnect' )
			->WHERE( 'user_id' )->EQUAL_TO( $wikiaUserId )
			->AND_( 'user_fbid' )->EQUAL_TO( $fbUserId )
			->LIMIT( 1 )
			->run( $dbr, function( $result ) {
				/** @var ResultWrapper $result */
				return $result->fetchObject();
			});

		return !empty( $data );
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
