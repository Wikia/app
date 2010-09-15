<?php

class SkinChooser {

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
	 * Select current theme in user preferences form
	 */
	public static function setThemeForPreferences($pref) {
		global $wgSkinTheme, $wgDefaultTheme;

		$userTheme = self::getUserOption('theme');

		# Normalize theme name and set it as a variable for skin object.
		if(isset($wgSkinTheme[$pref->mSkin])){
			if(!in_array($userTheme, $wgSkinTheme[$pref->mSkin])){
				if(in_array($wgDefaultTheme, $wgSkinTheme[$pref->mSkin])){
					$userTheme = $wgDefaultTheme;
				} else {
					$userTheme = $wgSkinTheme[$pref->mSkin][0];
				}
			}
			$pref->mTheme = $userTheme;
		}

		return true;
	}

	/**
	 * Update user skin/theme preferences
	 */
	public static function savePreferences($pref) {
		global $wgUser, $wgCityId, $wgAdminSkin, $wgTitle, $wgRequest;

		//self::log(__METHOD__, print_r($pref, true));

		# Save setting for admin skin
		if(!empty($pref->mAdminSkin)) {
			if( $wgUser->isAllowed( 'setadminskin' ) && !$wgUser->isBlocked() ) {
				$pref->mAdminSkin = str_replace('awesome', 'monaco', $pref->mAdminSkin); #RT17498
				if($pref->mAdminSkin != $wgAdminSkin && !(empty($wgAdminSkin) && $pref->mAdminSkin == 'ds')) {
					$log = new LogPage('var_log');
					if($pref->mAdminSkin == 'ds') {
						WikiFactory::SetVarById( 599, $wgCityId, null, 'via SkinChooser');
						$wgAdminSkin = null;
						$log->addEntry( 'var_set', $wgTitle, '', array(wfMsg('skin'), wfMsg('adminskin_ds')));
					} else {
						WikiFactory::SetVarById( 599, $wgCityId, $pref->mAdminSkin, 'via SkinChooser');
						$wgAdminSkin = $pref->mAdminSkin;
						$log->addEntry( 'var_set', $wgTitle, '', array(wfMsg('skin'), $pref->mAdminSkin));
					}
					WikiFactory::clearCache( $wgCityId );
				}
			}
		}

		// disable $wgAllowUserSkin so skin preference can be set only here
		global $wgAllowUserSkin;
		self::$wgAllowUserSkinOriginal = $wgAllowUserSkin;

		$wgAllowUserSkin = false;

		// set skin
		if ( !is_null($pref->mSkin) ) {
			self::setUserOption('skin', $pref->mSkin);
		}

		// set theme
		if ( !is_null($pref->mTheme) ) {
			self::setUserOption('theme', $pref->mTheme);
		}

		// set skinoverwrite
		self::setUserOption('skinoverwrite', $pref->mToggles['skinoverwrite']);
		unset($pref->mToggles['skinoverwrite']);

		return true;
	}

	/**
	 * This method is called after preferences are updated
	 *
	 * Value of $wgAllowUserSkin will be restored here
	 */
	public static function savePreferencesAfter($prefs, $wgUser, &$msg, $oldOptions) {
		global $wgAllowUserSkin;

		// restore value of $wgAllowUserSkin
		$wgAllowUserSkin = self::$wgAllowUserSkinOriginal;

		return true;
	}

	/**
	 * Extra user options related to SkinChooser
	 */
	public static function skinChooserExtraToggle(&$extraToggle) {
		$extraToggle[] = 'skinoverwrite';
		$extraToggle[] = 'showAds';
		return true;
	}

