<?php

/**
 * Class FacebookClientHooks
 */
class FacebookClientHooks {

	/**
	 * This hook runs whenever a user is being created from session data.  The only time action is taken is if the
	 * user is currently on Special:Userlogin.  In this case it will see if there is a valid Facebook user and if so
	 * send them to the Facebook connect flow (they wouldn't have the Facebook cookies if they hadn't clicked a
	 * Facebook login button)
	 *
	 * @param $user
	 * @param $result
	 *
	 * @return bool
	 */
	public static function UserLoadFromSession( $user, &$result ) {
		$wg = F::app()->wg;

		if ( $wg->CommandLineMode ) {
			return true;
		}

		// If we're not trying to login, don't issue the redirect this handler creates
		if ( !$wg->Title->isSpecial( 'Userlogin' ) ) {
			return true;
		}

		// Check to see if the user can be logged in from Facebook
		$fb = FacebookClient::getInstance();
		$fbId = $fb->getUserId();

		// Check to see if the user can be loaded from the session
		$localId = isset( $_COOKIE[ $wg->CookiePrefix.'UserID' ] )
			? intval( $_COOKIE[ $wg->CookiePrefix.'UserID' ] )
			: ( isset( $_SESSION[ 'wsUserID' ] ) ? $_SESSION[ 'wsUserID' ] : 0 );

		if ( $fbId && !$localId ) {
			// Look up the MW ID of the Facebook user
			$mwUser = $fb->getWikiaUser( $fbId );
			$id = $mwUser ? $mwUser->getId() : 0;

			// If the user doesn't exist, ask them to name their new account
			// Don't redirect if we're on certain special pages
			if ( !$id && !empty( $wg->Title ) && FacebookClientHooks::isOkToRedirect() ) {
				$skin = RequestContext::getMain()->getSkin();

				$returnTo = $wg->request->getVal( 'returnto', $wg->Title->getPrefixedURL() );
				$redirectUrl = 'returnto=' . htmlspecialchars( $returnTo );
				$returnToQuery = $wg->request->getVal( 'returntoquery' );
				if ( $returnToQuery ) {
					$redirectUrl .= '&returntoquery=' . htmlspecialchars( $returnToQuery );
				}

				// Redirect to Special:Connect so the Facebook user can choose a nickname
				$wg->Out->redirect( $skin->makeSpecialUrl( 'FacebookConnect', $redirectUrl ) );
			}
		}

		// Case: Not logged into Facebook or the wiki
		// Case: Logged into Facebook, logged into the wiki
		return true;
	}

	private static function isOkToRedirect() {
		$title = F::app()->wg->Title;

		return !( $title->isSpecial( 'Userlogout' ) || $title->isSpecial( 'FacebookConnect' ) );
	}

	/**
	 * Adds several Facebook Connect variables to the page:
	 *
	 * fbAppId - Wikia's App ID
	 * fbScript
	 * fbLogo
	 * fbLogoutURL - (deprecated) The URL to be redirected to on a disconnect
	 * fbReturnToTitle
	 * fbScriptLangCode
	 *
	 */
	public static function MakeGlobalVariablesScript( &$vars ) {
		global $fbScript, $fbAppId, $fbLogo;
		$wg = F::app()->wg;

		$thisurl = $wg->Title->getPrefixedURL();
		$vars['fbAppId'] = $fbAppId;
		$vars['fbScript'] = $fbScript;
		$vars['fbLogo'] = (bool) $fbLogo;

		$vars['fbLogoutURL'] = Skin::makeSpecialUrl(
			'Userlogout',
			$wg->Title->isSpecial( 'Preferences' ) ? '' : "returnto={$thisurl}"
		);

		$vals = $wg->Request->getValues();
		if ( !empty( $vals['title'] ) ) {
			$vars['fbReturnToTitle'] = $vals['title'];
		}

		// macbre: needed for channelUrl
		$vars['fbScriptLangCode'] = FacebookClientLocale::getLocale();

		$vars['wgEnableFacebookClientExt'] = F::app()->wg->EnableFacebookClientExt;

		return true;
	}

	/**
	 * Add Facebook SDK loading code at the bottom of the page
	 *
	 * Fixes IE issue (RT #140425)
	 *
	 * @param $skin Skin
	 * @param $scripts
	 *
	 * @return bool
	 */
	static function SkinAfterBottomScripts( $skin, &$scripts ) {
		global $fbScript, $wgNoExternals;

		if ( !empty( $fbScript ) && empty( $wgNoExternals ) ) {
			$scripts .= '<div id="fb-root"></div>';
		}

		return true;
	}

	/**
	 * Create disconnect button and other things in pref
	 *
	 * @param $user User
	 *
	 * @return bool
	 */
	static function GetPreferences( $user, &$preferences ) {

		// Determine if we're connected already or not
		$ids = FacebookClient::getInstance()->getFacebookUserIds( $user );
		if ( count( $ids ) > 0 ) {
			$isConnected = true;
			$prefTab = 'fbconnect-connect';
		} else {
			$isConnected = false;
			$prefTab = 'fbconnect-disconnect';
		}

		$html = F::app()->renderView( 'FacebookClientController', 'preferences', [ 'isConnected' => $isConnected ] );
		// Create a new tab on the preferences page
		$preferences[$prefTab] = [
			'help' => $html,
			'label' => '',
			'type' => 'info',
			'section' => 'fbconnect-prefstext/fbconnect-status-prefstext'
		];

		return true;
	}

	/**
	 * Adds JS needed for the user preferences page
	 *
	 * @param Array $assetsArray
	 * @return bool
	 */
	public static function onOasisSkinAssetGroups( &$assetsArray ) {
		$title = F::app()->wg->Title;

		if ( $title instanceof Title && $title->isSpecial( 'Preferences' ) ) {
			$assetsArray[] = 'facebook_client_preferences_js';
		}

		return true;
	}

	public static function setupParserHook( \Parser $parser ) {
		FacebookClientXFBML::registerHooks( $parser );

		return true;
	}
}
