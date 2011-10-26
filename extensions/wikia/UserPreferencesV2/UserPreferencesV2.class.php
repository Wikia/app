<?php
class UserPreferencesV2 {

	public function __construct() {}

	/**
	 * @brief This function change user preferences special page
	 *
	 * @param user reference to the current user
	 * @param defaultPreferences reference to the default preferences array
	 *
	 * @return Bool
	 */

	public function onGetPreferences($user, $defaultPreferences) {

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
		$defaultPreferences = $this->moveToEndOfArray($defaultPreferences, 'showAds');

		//Tab 2: Email
		unset($defaultPreferences['imagesize']);
		unset($defaultPreferences['thumbsize']);
		unset($defaultPreferences['math']);
		$defaultPreferences['unsubscribed']['section'] = 'emailv2/emailv2';
		$defaultPreferences['emailaddress']['section'] = 'emailv2/emailv2';
		$defaultPreferences['emailauthentication']['section'] = 'emailv2/emailv2';
		$defaultPreferences['disablemail']['section'] = 'emailv2/emailv2';
		$defaultPreferences['ccmeonemails']['type'] = 'toggle';
		$defaultPreferences['ccmeonemails']['section'] = 'emailv2/emailv2';
		$defaultPreferences['ccmeonemails']['label-message'] = 'tog-ccmeonemails';
		$defaultPreferences['enotifwatchlistpages']['section'] = 'emailv2/emailv2';
		$defaultPreferences['enotifusertalkpages']['section'] = 'emailv2/emailv2';
		$defaultPreferences['enotifminoredits']['section'] = 'emailv2/emailv2';
		$defaultPreferences['enotifrevealaddr']['section'] = 'emailv2/emailv2';
		$defaultPreferences['htmlemails']['section'] = 'emailv2/emailv2';
		$defaultPreferences['marketingallowed']['section'] = 'emailv2/emailv2';

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
		unset($defaultPreferences['justify']);
		unset($defaultPreferences['numberheadings']);
		$defaultPreferences['enablerichtext']['section'] = 'editing/editing-experience';
		unset($defaultPreferences['disablelinksuggest']);
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
		$defaultPreferences['contextlines']['section'] = 'under-the-hood/searchv2';
		$defaultPreferences['contextchars']['section'] = 'under-the-hood/searchv2';
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



unset($defaultPreferences['watchdefault']);
unset($defaultPreferences['watchmoves']);
unset($defaultPreferences['watchdeletion']);
unset($defaultPreferences['watchcreations']);



unset($defaultPreferences['enotiffollowedpages']);
unset($defaultPreferences['enotiffollowedminoredits']);
unset($defaultPreferences['hidefollowedpages']);
unset($defaultPreferences['watchlistdigest']);




unset($defaultPreferences['diffonly']);
unset($defaultPreferences['norollbackdiff']);






		return true;
	}
	
	public function moveToEndOfArray($array, $key) {
		$temp[$key] = $array[$key];
		unset($array[$key]);
		return array_merge($array, $temp);
	}

}
