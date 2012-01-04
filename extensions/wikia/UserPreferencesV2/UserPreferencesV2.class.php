<?php
class UserPreferencesV2 {

	/**
	 * @brief This function change user preferences special page
	 *
	 * @param user reference to the current user
	 * @param defaultPreferences reference to the default preferences array
	 *
	 * @return Bool
	 */

	public function onGetPreferences($user, $defaultPreferences) {
		global $wgEnableWallExt, $wgOut, $wgScriptPath, $wgUser;

		//add javascript
		$wgOut->addScriptFile($wgScriptPath . '/extensions/wikia/UserPreferencesV2/js/UserPreferencesV2.js');
		//Tab 1: User Profile
		unset($defaultPreferences['userid']);
		unset($defaultPreferences['editcount']);
		unset($defaultPreferences['registrationdate']);
		unset($defaultPreferences['realname']);
		unset($defaultPreferences['rememberpassword']);
		unset($defaultPreferences['ccmeonemails']);
		$defaultPreferences['username']['label-message'] = 'preferences-v2-username';
		$defaultPreferences['usergroups']['label-message'] = 'preferences-v2-usergroups';
		$defaultPreferences['gender']['label-message'] = 'preferences-v2-gender';
		$defaultPreferences['gender']['help-message'] = '';
		$defaultPreferences['password']['label-message'] = 'preferences-v2-password';
		$defaultPreferences['oldsig']['label-message'] = 'preferences-v2-oldsig';
		$defaultPreferences['nickname']['label-message'] = 'preferences-v2-nickname';
		$defaultPreferences['fancysig']['label-message'] = 'preferences-v2-fancysig';
		$defaultPreferences['fancysig']['help-message'] = '';
		$defaultPreferences['language']['section'] = 'personal/appearance';
		$defaultPreferences = $this->moveToEndOfArray($defaultPreferences, 'language');
		$defaultPreferences['date']['section'] = 'personal/appearance';
		$defaultPreferences['date']['type'] = 'select';
		$defaultPreferences['date']['label-message'] = 'preferences-v2-date';
		$defaultPreferences = $this->moveToEndOfArray($defaultPreferences, 'date');
		$defaultPreferences['timecorrection']['section'] = 'personal/appearance';
		$defaultPreferences['timecorrection']['label-message'] = 'preferences-v2-time';
		$defaultPreferences = $this->moveToEndOfArray($defaultPreferences, 'timecorrection');
		$defaultPreferences['skin']['section'] = 'personal/appearance';
		$defaultPreferences['skin']['type'] = 'select';
		$defaultPreferences['skin']['label-message'] = 'preferences-v2-skin';
		$defaultPreferences = $this->moveToEndOfArray($defaultPreferences, 'skin');
		$redirectOptions[wfMsg('preferences-v2-redirect-enable')] = false;
		$redirectOptions[wfMsg('preferences-v2-redirect-disable')] = true;
		$defaultPreferences['myhomedisableredirect']['type'] = 'select';
		$defaultPreferences['myhomedisableredirect']['options'] = $redirectOptions;
		$defaultPreferences['myhomedisableredirect']['label-message'] = 'preferences-v2-myhomedisableredirect';
		$defaultPreferences['myhomedisableredirect']['section'] = 'personal/appearance';
		$defaultPreferences = $this->moveToEndOfArray($defaultPreferences, 'myhomedisableredirect');
		$defaultPreferences['showAds']['section'] = 'personal/appearance';
		$defaultPreferences['showAds']['label-message'] = 'tog-showAdsv2';
		$defaultPreferences['showAds']['type'] = 'select';
		$adOptions[wfMsg('preferences-v2-showads-disable')] = false;
		$adOptions[wfMsg('preferences-v2-showads-enable')] = true;
		$defaultPreferences['showAds']['options'] = $adOptions;
		$defaultPreferences = $this->moveToEndOfArray($defaultPreferences, 'showAds');
		$defaultPreferences = $this->moveToEndOfArray($defaultPreferences, 'myhomedisableredirect');

		//Tab 2: Email
		unset($defaultPreferences['imagesize']);
		unset($defaultPreferences['thumbsize']);
		unset($defaultPreferences['math']);
		$defaultPreferences['emailaddress']['section'] = 'emailv2/addressv2';
		$defaultPreferences['emailaddress']['label-message'] = 'preferences-v2-my-email-address';
		$defaultPreferences['emailauthentication']['section'] = 'emailv2/addressv2';
		
		$defaultPreferences['watchdefault']['section'] = 'emailv2/followed-pages-iv2';
		$defaultPreferences['watchdefault']['label-message'] = 'preferences-v2-watchdefault';
		$defaultPreferences['watchmoves']['section'] = 'emailv2/followed-pages-iv2';
		$defaultPreferences['watchmoves']['label-message'] = 'preferences-v2-watchmoves';
		if (in_array("autoconfirmed", $wgUser->getEffectiveGroups()) || $wgUser->isEmailConfirmed()) {
			$defaultPreferences['watchdeletion']['section'] = 'emailv2/followed-pages-iv2';
			$defaultPreferences['watchdeletion']['label-message'] = 'preferences-v2-watchdeletion';
			$defaultPreferences['watchdeletion']['type'] = 'toggle';
		}
		$defaultPreferences['watchcreations']['section'] = 'emailv2/followed-pages-iv2';
		$defaultPreferences['watchcreations']['label-message'] = 'preferences-v2-watchcreations';
		
		$defaultPreferences['enotifwatchlistpages']['section'] = 'emailv2/email-me-v2';
		$defaultPreferences['enotifwatchlistpages']['label-message'] = 'tog-enotifwatchlistpages-v2';
		$defaultPreferences = $this->moveToEndOfArray($defaultPreferences, 'enotifwatchlistpages');
		$defaultPreferences['enotifminoredits']['section'] = 'emailv2/email-me-v2';
		$defaultPreferences['enotifminoredits']['label-message'] = 'tog-enotifminoredits-v2';
		$defaultPreferences = $this->moveToEndOfArray($defaultPreferences, 'enotifminoredits');
		$defaultPreferences['enotifusertalkpages']['section'] = 'emailv2/email-me-v2';
		$defaultPreferences['enotifusertalkpages']['label-message'] = 'tog-enotifusertalkpages-v2';
		$defaultPreferences = $this->moveToEndOfArray($defaultPreferences, 'enotifusertalkpages');
		$defaultPreferences['marketingallowed']['section'] = 'emailv2/email-me-v2';
		$defaultPreferences['marketingallowed']['label-message'] = 'tog-marketingallowed-v2';
		$defaultPreferences = $this->moveToEndOfArray($defaultPreferences, 'marketingallowed');
		$defaultPreferences['watchlistdigest']['section'] = 'emailv2/email-me-v2';
		$defaultPreferences['watchlistdigest']['label-message'] = 'tog-watchlistdigest-v2';
		$defaultPreferences = $this->moveToEndOfArray($defaultPreferences, 'watchlistdigest');
		$defaultPreferences['marketingallowed']['section'] = 'emailv2/email-me-v2';
		$defaultPreferences = $this->moveToEndOfArray($defaultPreferences, 'marketingallowed');
		if($wgEnableWallExt) {
			$defaultPreferences = $this->moveToEndOfArray($defaultPreferences, 'enotifwallthread');
			$defaultPreferences = $this->moveToEndOfArray($defaultPreferences, 'enotifmywall');
		}

		$defaultPreferences['htmlemails']['section'] = 'emailv2/email-advanced-v2';
		$defaultPreferences['htmlemails']['label-message'] = 'tog-htmlemails-v2';
		$defaultPreferences = $this->moveToEndOfArray($defaultPreferences, 'htmlemails');
		$defaultPreferences['disablemail']['section'] = 'emailv2/email-advanced-v2';
		$defaultPreferences = $this->moveToEndOfArray($defaultPreferences, 'disablemail');
		$defaultPreferences['enotifrevealaddr']['section'] = 'emailv2/email-advanced-v2';
		$defaultPreferences = $this->moveToEndOfArray($defaultPreferences, 'enotifrevealaddr');
		if ( array_key_exists('watchlistdigestclear', $defaultPreferences) ) {
			$defaultPreferences['watchlistdigestclear']['section'] = 'emailv2/email-advanced-v2';
			$defaultPreferences = $this->moveToEndOfArray($defaultPreferences, 'watchlistdigestclear');
		}

		$defaultPreferences['unsubscribed']['section'] = 'emailv2/email-unsubscribe';
		$defaultPreferences['unsubscribed']['label-message'] = 'unsubscribe-preferences-toggle-v2';
		$defaultPreferences = $this->moveToEndOfArray($defaultPreferences, 'unsubscribed');
		
		//Tab 3: Editing
		$defaultPreferences['watchlistdays']['help'] = '';
		$defaultPreferences['wllimit']['help'] = '';
		unset($defaultPreferences['nowserver']);
		unset($defaultPreferences['nowlocal']);
		unset($defaultPreferences['underline']);
		unset($defaultPreferences['stubthreshold']);
		unset($defaultPreferences['highlightbroken']);
		unset($defaultPreferences['toggle']);
		unset($defaultPreferences['showtoc']);
		unset($defaultPreferences['nocache']);
		unset($defaultPreferences['showhiddencats']);
		unset($defaultPreferences['showjumplinks']);
		unset($defaultPreferences['numberheadings']);
		$defaultPreferences['enablerichtext']['section'] = 'editing/editing-experience';
		$defaultPreferences['disablelinksuggest']['section'] = 'editing/editing-experience';
		$defaultPreferences = $this->moveToEndOfArray($defaultPreferences, 'disablelinksuggest');
		if ($user->mOptions['skin'] == 'monobook') {
			$defaultPreferences['showtoolbar']['section'] = 'editing/monobookv2';
			$defaultPreferences = $this->moveToEndOfArray($defaultPreferences, 'showtoolbar');
			$defaultPreferences['previewontop']['section'] = 'editing/monobookv2';
			$defaultPreferences = $this->moveToEndOfArray($defaultPreferences, 'previewontop');
			$defaultPreferences['previewonfirst']['section'] = 'editing/monobookv2';
			$defaultPreferences = $this->moveToEndOfArray($defaultPreferences, 'previewonfirst');
			$defaultPreferences['cols']['section'] = 'editing/monobookv2';
			$defaultPreferences = $this->moveToEndOfArray($defaultPreferences, 'cols');
			$defaultPreferences['rows']['section'] = 'editing/monobookv2';
			$defaultPreferences = $this->moveToEndOfArray($defaultPreferences, 'rows');
		}
		$defaultPreferences['editsectiononrightclick']['label-message'] = 'tog-editsectiononrightclick-v2';
		$defaultPreferences['editondblclick']['label-message'] = 'tog-editondblclick-v2';
		$defaultPreferences['disablecategoryselect']['section'] = 'editing/starting-an-edit';
		$defaultPreferences = $this->moveToEndOfArray($defaultPreferences, 'disablecategoryselect');

		//Tab 4: Under the Hood
		$defaultPreferences['rcdays']['section'] = 'under-the-hood/recent-changesv2';
		$defaultPreferences['rcdays']['help'] = '';
		$defaultPreferences['rclimit']['section'] = 'under-the-hood/recent-changesv2';
		$defaultPreferences['rclimit']['help'] = '';
		$defaultPreferences['rclimit']['help-message'] = '';
		$defaultPreferences['usenewrc']['section'] = 'under-the-hood/recent-changesv2';
		$defaultPreferences['hideminor']['section'] = 'under-the-hood/recent-changesv2';
		$defaultPreferences['watchlistdays']['section'] = 'under-the-hood/followed-pagesv2';
		$defaultPreferences['watchlistdays']['help'] = '';
		$defaultPreferences['wllimit']['section'] = 'under-the-hood/followed-pagesv2';
		$defaultPreferences['wllimit']['help'] = '';
		$defaultPreferences['extendwatchlist']['section'] = 'under-the-hood/followed-pagesv2';
		$defaultPreferences['watchlisthideminor']['section'] = 'under-the-hood/followed-pagesv2';
		$defaultPreferences['watchlisthidebots']['section'] = 'under-the-hood/followed-pagesv2';
		$defaultPreferences['watchlisthideown']['section'] = 'under-the-hood/followed-pagesv2';
		$defaultPreferences['watchlisthideanons']['section'] = 'under-the-hood/followed-pagesv2';
		$defaultPreferences['watchlisthideliu']['section'] = 'under-the-hood/followed-pagesv2';
		$defaultPreferences['watchlisttoken']['section'] = 'under-the-hood/followed-pagesv2';
		$defaultPreferences['searchlimit']['section'] = 'under-the-hood/searchv2';
		$defaultPreferences['searchlimit']['label-message'] = 'resultsperpage-v2';
		$defaultPreferences['contextlines']['section'] = 'under-the-hood/searchv2';
		$defaultPreferences['contextlines']['label-message'] = 'contextlines-v2';
		$defaultPreferences['contextchars']['section'] = 'under-the-hood/searchv2';
		$defaultPreferences['contextchars']['label-message'] = 'contextchars-v2';
		$defaultPreferences['disablesuggest']['section'] = 'under-the-hood/searchv2';
		$defaultPreferences['searcheverything']['section'] = 'under-the-hood/searchv2';
		$defaultPreferences['searchnamespaces']['section'] = 'under-the-hood/searchv2';
		$defaultPreferences['highlightbroken']['section'] = 'under-the-hood/advanced-displayv2';
		$defaultPreferences['highlightbroken']['type'] = 'toggle';
		$defaultPreferences['highlightbroken']['label-message'] = 'tog-highlightbrokenv2';
		$defaultPreferences['showtoc']['section'] = 'under-the-hood/advanced-displayv2';
		$defaultPreferences['showtoc']['type'] = 'toggle';
		$defaultPreferences['showtoc']['label-message'] = 'tog-showtoc';
		$defaultPreferences['nocache']['section'] = 'under-the-hood/advanced-displayv2';
		$defaultPreferences['nocache']['type'] = 'toggle';
		$defaultPreferences['nocache']['label-message'] = 'tog-nocache';
		$defaultPreferences['showhiddencats']['section'] = 'under-the-hood/advanced-displayv2';
		$defaultPreferences['showhiddencats']['type'] = 'toggle';
		$defaultPreferences['showhiddencats']['label-message'] = 'tog-showhiddencats';
		$defaultPreferences['showjumplinks']['section'] = 'under-the-hood/advanced-displayv2';
		$defaultPreferences['showjumplinks']['type'] = 'toggle';
		$defaultPreferences['showjumplinks']['label-message'] = 'tog-showjumplinks';
		$defaultPreferences['justify']['section'] = 'under-the-hood/advanced-displayv2';
		$defaultPreferences['justify']['type'] = 'toggle';
		$defaultPreferences['justify']['label-message'] = 'tog-justify';
		$defaultPreferences['numberheadings']['section'] = 'under-the-hood/advanced-displayv2';
		$defaultPreferences['numberheadings']['type'] = 'toggle';
		$defaultPreferences['numberheadings']['label-message'] = 'tog-numberheadings';
		$defaultPreferences['diffonly']['section'] = 'under-the-hood/advanced-displayv2';
		$defaultPreferences['norollbackdiff']['section'] = 'under-the-hood/advanced-displayv2';
		$defaultPreferences['hidefollowedpages']['section'] = 'under-the-hood/advanced-displayv2';
		$defaultPreferences['hidefollowedpages']['label-message'] = 'tog-hidefollowedpages-v2';
		$defaultPreferences = $this->moveToEndOfArray($defaultPreferences, 'hidefollowedpages');
		if ($user->mOptions['skin'] == 'monobook') {
			$defaultPreferences['justify']['section'] = 'under-the-hood/advanced-displayv2';
			$defaultPreferences['justify']['label-message'] = 'tog-justify-v2';
			$defaultPreferences = $this->moveToEndOfArray($defaultPreferences, 'justify');
		}
		else unset($defaultPreferences['justify']);
		if($wgEnableWallExt) {
			$defaultPreferences = $this->moveToEndOfArray($defaultPreferences, 'wallshowsource');
		}
		unset($defaultPreferences['enotiffollowedpages']);
		unset($defaultPreferences['enotiffollowedminoredits']);
		unset($defaultPreferences['nocache']);
		unset($defaultPreferences['numberheadings']);
		unset($defaultPreferences['showjumplinks']);

		return true;
	}
	
	public function moveToEndOfArray($array, $key) {
		$temp[$key] = $array[$key];
		unset($array[$key]);
		return array_merge($array, $temp);
	}

}
