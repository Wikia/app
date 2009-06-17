<?php

/**
 * "Attached" accounts always require authentication against the central password.
 *
 * "Unattached" accounts may be allowed to login on the local password if
 *   $wgWikiaCentralAuthStrict is not set, but they will not have access to any
 *   central password or settings.
 */
class WikiaCentralAuthPlugin extends AuthPlugin {

	public function getUserInstance( User &$oUser ) {
		return WikiaCentralAuthUser::getInstance( $oUser );
	}

	/**
	 * Check whether there exists a user account with the given name.
	 * The name will be normalized to MediaWiki's requirements, so
	 * you might need to munge it (for instance, for lowercase initial
	 * letters).
	 *
	 * @param $username String: username.
	 * @return bool
	 * @public
	 */
	function userExists( $username ) {
		wfProfileIn( __METHOD__ );
		$oCUser = new WikiaCentralAuthUser( $username );
		$exists = $oCUser->exists();
		wfDebug( __METHOD__ . ": check username {$username} exists - {$exists} \n" );
		wfProfileOut( __METHOD__ );
		return $exists;
	}

	/**
	 * Check if a username+password pair is a valid login.
	 * The name will be normalized to MediaWiki's requirements, so
	 * you might need to munge it (for instance, for lowercase initial
	 * letters).
	 *
	 * @param $username String: username.
	 * @param $password String: user password.
	 * @return bool
	 * @public
	 */
	function authenticate( $username, $password ) {
		global $wgWikiaCentralAuthAutoMigrate;
		wfProfileIn( __METHOD__ );
		$oCUser = new WikiaCentralAuthUser( $username );
		if( !$oCUser->exists() ) {
			wfDebug( __METHOD__ . ": plugin: no global account for '$username' \n" );
			wfProfileOut( __METHOD__ );
			return false;
		}

		$passwordMatch = $oCUser->authenticate( $password ) == "ok";

		if( !$oCUser->isAttached() ) {
			wfDebug( __METHOD__ . ": plugin: unattached account for '$username' \n" );
			wfProfileOut( __METHOD__ );
			return false;
		}
		
		wfProfileOut( __METHOD__ );
		return $passwordMatch;
	}

	/**
	 * Check if a user should authenticate locally if the global authentication fails.
	 * If either this or strict() returns true, local authentication is not used.
	 *
	 * @param $username String: username.
	 * @return bool
	 * @public
	 */
	function strictUserAuth( $username ) {
		// Authenticate locally if the global account doesn't exist,
		// or the local account isn't attached
		// If strict is on, local authentication won't work at all
		wfProfileIn( __METHOD__ );
		$oCUser = new WikiaCentralAuthUser( $username );
		$res = $oCUser->exists() && $oCUser->isAttached();
		wfProfileOut( __METHOD__ );
		return $res;
	}

	/**
	 * When a user logs in, optionally fill in preferences and such.
	 * For instance, you might pull the email address or real name from the
	 * external user database.
	 *
	 * The User object is passed by reference so it can be modified; don't
	 * forget the & on your function declaration.
	 *
	 * @param User $oUser
	 * @public
	 */
	function updateUser( User &$oUser ) {
		wfProfileIn( __METHOD__ );
		$oCUser = $this->getUserInstance( $oUser );
		wfDebug( __METHOD__ . ": update local user information from central auth : '{$oUser->getName()}' \n" );
		if ( $oCUser->exists() && $oCUser->isAttached() ) {
			#--- set global ID
			$oCUser->invalidateLocalUser($oUser);
			#--- save settings
			$oUser->saveSettings();
		}
		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Return true if the wiki should create a new local account automatically
	 * when asked to login a user who doesn't exist locally but does in the
	 * external auth database.
	 *
	 * If you don't automatically create accounts, you must still create
	 * accounts in some way. It's not possible to authenticate without
	 * a local account.
	 *
	 * This is just a question, and shouldn't perform any actions.
	 *
	 * @return bool
	 * @public
	 */
	function autoCreate() {
		global $wgGroupPermissions;
		// Yes unless account creation is restricted on this wiki
		return !empty( $wgGroupPermissions['*']['createaccount'] );
	}

	/**
	 * Set the given password in the authentication database.
	 * Return true if successful.
	 *
	 * @param $oUser User object.
	 * @param $password String: password.
	 * @return bool
	 * @public
	 */
	function setPassword( User &$oUser, $password ) {
		// Fixme: password changes should happen through central interface.
		wfProfileIn( __METHOD__ );
		$oCUser = $this->getUserInstance( $oUser );
		wfDebug( __METHOD__ . ": set password for user : '{$oUser->getName()}' \n" );
		if( $oCUser->isAttached() ) {
			$oCUser->setPassword( $password );
			$oCUser->invalidateLocalUser($oUser);
		} else {
			// Not attached, local password is set only
			wfProfileOut( __METHOD__ );
			return true;
		}
		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Update user information in the external authentication database.
	 * Return true if successful.
	 *
	 * @param $oUser User object.
	 * @return bool
	 * @public
	 */
	function updateExternalDB( User $oUser ) {
		return true;
	}

	/**
	 * Check to see if external accounts can be created.
	 * Return true if external accounts can be created.
	 * @return bool
	 * @public
	 */
	function canCreateAccounts() {
		// Require accounts to be created through the central login interface?
		return true;
	}

	/**
	 * Add a user to the external authentication database.
	 * E-mail and real name addresses are provided by the
	 * registering user, and may or may not be accepted.
	 *
	 * Return true if successful.
	 *
	 * @param User $oUser - only the name should be assumed valid at this point
	 * @param string $password
	 * @param string $email
	 * @param string $realname
	 * @return bool
	 * @public
	 */
	function addUser( User $oUser, $password, $email='', $realname='' ) {
		global $wgWikiaCentralAuthAutoNew;
		wfProfileIn( __METHOD__ );
		if( $wgWikiaCentralAuthAutoNew ) {
			$oCUser = $this->getUserInstance( $oUser );
			if( !$oCUser->exists() ) {
				// Username is unused; set up as a global account
				// @fixme is this even vaguely reliable? pah
				wfDebug( __METHOD__ . ": add new central user : '{$oUser->getName()}' \n" );
				$oCUser->addUser( $password, $email, $realname );
			}
		}
		wfProfileOut( __METHOD__ );
		return true;
	}


	/**
	 * Return true to prevent logins that don't authenticate here from being
	 * checked against the local database's password fields.
	 *
	 * This is just a question, and shouldn't perform any actions.
	 *
	 * @return bool
	 * @public
	 */
	function strict() {
		global $wgWikiaCentralAuthStrict;
		return $wgWikiaCentralAuthStrict;
	}

	/**
	 * When creating a user account, optionally fill in preferences and such.
	 * For instance, you might pull the email address or real name from the
	 * external user database.
	 *
	 * The User object is passed by reference so it can be modified; don't
	 * forget the & on your function declaration.
	 *
	 * @param $oUser User object.
	 * @public
	 */
	function initUser( User &$oUser, $autocreate=false ) {
		wfProfileIn( __METHOD__ );
		#if( $autocreate ) {
			$oCUser = $this->getUserInstance( $oUser );
			wfDebug( __METHOD__ . ": init central user and add to local table: '{$oUser->getName()}' \n" );
			if( $oCUser->exists() ) {
				$oCUser->addToLocalDB();
				$this->updateUser( $oUser );
			}
		#}
		wfProfileOut( __METHOD__ );
	}
}
