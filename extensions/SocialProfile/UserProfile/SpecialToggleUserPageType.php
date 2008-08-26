<?php
/**#@+
 * A special page for updating a user's userpage preference (If they want a wiki user page or social profile user page
 * when someone browses to User:xxx
 *
 * @package MediaWiki
 * @subpackage SpecialPage
 *
 * @author David Pean <david.pean@gmail.com>
 * @copyright Copyright © 2007, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

class SpecialToggleUserPage extends UnlistedSpecialPage {
	function __construct() {
		parent::__construct( 'ToggleUserPage' );
	}

	function execute( $params ) {
		global $wgRequest, $IP, $wgOut, $wgUser, $wgMemc, $wgDBprefix;

		if( !$wgUser->isLoggedIn() ){
			$wgOut->errorpage('error', 'badaccess');
			return "";
		}

		$dbr = wfGetDB( DB_MASTER );
		$s = $dbr->selectRow( 'user_profile', array( 'up_user_id' ), array( 'up_user_id' => $wgUser->getID() ), $fname );
		if ( $s === false ) {
			$fname = $wgDBprefix.'user_profile::addToDatabase';
			$dbw = wfGetDB( DB_MASTER );
			$dbw->insert( 'user_profile',
				array(
					'up_user_id' => $wgUser->getID()
				), $fname
			);
		}

		$profile = new UserProfile( $wgUser->getName() );
		$profile_data = $profile->getProfile();

		$user_page_type = (( $profile_data["user_page_type"] == 1 )?0:1);

		$dbw = wfGetDB( DB_MASTER );
		$dbw->update( 'user_profile',
			array( /* SET */
			'up_type' => $user_page_type
			), array( /* WHERE */
			'up_user_id' => $wgUser->getID()
			), ""
		);

		$key = wfMemcKey( 'user', 'profile', 'info', $wgUser->getID() );
		$wgMemc->delete($key);

		if( $user_page_type == 1 && !$wgUser->isBlocked() ){
			$user_page = Title::makeTitle( NS_USER, $wgUser->getName() );
			$article = new Article( $user_page );
			$user_page_content = $article->getContent();

			$user_wiki_title = Title::makeTitle( NS_USER_WIKI, $wgUser->getName() );
			$user_wiki = new Article( $user_wiki_title );
			if( !$user_wiki->exists() ){
				$user_wiki->doEdit($user_page_content, "import user wiki" );
			}
		}
		$title = Title::makeTitle( NS_USER, $wgUser->getName() );
		$wgOut->redirect( $title->getFullURL() );
	}
}
