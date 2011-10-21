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

		//Tab 2: Appearance
		unset($defaultPreferences['imagesize']);
		unset($defaultPreferences['thumbsize']);
		unset($defaultPreferences['math']);

		//Tab 6: Followed pages
		$defaultPreferences['watchlistdays']['help'] = '';
		$defaultPreferences['wllimit']['help'] = '';

		return true;
	}

}
