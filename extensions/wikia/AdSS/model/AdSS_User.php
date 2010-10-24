<?php

class AdSS_User {

	public $id;
	public $registered;
	public $email;
	public $password;
	public $newpassword;

	function __construct() {
		$this->id = 0;
		$this->registered = null;
		$this->email = '';
		$this->password = '';
		$this->newpassword = '';
	}

	static function newFromForm( $f ) {
		$user = new AdSS_User();
		$user->loadFromForm( $f );
		return $user;
	}

	static function newFromId( $id ) {
		$user = new AdSS_User();
		$user->id = $id;
		$user->loadFromDB();
		return $user;
	}

	static function newFromRow( $row ) {
		$user = new AdSS_User();
		$user->loadFromRow( $row );
		return $user;
	}

	function loadFromForm( $f ) {
		//todo
		$this->email = $f->get( 'wpEmail' );
	}

	function loadFromRow( $row ) {
		if( isset( $row->user_id ) ) {
			$this->id = intval( $row->user_id );
		}
		$this->registered = wfTimestampOrNull( TS_UNIX, $row->user_registered );
		$this->email = $row->user_email;
		$this->password = $row->user_password;
		$this->newpassword = $row->user_newpassword;
	}

	function loadFromDB() {
		global $wgAdSS_DBname;

		$dbr = wfGetDB( DB_SLAVE, array(), $wgAdSS_DBname );
		if( $this->id > 0 ) {
			$conds = array( 'user_id' => $this->id );
		} else {
			if( !empty( $this->email ) ) {
				$conds = array( 'user_email' => $this->email );
			} else {
				// invalid key
				return false;
			}
		}
		$row = $dbr->selectRow( 'users', '*', $conds, __METHOD__ );
		if( $row === false ) {
			$this->id = 0;
			return false;
		} else {
			$this->loadFromRow( $row );
			return true;
		}
	}

	function save() {
		global $wgAdSS_DBname;

		$dbw = wfGetDB( DB_MASTER, array(), $wgAdSS_DBname );
		if( $this->id == 0 ) {
			$dbw->insert( 'users',
					array(
						'user_registered'  => wfTimestampNow( TS_DB ),
						'user_email'       => $this->email,
						'user_password'    => $this->password,
						'user_newpassword' => $this->newpassword,
					     ),
					__METHOD__
				    );
			$this->id = $dbw->insertId();
		} else {
			$dbw->update( 'users',
					array(
						'user_email'       => $this->email,
						'user_password'    => $this->password,
						'user_newpassword' => $this->newpassword,
					     ),
					array(
						'user_id' => $this->id
					     ),
					__METHOD__
				    );
		}
	}

	function toString() {
		return "{$this->email} (ID={$this->id})";
	}

}
