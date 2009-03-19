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

	const limit = 500;
	const cachekey = 'wikicities:RandomWiki:list';

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
		global $wgOut, $wgSharedDB, $wgMemc;

		// Quit early if we don't have access to the central wiki DB
		if ( empty( $wgSharedDB ) )
			return;

		$topWikis = $wgMemc->get( self::cachekey );

		if ( empty( $topWikis ) ) {

			$options = array(
				'GROUP BY' => 'cw_city_id',
				'ORDER BY' => 'sum(cw_article_count_link) DESC',
				'LIMIT' => self::limit,
			);


			$dbs = wfGetDBExt( DB_SLAVE );
			$dbs->selectDB( 'dbstats' );

			$res = $dbs->select( 'city_stats_full', array( 'cw_city_id' ), '', __METHOD__, $options );

			while ( $row = $dbs->fetchObject( $res ) )
				$topWikis[] = $row->cw_city_id;
			
			$wgMemc->set( self::cachekey, $topWikis, 2592000 /* 30 days */ );
		}

		$rand = array_rand( $topWikis );
		$targetWiki = $topWikis[$rand];

		$wgServerRemote = WikiFactory::getVarByName( 'wgServer', $targetWiki );
		$url = unserialize( $wgServerRemote->cv_value );

		// When a param is given, add it to the URL as a wiki page
		if ( !empty( $par ) ) {
			$wgArticlePathRemote = WikiFactory::getVarByName( 'wgArticlePath', $targetWiki );
			$url .= str_replace( '$1', $par, unserialize( $wgArticlePathRemote->cv_value ) );
		}

		// Redirect the user to a randomly-chosen wiki
		$wgOut->redirect( $url );
	}

}
