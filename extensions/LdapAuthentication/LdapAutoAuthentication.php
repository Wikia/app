<?php

class LdapAutoAuthentication {

	/**
	 * Does the web server authentication piece of the LDAP plugin.
	 *
	 * @access public
	 */
	static function Authenticate( $user, &$result ) {
	        global $wgUser;
	        global $wgAuth;
		global $wgLDAPAutoAuthUsername;
		global $wgVersion;
	
	        $wgAuth->printDebug( "Entering AutoAuthentication.", NONSENSITIVE );

		if ( version_compare( $wgVersion, '1.14.0', '<' ) ) {
			//The following section is a hack to determine whether or not
			//the user is logged in. We need a core fix to make this simpler.
			if ( isset( $_SESSION['wsUserID'] ) ) {
				$user->setID( $_SESSION['wsUserID'] );
				if ( $user->loadFromId() ) {
					if ( $_SESSION['wsToken'] == $user->mToken  && $_SESSION['wsUserName'] == $user->mName ) {
				                $wgAuth->printDebug( "User is already logged in.", NONSENSITIVE );
						$result = true;
				                return true;
				        } else {
						$user->loadDefaults();
					}
				}
			}
		} else {
			if ( $user->isLoggedIn() ) {
				$wgAuth->printDebug( "User is already logged in.", NONSENSITIVE );
				return true;
			}
		}
	
	        $wgAuth->printDebug( "User isn't logged in, calling setup.", NONSENSITIVE );
	
	        //Let regular authentication plugins configure themselves for auto
	        //authentication chaining
	        $wgAuth->autoAuthSetup();
	
	        $wgAuth->printDebug( "Calling authenticate with username ($wgLDAPAutoAuthUsername).", NONSENSITIVE );
	        //The user hasn't already been authenticated, let's check them
	        $authenticated = $wgAuth->authenticate( $wgLDAPAutoAuthUsername );
	        if ( !$authenticated ) {
	                //If the user doesn't exist in LDAP, there isn't much reason to
	                //go any further.
	                $wgAuth->printDebug("User wasn't found in LDAP, exiting.", NONSENSITIVE );
	                return false;
	        }
	
	        //We need the username that MediaWiki will always use, *not* the one we
	        //get from LDAP.
	        $mungedUsername = $wgAuth->getCanonicalName( $wgLDAPAutoAuthUsername );
	
	        $wgAuth->printDebug( "User exists in LDAP; finding the user by name ($mungedUsername) in MediaWiki.", NONSENSITIVE );
	
		$localId = User::idFromName( $mungedUsername );
	        $wgAuth->printDebug( "Got id ($localId).", NONSENSITIVE );
	
	        //Is the user already in the database?
	        if( !$localId ) {
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

	static function attemptAddUser( $user, $mungedUsername ) {
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

	/* No logout link in MW */
	static function NoLogout( &$personal_urls, $title ) {
	        global $wgAuth;
	        $wgAuth->printDebug( "Entering NoLogout.", NONSENSITIVE );
	
	        $personal_urls['logout'] = null;
	
	        return true;
	}
}
