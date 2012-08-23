<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mech
 * Date: 8/22/12
 * Time: 2:55 PM
 */

class BlogsHelper {

	/**
	 * add a tab to special search page
	 */
	public static function OnSpecialSearchProfiles(&$profiles) {

		$blogSearchProfile = array(
			'message' => 'blogs-searchprofile',
			'tooltip' => 'blogs-searchprofile-tooltip',
			'namespaces' => array( NS_BLOG_ARTICLE, NS_BLOG_LISTING )
		);

		if ( !array_key_exists('users', $profiles) ) {
			$profiles['blogs'] = $blogSearchProfile;
		} else {
			$newProfiles = array();
			foreach ($profiles as $k => $value) {
				if ($k === 'users') {
					$newProfiles['blogs'] = $blogSearchProfile;
				}
				$newProfiles[$k] = $value;
			}
			$profiles = $newProfiles;

		}

		return true;
	}
}