	/**
	 * Render skin chooser form for Special:Preferences
	 */
	public static function renderSkinPreferencesForm($pref) {
		global $wgOut, $wgSkinTheme, $wgSkipSkins, $wgStylePath, $wgSkipThemes, $wgUser, $wgDefaultSkin, $wgDefaultTheme, $wgSkinPreviewPage, $wgAdminSkin, $wgSkipOldSkins, $wgForceSkin, $wgEnableAnswers;

		// don't show "See custom wikis" inside misc tab
		$pref->mUsedToggles['skinoverwrite'] = true;

		// hacks for Answers
		if (!empty($wgEnableAnswers)) {
			$pref->mSkin = 'answers';
			$pref->mTheme = self::getUserOption('theme');
		}

		if(!empty($wgForceSkin)) {
			$wgOut->addHTML(wfMsg('skin-forced'));
			$wgOut->addHTML('<div style="display:none;">'.self::getToggle('skinoverwrite').'</div>');

			self::log(__METHOD__, "skin is forced ({$wgForceSkin})");
			return false;
		}

		if(!empty($wgAdminSkin)) {
			$defaultSkinKey = $wgAdminSkin;
		} else if(!empty($wgDefaultTheme)) {
			$defaultSkinKey = $wgDefaultSkin . '-' . $wgDefaultTheme;
		} else {
			$defaultSkinKey = $wgDefaultSkin;
		}

		# Load list of skin names
		$validSkinNames = Skin::getSkinNames();

		# And sort them
		foreach ($validSkinNames as $skinkey => & $skinname ) {
			if ( isset( $skinNames[$skinkey] ) )  {
				$skinname = $skinNames[$skinkey];
			}
		}
		asort($validSkinNames);

		$validSkinNames2 = $validSkinNames;

		$previewtext = wfMsg('skin-preview');
		//ticket #2428 - Marooned
		if(isset($wgSkinPreviewPage) && is_string($wgSkinPreviewPage)) {
			$previewLinkTemplate = Title::newFromText($wgSkinPreviewPage)->getLocalURL('useskin=');
		} else {
			$mptitle = Title::newMainPage();
			$previewLinkTemplate = $mptitle->getLocalURL('useskin=');
		}

		# Used to display different background color every 2nd section
		$themeCount = 0;
		$skinKey = "";

		$wgOut->addHTML('<div '.($themeCount++%2!=1 ? 'class="prefSection"' : '').'>');
		$wgOut->addHTML('<h5>'.wfMsg('site-layout').'</h5>');

		$wgOut->addHTML('<div><input type="radio" value="oasis" id="wpSkinoasis" name="wpSkin"'.($pref->mSkin == 'oasis' ? ' checked="checked"' : '').'/><label for="wpSkinoasis">'.wfMsg('new-look').'</label> '.($skinKey == $defaultSkinKey ? ' (' . wfMsg( 'default' ) . ')' : '').'</div>');
		
		$oldSkinNames = array();
		foreach($validSkinNames as $skinKey => $skinVal) {
			if ($skinKey=='oasis' || ( ( in_array( $skinKey, $wgSkipSkins ) || in_array( $skinKey, $wgSkipOldSkins )) && !($skinKey == $pref->mSkin) ) ) {
				continue;
			}
			$oldSkinNames[$skinKey] = $skinVal;
		}

		# Display radio buttons for rest of skin
		if(count($oldSkinNames) > 0) {
			foreach($oldSkinNames as $skinKey => $skinVal) {
				$previewlink = '<a target="_blank" href="'.htmlspecialchars($previewLinkTemplate.$skinKey).'">'.$previewtext.'</a>';
				$wgOut->addHTML('<div><input type="radio" value="'.$skinKey.'" id="wpSkin'.$skinKey.'" name="wpSkin"'.($pref->mSkin == $skinKey ? ' checked="checked"' : '').'/><label for="wpSkin'.$skinKey.'">'.$skinVal.'</label> '.$previewlink.($skinKey == $defaultSkinKey ? ' (' . wfMsg( 'default' ) . ')' : '').'</div>');
			}
		}
		
		$wgOut->addHTML($pref->getToggle('showAds'));

		$wgOut->addHTML('</div>');

		# Display ComboBox for admins/staff only
		if( $wgUser->isAllowed( 'setadminskin' ) ) {

			$wgOut->addHTML("<br/><h2>".wfMsg('admin_skin')."</h2>".wfMsg('defaultskin_choose'));
			$wgOut->addHTML('<select name="adminSkin" id="adminSkin">');

			foreach($wgSkinTheme as $skinKey => $skinVal) {

				# Do not display skins which are defined in wgSkipSkins array
				if(in_array($skinKey, $wgSkipSkins)) {
					continue;
				}
				if($skinKey == 'quartz') {
					$skinKeyA = explode('-', $wgAdminSkin);
					if($skinKey != $skinKeyA[0]) {
						continue;
					}
				}

				if(count($wgSkinTheme[$skinKey]) > 0) {
					$wgOut->addHTML('<optgroup label="'.wfMsg($skinKey . '_skins').'">');
					foreach($wgSkinTheme[$skinKey] as $themeKey => $themeVal) {

						# Do not display themes which are defined in wgSkipThemes
						if(isset($wgSkipThemes[$skinKey]) && in_array($themeVal, $wgSkipThemes[$skinKey])) {
							continue;
						}
						if($skinKey == 'quartz') {
							if($themeVal != $skinKeyA[1]) {
								continue;
							}
						}
						$skinkey = $skinKey . '-' . $themeVal;
						$wgOut->addHTML("<option value='{$skinkey}'".($skinkey == $wgAdminSkin ? ' selected' : '').">".wfMsg($skinkey)."</option>");
					}
					$wgOut->addHTML('</optgroup>');
				}
			}
			$wgOut->addHTML("<option value='ds'".(empty($wgAdminSkin) ? ' selected' : '').">".wfMsg('adminskin_ds')."</option>");
			$wgOut->addHTML('</select>');

			wfLoadExtensionMessages('SkinChooser');
			$wgOut->addWikiMsg( 'skinchooser-customcss' );
		} else {
			$wgOut->addHTML('<br/>');
			if(!empty($wgAdminSkin)) {
				$elems = explode('-', $wgAdminSkin);
				$skin = ( array_key_exists(0, $elems) ) ? $elems[0] : null;
				$theme = ( array_key_exists(1, $elems) ) ? $elems[1] : null;
				if($theme != 'custom') {
					$wgOut->addHTML(wfMsg('defaultskin1', wfMsg($skin.'_skins').' '.wfMsg($wgAdminSkin)));
				} else {
					global $wgEnableAnswers;
					if( !empty($wgEnableAnswers) ) {
						$skinname = 'Answers';
					} else {
						$skinname = ucfirst($skin);
					}
					$wgOut->addHTML(wfMsgForContent('defaultskin2', wfMsg($skin.'_skins').' '.wfMsg($wgAdminSkin), Skin::makeNSUrl($skinname.'.css','',NS_MEDIAWIKI)));
				}
			} else {
				if(empty($wgDefaultTheme)) {
					$name = $validSkinNames2[$wgDefaultSkin];
				} else {
					$name = wfMsg($wgDefaultSkin.'_skins').' '.wfMsg($wgDefaultSkin.'-'.$wgDefaultTheme);
				}
				$wgOut->addHTML(wfMsg('defaultskin3',$name));
			}
		}

		return false;
	}

