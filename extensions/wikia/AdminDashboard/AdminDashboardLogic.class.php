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
			'Userrights' => true,
			'WikiFeatures' => true,
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
			$bits = explode( '/', $title->getDBkey(), 2 );
			$alias = SpecialPage::resolveAlias($bits[0]);
		
			// NOTE: keep this list in alphabetical order
			static $exclusionList = array(
				"AdSS",
				"ApiExplorer",
				"Confirmemail",
				"Connect",
				"Contact",
				"Contributions",
				"CreateBlogPage",
				"CreatePage",
				"CreateNewWiki",
				"CreateTopList",
				"Crunchyroll",
				"CloseWiki",
				"Following",
				"EditAccount",
				"EditTopList",
				"HuluVideoPanel",
				"Invalidateemail",
				"LandingPageSmurfs",
				"LayoutBuilder",
				"LayoutBuilderForm",
				"Leaderboard",
				"LookupContribs",
				"LookupUser",
				"MovePage",
				"MultiLookup",
				"NewFiles",
				"Newimages",
				"Our404Handler",
				"PageLayoutBuilder",
				"PageLayoutBuilderForm",
				"Phalanx",
				"PhalanxStats",
				"PhotoPopSetup",
				"Preferences",
				"ScavengerHunt",
				"Search",
				"Signup",
				"SiteWideMessages",
				"SponsorshipDashboard",
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
				"WikiStats",
			);
			return (!in_array($alias, $exclusionList));
		}
		return false;
	}

	/**
	 * Set global color profile long before the page loads.
	 */
	public function onBeforeInitialize( &$title, &$article, &$output, &$user, $request, $mediaWiki ) {
		global $wgTitle;
		if(self::displayAdminDashboard(F::app(), $wgTitle)) {
			$profile = SassColorProfile::getInstance();
			$profile->setDualMode(true);
		}
		
		return $output;
	}

}
