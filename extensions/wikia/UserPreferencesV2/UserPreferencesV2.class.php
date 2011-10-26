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

		return true;
	}
	
	public function moveToEndOfArray($array, $key) {
		$temp[$key] = $array[$key];
		unset($array[$key]);
		return array_merge($array, $temp);
	}

}
