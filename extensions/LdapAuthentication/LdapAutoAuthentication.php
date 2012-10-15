<?php

class LdapAutoAuthentication {

	/**
	 * Does the web server authentication piece of the LDAP plugin.
	 *
	 * @param $user User
	 * @param $result bool
	 * @return bool
	 */
	public static function Authenticate( $user, &$result = null ) {
		/**
		 * @var $wgAuth LdapAuthenticationPlugin
		 */
		global $wgAuth;

		$wgAuth->printDebug( "Entering AutoAuthentication.", NONSENSITIVE );

		if ( $user->isLoggedIn() ) {
			$wgAuth->printDebug( "User is already logged in.", NONSENSITIVE );
			return true;
		}

		$wgAuth->printDebug( "User isn't logged in, calling setup.", NONSENSITIVE );

		// Let regular authentication plugins configure themselves for auto
		// authentication chaining
		$wgAuth->autoAuthSetup();

		$autoauthname = $wgAuth->getConf( 'AutoAuthUsername' );
		$wgAuth->printDebug( "Calling authenticate with username ($autoauthname).", NONSENSITIVE );

		// The user hasn't already been authenticated, let's check them
		$authenticated = $wgAuth->authenticate( $autoauthname, '' );
		if ( !$authenticated ) {
			// If the user doesn't exist in LDAP, there isn't much reason to
			// go any further.
			$wgAuth->printDebug( "User wasn't found in LDAP, exiting.", NONSENSITIVE );
			return false;
		}

		// We need the username that MediaWiki will always use, not necessarily the one we
		// get from LDAP.
		$mungedUsername = $wgAuth->getCanonicalName( $autoauthname );

		$wgAuth->printDebug( "User exists in LDAP; finding the user by name ($mungedUsername) in MediaWiki.", NONSENSITIVE );
		$localId = User::idFromName( $mungedUsername );
		$wgAuth->printDebug( "Got id ($localId).", NONSENSITIVE );

		// Is the user already in the database?
		if ( !$localId ) {
			$userAdded = self::attemptAddUser( $user, $mungedUsername );
			if ( !$userAdded ) {
				$result = false;
				return false;
			}
		} else {
			$wgAuth->printDebug( "User exists in local database, logging in.", NONSENSITIVE );
			$user->setID( $localId );
			$user->loadFromId();
			$user->setCookies();
			$wgAuth->updateUser( $user );
			wfSetupSession();
			$result = true;
		}

		return true;
	}

	/**
	 * @param $user User
	 * @param $mungedUsername String
	 * @return bool
	 */
	public static function attemptAddUser( $user, $mungedUsername ) {
		/**
		 * @var $wgAuth LdapAuthenticationPlugin
		 */
		global $wgAuth;

		if ( !$wgAuth->autoCreate() ) {
			$wgAuth->printDebug( "Cannot automatically create accounts.", NONSENSITIVE );
			return false;
		}

		$wgAuth->printDebug( "User does not exist in local database; creating.", NONSENSITIVE );
		// Checks passed, create the user
		$user->loadDefaults( $mungedUsername );
		$user->addToDatabase();
		$wgAuth->initUser( $user, true );
		$user->setCookies();
		wfSetupSession();
		# Update user count
		$ssUpdate = new SiteStatsUpdate( 0, 0, 0, 0, 1 );
		$ssUpdate->doUpdate();
		# Notify hooks (e.g. Newuserlog)
		wfRunHooks( 'AuthPluginAutoCreate', array( $user ) );

		return true;
	}

	/**
	 * No logout link in MW
	 * @param $personal_urls array
	 * @param $title Title
	 * @return bool
	 */
	public static function NoLogout( &$personal_urls, $title ) {
		/**
		 * @var $wgAuth LdapAuthenticationPlugin
		 */
		global $wgAuth;

		$wgAuth->printDebug( "Entering NoLogout.", NONSENSITIVE );
		unset( $personal_urls['logout'] );
		return true;
	}

}
