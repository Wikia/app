<?php

class AdSS_User {

	public $id;
	public $registered;
	public $email;
	public $password;
	public $newpassword;
	public $pp_payerId;
	public $baid;

	function __construct() {
		$this->id = 0;
		$this->registered = null;
		$this->email = '';
		$this->password = '';
		$this->newpassword = '';
		$this->pp_payerId = null;
		$this->baid = null;
	}

	static function newFromId( $id ) {
		global $wgAdSS_DBname;

		$dbr = wfGetDB( DB_SLAVE, array(), $wgAdSS_DBname );
		$row = $dbr->selectRow( 'users', '*', array( 'user_id' => $id ), __METHOD__ );
		if( $row ) {
			$user = self::newFromRow( $row );
			if( $user->id == $id ) {
				return $user;
			}
		}
		return false;
	}

	static function newFromPayerId( $payerId, $email ) {
		global $wgAdSS_DBname;

		$dbr = wfGetDB( DB_SLAVE, array(), $wgAdSS_DBname );
		$row = $dbr->selectRow( 'users', '*', array( 'user_pp_payerid' => $payerId, 'user_email' => $email ), __METHOD__ );
		if( $row ) {
			$user = self::newFromRow( $row );
			if( $user->pp_payerId == $payerId ) {
				return $user;
			}
		}
		return false;
	}

	static function newFromBAID( $baid ) {
		global $wgAdSS_DBname;

		$dbr = wfGetDB( DB_SLAVE, array(), $wgAdSS_DBname );
		$row = $dbr->selectRow( 'users', '*', array( 'user_pp_baid' => $baid ), __METHOD__ );
		if( $row ) {
			$user = self::newFromRow( $row );
			if( $user->baid == $baid ) {
				return $user;
			}
		}
		return false;
	}

	static function newFromForm( $f ) {
		global $wgAdSS_DBname;

		$email = $f->get( "wpEmail" );
		$password = $f->get( "wpPassword" );

		$dbr = wfGetDB( DB_SLAVE, array(), $wgAdSS_DBname );
		$res = $dbr->select( 'users', '*', array( 'user_email' => $email ), __METHOD__ );

		foreach( $res as $row ) {
			$user = self::newFromRow( $row );
			if( $user->password == $user->cryptPassword( $password ) ) {
				$dbr->freeResult( $res );
				return $user;
			} elseif( $user->newpassword == $user->cryptPassword( $password ) ) {
				$dbr->freeResult( $res );
				$user->password = $user->newpassword;
				$user->newpassword = '';
				$user->save();
				return $user;
			}
		}
		$dbr->freeResult( $res );
		return false;
	}

	static function register( $email ) {
		$user = new self();
		$user->email = $email;
		$user->save();
		if( $user->id ) {
			$password = self::randomPassword();
			$user->password = $user->cryptPassword( $password );
			$user->save();

			$user->sendWelcomeMessage( $password );
			return $user;
		} else {
			return false;
		}
	}

	static function newFromRow( $row ) {
		$user = new self();
		$user->loadFromRow( $row );
		return $user;
	}

	function loadFromRow( $row ) {
		if( isset( $row->user_id ) ) {
			$this->id = intval( $row->user_id );
		}
		$this->registered = wfTimestampOrNull( TS_UNIX, $row->user_registered );
		$this->email = $row->user_email;
		$this->password = $row->user_password;
		$this->newpassword = $row->user_newpassword;
		$this->pp_payerId = $row->user_pp_payerid;
		$this->baid = $row->user_pp_baid;
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
						'user_pp_payerid'  => $this->pp_payerId,
						'user_pp_baid'     => $this->baid,
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
						'user_pp_payerid'  => $this->pp_payerId,
						'user_pp_baid'     => $this->baid,
					     ),
					array(
						'user_id' => $this->id
					     ),
					__METHOD__
				    );
		}
	}

	function sendWelcomeMessage( $password ) {
		global $wgAdSSPasswordSender, $wgAdSSBillingThreshold;
		$to = new MailAddress( $this->email );
		$from = new MailAddress( $wgAdSSPasswordSender );
		$subject = wfMsg( 'adss-welcome-subject' );
		$url = SpecialPage::getTitleFor( 'AdSS/manager' )->getFullURL();
		$body = wfMsg( 'adss-welcome-body', $url, $this->email, $password, $wgAdSSBillingThreshold );
		UserMailer::send( $to, $from, $subject, $body );
	}

	/**
	  Return a random password. Copied from MW User class
	  */
	static function randomPassword() {
		global $wgMinimalPasswordLength;
		$pwchars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz';
		$l = strlen( $pwchars ) - 1;

		$pwlength = max( 7, $wgMinimalPasswordLength );
		$digit = mt_rand(0, $pwlength - 1);
		$np = '';
		for ( $i = 0; $i < $pwlength; $i++ ) {
			$np .= $i == $digit ? chr( mt_rand(48, 57) ) : $pwchars{ mt_rand(0, $l)};
		}
		return $np;
	}

	function cryptPassword( $password ) {
		return md5( $this->id . $password );
	}

	function toString() {
		return "{$this->email} (ID={$this->id})";
	}

	function getAds() {
		global $wgAdSS_DBname;

		$ads = array();

		$dbr = wfGetDB( DB_SLAVE, array(), $wgAdSS_DBname );
		$res = $dbr->select( 'ads', '*', array( 'ad_user_id' => $this->id ), __METHOD__ );
		foreach( $res as $row ) {
			$ads[] = AdSS_AdFactory::newFromRow( $row );
		}
		return $ads;
	}

	function getBillingBalance() {
		global $wgAdSS_DBname;
		$dbr = wfGetDB( DB_SLAVE, array(), $wgAdSS_DBname );
		return $dbr->selectField( 'billing', 'sum(billing_amount)', array( 'billing_user_id' => $this->id ), __METHOD__ );
	}
}
