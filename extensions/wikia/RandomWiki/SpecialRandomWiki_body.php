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
	 * Redirect to a random wiki
	 *
	 * @param $par String: page name on target wiki
	 */
	public function execute( $par ) {
		global $wgOut, $wgSharedDB;

		// Quit early if we don't have access to the central wiki DB
		if ( empty( $wgSharedDB ) )
			return;

		$dbr = wfGetDB( DB_SLAVE );
		$dbr->selectDB( $wgSharedDB );

		$res = $dbr->select( 'city_list', array( 'city_url', 'city_id' ), array( 'city_public' => 1 ) );

		$totalWikis = $dbr->numRows( $res );

		$randomNum = mt_rand( 0, $totalWikis - 1 );

		$dbr->dataSeek( $res, $randomNum );

		$targetWiki = $dbr->fetchObject( $res );

		$dbr->freeResult( $res );

		$url = $targetWiki->city_url;

		// When a param is given, add it to the URL as a wiki page
		if ( !empty( $par ) ) {
			$articlePath = WikiFactory::getVarByName( 'wgArticlePath', $targetWiki->city_id );
			$url .= str_replace( '$1', urlencode( $par ), unserialize( $articlePath->cv_value ) );
		}

		// Redirect the user to a randomly-chosen wiki
		$wgOut->redirect( $url );
	}

}
