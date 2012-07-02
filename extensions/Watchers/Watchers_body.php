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
	function execute( $par ) {
		global $wgOut, $wgRequest, $wgUser, $wgWatchersLimit;

		$this->setHeaders();

		$page = $wgRequest->getVal( 'page', $par );
		if ( $page !== null ) {
			$title = Title::newFromText( $page );
			if ( !$title instanceof Title ) {
				$wgOut->addWikiMsg( 'watchers-error-invalid-page', $page );
				return;
			}
		} else {
			# b/c
			$id = $wgRequest->getInt( 'article', 0 );
			$title = Title::newFromID( $id );

			# Check for valid title
			if ( $id == 0 || $title->getArticleID() <= 0 ) {
				$wgOut->addWikiMsg( 'watchers_error_article' );
				return;
			}
		}

		$dbr = wfGetDB( DB_SLAVE );
		$conds = array(
			'wl_namespace' => $title->getNamespace(),
			'wl_title' => $title->getDBkey(),
		);

		$watcherscount = $dbr->selectField(
			/* FROM   */ 'watchlist',
			/* SELECT */ 'count(wl_user) AS num',
			/* WHERE  */ $conds,
			__METHOD__
		);

		if ( $wgUser->isAllowed( 'watchers-list' ) ) {
			if ( $watcherscount == 0 ) {
				$wgOut->addWikiMsg( 'watchers_noone_watches', $title->getPrefixedText() );
			} else {
				$wgOut->wrapWikiMsg( '<h2>$1</h2>', array( 'watchers_header', $title->getPrefixedText(), $watcherscount ) );

				$res = $dbr->select(
					/* FROM   */ 'watchlist',
					/* SELECT */ 'wl_user',
					/* WHERE  */ $conds,
					__METHOD__
				);

				$sk = $wgUser->getSkin();

				$wgOut->addHTML( "<ol>\n" );
				foreach ( $res AS $row ) {
					$u = User::newFromID( $row->wl_user );
					$link = $sk->link( $u->getUserPage(), htmlspecialchars( $u->getName() ) );
					$wgOut->addHTML( "<li>" . $link . "</li>\n" );
				}
				$wgOut->addHTML( "</ol>\n" );
			}
		} else {
			if ( $wgWatchersLimit === null ) {
				if ( $watcherscount == 0 ) {
					$wgOut->addWikiMsg( 'watchers_noone_watches', $title->getPrefixedText() );
				} else {
					$wgOut->addWikiMsg( 'watchers-num', $watcherscount, $title->getPrefixedText() );
				}
			} else {
				if ( $watcherscount >= $wgWatchersLimit ) {
					$wgOut->addWikiMsg( 'watchers_x_or_more', $wgWatchersLimit, $title->getPrefixedText() );
				} else {
					$wgOut->addWikiMsg( 'watchers_less_than_x', $wgWatchersLimit, $title->getPrefixedText() );
				}
			}
		}
	}
}
