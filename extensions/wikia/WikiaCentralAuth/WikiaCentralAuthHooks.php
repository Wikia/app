<?php

class WikiaCentralAuthHooks {
	static function onAuthPluginSetup( &$auth ) {
		$auth = new StubObject( 'wgAuth', 'WikiaCentralAuthPlugin' );
		return true;
	}

	/**
	 * Make sure migration information in localuser table is populated
	 * on local account creation
	 */
	static function onAddNewAccount( User $oUser, $addByEmail = false ) {
        if ( wfReadOnly() ) {
			wfDebug( __METHOD__ . ": Cannot save user to local DB - DB is running with the --read-only option " );
            return true;
        }

		wfProfileIn( __METHOD__ );
		if ( $addByEmail === false) {
			$oCUser = WikiaCentralAuthUser::getInstance( $oUser );
			$oCUser->addToLocalDB();
		}
		wfProfileOut( __METHOD__ );
		return true;
	}

	static function onAbortNewAccount( User $oUser, &$abortError ) {
		wfProfileIn( __METHOD__ );
		$centralUserId = WikiaCentralAuthUser::idFromUser( $oUser );
		$res = true;
		if ( $centralUserId !=0 ) {
			wfDebug( __METHOD__ . ": central user exists so abort creation \n" );
			$abortError = wfMsg( 'userexists' );
			$res = false;
		}
		wfProfileOut( __METHOD__ );
		return $res;
	}

