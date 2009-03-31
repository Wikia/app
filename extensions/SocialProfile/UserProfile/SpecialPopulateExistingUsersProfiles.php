<?php
/**
 * A special page for initializing social profiles for existing wikis
 * This is to be run once if you want to preserve existing user pages at User:xxx (otherwise
 * they will be moved to UserWiki:xxx)
 *
 * @file
 * @ingroup Extensions
 * @author David Pean <david.pean@gmail.com>
 * @copyright Copyright © 2007, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

class SpecialPopulateUserProfiles extends SpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'PopulateUserProfiles' );
	}

	/**
	 * Show the special page
	 *
	 * @param $params Mixed: parameter(s) passed to the page or null
	 */
	public function execute( $params ) {
		global $wgRequest, $IP, $wgOut, $wgUser, $wgMemc;

		if( !in_array( 'staff', $wgUser->getGroups() ) ){
			$wgOut->errorpage('error', 'badaccess');
			return '';
		}

		$dbw = wfGetDB( DB_MASTER );
		$res = $dbw->select( 'page',
					array( 'page_title' ),
					array( 'page_namespace' => NS_USER ),
					__METHOD__,
					''
				);

		$count = 0; // To avoid an annoying PHP notice

		while( $row = $dbr->fetchObject($res) ){
			$user_name_title = Title::newFromDBkey( $row->page_title );
			$user_name = $user_name_title->getText();
			$user_id = User::idFromName( $user_name );

			if( $user_id > 0 ){
			//echo "user_name:{$user_name}/user_id:" . $user_id . "<br />";
			//$count++;

				$s = $dbw->selectRow( 'user_profile', array( 'up_user_id' ), array( 'up_user_id' => $user_id ), __METHOD__ );
				if ( $s === false ) {
					$dbw = wfGetDB( DB_MASTER );
					$dbw->insert( 'user_profile',
						array(
							'up_user_id' => $user_id,
							'up_type' => 0
						), __METHOD__
					);
					$count++;
				}
			}
		}

		$wgOut->addHTML( wfMsgExt( 'populate-user-profile-done', 'parsemag', $count ) );
	}
}