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
			$alias = SpecialPageFactory::resolveAlias($bits[0])[0];


			// NOTE: keep this list in alphabetical order
			static $exclusionList = [
				'AbTesting',
				'ApiExplorer',
				'Chat',
				'CloseWiki',
				'Code',
				'CommunityTasks',
				'Community',
				'Confirmemail',
				'Connect',
				'Contact',
				'Contributions',
				'CreateBlogPage',
				'CreatePage',
				'CreateNewWiki',
				'CreateTopList',
				'Crunchyroll',
				'EditAccount',
				'EditTopList',
				'Flags',
				'Following',
				'Forum',
				'ImageReview',
				'Images',
				'InfoboxBuilder',
				'Insights',
				'Invalidateemail',
				'LandingPageSmurfs',
				'LayoutBuilder',
				'LayoutBuilderForm',
				'Leaderboard',
				'LookupContribs',
				'LookupUser',
				'ManageWikiaHome',
				'MiniEditor',
				'MovePage',
				'Maps',
				'MultiLookup',
				'NewFiles',
				'Newimages',
				'Our404Handler',
				'Phalanx',
				'PhalanxStats',
				'Places',
				'Play',
				'Preferences',
				'PromoteImageReview',
				'ScavengerHunt',
				'Search',
				'SendEmail',
				'Signup',
				'SiteWideMessages',
				'SponsorshipDashboard',
				'TaskManager',
				'ThemeDesigner',
				'ThemeDesignerPreview',
				'UnusedVideos',
				'UserActivity',
				'Userlogin',
				'UserManagement',
				'UserPathPrediction',
				'UserSignup',
				'Version',
				'VideoPageAdmin',
				'Videos',
				'WDACReview',
				'WhereIsExtension',
				'WikiActivity',
				'WikiaConfirmEmail',
				'WikiaHubsV3',
				'WikiaSearch',
				'WikiaStyleGuide',
				'WikiFactory',
				'WikiFactoryReporter',
			];
			return (!in_array($alias, $exclusionList));
		}
		return false;
	}

	/**
	 *  @brief hook to add toolbar item for admin dashboard
	 */
	static function onBeforeToolbarMenu( &$items, $type ) {
		$wg = F::app()->wg;
		if( $wg->User->isAllowed( 'admindashboard' ) && $type == 'main' ) {
			$items[] =  [
				'type' => 'html',
				'html' => Wikia::specialPageLink(
					'AdminDashboard',
					'admindashboard-toolbar-link',
					['data-tracking' => 'admindashboard/toolbar/admin']
				)
			];
		}
		return true;
	}

	/**
	 * For the special pages grouped in admin dashboard, update the HTML title, so it says:
	 * "Name of the special page - Admin Dashboard - Wiki name - Wikia"
	 *
	 * This hook adds the "Admin Dashboard" part.
	 *
	 * @param Title $title
	 * @param array $extraParts
	 * @return bool
	 */
	static function onWikiaHtmlTitleExtraParts( Title $title, array &$extraParts ) {
		if ( self::displayAdminDashboard( F::app(), $title ) && !$title->isSpecial( 'AdminDashboard' ) ) {
			$extraParts = [ wfMessage( 'admindashboard-header' ) ];
		}
		return true;
	}
}
