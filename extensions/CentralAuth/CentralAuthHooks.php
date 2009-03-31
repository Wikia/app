<?php

class CentralAuthHooks {
	static function onAuthPluginSetup( &$auth ) {
		$auth = new StubObject( 'wgAuth', 'CentralAuthPlugin' );
		return true;
	}
	
	/**
	 * Make sure migration information in localuser table is populated
	 * on local account creation
	 */
	static function onAddNewAccount( $user ) {
		$central = CentralAuthUser::getInstance( $user );
		$central->addLocalName( wfWikiID() );
		return true;
	}
	
	/**
	 * Add a little pretty to the preferences user info section
	 */
	static function onPreferencesUserInformationPanel( $prefsForm, &$html ) {
		global $wgUser, $wgLang;

		if ( !$wgUser->isAllowed( 'centralauth-merge' ) ) {
			// Not allowed to merge, don't display merge information
			return true;
		}

		wfLoadExtensionMessages('SpecialCentralAuth');
		$skin = $wgUser->getSkin();
		$special = SpecialPage::getTitleFor( 'MergeAccount' );


		// Possible states:
		// - account not merged at all
		// - global accounts exists, but this local account is unattached
		// - this local account is attached, but migration incomplete
		// - all local accounts are attached

		$global = CentralAuthUser::getInstance( $wgUser );
		if( $global->exists() ) {
			if( $global->isAttached() ) {
				// Local is attached...
				$attached = count( $global->listAttached() );
				$unattached = count( $global->listUnattached() );
				if( $unattached ) {
					// Migration incomplete
					$message = '<strong>' . wfMsgHtml( 'centralauth-prefs-migration' ) . '</strong>' .
						'<br />' .
						htmlspecialchars( wfMsgExt( 'centralauth-prefs-count-attached', array( 'parsemag' ), $wgLang->formatNum( $attached ) ) ) .
						'<br />' .
						htmlspecialchars( wfMsgExt( 'centralauth-prefs-count-unattached', array( 'parsemag' ), $wgLang->formatNum( $unattached ) ) );
				} else {
					// Migration complete
					$message = '<strong>' . wfMsgHtml( 'centralauth-prefs-complete' ) . '</strong>' .
						'<br />' .
						htmlspecialchars( wfMsgExt( 'centralauth-prefs-count-attached', array( 'parsemag' ), $wgLang->formatNum( $attached ) ) );
				}
			} else {
				// Account is in migration, but the local account is not attached
				$message = '<strong>' . wfMsgHtml( 'centralauth-prefs-unattached' ) . '</strong>' .
					'<br />' .
					wfMsgHtml( 'centralauth-prefs-detail-unattached' );
			}
		} else {
			// Not migrated.
			$message = wfMsgHtml( 'centralauth-prefs-not-managed' );
		}

		$manageLink = $skin->makeKnownLinkObj( $special,
			wfMsgHtml( 'centralauth-prefs-manage' ) );
		$html .= $prefsForm->tableRow(
			wfMsgHtml( 'centralauth-prefs-status' ),
			"$message<br />($manageLink)" );
		return true;
	}
	
	static function onAbortNewAccount( $user, &$abortError ) {
		$centralUser = CentralAuthUser::getInstance( $user );
		if ( $centralUser->exists() ) {
			wfLoadExtensionMessages('SpecialCentralAuth');
			$abortError = wfMsg( 'centralauth-account-exists' );
			return false;
		}
		return true;
	}
	
