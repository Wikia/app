<?php

class SkinChooser {

	public static function onGetPreferences($user, &$defaultPreferences) {
		global $wgEnableAnswers, $wgForceSkin, $wgAdminSkin, $wgDefaultSkin, $wgDefaultSkin, $wgSkinPreviewPage, $wgSkipSkins, $wgSkipOldSkins, $wgEnableUserPreferencesV2Ext;

		// hide default MediaWiki skin fieldset
		unset($defaultPreferences['skin']);

		$mSkin  = $user->getOption('skin');

		// hacks for Answers
		if (!empty($wgEnableAnswers)) {
			$mSkin = 'answers';
		}

		// no skin settings at all when skin is forced
		if(!empty($wgForceSkin)) {
			return true;
		}

		if(!empty($wgAdminSkin)) {
			$defaultSkinKey = $wgAdminSkin;
		} else if(!empty($wgDefaultTheme)) {
			$defaultSkinKey = $wgDefaultSkin . '-' . $wgDefaultTheme;
		} else {
			$defaultSkinKey = $wgDefaultSkin;
		}

		// load list of skin names
		$validSkinNames = Skin::getSkinNames();

		// and sort them
		foreach($validSkinNames as $skinkey => &$skinname) {
			if(isset($skinNames[$skinkey]))  {
				$skinname = $skinNames[$skinkey];
			}
		}
		asort($validSkinNames);

		$validSkinNames2 = $validSkinNames;

		$previewtext = wfMsg('skin-preview');
		if(isset($wgSkinPreviewPage) && is_string($wgSkinPreviewPage)) {
			$previewLinkTemplate = Title::newFromText($wgSkinPreviewPage)->getLocalURL('useskin=');
		} else {
			$mptitle = Title::newMainPage();
			$previewLinkTemplate = $mptitle->getLocalURL('useskin=');
		}

		$oldSkinNames = array();
		foreach($validSkinNames as $skinKey => $skinVal) {
			if ( $skinKey == 'oasis' || ((in_array($skinKey, $wgSkipSkins) || in_array($skinKey, $wgSkipOldSkins)) && !($skinKey == $mSkin))) {
				continue;
			}
			$oldSkinNames[$skinKey] = $skinVal;
		}

		$skins = array();
		$skins[wfMsg('new-look')] = 'oasis';

		// display radio buttons for rest of skin
		if(count($oldSkinNames) > 0) {
			foreach($oldSkinNames as $skinKey => $skinVal) {
				$previewlink = $wgEnableUserPreferencesV2Ext ? '' : ' <a target="_blank" href="'.htmlspecialchars($previewLinkTemplate.$skinKey).'">'.$previewtext.'</a>';
				$skins[$skinVal.$previewlink.($skinKey == $defaultSkinKey ? ' ('.wfMsg('default').')' : '')] = $skinKey;
			}
		}

		$defaultPreferencesTemp = array();

		foreach($defaultPreferences as $k => $v) {
			$defaultPreferencesTemp[$k] = $v;
			if($k == 'oldsig') {

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

	static private $wgAllowUserSkinOriginal;

	/**
	 * Generate proper key for user option
	 *
	 * This allow us to use different user preferences for answers / recipes / other wikis
	 */
	private static function getUserOptionKey($option) {
		global $wgEnableAnswers;
		wfProfileIn(__METHOD__);

		if (!empty($wgEnableAnswers)) {
			$key = "answers-{$option}";
		}
		else {
			$key = $option;
		}

		wfProfileOut(__METHOD__);
		return $key;
	}

	/**
	 * Get given option from user preferences
	 */
	private static function getUserOption($option) {
		global $wgUser, $wgEnableAnswers;
		wfProfileIn(__METHOD__);

		$val = $wgUser->getOption(self::getUserOptionKey($option));

		// fallback to non-answers option (RT #54087)
		if (!empty($wgEnableAnswers) &&  $val == '') {
			wfDebug(__METHOD__ . ": '{$option}' fallbacked\n");

			$val = $wgUser->getOption($option);
		}

		wfDebug(__METHOD__ . ": '{$option}' = {$val}\n");

		wfProfileOut(__METHOD__);
		return $val;
	}

	/**
	 * Set given option in user preferences
	 */
	private static function setUserOption($option, $value) {
		global $wgUser;
		wfProfileIn(__METHOD__);

		$key = self::getUserOptionKey($option);

		$wgUser->setOption($key, $value);
		self::log(__METHOD__, "{$key} = {$value}");

		/* debugging skin leak, -uber */
		if($key=='skin') { #yes, i do mean to check key and not option here
			global $wgCityId;
			$wgUser->setOption('skin-set', implode('|', array('SkinChooser', $wgCityId, time()) ) );
		}
		/* end debug */

		wfProfileOut(__METHOD__);
	}

	private static function getToggle( $tname, $trailer = false, $disabled = false ) {
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
	public static function onGetSkin(RequestContext $context, &$skin) {
		global $wgCookiePrefix, $wgCookieExpiration, $wgCookiePath, $wgCookieDomain, $wgCookieSecure, $wgDefaultSkin, $wgDefaultTheme,
			$wgSkinTheme, $wgOut, $wgForceSkin, $wgAdminSkin, $wgSkipSkins, $wgArticle, $wgDevelEnvironment, $wgEnableWikiaMobile, $wgEnableAnswers;

		$isOasisPublicBeta = $wgDefaultSkin == 'oasis';

		wfProfileIn(__METHOD__);

		$request = $context->getRequest();
		$title = $context->getTitle();
		$user = $context->getUser();

		//allow showing wikiaphone on wikis where WikiaMobile is enabled for functionality comparison and testing
		//will be removed on Dec 7th 2011
		$wikiaMobileEnabled = !empty( $wgEnableWikiaMobile );

		if( $request->getVal('useskin') == 'wikiaphone' && $wikiaMobileEnabled ) {
			$skin = Skin::newFromKey(  $request->getVal('useskin') );
			wfProfileOut(__METHOD__);
			return false;
		}

		/**
		 * check headers sent by varnish, if X-Skin is send force skin
		 * @author eloy, requested by artur
		 */
		if( function_exists( 'apache_request_headers' ) ) {
			$headers = apache_request_headers();
			if( isset( $headers[ "X-Skin" ] ) && in_array( $headers[ "X-Skin" ], array( "monobook", "oasis", "wikia", "wikiaphone", "wikiaapp" ) ) ) {
				//FB#16417 - for the first release bind wikiaphone to wikiamobile via a WF variable
				//TODO: remove after Ad performance test ends and WikiaMobile will be the default (FB#16582)
				if ( $headers[ "X-Skin" ] == 'wikiaphone' ) {
					//give mobile skin users with no js support a chance to use different skins
					//FB#19758
					$requestedSkin = $request->getVal( 'useskin' );

					if (
						!empty( $requestedSkin ) &&
						/* avoid causing an error if WikiaMobile is disabled, FB#20041 */
						!(
							!$wikiaMobileEnabled &&
							$requestedSkin == 'wikiamobile'
						)
					) {
						$headers[ "X-Skin" ] = $requestedSkin;
					} elseif ( $wikiaMobileEnabled ) {
						$headers[ "X-Skin" ] = 'wikiamobile';
					}
				}

				$skin = Skin::newFromKey( $headers[ "X-Skin" ] );
				wfProfileOut(__METHOD__);
				return false;
			}
		}

		if(!($title instanceof Title) || in_array( self::getUserOption('skin'), $wgSkipSkins )) {
			$skin = Skin::newFromKey(isset($wgDefaultSkin) ? $wgDefaultSkin : 'monobook');
			wfProfileOut(__METHOD__);
			return false;
		}

		// only allow useskin=wikia for beta & staff.
		if( $request->getVal('useskin') == 'wikia' ) {
			$request->setVal('useskin', 'oasis');
		}
		if(!empty($wgForceSkin)) {
			$wgForceSkin = $request->getVal('useskin', $wgForceSkin);
			$elems = explode('-', $wgForceSkin);
			$userSkin = ( array_key_exists(0, $elems) ) ? $elems[0] : null;
			$userTheme = ( array_key_exists(1, $elems) ) ? $elems[1] : null;

			$skin = Skin::newFromKey($userSkin);
			$skin->themename = $userTheme;

			self::log(__METHOD__, "forced skin to be {$wgForceSkin}");

			wfProfileOut(__METHOD__);
			return false;
		}

		# Get skin logic
		wfProfileIn(__METHOD__.'::GetSkinLogic');

		if(!$user->isLoggedIn()) { # If user is not logged in
			if($wgDefaultSkin == 'oasis') {
				$userSkin = $wgDefaultSkin;
				$userTheme = null;
			} else if(!empty($wgAdminSkin) && !$isOasisPublicBeta) {
				$adminSkinArray = explode('-', $wgAdminSkin);
				$userSkin = isset($adminSkinArray[0]) ? $adminSkinArray[0] : null;
				$userTheme = isset($adminSkinArray[1]) ? $adminSkinArray[1] : null;
			} else {
				$userSkin = $wgDefaultSkin;
				$userTheme = $wgDefaultTheme;
			}
		} else {
			$userSkin = self::getUserOption('skin');
			$userTheme = self::getUserOption('theme');

			//RT:81173 Answers force hack.  It's in here because wgForceSkin is overwritten in CommonExtensions to '', most likely due to allowing admin skins and themes.  This will force answers and falls through to admin skin and theme logic if there is one.
			if(!empty($wgDefaultSkin) && $wgDefaultSkin == 'answers') {
				$userSkin = 'answers';
			}

			if(empty($userSkin)) {
				if(!empty($wgAdminSkin)) {
					$adminSkinArray = explode('-', $wgAdminSkin);
					$userSkin = isset($adminSkinArray[0]) ? $adminSkinArray[0] : null;
					$userTheme = isset($adminSkinArray[1]) ? $adminSkinArray[1] : null;
				} else {
					$userSkin = 'oasis';
				}
			} else if(!empty($wgAdminSkin) && $userSkin != 'oasis' && $userSkin != 'monobook' && $userSkin != 'wowwiki' && $userSkin != 'lostbook') {
				$adminSkinArray = explode('-', $wgAdminSkin);
				$userSkin = isset($adminSkinArray[0]) ? $adminSkinArray[0] : null;
				$userTheme = isset($adminSkinArray[1]) ? $adminSkinArray[1] : null;
			}

		}
		wfProfileOut(__METHOD__.'::GetSkinLogic');

		$useskin = $request->getVal('useskin', $userSkin);
		$elems = explode('-', $useskin);
		$userSkin = ( array_key_exists(0, $elems) ) ? ( (empty($wgEnableAnswers) && $elems[0] == 'answers') ? 'oasis' : $elems[0]) : null;
		$userTheme = ( array_key_exists(1, $elems) ) ? $elems[1] : $userTheme;
		$userTheme = $request->getVal('usetheme', $userTheme);

		//Fix RT#133364 and makes crazy mobile users get the correct one
		if( $userSkin == 'smartphone' ){
			$userSkin = 'wikiaphone';
		}

		//WikiaMobile is a devbox-only for now
		if( $userSkin == 'wikiamobile' && !$wgEnableWikiaMobile ){
			$userSkin = 'wikiaphone';
		}

		//FB#16417 - for the first release bind wikiaphone to wikiamobile via a WF variable
		//TODO: remove after Ad performance test ends and WikiaMobile will be the default (FB#16582)
		if ( !empty( $wgEnableWikiaMobile ) && $userSkin == 'wikiaphone' ) {
			$userSkin = 'wikiamobile';
		}

		$skin = &Skin::newFromKey($userSkin);

		$normalizedSkinName = substr(strtolower(get_class($skin)),4);

		self::log(__METHOD__, "using skin {$normalizedSkinName}");

		# Normalize theme name and set it as a variable for skin object.
		if(isset($wgSkinTheme[$normalizedSkinName])){
			wfProfileIn(__METHOD__.'::NormalizeThemeName');
			if(!in_array($userTheme, $wgSkinTheme[$normalizedSkinName])){
				if(in_array($wgDefaultTheme, $wgSkinTheme[$normalizedSkinName])){
					$userTheme = $wgDefaultTheme;
				} else {
					$userTheme = $wgSkinTheme[$normalizedSkinName][0];
				}
			}

			$skin->themename = $userTheme;

			# force default theme on monaco and oasis when there is no admin setting
			if( $normalizedSkinName == 'oasis' && (empty($wgAdminSkin) && $isOasisPublicBeta) ) {
				$skin->themename = $wgDefaultTheme;
			}

			self::log(__METHOD__, "using theme {$userTheme}");
			wfProfileOut(__METHOD__.'::NormalizeThemeName');
		}

		// FIXME: add support for oasis themes
		if ($normalizedSkinName == 'oasis') {
			$skin->themename = $request->getVal('usetheme');
		}

		wfProfileOut(__METHOD__);
		return false;
	}

	private static function log($method, $msg) {
		wfDebug("{$method}: {$msg}\n");
	}

}
