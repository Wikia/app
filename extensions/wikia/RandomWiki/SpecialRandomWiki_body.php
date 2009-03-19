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

	var $limit = 500;

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

		$options = array(
			'GROUP BY' => 'cw_city_id',
			'ORDER BY' => 'sum(cw_article_count_link) DESC',
			'LIMIT' => $this->limit,
		);


		$dbs = wfGetDBExt( DB_SLAVE );
		$dbs->selectDB( 'dbstats' );

		$res = $dbs->select( 'city_stats_full', array( 'cw_city_id' ), '', __METHOD__, $options );

		$totalWikis = $dbs->numRows( $res );
		$randomNum = mt_rand( 0, $totalWikis - 1 );
		$dbs->dataSeek( $res, $randomNum );

		$targetWiki = $dbs->fetchObject( $res );

		$wgServerRemote = WikiFactory::getVarByName( 'wgServer', $targetWiki->cw_city_id );
		$url = unserialize( $wgServerRemote->cv_value );

		// When a param is given, add it to the URL as a wiki page
		if ( !empty( $par ) ) {
			$wgArticlePathRemote = WikiFactory::getVarByName( 'wgArticlePath', $targetWiki->cw_city_id );
			$url .= str_replace( '$1', $par, unserialize( $wgArticlePathRemote->cv_value ) );
		}

		// Redirect the user to a randomly-chosen wiki
		$wgOut->redirect( $url );
	}

}