	static function onUserLoginComplete( &$user, &$inject_html ) {
		global $wgCentralAuthCookies;
		if( !$wgCentralAuthCookies ) {
			// Use local sessions only.
			return true;
		}

		$centralUser = CentralAuthUser::getInstance( $user );
		
		if (!$centralUser->exists() || !$centralUser->isAttached()) {
			return true;
		}
		
		// On other wikis
		global $wgCentralAuthAutoLoginWikis;
		if ( !$wgCentralAuthAutoLoginWikis ) {
			return true;
		}

		wfLoadExtensionMessages( 'SpecialCentralAuth' );
		$inject_html .= '<div class="centralauth-login-box"><p>' . 
			wfMsg( 'centralauth-login-progress' ) . "</p>\n<p>";
		foreach( $wgCentralAuthAutoLoginWikis as $alt => $wiki ) {
			$data = array(
				'userName' => $user->getName(),
				'token' => $centralUser->getAuthToken(),
				'remember' => $user->getOption( 'rememberpassword' ),
				'wiki' => $wiki
			);
			$loginToken = wfGenerateToken( $centralUser->getId() );
			global $wgMemc;
			$wgMemc->set( CentralAuthUser::memcKey( 'login-token', $loginToken ), $data, 600 );
			
			$wiki = WikiMap::getWiki( $wiki );
			$url = $wiki->getUrl( 'Special:AutoLogin' );
			
			$querystring = 'token=' . $loginToken;
			
			if (strpos($url, '?') > 0) {
				$url .= "&$querystring";
			} else {
				$url .= "?$querystring";
			}
			
			$inject_html .= Xml::element( 'img', 
				array( 
					'src' => $url,
					'alt' => $alt,
					'title' => $alt,
					'width' => 20,
					'height' => 20,
					'style' => 'border: 1px solid #ccc;',
			   	) );
		}
		
		$inject_html .= '</p></div>';
		
		return true;
	}
	
	static function onUserLoadFromSession( $user, &$result ) {
		global $wgCentralAuthCookies, $wgCentralAuthCookiePrefix;
		if( !$wgCentralAuthCookies ) {
			// Use local sessions only.
			return true;
		}
		$prefix = $wgCentralAuthCookiePrefix;
		
		if( $user->isLoggedIn() ) {
			// Already logged in; don't worry about the global session.
			return true;
		}
		
		if (isset($_COOKIE["{$prefix}User"]) && isset($_COOKIE["{$prefix}Token"])) {
			$userName = $_COOKIE["{$prefix}User"];
			$token = $_COOKIE["{$prefix}Token"];
		} elseif ( (bool)( $session = CentralAuthUser::getSession() ) ) {
			$token = $session['token'];
			$userName = $session['user'];
		} else {
			wfDebug( __METHOD__.": no token or session\n" );
			return true;
		}

		$centralUser = new CentralAuthUser( $userName );
		$localId = User::idFromName( $userName );
		
		if ( $centralUser->authenticateWithToken( $token ) != 'ok' ) {
			wfDebug( __METHOD__.": token mismatch\n" );
		} elseif ( !$centralUser->isAttached() && $localId ) {
			wfDebug( __METHOD__.": exists, and not attached\n" );
		} else {
			if ( !$localId ) {
				// User does not exist locally, attempt to create it
				if ( !self::attemptAddUser( $user, $userName ) ) {
					// Can't create user, give up now
					return true;
				}
			} else {
				$user->setID( $localId );
				$user->loadFromId();
			}
			// Auth OK.
			wfDebug( __METHOD__.": logged in from session\n" );
			self::initSession( $user, $token );
			$user->centralAuthObj = $centralUser;
			$result = true;
		}
		
		return true;
	}
	
	static function onUserLogout( &$user ) {
		global $wgCentralAuthCookies;
		if( !$wgCentralAuthCookies ) {
			// Use local sessions only.
			return true;
		}
		$centralUser = CentralAuthUser::getInstance( $user );
		
		if ($centralUser->exists()) {
			$centralUser->deleteGlobalCookies();
			$centralUser->resetAuthToken();
		}
		
		return true;
	}
	
	static function onUserLogoutComplete( &$user, &$inject_html, $userName ) {
		global $wgCentralAuthCookies, $wgCentralAuthAutoLoginWikis;
		if( !$wgCentralAuthCookies || !$wgCentralAuthAutoLoginWikis ) {
			// Nothing to do.
			return true;
		}
		
		$centralUser = CentralAuthUser::getInstance( $user );
		
		if (!$centralUser->exists() || !$centralUser->isAttached()) {
			return true;
		}

		// Generate the images
		wfLoadExtensionMessages( 'SpecialCentralAuth' );
		$inject_html .= '<div class="centralauth-logout-box"><p>' . 
			wfMsg( 'centralauth-logout-progress' ) . "</p>\n<p>";
		$centralUser = new CentralAuthUser( $userName );

		foreach( $wgCentralAuthAutoLoginWikis as $alt => $wiki ) {
			$data = array(
				'userName' => $userName,
				'token' => $centralUser->getAuthToken(),
				'remember' => false,
				'wiki' => $wiki
			);
			$loginToken = wfGenerateToken( $centralUser->getId() );
			global $wgMemc;
			$wgMemc->set( CentralAuthUser::memcKey( 'login-token', $loginToken ), $data, 600 );

			$wiki = WikiMap::getWiki( $wiki );
			$url = $wiki->getUrl( 'Special:AutoLogin' );
			
			if (strpos($url, '?') > 0) {
				$url .= "&logout=1&token=$loginToken";
			} else {
				$url .= "?logout=1&token=$loginToken";
			}
			
			$inject_html .= Xml::element( 'img', 
				array( 
					'src' => $url,
					'alt' => $alt,
					'title' => $alt,
					'width' => 20,
					'height' => 20,
					'style' => 'border: 1px solid #ccc;',
			   	) );
		}
		
		$inject_html .= '</p></div>';
		return true;
	}
	
