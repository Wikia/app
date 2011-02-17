<?php

class ExternalUser_Wikia extends ExternalUser {
	private $mRow, $mDb;

	protected function initFromName( $name ) {
		$name = User::getCanonicalName( $name, 'usable' );

		if ( !is_string( $name ) ) {
			return false;
		}

		return $this->initFromCond( array( 'user_name' => $name ) );
	}

	protected function initFromId( $id ) {
		return $this->initFromCond( array( 'user_id' => $id ) );
	}

	private function initFromCond( $cond ) {
		global $wgExternalSharedDB;

		$this->mDb = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );

		$row = $this->mDb->selectRow( 
			'user', 
			array( '*' ), 
			cond, 
			__METHOD__
		);
		if ( !$row ) {
			return false;
		}
		$this->mRow = $row;

		return true;
	}

	public function getId() {
		return $this->mRow->user_id;
	}

	public function getName() {
		return $this->mRow->user_name;
	}

	public function getEmail() {
		return $this->mRow->user_email;
	}
	
	public function getEmailAuthentication() {
		return $this->mRow->user_email_authenticated;
	}

	public function getUserTouched() {
		return $this->mRow->user_touched;
	}
	
	public function authenticate( $password ) {
		# This might be wrong if anyone actually uses the UserComparePasswords hook 
		# (on either end), so don't use this if you those are incompatible.
		return User::comparePasswords( $this->mRow->user_password, $password, $this->mRow->user_id );	
	}

	public function getPref( $pref ) {
		return null;
	}
	
	public static function newFromUser( $user ) {
		return null;
	}
		
	public function linkToLocal( $id ) {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->replace( 
			'user',
			array( 'user_name', 'user_id', 'user_password', 'user_email', 'user_email_authenticated', 'user_touched' ),
			array( 
				'user_id' 		=> $id,
				'user_name' 	=> $this->getName(),
				'user_email'	=> $this->getEmail(), 
				'user_email_authenticated' => $this->getEmailAuthentication(), 
				'user_touched' 	=> $this->getUserTouched()
			),
			__METHOD__ 
		);
	}		
	
	public function getLocalUser(){
		$dbr = wfGetDb( DB_SLAVE );
		$row = $dbr->selectRow(
			'user',
			'*',
			array( 'user_id' => $this->getId() )
		);
		return $row ? User::newFromId( $row->user_id ) : null;
	}	
		
	public function initFromCookie() {
        if ( wfReadOnly() ) {
			wfDebug( __METHOD__ . ": Cannot load from session - DB is running with the --read-only option " );
            return false;
        }

		$uid = $_SESSION['wsUserID'];
		if ( empty($uid) ) {
			return false;
		} 
		
		// exists on central
		$this->initFromId( $uid );	
		
		// exists on local
		if ( !empty($this->mRow) ) {
			// additional check to not do it every request
			$oUser = $this->getLocalUser();
		} else {
			$oUser = null;
		}
		
		return is_null( $oUser );
	}
}
