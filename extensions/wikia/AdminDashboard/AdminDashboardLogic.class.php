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
			'CSS' => true,
			'Listusers' => true,
			'ListUsers' => true,
			'MultipleUpload' => true,
			'PageLayoutBuilder' => true,
			'Promote' => true,
			'Recentchanges' => true,
			'RecentChanges' => true,
			'ThemeDesigner' => true,
			'Upload' => true,
			'UserRights' => true,
			'Userrights' => true,
			'WikiFeatures' => true,
			'WikiaVideoAdd' => true,
		);
		return !empty($generalApps[$appName]);
	}

	/**
	 * @brief Helper function which determines whether to display the Admin Dashboard Chrome in the Oasis Skin
	 * @param WikiaApp $app
	 * @param Title $title Title of page we are on
	 * @return boolean
	 */
	public static function displayAdminDashboard($app, $title) {
		// Admin Dashboard is only for logged in plus a list of groups
		if (!$app->wg->User->isLoggedIn()) return false;
		if (!$app->wg->User->isAllowed( 'admindashboard' )) return false;
		if ($title && $title->isSpecialPage()) {
			$bits = explode( '/', $title->getDBkey(), 2 );
			$alias = array_shift(SpecialPageFactory::resolveAlias($bits[0]));


			// NOTE: keep this list in alphabetical order
			static $exclusionList = array(
				"AbTesting",
				"ApiExplorer",
				"ApiGate",
				"Chat",
				"CloseWiki",
				"Code",
				"Confirmemail",
				"Connect",
				"Contact",
				"Contributions",
				"CreateBlogPage",
				"CreatePage",
				"CreateNewWiki",
				"CreateTopList",
				"Crunchyroll",
				"EditAccount",
				"EditTopList",
				"Following",
				"Forum",
				"ImageReview",
				"Invalidateemail",
				"LandingPageSmurfs",
				"LayoutBuilder",
				"LayoutBuilderForm",
				"Leaderboard",
				"LicensedVideoSwap",
				"LookupContribs",
				"LookupUser",
				"ManageWikiaHome",
				"MiniEditor",
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
				"Places",
				"Play",
				"Preferences",
				"PromoteImageReview",
				"ScavengerHunt",
				"Search",
				"Signup",
				"SiteWideMessages",
				"SponsorshipDashboard",
				"StructuredData",
				"TaskManager",
				"ThemeDesigner",
				"ThemeDesignerPreview",
				"UnusedVideos",
				"Userlogin",
				"UserManagement",
				"UserPathPrediction",
				"UserSignup",
				"Version",
				"VideoPageAdmin",
				"Videos",
				"WDACReview",
				"WhereIsExtension",
				"WikiActivity",
				"WikiaConfirmEmail",
				"WikiaHubsV2",
				"WikiaSearch",
				"WikiaStyleGuide",
				"WikiFactory",
				"WikiFactoryReporter",
				"WikiStats",
			);
			return (!in_array($alias, $exclusionList));
		}
		return false;
	}

	/**
	 *  @brief hook to add toolbar item for admin dashboard
	 */
	static function onBeforeToolbarMenu(&$items) {
		$wg = F::app()->wg;
		if( $wg->User->isAllowed('admindashboard') ) {
			$item = array(
				'type' => 'html',
				'html' => Wikia::specialPageLink('AdminDashboard', 'admindashboard-toolbar-link', array('data-tracking' => 'admindashboard/toolbar/admin') )
			);

			if( is_array($items) ) {
				$isMenuSubElPresent = false;

				foreach($items as $el) {
					if( isset($el['type']) && $el['type'] === 'menu' ) {
						$isMenuSubElPresent = true;
						break;
					}
				}

				if( $isMenuSubElPresent ) {
					$items[] = $item;
				}
			} else {
				$items = array($item);
			}
		}
		return true;
	}
}
