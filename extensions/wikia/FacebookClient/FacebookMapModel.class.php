<?php

class FacebookMapModel {

	// Make these often used parameters constants so they can be checked by the compiler
	const paramWikiaUserId = 'wikiaUserId';
	const paramFacebookUserId = 'facebookUserId';
	const paramUpdateTime = 'updateTime';

	private $facebookUserId;
	private $wikiaUserId;
	private $lastUpdateTime;

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

		return $mappings[0];
	}

	/**
	 * Delete all mappings that have the given Wikia user ID
	 *
	 * @param int $wikiaId A Wikia User ID
	 */
	public static function deleteFromWikiaID( $wikiaId ) {
		self::deleteMapping( [ self::paramWikiaUserId => $wikiaId ] );
	}

	/**
	 * Delete all mappings that have the given Facebook user ID
	 *
	 * @param int $facebookId A Facebook user ID
	 */
	public static function deleteFromFacebookID( $facebookId ) {
		self::deleteMapping( [ self::paramFacebookUserId => $facebookId ] );
	}

	private static function loadWithCache( array $params = [] ) {
		$wg = F::app()->wg;

		$memkey = self::generateMemKey( $params );
		$mappings = $wg->Memc->get( $memkey );

		// If we got nothing back, try loading from the DB
		if ( !is_array( $mappings ) ) {
			$data = self::loadFromDB( $params );

			if ( is_array( $data ) ) {
				// Return now with an empty array if its not found
				return [];
			}

			// Construct objects to send back
			foreach ( $data as $mapping ) {
				$mappings[] = new FacebookMapModel( $mapping );
			}
		}

		$wg->Memc->set( $memkey, $mappings );

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

	private static function deleteMapping( array $params = [] ) {
		$memkey = self::generateMemKey( $params );
		F::app()->wg->Memc->delete( $memkey );

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
	 */
	public function save() {
		// Can't save if we haven't set the proper IDs on this instance
		if ( !$this->wikiaUserId || !$this->facebookUserId ) {
			throw new FacebookMapModelInvalidDataException();
		}

		list( $column, $id ) = self::getColumnAndValue( [
			self::paramFacebookUserId => $this->facebookUserId
		] );

		$dbw = wfGetDB( DB_MASTER, null, F::app()->wg->ExternalSharedDB );
		( new WikiaSQL() )
			->INSERT( 'user_fbconnect' )
			->WHERE( $column )->EQUAL_TO( $id )
			->run( $dbw );

		$memkey = self::generateMemKey( [
			self::paramFacebookUserId => $this->facebookUserId
		] );

		F::app()->wg->Memc->set( $memkey, [
			self::paramWikiaUserId => $this->wikiaUserId,
			self::paramFacebookUserId => $this->facebookUserId,
			self::paramUpdateTime => $this->lastUpdateTime,
		] );
	}
}

/**
 * Class FacebookMapModelInvalidParamException
 *
 * Thrown when the parameters needed for methods in the FacebookMapModel are not given or invalid
 */
class FacebookMapModelInvalidParamException extends Exception { }

/**
 * Class FaceBookMapModelInvalidDataException
 *
 * Thrown when the data in a FacebookMapModel is invalid
 */
class FacebookMapModelInvalidDataException extends Exception { }