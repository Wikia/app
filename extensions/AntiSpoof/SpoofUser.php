<?php

class SpoofUser {

	/**
	 * @param $name string
	 */
	public function __construct( $name ) {
		$this->mName = strval( $name );
		list( $ok, $normalized ) = AntiSpoof::checkUnicodeString( $this->mName );
		$this->mLegal = ( $ok == 'OK' );
		if ( $this->mLegal ) {
			$this->mNormalized = $normalized;
			$this->mError = null;
		} else {
			$this->mNormalized = null;
			$this->mError = $normalized;
		}
	}

	/**
	 * Does the username pass Unicode legality and script-mixing checks?
	 * @return bool
	 */
	public function isLegal() {
		return $this->mLegal;
	}

	/**
	 * Describe the error.
	 * @return null|string
	 */
	public function getError() {
		return $this->mError;
	}

	/**
	 * Get the normalized key form
	 * @return string|null
	 */
	public function getNormalized() {
		return $this->mNormalized;
	}

	/**
	 * Does the username pass Unicode legality and script-mixing checks?
	 *
	 * @param $skipExactMatch - when true exact match username is not returned
	 *
	 * @return array empty if no conflict, or array containing conflicting user names
	 */
	public function getConflicts( $skipExactMatch = false ) {
		$dbr = self::getDBSlave();

		// Join against the user table to ensure that we skip stray
		// entries left after an account is renamed or otherwise munged.
		/* Wikia Change - begin :
			Quote the table names, otherwise the select method
				tries to prefix the tablenames with the current user DB
			Added $skipExactMatch */
		$conds = array(
			'su_normalized' => $this->mNormalized,
			'su_name=user_name',
		);
		if ( $skipExactMatch ) {
			// BINARY enforces case sensitive comparison
			$conds[] = "BINARY su_name != {$dbr->addQuotes( $this->mName )}";
		}

		$spoofedUsers = $dbr->select(
			array( '`spoofuser`', '`user`' ),
			array( 'user_name' ),
			$conds,
			__METHOD__,
			array(
				'LIMIT' => 5
			) );
		/* Wikia Change - end */

		$spoofs = array();
		foreach ( $spoofedUsers as $row ) {
			array_push( $spoofs, $row->user_name );
		}
		return $spoofs;
	}

	/**
	 * Record the username's normalized form into the database
	 * for later comparison of future names...
	 * @return bool
	 */
	public function record() {
		return self::batchRecord( array( $this ) );
	}

	/**
	 * @return array
	 */
	private function insertFields() {
		return array(
			'su_name'       => $this->mName,
			'su_normalized' => $this->mNormalized,
			'su_legal'      => $this->mLegal ? 1 : 0,
			'su_error'      => $this->mError,
		);
	}

	/**
	 * Insert a batch of spoof normalization records into the database.
	 * @param $items array of SpoofUser
	 * @return bool
	 */
	public static function batchRecord( $items ) {
		if ( !count( $items ) ) {
			return false;
		}
		$fields = array();
		/**
		 * @var $item SpoofUser
		 */
		foreach ( $items as $item ) {
			$fields[] = $item->insertFields();
		}
		$dbw = self::getDBMaster();
		$dbw->replace(
			'spoofuser',
			array( 'su_name' ),
			$fields,
			__METHOD__ );
		return true;
	}

	/**
	 * @param $oldName
	 */
	public function update( $oldName ) {
		$dbw = self::getDBMaster();

		if( $this->record() ) {
			$dbw->delete(
				'spoofuser',
				array( 'su_name' => $oldName ),
				__METHOD__
			);
		}
	}

	/**
	 * Wikia Change - change database
	 * @return DatabaseBase
	 */
	protected static function getDBSlave() {
		return wfGetDB( DB_SLAVE, [], F::app()->wg->ExternalSharedDB );
	}

	/**
	 * Wikia Change - change database
	 * @return DatabaseBase
	 */
	protected static function getDBMaster() {
		return wfGetDB( DB_MASTER, [], F::app()->wg->ExternalSharedDB );
	}

	/**
	 * Wikia change
	 * remove spoof normalization record from the database
	 */
	public function removeRecord() {
		wfProfileIn( __METHOD__ );

		if ( !wfReadOnly() ) {
			$db = $this->getDBMaster();
			$db->delete(
				'spoofuser',
				array( 'su_name' => $this->mName),
				__METHOD__
			);
			$db->commit();
		}

		wfProfileOut( __METHOD__ );
	}

}
