<?php

class ExternalUser_Wikia extends ExternalUser {
	private $mRow, $mDb, $mUser;

	protected function initFromName( $name ) {
		wfDebug( __METHOD__ . ": init User from name: $name \n" );
		$name = User::getCanonicalName( $name, 'usable' );

		if ( !is_string( $name ) ) {
			return false;
		}

		return $this->initFromCond( array( 'user_name' => $name ) );
	}

	protected function initFromId( $id ) {
		wfDebug( __METHOD__ . ": init User from id: $id \n" );
		return $this->initFromCond( array( 'user_id' => $id ) );
	}

	protected function initFromUser( $user ) {
		wfDebug( __METHOD__ . ": init User from object with user id : " . $user->getId() ." \n" );
		$this->mUser = $user;
		return $this->initFromCond( array( 'user_id' => $user->getId() ) );
	}

	private function initFromCond( $cond ) {
		global $wgExternalSharedDB;


		wfDebug( __METHOD__ . ": init User from cond: " . wfArrayToString( $cond ) . " \n" );

		$this->mDb = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
		$row = $this->mDb->selectRow(
			'`user`',
			array( '*' ),
			$cond,
			__METHOD__
		);
		if ( !$row ) {
			$this->mDb = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );
			$row = $this->mDb->selectRow(
				'`user`',
				array( '*' ),
				$cond,
				__METHOD__
			);
		}

		if ( !$row ) {
			return false;
		}

		$this->mRow = $row;

