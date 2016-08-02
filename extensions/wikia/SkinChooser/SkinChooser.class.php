<?php

class SkinChooser {

	/**
	 * @static
	 * @param User $user
	 * @param Array $defaultPreferences
	 * @return bool
	 */
	public static function onGetPreferences( $user, &$defaultPreferences ) {
		global $wgEnableAnswers, $wgAdminSkin, $wgDefaultSkin, $wgSkinPreviewPage, $wgSkipSkins, $wgEnableUserPreferencesV2Ext;

		// hide default MediaWiki skin fieldset
		unset( $defaultPreferences['skin'] );

		$mSkin  = $user->getGlobalPreference( 'skin' );

		if ( !empty( $wgAdminSkin ) ) {
			$defaultSkinKey = $wgAdminSkin;
		} else if ( !empty( $wgDefaultTheme ) ) {
			$defaultSkinKey = $wgDefaultSkin . '-' . $wgDefaultTheme;
		} else {
			$defaultSkinKey = $wgDefaultSkin;
		}

		// load list of skin names
		$validSkinNames = Skin::getSkinNames();

		// and sort them
		foreach ( $validSkinNames as $skinkey => &$skinname ) {
			if ( isset( $skinNames[$skinkey] ) )  {
				$skinname = $skinNames[$skinkey];
			}
		}
		asort( $validSkinNames );

		$previewtext = wfMsg( 'skin-preview' );
		if ( isset( $wgSkinPreviewPage ) && is_string( $wgSkinPreviewPage ) ) {
			$previewLinkTemplate = Title::newFromText( $wgSkinPreviewPage )->getLocalURL( 'useskin=' );
		} else {
			$mptitle = Title::newMainPage();
			$previewLinkTemplate = $mptitle->getLocalURL( 'useskin=' );
		}

		$oldSkinNames = array();
		foreach ( $validSkinNames as $skinKey => $skinVal ) {
			if ( $skinKey == 'oasis' || ( ( in_array( $skinKey, $wgSkipSkins ) ) && !( $skinKey == $mSkin ) ) ) {
				continue;
			}
			$oldSkinNames[$skinKey] = $skinVal;
		}

		$skins = array();
		$skins[wfMsg( 'new-look' )] = 'oasis';

		// display radio buttons for rest of skin
		if ( count( $oldSkinNames ) > 0 ) {
			foreach ( $oldSkinNames as $skinKey => $skinVal ) {
				$previewlink = $wgEnableUserPreferencesV2Ext ? '' : ' <a target="_blank" href="' . htmlspecialchars( $previewLinkTemplate . $skinKey ) . '">' . $previewtext . '</a>';
				$skins[$skinVal . $previewlink . ( $skinKey == $defaultSkinKey ? ' (' . wfMsg( 'default' ) . ')' : '' )] = $skinKey;
			}
		}

		$defaultPreferencesTemp = array();

		foreach ( $defaultPreferences as $k => $v ) {
			$defaultPreferencesTemp[$k] = $v;
			if ( $k == 'oldsig' ) {

				$defaultPreferencesTemp['skin'] = array(
					'type' => 'radio',
					'options' => $skins,
					'label' => '&nbsp;',
					'section' => 'personal/layout',
				);

				$defaultPreferencesTemp['showAds'] = array(
					'type' => 'toggle',
					'label-message' => 'tog-showAds',
					'section' => 'personal/layout',
				);

			}
		}

		$defaultPreferences = $defaultPreferencesTemp;

		return true;
	}

	/**
	 * Generate proper key for user option
	 *
	 * This allow us to use different user preferences for answers / recipes / other wikis
	 */
	private static function getUserOptionKey( $option ) {
		global $wgEnableAnswers;
		wfProfileIn( __METHOD__ );

		if ( !empty( $wgEnableAnswers ) ) {
			$key = "answers-{$option}";
		}
		else {
			$key = $option;
		}

		wfProfileOut( __METHOD__ );
		return $key;
	}