	static function onGetCacheVaryCookies( $out, &$cookies ) {
		global $wgCentralAuthCookiePrefix;
		$cookies[] = $wgCentralAuthCookiePrefix . 'Token';
		$cookies[] = $wgCentralAuthCookiePrefix . 'Session';
		$cookies[] = $wgCentralAuthCookiePrefix . 'LoggedOut';
		return true;
	}
	
	static function onUserArrayFromResult( &$userArray, $res ) {
		$userArray = CentralAuthUserArray::newFromResult( $res );
		return true;
	}
	
	/**
	 * Warn bureaucrat about possible conflicts with unified accounts
	 */
	static function onRenameUserWarning( $oldName, $newName, &$warnings ) {
		$oldCentral = new CentralAuthUser( $oldName );
		if ( $oldCentral->exists() && $oldCentral->isAttached() ) {
			wfLoadExtensionMessages('SpecialCentralAuth');
			$warnings[] = array( 'centralauth-renameuser-merged', $oldName, $newName );
		}
		$newCentral = new CentralAuthUser( $newName );
		if ( $newCentral->exists() && !$newCentral->isAttached() ) {
			wfLoadExtensionMessages('SpecialCentralAuth');
			$warnings[] = array( 'centralauth-renameuser-reserved', $oldName, $newName );
		}
		return true;
	}

	static function onRenameUserPreRename( $uid, $oldName, $newName ) {
		$oldCentral = new CentralAuthUser( $oldName );
		if( $oldCentral->exists() && $oldCentral->isAttached() ) {
			$oldCentral->adminUnattach( array( wfWikiID() ) );
		}
		return true;
	}

	/**
	 * When renaming an account, ensure that the presence records are updated.
	 */
	static function onRenameUserComplete( $userId, $oldName, $newName ) {
		$oldCentral = new CentralAuthUser( $oldName );
		$oldCentral->removeLocalName( wfWikiID() );

		$newCentral = new CentralAuthUser( $newName );
		$newCentral->addLocalName( wfWikiID() );

		return true;
	}

	/**
	 * Helper function for onUserLoadFromSession
	 */
	static function initSession( $user, $token ) {
		global $wgAuth;

		$userName = $user->getName();
		wfSetupSession();
		if ($token != @$_SESSION['globalloggedin'] ) {
			$_SESSION['globalloggedin'] = $token;
			$user->invalidateCache();
			wfDebug( __METHOD__.": Initialising session for $userName with token $token.\n" );
		} else {
			wfDebug( __METHOD__.": Session already initialised for $userName with token $token.\n" );
		}
	}

	/**
	 * Attempt to add a user to the database
	 * Does the required authentication checks and updates for auto-creation
	 * @param User $user
	 * @return bool Success
	 */
	static function attemptAddUser( $user, $userName ) {
		global $wgAuth, $wgCentralAuthCreateOnView;
		// Denied by configuration?
		if ( !$wgAuth->autoCreate() ) {
			wfDebug( __METHOD__.": denied by configuration\n" );
			return false;
		}
		
		if ( !$wgCentralAuthCreateOnView ) {
			// Only create local accounts when we perform an active login...
			// Don't freak people out on every page view
			wfDebug( __METHOD__.": denied by \$wgCentralAuthCreateOnView\n" );
			return false;
		}

		// Is the user blacklisted by the session?
		// This is just a cache to avoid expensive DB queries in $user->isAllowedToCreateAccount(). 
		// The user can log in via Special:UserLogin to bypass the blacklist and get a proper 
		// error message.
		$session = CentralAuthUser::getSession();
		if ( isset( $session['auto-create-blacklist'] ) && in_array( wfWikiID(), (array)$session['auto-create-blacklist'] ) ) {
			wfDebug( __METHOD__.": blacklisted by session\n" );
			return false;
		}

		// Is the user blocked?
		$anon = new User;
		if ( !$anon->isAllowedToCreateAccount() ) {
			// Blacklist the user to avoid repeated DB queries subsequently
			// First load the session again in case it changed while the above DB query was in progress
			wfDebug( __METHOD__.": user is blocked from this wiki, blacklisting\n" );
			$session = CentralAuthUser::getSession();
			$session['auto-create-blacklist'][] = wfWikiID();
			CentralAuthUser::setSession( $session );
			return false;
		}

		// Checks passed, create the user
		wfDebug( __METHOD__.": creating new user\n" );
		$user->loadDefaults( $userName );
		$user->addToDatabase();

		$wgAuth->initUser( $user, true );
		$wgAuth->updateUser( $user );

		# Update user count
		$ssUpdate = new SiteStatsUpdate( 0, 0, 0, 0, 1 );
		$ssUpdate->doUpdate();

		# Notify hooks (e.g. Newuserlog)
		wfRunHooks( 'AuthPluginAutoCreate', array( $user ) );
		$user->addNewUserLogEntryAutoCreate();
		return true;
	}

