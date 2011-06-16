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
	public static function displayControlCenter($title) {
		
		$pageList = array ( "ControlCenter", "UserRights", "ListUsers", "RecentChanges", "WikiaLabs", "Categories", "MultipleUpload", "SponsorshipDashboard");
//		print_pre($title->getDBKey());
		if ($title && $title->isSpecialPage() && in_array($title->getDBKey(), $pageList)) {
			return true;
		}
		return false;
	}
	
}