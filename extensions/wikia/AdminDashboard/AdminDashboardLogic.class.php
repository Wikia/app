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
}
