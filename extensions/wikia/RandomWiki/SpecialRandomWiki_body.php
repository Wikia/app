<?php
/**
 * RandomWiki
 *
 * @file
 * @ingroup Extensions
 * @author Łukasz Garczewski (TOR) <tor@wikia-inc.com>
 * @author Maciej Błaszkowski (Marooned) <marooned@wikia-inc.com>
 * @date 2009-01-30
 * @copyright Copyright © 2008 Łukasz Garczewski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo "This is a MediaWiki extension named RandomWiki.\n";
	exit( 1 );
}

class RandomWiki extends SpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'RandomWiki' );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgOut, $wgSharedDB;

		$dbr = wfGetDB( DB_SLAVE );
		// Make sure that we're in the shared database so that the query will work
		$dbr->selectDB( $wgSharedDB );

		$res = $dbr->select( 'city_list', array( 'city_url' ), array( 'city_public' => 1 ) );

		$totalWikis = $dbr->numRows( $res );

		$randomNum = mt_rand( 0, $totalWikis - 1 );

		$dbr->dataSeek( $res, $randomNum );

		$targetWiki = $dbr->fetchObject( $res );

		// Redirect the user to a randomly-chosen wiki
		$wgOut->redirect( $targetWiki->city_url );
	}

}