	/**
	 * Select proper skin and theme based on user preferences / default settings
	 */
	public static function getSkin($user) {
		global $wgCookiePrefix, $wgCookieExpiration, $wgCookiePath, $wgCookieDomain, $wgCookieSecure, $wgDefaultSkin, $wgDefaultTheme;
		global $wgVisitorSkin, $wgVisitorTheme, $wgOldDefaultSkin, $wgSkinTheme, $wgOut, $wgForceSkin, $wgRequest, $wgHomePageSkin, $wgTitle;
		global $wgAdminSkin, $wgSkipSkins, $wgArticle, $wgRequest;
		$isOasisPublicBeta = $wgDefaultSkin == 'oasis';

		wfProfileIn(__METHOD__);

		if(!($wgTitle instanceof Title) || in_array( self::getUserOption('skin'), $wgSkipSkins )) {
			$user->mSkin = &Skin::newFromKey(isset($wgDefaultSkin) ? $wgDefaultSkin : 'monobook');
			wfProfileOut(__METHOD__);
			return false;
		}

		// change to custom skin for home page
		if( !empty( $wgHomePageSkin ) ) {
			$overrideSkin = false;
			$mainPrefixedText = Title::newMainPage()->getPrefixedText();
			if ( $wgTitle->getPrefixedText() === $mainPrefixedText ) {
				// we're on the main page
				$overrideSkin = true;
			} elseif ( $wgTitle->isRedirect() && $wgRequest->getVal( 'redirect' ) !== 'no' ) {
				// not on main page, but page is redirect -- check where we're going next
				$tempArticle = new Article( $wgTitle );
				if ( !is_null( $tempArticle ) ) {
					$rdTitle = $tempArticle->getRedirectTarget();
					if ( !is_null( $rdTitle ) && $rdTitle->getPrefixedText() == $mainPrefixedText ) {
						// current page redirects to main page
						$overrideSkin = true;
					}
				}
			}
			if ( $overrideSkin ) {
				$user->mSkin = &Skin::newFromKey( $wgHomePageSkin );
				wfProfileOut(__METHOD__);
				return false;
			}
		}

		if( $wgRequest->getVal('useskin') == 'oasis' ) {
			$wgRequest->setVal('useskin', 'monaco');
		}
		if( $wgRequest->getVal('useskin') == 'wikia' ) {
			$wgRequest->setVal('useskin', 'oasis');
		}
		if(!empty($wgForceSkin)) {
			$wgForceSkin = $wgRequest->getVal('useskin', $wgForceSkin);
			$elems = explode('-', $wgForceSkin);
			$userSkin = ( array_key_exists(0, $elems) ) ? $elems[0] : null;
			$userTheme = ( array_key_exists(1, $elems) ) ? $elems[1] : null;

			$user->mSkin = &Skin::newFromKey($userSkin);
			$user->mSkin->themename = $userTheme;

			// FIXME: add support for oasis themes
			if ($userSkin == 'oasis') {
				$user->mSkin->themename = $wgRequest->getVal('usetheme', $userTheme);
			}

			self::log(__METHOD__, "forced skin to be {$wgForceSkin}");

			wfProfileOut(__METHOD__);
			return false;
		}

		if(!empty($wgVisitorTheme) && $wgVisitorSkin == 'quartz') {
			$wgVisitorSkin .= $wgVisitorTheme;
		}

		# Get rid of 'wgVisitorSkin' variable, but sometimes create new one 'wgOldDefaultSkin'
		if($wgDefaultSkin == 'monobook' && substr($wgVisitorSkin, 0, 6) == 'quartz') {
			$wgOldDefaultSkin = $wgDefaultSkin;
			$wgDefaultSkin = $wgVisitorSkin;
		}
		unset($wgVisitorSkin);
		unset($wgVisitorTheme);

		if(strlen($wgDefaultSkin) > 7 && substr($wgDefaultSkin, 0, 6) == 'quartz') {
			$wgDefaultTheme=substr($wgDefaultSkin, 6);
			$wgDefaultSkin='quartz';
		}

		# Get skin logic
		wfProfileIn(__METHOD__.'::GetSkinLogic');

		if(!$user->isLoggedIn()) { # If user is not logged in
			if(!empty($wgAdminSkin) && !$isOasisPublicBeta) {
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
			if(empty($userSkin)) {
				if(!empty($wgAdminSkin)) {
					$adminSkinArray = explode('-', $wgAdminSkin);
					$userSkin = isset($adminSkinArray[0]) ? $adminSkinArray[0] : null;
					$userTheme = isset($adminSkinArray[1]) ? $adminSkinArray[1] : null;
				} else {
					$userSkin = 'monaco';
				}	
			}
		}
		wfProfileOut(__METHOD__.'::GetSkinLogic');

		$useskin = $wgRequest->getVal('useskin', $userSkin);
		$elems = explode('-', $useskin);
		$userSkin = ( array_key_exists(0, $elems) ) ? $elems[0] : null;
		$userTheme = ( array_key_exists(1, $elems) ) ? $elems[1] : $userTheme;
		$userTheme = $wgRequest->getVal('usetheme', $userTheme);

		if(empty($userTheme) && strpos($userSkin, 'quartz-') === 0) {
			$userSkin = 'quartz';
			$userTheme = '';
		}

		if($userSkin == 'monacoold') {
			global $wgUseMonaco2;
			$wgUseMonaco2 = null;
			$userSkin = 'monaco';
		}
		if($userSkin == 'monaconew') {
			global $wgUseMonaco2;
			$wgUseMonaco2 = true;
			$userSkin = 'monaco';
		}
		//fix for RT#20005 - Marooned
		global $wgEnableAnswers;
		if ($userSkin == 'answers' && empty($wgEnableAnswers)) {
			$userSkin = 'monaco';
		}

		if( !$isOasisPublicBeta && $userSkin == 'oasis' && !$user->isAllowed( 'devcookie' ) ) {
			$userSkin = 'monaco';
		}

		$user->mSkin = &Skin::newFromKey($userSkin);

		$normalizedSkinName = substr(strtolower(get_class($user->mSkin)),4);

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

			$user->mSkin->themename = $userTheme;
			
			# force default theme on monaco and oasis when there is no admin setting
			if(($normalizedSkinName == 'monaco' || $normalizedSkinName == 'oasis') && (empty($wgAdminSkin) || $isOasisPublicBeta) ) {
				$user->mSkin->themename = $wgDefaultTheme;
			}

			self::log(__METHOD__, "using theme {$userTheme}");
			wfProfileOut(__METHOD__.'::NormalizeThemeName');
		}

		// FIXME: add support for oasis themes
		if ($normalizedSkinName == 'oasis') {
			$user->mSkin->themename = $wgRequest->getVal('usetheme');
		}

		wfProfileOut(__METHOD__);
		return false;
	}

	private static function log($method, $msg) {
		wfDebug("{$method}: {$msg}\n");
	}
	
}
