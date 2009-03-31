<?php

/**
 * "Attached" accounts always require authentication against the central password.
 *
 * "Unattached" accounts may be allowed to login on the local password if
 *   $wgCentralAuthStrict is not set, but they will not have access to any
 *   central password or settings.
 */
class CentralAuthPlugin extends AuthPlugin {

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
		$central = new CentralAuthUser( $username );
		return $central->exists();
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
		global $wgCentralAuthAutoMigrate;

		$central = new CentralAuthUser( $username );
		if( !$central->exists() ) {
			wfDebugLog( 'CentralAuth',
				"plugin: no global account for '$username'" );
			return false;
		}

		$passwordMatch = $central->authenticate( $password ) == "ok";

		if( $passwordMatch && $wgCentralAuthAutoMigrate ) {
			// If the user passed in the global password, we can identify
			// any remaining local accounts with a matching password
			// and migrate them in transparently.
			//
			// That may or may not include the current wiki.
			//
			$central->attemptPasswordMigration( $password );
		}

		// Several possible states here:
		//
		// global exists, local exists, attached: require global auth
		// global exists, local exists, unattached: require LOCAL auth to login
		// global exists, local doesn't exist: require global auth -> will autocreate local
		// global doesn't exist, local doesn't exist: no authentication
		//
		if( !$central->isAttached() ) {
			$local = User::newFromName( $username );
			if( $local && $local->getId() ) {
				// An unattached local account; central authentication can't
				// be used until this account has been transferred.
				// $wgCentralAuthStrict will determine if local login is allowed.
				wfDebugLog( 'CentralAuth',
					"plugin: unattached account for '$username'" );
				return false;
			}
		}

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
		$central = new CentralAuthUser( $username );
		return $central->exists() && $central->isAttached();
	}

	/**
	 * When a user logs in, optionally fill in preferences and such.
	 * For instance, you might pull the email address or real name from the
	 * external user database.
	 *
	 * The User object is passed by reference so it can be modified; don't
	 * forget the & on your function declaration.
	 *
	 * @param User $user
	 * @public
	 */
	function updateUser( &$user ) {
		$central = CentralAuthUser::getInstance( $user );
		if ( $central->exists() && $central->isAttached() ) {
			$user->setEmail( $central->getEmail() );
			$user->mEmailAuthenticated = $central->getEmailAuthenticationTimestamp();
			$user->saveSettings();
		}
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
	 * @param $user User object.
	 * @param $password String: password.
	 * @return bool
	 * @public
	 */
	function setPassword( $user, $password ) {
		// Fixme: password changes should happen through central interface.
		$central = CentralAuthUser::getInstance( $user );
		if( $central->isAttached() ) {
			return $central->setPassword( $password );
		} else {
			// Not attached, local password is set only
			return true;
		}
	}

	/**
	 * Update user information in the external authentication database.
	 * Return true if successful.
	 *
	 * @param $user User object.
	 * @return bool
	 * @public
	 */
	function updateExternalDB( $user ) {
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
	 * @param User $user - only the name should be assumed valid at this point
	 * @param string $password
	 * @param string $email
	 * @param string $realname
	 * @return bool
	 * @public
	 */
	function addUser( $user, $password, $email='', $realname='' ) {
		global $wgCentralAuthAutoNew;
		if( $wgCentralAuthAutoNew ) {
			$central = CentralAuthUser::getInstance( $user );
			if( !$central->exists() && !$central->listUnattached() ) {
				// Username is unused; set up as a global account
				// @fixme is this even vaguely reliable? pah
				$central->register( $password, $email, $realname );
				$central->attach( wfWikiID(), 'new' );
			}
		}
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
		global $wgCentralAuthStrict;
		return $wgCentralAuthStrict;
	}

	/**
	 * When creating a user account, optionally fill in preferences and such.
	 * For instance, you might pull the email address or real name from the
	 * external user database.
	 *
	 * The User object is passed by reference so it can be modified; don't
	 * forget the & on your function declaration.
	 *
	 * @param $user User object.
	 * @public
	 */
	function initUser( &$user, $autocreate=false ) {
		if( $autocreate ) {
			$central = CentralAuthUser::getInstance( $user );
			if( $central->exists() ) {
				$central->attach( wfWikiID(), 'login' );
				$central->addLocalName( wfWikiID() );
				$this->updateUser( $user );
			}
		}
	}
	
	public function getUserInstance( User &$user ) {
		return CentralAuthUser::getInstance( $user );
	}
}