	/**
	 * Get given option from user preferences
	 */
	private static function getUserOption( $option ) {
		global $wgUser, $wgEnableAnswers;
		wfProfileIn( __METHOD__ );

		$val = $wgUser->getGlobalPreference( self::getUserOptionKey( $option ) );

		// fallback to non-answers option (RT #54087)
		if ( !empty( $wgEnableAnswers ) &&  $val == '' ) {
			wfDebug( __METHOD__ . ": '{$option}' fallbacked\n" );

			$val = $wgUser->getGlobalPreference( $option );
		}

		wfDebug( __METHOD__ . ": '{$option}' = {$val}\n" );

		wfProfileOut( __METHOD__ );
		return $val;
	}

	/**
	 * Set given option in user preferences
	 */
	private static function setUserOption( $option, $value ) {
		global $wgUser;
		wfProfileIn( __METHOD__ );

		$key = self::getUserOptionKey( $option );

		$wgUser->setGlobalPreference( $key, $value );
		self::log( __METHOD__, "{$key} = {$value}" );

		/* debugging skin leak, -uber */
		if ( $key == 'skin' ) { # yes, i do mean to check key and not option here
			global $wgCityId;
			$wgUser->setGlobalPreference( 'skin-set', implode( '|', array( 'SkinChooser', $wgCityId, time() ) ) );
		}
		/* end debug */

		wfProfileOut( __METHOD__ );
	}

	/**
	 * @static
	 * @param $tname
	 * @param bool $trailer
	 * @param bool $disabled
	 * @return string
	 */
	private static function getToggle( $tname, $trailer = false, $disabled = false ) {
		/* @var $wgLang Language */
		global $wgLang;

		$ttext = $wgLang->getUserToggle( $tname );

		$checked = self::getUserOption( $tname ) == 1 ? ' checked="checked"' : '';
		$disabled = $disabled ? ' disabled="disabled"' : '';
		$trailer = $trailer ? $trailer : '';
		return "<div class='toggle'><input type='checkbox' value='1' id=\"$tname\" name=\"wpOp$tname\"$checked$disabled />" .
		" <span class='toggletext'><label for=\"$tname\">$ttext</label>$trailer</span></div>\n";
	}

