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
		global $wgExternalSharedDB, $wgExternalStatsDB, $wgOut, $wgMemc;

		$topWikis = $wgMemc->get( self::cachekey );

		if ( empty( $topWikis ) ) {

			$two_days_ago = time() - 2 * 24 * 3600; // allow a day or two in case stats generation will be disrupted (or yikes! month ends)
			$conds = array(
				'cw_stats_date' => date('Ym00000000', $two_days_ago), // pick wiki with recent stats present => more likely to be live (but no guarantee till the end of the month)
			);
			$options = array(
				'ORDER BY' => 'cw_article_count_link DESC',
				'LIMIT' => self::limit,
			);


			$dbs = wfGetDB( DB_SLAVE, array(), $wgExternalStatsDB );

			$res = $dbs->select( 'city_stats_full', array( 'cw_city_id' ), $conds, __METHOD__, $options );

			$topWikis = array();
			while ( $row = $dbs->fetchObject( $res ) )
				$topWikis[] = $row->cw_city_id;
			
			if (count($topWikis)) {
				$db2 = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );

				// check if any wiki from that list above has been closed
				// removing from list should be quicker than reproducing it,
				// hence public=0 and array_diff
				$conds2 = array(
					'city_public' => 0,
					'city_id IN (' . join(',', $topWikis) . ')',
				);
				$options2 = array(
					'ORDER BY' => 'city_id',
				);
				$res2 = $db2->select('city_list', array('city_id'), $conds2, __METHOD__, $options2);
				$closedWikis = array();
				while ($row = $db2->fetchObject($res2)) {
					$closedWikis[] = $row->city_id;
				}

				if (count($closedWikis)) {
					$topWikis = array_diff($topWikis, $closedWikis);
				}
			}

			$wgMemc->set( self::cachekey, $topWikis, 24 * 3600 ); // cache it for 24h only, wiki can be closed at any time
		}

		$rand = array_rand( $topWikis );
		$targetWiki = $topWikis[$rand];

		$wgServerRemote = WikiFactory::getVarByName( 'wgServer', $targetWiki );
		$url = unserialize( $wgServerRemote->cv_value );

		// When a param is given, add it to the URL as a wiki page
		if ( !empty( $par ) ) {
			$wgArticlePathRemote = unserialize( WikiFactory::getVarByName( 'wgArticlePath', $targetWiki )->cv_value );
			// Check for funky $wgArticlePath
			if ( strpos( $wgArticlePathRemote, '$wgScriptPath' ) !== false  ) {
				$wgScriptPathRemote = unserialize( WikiFactory::getVarByName( 'wgScriptPath', $targetWiki )->cv_value );
				$wgArticlePathRemote = str_replace( '$wgArticlePath', $wgScriptPathRemote, $wgArticlePathRemote );
			}
			$url .= str_replace( '$1', $par, $wgArticlePathRemote );
		}

		// Redirect the user to a randomly-chosen wiki
		$wgOut->redirect( $url );
	}

}