	static function onUserGetEmail( $user, &$email ) {
		$ca = CentralAuthUser::getInstance( $user );
		if ( $ca->isAttached() ) {
			$email = $ca->getEmail();
		}
		return true;
	}

	static function onUserGetEmailAuthenticationTimestamp( $user, &$timestamp ) {
		$ca = CentralAuthUser::getInstance( $user );
		if ( $ca->isAttached() ) {
			$timestamp = $ca->getEmailAuthenticationTimestamp();
		}
		return true;
	}

	static function onUserSetEmail( $user, &$email ) {
		$ca = CentralAuthUser::getInstance( $user );
		if ( $ca->isAttached() ) {
			$ca->setEmail( $email );
		}
		return true;
	}

	static function onUserSaveSettings( $user ) {
		$ca = CentralAuthUser::getInstance( $user );
		if ( $ca->isAttached() ) {
			$ca->saveSettings();
		}
		return true;
	}

	static function onUserSetEmailAuthenticationTimestamp( $user, &$timestamp ) {
		$ca = CentralAuthUser::getInstance( $user );
		if ( $ca->isAttached() ) {
			$ca->setEmailAuthenticationTimestamp( $timestamp );
		}
		return true;
	}
	
	static function onUserGetRights( $user, &$rights ) {
		if (!$user->isAnon()) {
			$centralUser = CentralAuthUser::getInstance( $user );
			
			if ($centralUser->exists() && $centralUser->isAttached()) {
				$extraRights = $centralUser->getGlobalRights();
				
				$rights = array_merge( $extraRights, $rights );
			}
		}
		
		return true;
	}

	/**
	 * Destroy local login cookies so that remote logout works
	 */
	static function onUserSetCookies( $user, &$session, &$cookies ) {
		global $wgCentralAuthCookies, $wgCentralAuthCookieDomain;
		if ( !$wgCentralAuthCookies || $user->isAnon() ) {
			return true;
		}
		$centralUser = CentralAuthUser::getInstance( $user );
		if ( !$centralUser->isAttached() ) {
			return true;
		}

		unset( $session['wsToken'] );
		if ( !empty( $cookies['Token'] ) ) {
			unset( $cookies['Token'] );
			$remember = true;
		} else {
			$remember = false;
		}
		$centralUser->setGlobalCookies( $remember );
		return true;
	}

	/**
	 * Use the central LoggedOut cookie just like the local one
	 */
	static function onUserLoadDefaults( $user, $name ) {
		global $wgCentralAuthCookiePrefix;
		if ( isset( $_COOKIE[$wgCentralAuthCookiePrefix.'LoggedOut'] ) ) {
			$user->mTouched = wfTimestamp( TS_MW, $_COOKIE[$wgCentralAuthCookiePrefix.'LoggedOut'] );
		}
		return true;
	}

	static function onGetUserPermissionsErrorsExpensive( $title, $user, $action, &$result ) {
		if( $action == 'read' || $user->isAnon() ) {
			return true;
		}
		$centralUser = CentralAuthUser::getInstance( $user );
		if( !($centralUser->exists() && $centralUser->isAttached()) ) {
			return true;
		}
		if( $centralUser->isLocked() ) {
			$result = 'centralauth-error-locked';
			return false;
		}
		return true;
	}
}
