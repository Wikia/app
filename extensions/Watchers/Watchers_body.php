<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();
/**
 * Implements special page Watchers
 *
 * @author Magnus Manske
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

class SpecialWatchers extends UnlistedSpecialPage {

	/**
	 * Constructor
	*/
	function __construct() {
		parent::__construct( 'Watchers' );
		$this->includable( true );
	}

	/**
	 * Renders the special page
	*/
	function execute( $parameters ) {
		global $wgOut , $wgRequest , $wgUser , $wgWatchersLimit;

		wfLoadExtensionMessages( 'Watchers' );

		$out = "";
		$fname = "wfWatchersExtension::execute";
		$sk =&$wgUser->getSkin();
		$id = $wgRequest->getInt ( 'article' , 0 );
		$title = Title::newFromID ( $id );

		# Check for valid title
		if ( $id == 0 || $title->getArticleID() <= 0 ) {
			$out = wfMsg ( 'watchers_error_article' );
			$this->setHeaders();
			$wgOut->addHTML( $out );
			return;
		}

		$dbr =& wfGetDB( DB_SLAVE );
		$conds = array (
			'wl_namespace' => $title->getNamespace() ,
			'wl_title' => $title->getDBkey() ,
		);

		$watcherscountquery = $dbr->select(
			/* FROM   */ 'watchlist',
			/* SELECT */ 'count(wl_user) AS num',
			/* WHERE  */ $conds,
			$fname
		);

		$o = $dbr->fetchObject( $watcherscountquery );
		$watcherscount = $o->num;

		$link1 = $sk->makeLinkObj( $title );
		$out .= "<h2>" . wfMsgExt( 'watchers_header' , array( 'parsemag' ), $link1, $watcherscount ) . "</h2>";

		if ( $wgWatchersLimit != NULL ) {

			if ( $watcherscount >= $wgWatchersLimit ) {
				$out .= "<p>" . wfMsgExt( 'watchers_x_or_more', array( 'parsemag' ), $wgWatchersLimit ) . "</p>\n";
			} else {
				$out .= "<p>" . wfMsgExt( 'watchers_less_than_x', array( 'parsemag' ), $wgWatchersLimit ) . "</p>\n";
			}
		} else {
			$res = $dbr->select(
				/* FROM   */ 'watchlist',
				/* SELECT */ 'wl_user',
				/* WHERE  */ $conds,
				$fname
			);
			$user_ids = array ();
			while ( $o = $dbr->fetchObject( $res ) ) {
				$user_ids[] = $o->wl_user;
			}
			$dbr->freeResult( $res );

			if ( count ( $user_ids ) == 0 ) {
				$out .= "<p>" . wfMsg ( 'watchers_noone_watches' ) . "</p>";
			} else {
				$out .= "<ol>";
				foreach ( $user_ids AS $uid ) {
					$u = new User;
					$u->setID ( $uid );
					$u->loadFromDatabase();
					$link = $sk->makeLinkObj ( $u->getUserPage() );
					$out .= "<li>" . $link . "</li>\n";
				}
				$out .= "</ol>";
			}
		}

		$dbr->freeResult( $watcherscountquery );

		$this->setHeaders();
		$wgOut->addHTML( $out );
	}
}