	/**
	 * Select proper skin and theme based on user preferences / default settings
	 */
	public static function onGetSkin( RequestContext $context, &$skin ) {
		global $wgDefaultSkin, $wgDefaultTheme, $wgSkinTheme, $wgAdminSkin, $wgSkipSkins, $wgEnableAnswers;

		wfProfileIn( __METHOD__ );

		$isOasisPublicBeta = ( $wgDefaultSkin == 'oasis' );

		$request = $context->getRequest();
		$title = $context->getTitle();
		$user = $context->getUser();
		$useskin = $request->getVal( 'useskin', null );

		/**
		 * check headers sent by varnish, if X-Skin is send force skin unless there is useskin param in url
		 * @author eloy, requested by artur
		 */
		if ( is_null( $useskin ) ) {
			if ( !empty( $_SERVER['HTTP_X_SKIN'] ) ) {
				$skinFromHeader = $_SERVER['HTTP_X_SKIN'];

				if ( in_array( $skinFromHeader, array( 'monobook', 'oasis', 'wikia', 'wikiamobile', 'uncyclopedia' ) ) ) {
					$skin = Skin::newFromKey( $skinFromHeader );
				// X-Skin header fallback for Mercury which is actually not a MediaWiki skin but a separate application
				} elseif ( $skinFromHeader === 'mercury') {
					$skin = Skin::newFromKey( 'wikiamobile' );
				}
				wfProfileOut( __METHOD__ );
				return false;
			}
		}

		// useskin query param fallback for Mercury which is actually not a MediaWiki skin but a separate application
		if ( $useskin === 'mercury' ) {
			$useskin = 'wikiamobile';
		}

		if ( !( $title instanceof Title ) || in_array( self::getUserOption( 'skin' ), $wgSkipSkins ) ) {
			$skin = Skin::newFromKey( isset( $wgDefaultSkin ) ? $wgDefaultSkin : 'monobook' );
			wfProfileOut( __METHOD__ );
			return false;
		}

		// only allow useskin=wikia for beta & staff.
		if ( $request->getVal( 'useskin' ) == 'wikia' ) {
			$request->setVal( 'useskin', 'oasis' );
		}

		# Get skin logic
		wfProfileIn( __METHOD__ . '::GetSkinLogic' );

		if ( !$user->isLoggedIn() ) { # If user is not logged in
			if ( $wgDefaultSkin == 'oasis' ) {
				$userSkin = $wgDefaultSkin;
				$userTheme = null;
			} else if ( !empty( $wgAdminSkin ) && !$isOasisPublicBeta ) {
				$adminSkinArray = explode( '-', $wgAdminSkin );
				$userSkin = isset( $adminSkinArray[0] ) ? $adminSkinArray[0] : null;
				$userTheme = isset( $adminSkinArray[1] ) ? $adminSkinArray[1] : null;
			} else {
				$userSkin = $wgDefaultSkin;
				$userTheme = $wgDefaultTheme;
			}
		} else {
			$userSkin = self::getUserOption( 'skin' );
			$userTheme = self::getUserOption( 'theme' );

			if ( empty( $userSkin ) ) {
				if ( !empty( $wgAdminSkin ) ) {
					$adminSkinArray = explode( '-', $wgAdminSkin );
					$userSkin = isset( $adminSkinArray[0] ) ? $adminSkinArray[0] : null;
					$userTheme = isset( $adminSkinArray[1] ) ? $adminSkinArray[1] : null;
				} else {
					$userSkin = 'oasis';
				}
			} else if ( !empty( $wgAdminSkin ) && $userSkin != 'oasis' && $userSkin != 'monobook' && $userSkin != 'wowwiki' && $userSkin != 'lostbook' ) {
				$adminSkinArray = explode( '-', $wgAdminSkin );
				$userSkin = isset( $adminSkinArray[0] ) ? $adminSkinArray[0] : null;
				$userTheme = isset( $adminSkinArray[1] ) ? $adminSkinArray[1] : null;
			}
		}

		wfProfileOut( __METHOD__ . '::GetSkinLogic' );

		$chosenSkin = !is_null( $useskin ) ? $useskin : $userSkin;

		$elems = explode( '-', $chosenSkin );

		$userSkin = ( array_key_exists( 0, $elems ) ) ? ( ( empty( $wgEnableAnswers ) && $elems[ 0 ] == 'answers' ) ? 'oasis' : $elems[ 0 ] ) : null;
		$userTheme = ( array_key_exists( 1, $elems ) ) ? $elems[ 1 ] : $userTheme;
		$userTheme = $request->getVal( 'usetheme', $userTheme );

		wfRunHooks( 'BeforeSkinLoad', [ &$userSkin, $useskin, $title ] );

		$skin = Skin::newFromKey( $userSkin );

		$normalizedSkinName = substr( strtolower( get_class( $skin ) ), 4 );

		self::log( __METHOD__, "using skin {$normalizedSkinName}" );

		# Normalize theme name and set it as a variable for skin object.
		if ( isset( $wgSkinTheme[$normalizedSkinName] ) ) {
			wfProfileIn( __METHOD__ . '::NormalizeThemeName' );
			if ( !in_array( $userTheme, $wgSkinTheme[$normalizedSkinName] ) ) {
				if ( in_array( $wgDefaultTheme, $wgSkinTheme[$normalizedSkinName] ) ) {
					$userTheme = $wgDefaultTheme;
				} else {
					$userTheme = $wgSkinTheme[$normalizedSkinName][0];
				}
			}

			$skin->themename = $userTheme;

			# force default theme on monaco and oasis when there is no admin setting
			if ( $normalizedSkinName == 'oasis' && ( empty( $wgAdminSkin ) && $isOasisPublicBeta ) ) {
				$skin->themename = $wgDefaultTheme;
			}

			self::log( __METHOD__, "using theme {$userTheme}" );
			wfProfileOut( __METHOD__ . '::NormalizeThemeName' );
		}

		// FIXME: add support for oasis themes
		if ( $normalizedSkinName == 'oasis' ) {
			$skin->themename = $request->getVal( 'usetheme' );
		}

		wfProfileOut( __METHOD__ );
		return false;
	}

	/**
	 * @static
	 * @param $method
	 * @param $msg
	 */
	private static function log( $method, $msg ) {
		wfDebug( "{$method}: {$msg}\n" );
	}
}
