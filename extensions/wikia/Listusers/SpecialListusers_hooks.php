<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Piotr Molski <moli@wikia.com>
 * @version: $Id$
 */

class ListusersHooks {

	/**
	 * redirect Special::Activeusers to Special::Listusers
	 *
	 * @author      Piotr Molski <moli@wikia-inc.com>
	 * @version     1.0.0
	 * @param       array   $list
	 * @return bool
	 */
	public static function Activeusers( &$list ) {
		wfProfileIn( __METHOD__ );
		$list['Activeusers'] = array( 'SpecialPage', 'Listusers' );
		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * update list users table on user right change
	 *
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/UserRights
	 *
	 * @author      Piotr Molski <moli@wikia-inc.com>
	 * @version     1.0.0
	 * @param       User    $user object
	 * @param       array   $addgroup - selected groups for user
	 * @param       array   $removegroup - disabled groups for user
	 * @return bool
	 */
	static public function updateUserRights( User $user, array $addgroup, array $removegroup ) {
		global $wgCityId;

		$data = new ListusersData($wgCityId);
		$data->updateUserGroups( $user, $addgroup, $removegroup );
		return true;
	}
}
