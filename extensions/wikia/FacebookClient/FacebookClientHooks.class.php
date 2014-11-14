<?php

/**
 * Class FacebookClientHooks
 */
class FacebookClientHooks {
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
