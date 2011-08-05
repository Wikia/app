<?php

/**
 * Helper functions for Admin Dashboard
 */

class AdminDashboardLogic {
	
	/**
	 * @brief Helper function which determines whether to display the Admin Dashboard Chrome in the Oasis Skin
	 * @param type $title Title of page we are on
	 * @return type boolean 
	 */
	public static function displayAdminDashboard($app, $title) {
		// Admin Dashboard is only for logged in plus a list of groups
		if (!$app->wg->User->isLoggedIn()) return false;
		if (!$app->wg->User->isAllowed( 'admindashboard' )) return false;
		if ($title && $title->isSpecialPage()) {
			$exclusionList = array(
				"Connect", 
				"Contact",
				"Contributions",
				"CreatePage",
				"CreateNewWiki",
				"CreateTopList",
				"Following",
				"EditAccount",
				"EditTopList",
				"LayoutBuilder",
				"Leaderboard",
				"LookupContribs",
				"LookupUser",
				"MovePage",
				"MultiLookup",
				"NewFiles",
				"Our404Handler",
				"PageLayoutBuilder",
				"Phalanx",
				"PhalanxStats",
				"Preferences", 
				"ScavengerHunt",
				"Search",
				"Signup",
				"TaskManager",
				"ThemeDesigner",
				"ThemeDesignerPreview",
				"UserLogin",
				"UserPathPrediction",
				"Version",
				"WhereIsExtension",
				"WikiActivity",
				"WikiFactory",
				"WikiFactoryReporter",
				"WikiaLabs",
				"WikiStats",
			);
			return (!in_array($title->getDBKey(), $exclusionList));
		}
		return false;
	}
	
}