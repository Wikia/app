<?php
/**#@+
*	A special page for initializing social profiles for existing wikis
* 	This is to be run once if you want to preserve existing user pages at User:xxx (otherwise
*	they will be moved to UserWiki:xxx)
*
* @package MediaWiki
* @subpackage SpecialPage
*
* @author David Pean <david.pean@gmail.com>
* @copyright Copyright © 2007, Wikia Inc.
* @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
*/

$wgExtensionFunctions[] = 'wfSpecialPopulateUserProfiles';

function wfSpecialPopulateUserProfiles(){
  global $wgUser,$IP;
  include_once("includes/SpecialPage.php");


class PopulateUserProfiles extends SpecialPage {

	
	function PopulateUserProfiles(){
		UnlistedSpecialPage::UnlistedSpecialPage("PopulateUserProfiles");
	}
	
	function execute(){
		global $wgRequest, $IP, $wgOut, $wgUser, $wgMemc;
		
		if( !in_array( "staff", $wgUser->getGroups())  ){
			$wgOut->errorpage('error', 'noaccess');
			return "";
		}
		
		
		$dbr =& wfGetDB( DB_MASTER );
		$res = $dbr->select( 'page', 
					array('page_title'), 
					array('page_namespace' => NS_USER), __METHOD__, 
					""
				);
				
		while( $row = $dbr->fetchObject($res) ){
			$user_name_title = Title::newFromDBkey( $row->page_title );
			$user_name = $user_name_title->getText();
			$user_id = User::idFromName( $user_name );
			
			if( $user_id > 0 ){
				
				$s = $dbr->selectRow( 'user_profile', array( 'up_user_id' ), array( 'up_user_id' => $user_id ), $fname );
				if ( $s === false ) {		
					$fname = 'user_profile::addToDatabase';
					$dbr =& wfGetDB( DB_MASTER );
					$dbr->insert( '`user_profile`',
						array(
							'up_user_id' => $user_id,
							'up_type' => 0
						), $fname
					);
					$count++;
				}
				
			}
		}
			
		$wgOut->addHTML("Added $count profiles");
	}
  
}

SpecialPage::addPage( new PopulateUserProfiles );

}

?>