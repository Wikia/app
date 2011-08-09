<?php

/**
 * Helper functions for Admin Dashboard
 */

class AdminDashboardLogic {
	
	public static function isGeneralApp($appName) {
		$generalApps = array(
			'Categories' => true,
			'CreateBlogPage' => true,
			'CreatePage' => true,
			'Listusers' => true,
			'ListUsers' => true,
			'MultipleUpload' => true,
			'PageLayoutBuilder' => true,
			'Recentchanges' => true,
			'RecentChanges' => true,
			'ThemeDesigner' => true,
			'Upload' => true,
			'UserRights' => true,
			'WikiaLabs' => true,
		);
		return !empty($generalApps[$appName]);
	}

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
				"HuluVideoPanel",
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
				"LandingPageSmurfs",
			);
			return (!in_array($title->getDBKey(), $exclusionList));
		}
		return false;
	}
	
}
