<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Piotr Molski <moli@wikia.com>
 * @version: $Id$
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension and cannot be used standalone.\n";
    exit( 1 ) ;
}

class ListusersHooks {	

	function __construct() { /* not used */ }

	/**
	 * redirect Special::Activeusers to Special::Listusers
	 *
	 * @author      Piotr Molski <moli@wikia-inc.com>
	 * @version     1.0.0
	 * @param       Array   $list
	 */	
	public static function Activeusers( &$list ) {
		wfProfileIn( __METHOD__ );		
		$list['Activeusers'] = array( 'SpecialRedirectToSpecial', 'Activeusers', Listusers::TITLE );
		wfProfileOut( __METHOD__ );		
		return true;
	}
	
	/**
	 * update list users table on user right change
	 *
	 * @author      Piotr Molski <moli@wikia-inc.com>
	 * @version     1.0.0
	 * @param       User    $user object
	 * @param       Array   $addgroup - selected groups for user
	 * @param       Array   $removegroup - disabled groups for user
	 */
	static public function updateUserRights( &$user, $addgroup, $removegroup ) {
		global $wgCityId;
		wfProfileIn( __METHOD__ );		
		$data = new ListusersData($this->mCityId, 0);
		if ( is_object($data) ) {
			$data->updateUserGroups( $user, $addgroup, $removegroup );
		}
		wfProfileOut( __METHOD__ );
		return true;
	}
}