		return true;
	}

	public function initFromCookie() {
		global $wgMemc,$wgDBcluster, $wgCookiePrefix, $wgRequest;
		wfDebug( __METHOD__ . " \n" );

        if ( wfReadOnly() ) {
			wfDebug( __METHOD__ . ": Cannot load from session - DB is running with the --read-only option " );
            return false;
        }

		// Copy safety check from User.php
		$uid = intval( isset( $_COOKIE["{$wgCookiePrefix}UserID"] ) ? $_COOKIE["{$wgCookiePrefix}UserID"] : 0 );
		if( $uid != 0 && isset( $_SESSION['wsUserID'] ) && $uid != $_SESSION['wsUserID'] ) {
			$wgRequest->response()->setcookie( "UserID", '', time() - 86400 );
			$wgRequest->response()->setcookie( "UserName", '', time() - 86400 );
			$wgRequest->response()->setcookie( "_session", '', time() - 86400 );
			$wgRequest->response()->setcookie( "Token", '', time() - 86400 );
			trigger_error("###INEZ### {$_SESSION['wsUserID']}\n", E_USER_WARNING);
			return false;
		}

		wfDebug( __METHOD__ . ": user from session: $uid \n" );
		if ( empty($uid) ) {
			return false;
		}

		// exists on central
		$this->initFromId( $uid );

		// exists on local
		$User = null;
		if ( !empty($this->mRow) ) {
			$memkey = sprintf("extuser:%d:%s", $this->getId(), $wgDBcluster);
error_log( __METHOD__ . ": memkey = $memkey \n", 3, "/tmp/moli.log" );
			$user_touched = $wgMemc->get( $memkey );
error_log( __METHOD__ . ": user_touched = $user_touched, getUserTouched = " . $this->getUserTouched() . " \n", 3, "/tmp/moli.log" );
			if ( $user_touched != $this->getUserTouched() ) {
				$_key = wfSharedMemcKey( "user_touched", $this->getId() );
				wfDebug ( __METHOD__ . ": user touched is different on central and $wgDBcluster \n" );
				wfDebug ( __METHOD__ . ": clear $_key \n" );
				$wgMemc->set( $memkey, $this->getUserTouched() );
				$wgMemc->delete( $_key );
			} else {
				$User = $this->getLocalUser();
			}
		}

		wfDebug( __METHOD__ . ": return user object \n" );
		return is_null( $User );
	}

	public function getId() {
		wfDebug( __METHOD__ . ": " . $this->mRow->user_id . " \n" );
		return $this->mRow->user_id;
	}

	public function getName() {
		wfDebug( __METHOD__ . ": " . $this->mRow->user_name . " \n" );
		return $this->mRow->user_name;
	}

	public function getEmail() {
		wfDebug( __METHOD__ . ": " . $this->mRow->user_email . " \n" );
		return $this->mRow->user_email;
	}

	public function getEmailAuthentication() {
		wfDebug( __METHOD__ . ": " . $this->mRow->user_email_authenticated . " \n" );
		return $this->mRow->user_email_authenticated;
	}

	public function getUserTouched() {
		wfDebug( __METHOD__ . ": " . $this->mRow->user_touched . " \n" );
		return $this->mRow->user_touched;
	}

	public function getRealName() {
		wfDebug( __METHOD__ . ": " . $this->mRow->user_real_name . " \n" );
		return $this->mRow->user_real_name;
	}

	public function getPassword() {
		wfDebug( __METHOD__ . ": " . $this->mRow->user_password . " \n" );
		return $this->mRow->user_password;
	}

	public function getNewPassword() {
		wfDebug( __METHOD__ . ": " . $this->mRow->user_newpassword . " \n" );
		return $this->mRow->user_newpassword;
	}

	public function getOptions() {
		wfDebug( __METHOD__ . ": " . $this->mRow->user_options . " \n" );
		return $this->mRow->user_options;
	}

	public function getToken() {
		wfDebug( __METHOD__ . ": " . $this->mRow->user_token . " \n" );
		return $this->mRow->user_token;
	}

	public function getEmailToken() {
		wfDebug( __METHOD__ . ": " . $this->mRow->user_email_token . " \n" );
		return $this->mRow->user_token;
	}

	public function getEmailTokenExpires() {
		wfDebug( __METHOD__ . ": " . $this->mRow->user_email_token_expires . " \n" );
		return $this->mRow->user_email_token_expires;
	}

	public function getRegistration() {
		wfDebug( __METHOD__ . ": " . $this->mRow->user_registration . " \n" );
		return $this->mRow->user_registration;
	}

	public function getNewpassTime() {
		wfDebug( __METHOD__ . ": " . $this->mRow->user_newpass_time . " \n" );
		return $this->mRow->user_newpass_time;
	}

	public function getEditCount() {
		wfDebug( __METHOD__ . ": " . $this->mRow->user_editcount . " \n" );
		return $this->mRow->user_editcount;
	}

	public function getBirthdate() {
		wfDebug( __METHOD__ . ": " . $this->mRow->user_birthdate . " \n" );
		return $this->mRow->user_birthdate;
	}

	public function authenticate( $password ) {
		# This might be wrong if anyone actually uses the UserComparePasswords hook
		# (on either end), so don't use this if you those are incompatible.
		wfDebug( __METHOD__ . ": " . $this->getId() . " \n" );
		return User::comparePasswords( $this->getPassword(), $password, $this->getId() );
	}

	public function getPref( $pref ) {
		# we are using user_properties table - so no action is needed here
		wfDebug( __METHOD__ . " \n" );
		return null;
	}

	public function mapToUser() {
		wfDebug( __METHOD__ . " \n" );
		return User::newFromRow( $this->mRow );
	}

	protected function addToDatabase( $User, $password, $email, $realname ) {
		global $wgExternalSharedDB, $wgEnableUserLoginExt;
		wfProfileIn( __METHOD__ );

		if( wfReadOnly() ){ // Change to wgReadOnlyDbMode if we implement that
			wfDebug( __METHOD__ . ": Tried to add user to the $wgExternalSharedDB database while in wgReadOnly mode! " . $User->getName() . " (that's bad... fix the calling code)\n" );
		} else {
			wfDebug( __METHOD__ . ": add user to the $wgExternalSharedDB database: " . $User->getName() . " \n" );

			$dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );
			$seqVal = $dbw->nextSequenceValue( 'user_user_id_seq' );
			if ( empty($wgEnableUserLoginExt) ) {
				$User->setPassword( $password );
			}
			$User->setToken();

			$dbw->insert( '`user`',
				array(
					'user_id' => $seqVal,
					'user_name' => $User->mName,
					'user_password' => $User->mPassword,
					'user_newpassword' => $User->mNewpassword,
					'user_newpass_time' => $dbw->timestamp( $User->mNewpassTime ),
					'user_email' => $email,
					'user_email_authenticated' => $dbw->timestampOrNull( $User->mEmailAuthenticated ),
					'user_real_name' => $realname,
					'user_options' => '',
					'user_token' => $User->mToken,
					'user_registration' => $dbw->timestamp( $User->mRegistration ),
					'user_editcount' => 0,
					'user_birthdate' => $User->mBirthDate
				), __METHOD__, array('IGNORE')
			);
			$User->mId = $dbw->insertId();

			// Clear instance cache other than user table data, which is already accurate
			$User->clearInstanceCache();
		}

		wfProfileOut( __METHOD__ );
		return $User;
	}

	/**
	 * linkToLocal -- link central account to local account on every cluster
	 *
	 * @param Integer $id -- user identifier in user table on central database
	 *
	 * @author Piotr Molski (moli) <moli@wikia-inc.com>
	 */
	public function linkToLocal( $id ) {
		wfProfileIn( __METHOD__ );

		if ( empty( $this->mRow ) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

error_log( __METHOD__ . ": id = $id \n", 3, "/tmp/moli.log" );

		if ( ( '' == $this->getToken() ) && ( '' == $this->getEmail() ) && ( ! $this->getEmailToken() ) ) {
error_log( __METHOD__ . ": don't copy - token, email and emailtoken is empty \n", 3, "/tmp/moli.log" );
			wfProfileOut( __METHOD__ );
			return false;
		}

		wfDebug( __METHOD__ . ": update local user table: $id \n" );

		if ( $id != $this->getId() ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

error_log( __METHOD__ . ": copy to local cluster \n", 3, "/tmp/moli.log" );

		if( !wfReadOnly() ){ // Change to wgReadOnlyDbMode if we implement that
			$dbw = wfGetDB( DB_MASTER );
			$data = array();
			foreach ( ( array )$this->mRow as $field => $value ) {
				$data[ $field ] = $value;
			}

			$row = $dbw->selectRow( 'user', array( '*' ), array( 'user_id' => $this->getId() ), __METHOD__ );

			if ( empty( $row ) ) {
				$dbw->insert( 'user', $data, __METHOD__, array('IGNORE') );
			} else {
				$need_update = false;
				foreach ( $row as $field => $value ) {
					if ( isset( $data[$field] ) && ( $data[$field] != $value ) )  {
						$need_update = true;
					}
				}

				if ( $need_update ) {
					$dbw->update( 'user', $data, array( 'user_id' => $this->getId() ), __METHOD__ );
					$dbw->commit();
				}
			}
		}

		wfProfileOut( __METHOD__ );
	}

	public function getLocalUser( $obj = true ) {
		wfProfileIn( __METHOD__ );
		
		if ( empty( $this->mRow ) ) {
			wfProfileOut( __METHOD__ );
			return null;
		}

		if ( $obj ) {
			$res = User::newFromRow( $this->mRow );
		} else {
			$res = $this->mRow;
		}

		wfProfileOut( __METHOD__ );
		return $res;
	}

	public function updateUser() {
		global $wgExternalSharedDB;
		wfProfileIn( __METHOD__ );

		if( wfReadOnly() ){ // Change to wgReadOnlyDbMode if we implement that
			wfDebug( __METHOD__ . ": tried to updateUser while in read-only mode.\n" );
		} else {
			wfDebug( __METHOD__ . ": update central user data \n" );

			$dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );
			$this->mUser->mTouched = User::newTouchedTimestamp();
			$dbw->update( '`user`',
				array( /* SET */
					'user_name' => $this->mUser->mName,
					'user_password' => $this->mUser->mPassword,
					'user_newpassword' => $this->mUser->mNewpassword,
					'user_newpass_time' => $dbw->timestampOrNull( $this->mUser->mNewpassTime ),
					'user_real_name' => $this->mUser->mRealName,
					'user_email' => $this->mUser->mEmail,
					'user_email_authenticated' => $dbw->timestampOrNull( $this->mUser->mEmailAuthenticated ),
					'user_options' => '',
					'user_touched' => $dbw->timestamp( $this->mUser->mTouched ),
					'user_token' => $this->mUser->mToken,
					'user_email_token' => $this->mUser->mEmailToken,
					'user_email_token_expires' => $dbw->timestampOrNull( $this->mUser->mEmailTokenExpires ),
				), array( /* WHERE */
					'user_id' => $this->mUser->mId
				), __METHOD__
			);
			$dbw->commit();
		}
		wfProfileOut( __METHOD__ );
	}

	/**
	 * Removes user info from secondary clusters so that it can be regenerated from scratch
	 *
	 * @author mix
	 * @author tor
	 */
	public static function removeFromSecondaryClusters( $id ) {
		global $wgMemc;

		wfProfileIn( __METHOD__ );
		$clusters = WikiFactory::getSecondaryClusters(); // wikicities with a c1 .. cx cluster suffix.

		foreach ($clusters as $clusterName) {
			// This is a classic double-check. I do not want to delete the record from the primary cluster.
			// No, really! I do not.
			if ( RenameUserHelper::CLUSTER_DEFAULT != $clusterName ) {
				$memkey = sprintf("extuser:%d:%s", $id, $clusterName);
				$clusterName = 'wikicities_' . $clusterName;

				$oDB = wfGetDB( DB_MASTER, array(), $clusterName );
				$oDB->delete(
					'`user`',
					array( 'user_id' => $id ),
					__METHOD__
				);
				$oDB->commit();

				$wgMemc->delete( $memkey );
			}
		}
		wfProfileOut( __METHOD__ );
	}
}
