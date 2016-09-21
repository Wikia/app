<?php

/**
 * Helper functions for Admin Dashboard
 */
class AdminDashboardLogic {

	/**
	 * Returns whether the given special page belongs to the General section of Admin Dashboard
	 * @param string $appName Special page name
	 * @return bool Whether the given special page belongs to the General section of Admin Dashboard
	 */
	public static function isGeneralApp( $appName ) {
		$generalApps = [
			'Categories',
			'CreateBlogPage',
			'CreatePage',
			'CSS',
			'Listusers',
			'ListUsers',
			'MultipleUpload',
			'Recentchanges',
			'RecentChanges',
			'ThemeDesigner',
			'Upload',
			'UserRights',
			'Userrights',
			'WikiFeatures',
			'WikiaVideoAdd',
		];

		return in_array( $appName, $generalApps );
	}

	/**
	 * Hook: BeforeToolbarMenu
	 * Add toolbar item for admin dashboard
	 * @param array $items array of toolbar items (reference)
	 * @param string $type
	 * @return bool true to continue hook processing
	 */
	static function onBeforeToolbarMenu( &$items, $type ) {
		$wg = F::app()->wg;
		if ( $wg->User->isAllowed( 'admindashboard' ) && $type == 'main' ) {
			$items[] = [
				'type' => 'html',
				'html' => Wikia::specialPageLink(
					'AdminDashboard',
					'admindashboard-toolbar-link',
					[ 'data-tracking' => 'admindashboard/toolbar/admin' ]
				),
			];
		}
		return true;
	}
}
