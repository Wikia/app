<?php

class SkinChooser {

	/**
	 * @static
	 * @param User $user
	 * @param array $defaultPreferences
	 */
	public static function onGetPreferences( $user, &$defaultPreferences ) {
		// hide default MediaWiki skin fieldset
		unset( $defaultPreferences['skin'] );

		$defaultPreferencesTemp = array();

		foreach ( $defaultPreferences as $k => $v ) {
			$defaultPreferencesTemp[$k] = $v;
			if ( $k == 'oldsig' ) {

				$defaultPreferencesTemp['showAds'] = array(
					'type' => 'toggle',
					'label-message' => 'tog-showAds',
					'section' => 'personal/layout',
				);

			}
		}

		$defaultPreferences = $defaultPreferencesTemp;
	}

	/**
	 * Set given option in user preferences
	 */
	private static function setUserOption( $option, $value ) {
		global $wgUser;
		$wgUser->setGlobalPreference( $option, $value );
		self::log( __METHOD__, "{$option} = {$value}" );

		/* debugging skin leak, -uber */
		if ( $option == 'skin' ) { # yes, i do mean to check key and not option here
			global $wgCityId;
			$wgUser->setGlobalPreference( 'skin-set', implode( '|', array( 'SkinChooser', $wgCityId, time() ) ) );
		}
		/* end debug */
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
		global $wgLang, $wgUser;

		$ttext = $wgLang->getUserToggle( $tname );

		$checked = $wgUser->getGlobalPreference( $tname ) == 1 ? ' checked="checked"' : '';
		$disabled = $disabled ? ' disabled="disabled"' : '';
		$trailer = $trailer ? $trailer : '';
		return "<div class='toggle'><input type='checkbox' value='1' id=\"$tname\" name=\"wpOp$tname\"$checked$disabled />" .
		" <span class='toggletext'><label for=\"$tname\">$ttext</label>$trailer</span></div>\n";
	}

	/**
	 * Select proper skin and theme based on user preferences / default settings
	 */
	public static function onGetSkin( RequestContext $context, &$skin ) {
		global $wgDefaultSkin, $wgDefaultTheme, $wgSkinTheme, $wgAdminSkin;

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
			$skinFromHeader = $request->getHeader( 'X-Skin' );

			if ( $skinFromHeader !== false ) {
				if ( in_array( $skinFromHeader, array( 'oasis', 'wikia', 'wikiamobile' ) ) ) {
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

		// SUS-4796
		if ( in_array( $useskin, [ 'monobook', 'uncyclopedia' ] ) ) {
			$useskin = 'oasis';
		}

		if ( !( $title instanceof Title ) ) {
			$skin = Skin::newFromKey( $wgDefaultSkin );
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
			$userSkin = $user->getGlobalPreference( 'skin' );
			$userTheme = $user->getGlobalPreference( 'theme' );

			if ( empty( $userSkin ) ) {
				if ( !empty( $wgAdminSkin ) ) {
					$adminSkinArray = explode( '-', $wgAdminSkin );
					$userSkin = isset( $adminSkinArray[0] ) ? $adminSkinArray[0] : null;
					$userTheme = isset( $adminSkinArray[1] ) ? $adminSkinArray[1] : null;
				} else {
					$userSkin = 'oasis';
				}
			} else if ( !empty( $wgAdminSkin ) && $userSkin != 'oasis' && $userSkin != 'monobook' ) {
				$adminSkinArray = explode( '-', $wgAdminSkin );
				$userSkin = isset( $adminSkinArray[0] ) ? $adminSkinArray[0] : null;
				$userTheme = isset( $adminSkinArray[1] ) ? $adminSkinArray[1] : null;
			} else if ( $userSkin === 'monobook') {
				$userSkin = 'oasis'; // SUS-4796 - force Oasis for MonoBook users
			}
		}

		wfProfileOut( __METHOD__ . '::GetSkinLogic' );

		$chosenSkin = !is_null( $useskin ) ? $useskin : $userSkin;

		$elems = explode( '-', $chosenSkin );

		$userSkin = ( array_key_exists( 0, $elems ) ) ? ( ( $elems[ 0 ] == 'answers' ) ? 'oasis' : $elems[ 0 ] ) : null;
		$userTheme = ( array_key_exists( 1, $elems ) ) ? $elems[ 1 ] : $userTheme;
		$userTheme = $request->getVal( 'usetheme', $userTheme );

		Hooks::run( 'BeforeSkinLoad', [ &$userSkin, $useskin, $title ] );

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