	static function onUserLoadFromSession_old( User $oUser, &$result ) {
		global $wgWikiaCentralAuthCookies, $wgWikiaCentralAuthCookiePrefix;
		wfProfileIn( __METHOD__ );
		if( !$wgWikiaCentralAuthCookies ) {
			// Use local sessions only.
			wfDebug( __METHOD__ . ": central cookies authentication is disabled \n" );
			wfProfileOut( __METHOD__ );
			return true;
		}
		$prefix = $wgWikiaCentralAuthCookiePrefix;

		if( $oUser->isLoggedIn() ) {
			// Already logged in; don't worry about the global session.
			wfDebug( __METHOD__ . ": user is logged in \n" );
			wfProfileOut( __METHOD__ );
			return true;
		}

		if (isset($_COOKIE["{$prefix}UserID"]) && isset($_COOKIE["{$prefix}Token"])) {
			$userName = $_COOKIE["{$prefix}UserID"];
			$token = $_COOKIE["{$prefix}Token"];
		} elseif ( (bool)( $session = WikiaCentralAuthUser::getSession() ) ) {
			$token = $session['wsAuthToken'];
			$userName = $session['wsAuthUser'];
		} else {
			wfDebug( __METHOD__ .": no token or session\n \n" );
			wfProfileOut( __METHOD__ );
			return true;
		}

		$oCUser = new WikiaCentralAuthUser( $userName );
		$localId = User::idFromName( $userName );

		if ( $oCUser->authenticateWithToken( $token ) != 'ok' ) {
			wfDebug( __METHOD__ .": token mismatch\n \n" );
		} elseif ( !$oCUser->isAttached() && $localId ) {
			wfDebug( __METHOD__ .": exists, and not attached\n" );
		} else {
			if ( !$localId ) {
				// User does not exist locally, attempt to create it
				if ( !self::attemptAddUser( $oUser, $userName ) ) {
					// Can't create user, give up now
					wfProfileOut( __METHOD__ );
					return true;
				}
			} else {
				$oUser->setID( $localId );
				$oUser->loadFromId();
			}
			// Auth OK.
			wfDebug( __METHOD__ .": logged in from session\n" );
			self::initSession( $oUser, $token );
			$oUser->centralAuth = $oCUser;
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	static function onUserLoadFromSession( User $oUser, &$result ) {
		global $wgCookiePrefix;
        if ( wfReadOnly() ) {
			wfDebug( __METHOD__ . ": Cannot load from session - DB is running with the --read-only option " );
            return true;
        }

		wfProfileIn( __METHOD__ );

		if( $oUser->isLoggedIn() ) {
			// Already logged in; don't worry about the global session.
			wfDebug( __METHOD__ . ": user is logged in \n" );
			wfProfileOut( __METHOD__ );
			return true;
		}

		if ( isset( $_COOKIE["{$wgCookiePrefix}UserID"] ) ) {
			$sId = intval( $_COOKIE["{$wgCookiePrefix}UserID"] );
			if( isset( $_SESSION['wsUserID'] ) && $sId != $_SESSION['wsUserID'] ) {
				wfDebug( __METHOD__ . ": Session user ID ({$_SESSION['wsUserID']}) and cookie user ID ($sId) don't match!" );
				wfProfileOut( __METHOD__ );
				return true;
			}
			$_SESSION['wsUserID'] = $sId;
		} else if ( isset( $_SESSION['wsUserID'] ) ) {
			if ( $_SESSION['wsUserID'] != 0 ) {
				$sId = $_SESSION['wsUserID'];
			} else {
				wfProfileOut( __METHOD__ );
				return true;
			}
		} else {
			wfProfileOut( __METHOD__ );
			return true;
		}

		$sName = "";
		if ( isset( $_SESSION['wsUserName'] ) ) {
			$sName = $_SESSION['wsUserName'];
		} else if ( isset( $_COOKIE["{$wgCookiePrefix}UserName"] ) ) {
			$sName = $_COOKIE["{$wgCookiePrefix}UserName"];
			$_SESSION['wsUserName'] = $sName;
		}

		if ( empty( $sName ) ) {
			wfDebug( __METHOD__ .": username doesn't exists \n" );
			wfProfileOut( __METHOD__ );
			return true;
		}

		$oCUser = new WikiaCentralAuthUser( $sName );
		$localId = User::idFromName( $sName );

		if ( empty($localId) ) {
			$localId = $oCUser->idFromName();
		}
		
		if ( empty($_SESSION['wsUserId']) && !empty($localId) ) {
			$_SESSION['wsUserId'] = $localId;
		}

		if ( !$oCUser->isAttached() && $localId ) {
			wfDebug( __METHOD__ .": exists, and not attached \n" );
			wfProfileOut( __METHOD__ );
			return true;
		} else {
			if ( !empty($sName) && !$localId ) {
				// User does not exist locally, attempt to create it
				if ( !self::attemptAddUser( $oUser, $sName ) ) {
					// Can't create user, give up now
					wfProfileOut( __METHOD__ );
					return true;
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	static function onUserLogout( User &$oUser ) {
		global $wgWikiaCentralAuthCookies;

        if ( wfReadOnly() ) {
			wfDebug( __METHOD__ . ": DB is running with the --read-only option " );
            return true;
        }

		wfProfileIn( __METHOD__ );
		if( !$wgWikiaCentralAuthCookies ) {
			// Use local sessions only.
			wfDebug( __METHOD__ . ": central cookies auth is disabled \n" );
			wfProfileOut( __METHOD__ );
			return true;
		}
		$oCUser = WikiaCentralAuthUser::getInstance( $oUser );

		if ($oCUser->exists()) {
			$oCUser->deleteGlobalCookies();
			$oCUser->resetAuthToken();
			$oCUser->quickInvalidateCache();
		}
		wfProfileOut( __METHOD__ );
		return true;
	}

	static function onGetCacheVaryCookies( $out, &$cookies ) {
		global $wgWikiaCentralAuthCookiePrefix;
		wfProfileIn( __METHOD__ );
		$cookies[] = $wgWikiaCentralAuthCookiePrefix . 'Token';
		$cookies[] = $wgWikiaCentralAuthCookiePrefix . 'Session';
		$cookies[] = $wgWikiaCentralAuthCookiePrefix . 'LoggedOut';
		wfProfileOut( __METHOD__ );
		return true;
	}

	static function onUserArrayFromResult( &$userArray, $res ) {
		wfProfileIn( __METHOD__ );
		$userArray = WikiaCentralAuthUserArray::newFromResult( $res );
		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Helper function for onUserLoadFromSession
	 */
	static function initSession( User $oUser, $token ) {
		global $wgAuth;
        if ( wfReadOnly() ) {
			wfDebug( __METHOD__ . ": DB is running with the --read-only option " );
            return true;
        }
		wfProfileIn( __METHOD__ );
		$userName = $oUser->getName();
		wfSetupSession();
		if ($token != @$_SESSION['globalloggedin'] ) {
			$_SESSION['globalloggedin'] = $token;
			$oUser->invalidateCache();
			wfDebug( __METHOD__ .": Initialising session for $userName with token $token.\n" );
		} else {
			wfDebug( __METHOD__ .": Session already initialised for $userName with token $token.\n" );
		}
		wfProfileOut( __METHOD__ );
	}

	/**
	 * Attempt to add a user to the database
	 * Does the required authentication checks and updates for auto-creation
	 * @param User $user
	 * @return bool Success
	 */
	static function attemptAddUser( User $oUser, $userName ) {
		global $wgAuth, $wgWikiaCentralAuthCreateOnView;

        if ( wfReadOnly() ) {
			wfDebug( __METHOD__ . ": DB is running with the --read-only option " );
            return false;
        }

		wfProfileIn( __METHOD__ );
		// Denied by configuration?
		if ( !$wgAuth->autoCreate() ) {
			wfDebug( __METHOD__ .": denied by configuration\n" );
			wfProfileOut( __METHOD__ );
			return false;
		}

		if ( !$wgWikiaCentralAuthCreateOnView ) {
			// Only create local accounts when we perform an active login...
			// Don't freak people out on every page view
			wfDebug( __METHOD__ .": denied by \$wgWikiaCentralAuthCreateOnView\n" );
			wfProfileOut( __METHOD__ );
			return false;
		}

		// Is the user blacklisted by the session?
		// This is just a cache to avoid expensive DB queries in $oUser->isAllowedToCreateAccount().
		// The user can log in via Special:UserLogin to bypass the blacklist and get a proper
		// error message.
		/*$session = WikiaCentralAuthUser::getSession();
		if ( isset( $session['auto-create-blacklist'] ) && in_array( wfWikiID(), (array)$session['auto-create-blacklist'] ) ) {
			wfDebug( __METHOD__ .": blacklisted by session\n" );
			return false;
		}*/

		// Is the user blocked?
		$anon = new User;
		if ( !$anon->isAllowedToCreateAccount() ) {
			// Blacklist the user to avoid repeated DB queries subsequently
			// First load the session again in case it changed while the above DB query was in progress
			wfDebug( __METHOD__ .": user is blocked from this wiki, blacklisting\n" );
			$session = WikiaCentralAuthUser::getSession();
			$session['auto-create-blacklist'][] = wfWikiID();
			WikiaCentralAuthUser::setSession( $session );
			wfProfileOut( __METHOD__ );
			return false;
		}

		// Checks passed, create the user
		wfDebug( __METHOD__ .": creating new user\n" );
		$oUser->loadDefaults( $userName );
		$oUser->addToDatabase();

		$wgAuth->initUser( $oUser, true );
		$wgAuth->updateUser( $oUser );

		# Update user count
		$ssUpdate = new SiteStatsUpdate( 0, 0, 0, 0, 1 );
		$ssUpdate->doUpdate();

		# Notify hooks (e.g. Newuserlog)
		wfRunHooks( 'AuthPluginAutoCreate', array( $oUser ) );
		$oUser->addNewUserLogEntryAutoCreate();
		wfProfileOut( __METHOD__ );
		return true;
	}

	static function onUserGetEmail( User $oUser, &$email ) {
		wfProfileIn( __METHOD__ );
		if ( empty($email) ) {
			$ca = WikiaCentralAuthUser::getInstance( $oUser );
			if ( $ca->isAttached() ) {
				$email = $ca->getEmail();
			}
		}
		wfProfileOut( __METHOD__ );
		return true;
	}

	static function onUserGetEmailAuthenticationTimestamp( User $oUser, &$timestamp ) {
		wfProfileIn( __METHOD__ );
		$ca = WikiaCentralAuthUser::getInstance( $oUser );
		if ( $ca->isAttached() ) {
			$timestamp = $ca->getEmailAuthenticationTimestamp();
		}
		wfProfileOut( __METHOD__ );
		return true;
	}

	static function onUserSetEmail( User $oUser, &$email ) {
		wfProfileIn( __METHOD__ );
		$ca = WikiaCentralAuthUser::getInstance( $oUser );
		if ( $ca->isAttached() ) {
			$ca->setEmail( $email );
		}
		wfProfileOut( __METHOD__ );
		return true;
	}

	static function onUserSaveSettings( User $oUser ) {
		wfProfileIn( __METHOD__ );
		$ca = WikiaCentralAuthUser::getInstance( $oUser );
		if ( $ca->isAttached() ) {
			wfDebug( __METHOD__ . ": save settings of user: {$oUser->getName()} \n" );
			$ca->invalidateCentralUser( $oUser );
			$ca->resetAuthToken($oUser->mToken);
			$ca->invalidateCache();
		}
		wfProfileOut( __METHOD__ );
		return true;
	}

	static function onUserSetEmailAuthenticationTimestamp( User $oUser, &$timestamp ) {
		wfProfileIn( __METHOD__ );
		$ca = WikiaCentralAuthUser::getInstance( $oUser );
		if ( $ca->isAttached() ) {
			wfDebug( __METHOD__ . ": set email authentication timestamp of user: {$oUser->getName()} \n" );
			$ca->setEmailAuthenticationTimestamp( $timestamp );
		}
		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Destroy local login cookies so that remote logout works
	 */
	static function onUserSetCookies( User $oUser, &$session, &$cookies ) {
		global $wgWikiaCentralAuthCookies, $wgWikiaCentralAuthCookieDomain;
		wfProfileIn( __METHOD__ );
		if ( !$wgWikiaCentralAuthCookies || $oUser->isAnon() ) {
			wfDebug( __METHOD__ . ": central cookies authentication is disabled \n" );
			wfProfileOut( __METHOD__ );
			return true;
		}
		$oCUser = WikiaCentralAuthUser::getInstance( $oUser );
		if ( !$oCUser->isAttached() ) {
			wfDebug( __METHOD__ . ": central user is not attached \n" );
			wfProfileOut( __METHOD__ );
			return true;
		}

		if ( !empty( $cookies['Token'] ) ) {
			unset( $cookies['Token'] );
			$remember = true;
		} else {
			$remember = false;
		}
		$oCUser->setGlobalCookies( $session, $remember );
		wfDebug( __METHOD__ . ": set central cookies \n" );
		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Use the central LoggedOut cookie just like the local one
	 */
	static function onUserLoadDefaults( $oUser, $name ) {
		global $wgWikiaCentralAuthCookiePrefix;
		wfProfileIn( __METHOD__ );
		if ( !empty($name) ) {
			$oCUser = WikiaCentralAuthUser::getInstance( $oUser );
			if ( $oCUser->exists() && $oCUser->isAttached() ) {
				$oCUser->invalidateLocalUser($oUser, true);
			}
		}
		if ( isset( $_COOKIE[$wgWikiaCentralAuthCookiePrefix.'LoggedOut'] ) ) {
			wfDebug( __METHOD__ . ": set user touched date \n" );
			$oUser->mTouched = wfTimestamp( TS_MW, $_COOKIE[$wgWikiaCentralAuthCookiePrefix.'LoggedOut'] );
		}
		wfProfileOut( __METHOD__ );
		return true;
	}

	static function onGetUserPermissionsErrorsExpensive( $title, User $oUser, $action, &$result ) {
		wfProfileIn( __METHOD__ );

        if ( wfReadOnly() ) {
			wfDebug( __METHOD__ . ": DB is running with the --read-only option " );
			wfProfileOut( __METHOD__ );
            return false;
        }

		if( $action == 'read' || $oUser->isAnon() ) {
			wfProfileOut( __METHOD__ );
			return true;
		}
		$oCUser = WikiaCentralAuthUser::getInstance( $oUser );
		if( !($oCUser->exists() && $oCUser->isAttached()) ) {
			wfProfileOut( __METHOD__ );
			return true;
		}
		if( $oCUser->isLocked() ) {
			$result = 'centralauth-error-locked';
			wfProfileOut( __METHOD__ );
			return false;
		}
		wfProfileOut( __METHOD__ );
		return true;
	}

	static function onUserLoadFromSessionInfo( &$oUser, $from ) {
		wfDebug( __METHOD__ . " load from session data for user: {$oUser->getName()} \n");

        if ( wfReadOnly() ) {
			wfDebug( __METHOD__ . ": DB is running with the --read-only option " );
            return false;
        }

		wfProfileIn( __METHOD__ );
		$oCUser = WikiaCentralAuthUser::getInstance( $oUser );
		if ( !($oCUser->exists() && $oCUser->isAttached()) ) {
			# Invalid credentials
			wfDebug( __METHOD__ . ": Can't find user {$oUser->getName()} \n" );
			$oUser->loadDefaults();
			wfProfileOut( __METHOD__ );
			return false;
		}

		wfDebug( __METHOD__ . " central user exists: {$oUser->getName()} \n");
		$userName = $oUser->getName();
		/*$localId = User::idFromName( $userName );
		if ( !$localId ) {
			wfDebug( __METHOD__ . ": Local user not found {$userName} -> {$localId} \n" );
			if ( !self::attemptAddUser( $oUser, $userName ) ) {
				// Can't create user, give up now
				wfDebug( __METHOD__ . ": Cannot add local user {$userName} \n" );
				wfProfileOut( __METHOD__ );
				return true;
			}
		} else {
			#--- set global ID
			wfDebug( __METHOD__ . ": User exists so load from cache (or DB) {$userName} \n" );
			$oUser->loadFromId();
		}*/
		wfDebug( __METHOD__ . ": Move central user data to wgUser {$userName} \n" );
		$oCUser->invalidateLocalUser($oUser, true);
		#---
		wfDebug( __METHOD__ . ": Update session if needed \n" );
		self::initSession( $oUser, $oUser->getToken() );
		$oUser->centralAuth = $oCUser;

		wfProfileOut( __METHOD__ );
		return true;
	}

	static function onUserLoadGroups ( User &$oUser ) {
		wfProfileIn( __METHOD__ );
		wfDebug( __METHOD__ . " load central user groups: {$oUser->getName()} \n");
		$oCUser = WikiaCentralAuthUser::getInstance( $oUser );
		$res = true;
		if ( !($oCUser->exists() && $oCUser->isAttached()) ) {
			# Invalid credentials
			wfDebug( __METHOD__ . ": Can't find user {$oUser->getName()} \n" );
			$res = false;
		} else {
			$oUser->mGroups = $oCUser->setGroups($oUser->mGroups);
		}
		wfProfileOut( __METHOD__ );
		return $res;
	}


	static function onUserLoadFromDatabase ( User $oUser, &$oRow ) {

        if ( wfReadOnly() ) {
			wfDebug( __METHOD__ . ": DB is running with the --read-only option " );
            return true;
        }

		if ( !$oUser instanceof User ) {
			return true;
		}
		wfDebug( __METHOD__ . ": Load from central database user: {$oUser->getName()} \n" );
		$userName = $oUser->mName;
		if ( User::isValidUserName($userName) ) {
			$oRow2 = WikiaCentralAuthUser::loadFromDatabaseByName($userName);
			if ( $oRow2 ) {
				$oRow = $oRow2;
			}
		} else {
			$userId = intval($oUser->mId);
			$oRow2 = WikiaCentralAuthUser::loadFromDatabaseById($userId);
			if ( $oRow2 ) {
				$oRow = $oRow2;
			}
		}
		return true;
	}

	static function onUserNameLoadFromId ( $user_name, $oRow ) {
        if ( wfReadOnly() ) {
			wfDebug( __METHOD__ . ": DB is running with the --read-only option " );
            return true;
        }

		if ( User::isValidUserName($user_name) ) {
			$oRow2 = WikiaCentralAuthUser::loadFromDatabaseByName($user_name);
			if ( $oRow2 ) {
				$oRow = $oRow2;
			}
		}

		return true;
	}

}
