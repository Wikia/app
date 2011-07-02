<?php

/**
 * Helper functions for Control Center
 */

class ControlCenterLogic {
	
	/**
	 * @brief Helper function which determines whether to display the Control Center Chrome in the Oasis Skin
	 * @param type $title Title of page we are on
	 * @return type boolean 
	 */
	public static function displayControlCenter($app, $title) {
		
		// Control center is only for logged in plus a list of groups
		// FIXME: make this a right and add it to those groups instead
		if (!$app->wg->User->isLoggedIn()) return false;
		if (count(array_intersect(array('sysop', 'staff', 'bureaucrat'), $app->wg->User->getGroups())) == 0) return false;
		
		$pageList = array ( "ControlCenter", "UserRights", "ListUsers", "RecentChanges", "Categories", "MultipleUpload", "SponsorshipDashboard");
//		print_pre($title->getDBKey());
		if ($title && $title->isSpecialPage() && in_array($title->getDBKey(), $pageList)) {
			return true;
		}
		return false;
	}
	
}