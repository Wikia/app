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
	 * Add Facebook div at the bottom of the page so we don't get JS console messages from FB about it.
	 * @param Skin $skin
	 * @param string $html
	 * @return bool
	 */
	public static function onGetHTMLAfterBody($skin, &$html) {
		$html .= '<div id="fb-root"></div>';

		return true;
	}


	/**
	 * Create disconnect button and other things in pref
	 *
	 * @param User $user
	 * @param array $preferences
	 * @return bool
	 */
	static function GetPreferences( $user, &$preferences ) {

		// Determine if we're connected already or not
		$id = FacebookClient::getInstance()->getFacebookUserId( $user );
		if ( $id ) {
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

		JSMessages::enqueuePackage( 'FacebookClient', JSMessages::EXTERNAL );

		return true;
	}

	/**
	 * Adds JS needed for FacebookClient code
	 *
	 * @param Array $assetsArray
	 * @return bool
	 */
	public static function onSkinAssetGroups( &$assetsArray ) {
		$app = F::app();
		$title = $app->wg->Title;

		// Special:Preferences
		if ( $title instanceof Title &&
			$title->isSpecial( 'Preferences' ) &&
			$app->wg->User->isLoggedIn()
		) {
			$assetsArray[] = 'facebook_client_preferences_js';
		}

		return true;
	}

	public static function setupParserHook( \Parser $parser ) {
		FacebookClientXFBML::registerHooks( $parser );

		return true;
	}

	/**
	 * Handle confirmation message from Facebook Connect
	 */
	public static function onSkinTemplatePageBeforeUserMsg( &$html ) {
		if ( F::app()->checkSkin( 'oasis' ) ) {
			// check for querystring param
			$fbStatus = F::app()->wg->Request->getVal( 'fbconnected' );

			if ( $fbStatus  == '1' ) {
				// check if current user is connected to facebook
				$map = FacebookClient::getInstance()->getMapping();
				if ( !empty( $map ) ) {
					BannerNotificationsController::addConfirmation(
						wfMessage( 'fbconnect-connect-msg' )->escaped()
					);
				}
			}
		}

		return true;
	}

	public static function onSkinAfterBottomScripts( $skin, &$text ) {

		$script = AssetsManager::getInstance()->getURL( 'facebook_client_xfbml_js' );
		$text .= Html::linkedScript( $script[0] );

		return true;
	}
}
