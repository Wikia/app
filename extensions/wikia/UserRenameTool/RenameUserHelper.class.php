<?php
/**
 * @author: Federico "Lox" Lucignano
 *
 * A helper class for the User rename tool
 * @copyright (C) 2010, Wikia Inc.
 * @licence GNU General Public Licence 3.0 or later
 */
class RenameUserHelper {

	const CLUSTER_DEFAULT = '';

	public static $excludedWikis = array(
		425, /* uncyclopedia */
	);

	/**
	 * @author Federico "Lox" Lucignano
	 * @param $userID int the registered user ID
	 * @return Array A list of wikis' IDs related to user activity, false if the user is not an existing one or an anon
	 *
	 * Finds on which wikis a REGISTERED user (see LookupContribs for anons) has been active using the events table stored in the stats DB
	 * instead of the blobs table in dataware, tests showed is faster and more accurate
	 */
	static public function lookupRegisteredUserActivity($userID) {
		global $wgDevelEnvironment, $wgDWStatsDB, $wgStatsDBEnabled;
		wfProfileIn(__METHOD__);

		//check for non admitted values
		if(empty($userID) || !is_int($userID)){
			wfProfileOut( __METHOD__ );
			return false;
		}

		wfDebugLog(__CLASS__.'::'.__METHOD__, "Looking up registered user activity for user with ID {$userID}");

		$result = [];
		if ( empty($wgDevelEnvironment) ) { // on production
			if ( !empty( $wgStatsDBEnabled ) ) {
				$dbr = wfGetDB(DB_SLAVE, array(), $wgDWStatsDB);
				$res = $dbr->select('rollup_edit_events', 'wiki_id', ['user_id' => $userID], __METHOD__, ['GROUP BY' => 'wiki_id']);

				while($row = $dbr->fetchObject($res)) {
					if ( !in_array( $row->wiki_id, self::$excludedWikis ) ) {
						if ( WikiFactory::isPublic( $row->wiki_id ) ) {
							$result[] = (int)$row->wiki_id;
							wfDebugLog(__CLASS__.'::'.__METHOD__, "Registered user with ID {$userID} was active on wiki with ID {$row->wiki_id}");
						} else {
							wfDebugLog(__CLASS__.'::'.__METHOD__, "Skipped wiki with ID {$row->wiki_id} (inactive wiki)");
						}
					} else {
						wfDebugLog(__CLASS__.'::'.__METHOD__, "Skipped wiki with ID {$row->wiki_id} (excluded wiki)");
					}
				}

				$dbr->freeResult($res);
			}
		}
		else { // on devbox - set up the list manually
			$result = array(
				165, // firefly
			);
		}

		wfProfileOut(__METHOD__);

		return $result;
	}

	/**
	 * Gets wikis an IP address might have edits on
	 *
	 * @author Daniel Grunwell (Grunny)
	 * @param String $ipAddress The IP address to lookup
	 */
	public static function lookupIPActivity( $ipAddress ) {
		global $wgDevelEnvironment, $wgStatsDB, $wgStatsDBEnabled;
		wfProfileIn( __METHOD__ );

		if ( empty( $ipAddress ) || !IP::isIPAddress( $ipAddress ) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		$result = [];
		$ipLong = ip2long( $ipAddress );
		if ( empty( $wgDevelEnvironment ) ) {
			if ( !empty( $wgStatsDBEnabled ) ) {
				$dbr = wfGetDB( DB_SLAVE, [], $wgStatsDB );
				$res = $dbr->select(
					[ '`specials`.`multilookup`' ],
					[ 'ml_city_id' ],
					[
						'ml_ip' => $ipLong,
					],
					__METHOD__
				);

				foreach ( $res as $row ) {
					if ( !in_array( $row->ml_city_id, self::$excludedWikis ) ) {
						if ( WikiFactory::isPublic( $row->ml_city_id ) ) {
							$result[] = (int)$row->ml_city_id;
						}
					}
				}

				$dbr->freeResult( $res );
			}
		} else { // on devbox - set up the list manually
			$result = [
				165, // firefly
			];
		}

		wfProfileOut( __METHOD__ );
		return $result;
	}

	/**
	 * @author Federico "Lox" Lucignano
	 * @param $wikiCityID int the city_id for the wiki
	 * @return string the name of the cluster the wiki DB belongs to
	 *
	 * Retrieves the name of the cluster in which the local DB for the specified wiki is stored
	 */
	static public function getCityCluster($wikiCityID) {
		wfProfileIn(__METHOD__);

		//check for non admitted values
		if(empty($wikiCityID) || !is_int($wikiCityID)){
			wfProfileOut( __METHOD__ );
			return false;
		}

		wfDebugLog(__CLASS__.'::'.__METHOD__, "Looking up cluster for wiki with ID {$wikiCityID}");

		//WikiFactory implementation
		$value = WikiFactory::getVarValueByName('wgDBcluster', $wikiCityID);

		//if not found fall back to city_list implementation
		if (empty($value)) {
			$dbr = WikiFactory::db(DB_SLAVE);
			$res = $dbr->selectField('city_list', 'city_cluster', array('city_id' => $wikiCityID));
			$value = $res;
		}

		wfDebugLog(__CLASS__.'::'.__METHOD__, "Cluster for wiki with ID {$wikiCityID} is '{$value}'" . ((empty($value) ? ' (main shared DB)' : null)));

		wfProfileOut(__METHOD__);
		return (empty($value)) ? self::CLUSTER_DEFAULT : $value;
	}

	/**
	 * testBlock
	 *
	 * performs a test of all available filters and returns matching filters
	 *
	 * @param $text String to match
	 * @return String with HTML to display via AJAX
	 *
	 * @author tor <tor@wikia-inc.com>
	 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com> (changes for PhalanxII)
	 *
	 * @todo PhalanxFallback will be removed in future, this helper has to be rewritten
	 */
	public static function testBlock( $text ) {
		$data = array();
		$output = '';

		$aModules = Phalanx::getAllTypeNames();
		$link_unblock = wfMsg('phalanx-link-unblock');
		$link_modify = wfMsg('phalanx-link-modify');
		$link_stats = wfMsg('phalanx-link-stats');

		foreach ( $aModules as $module => $name ) {
			$filters = PhalanxFallback::getFromFilter( $module );
			$data[$module] = array();

			if ( empty( $filters ) ) {
				continue;
			}

			$filter = null;
			if( defined( "PHALANX_VERSION" ) && PHALANX_VERSION >= 2 ) {
				$result = PhalanxFallback::findBlocked( $text, $filters, true, $filter );
			}
			else {
				$result = Phalanx::findBlocked( $text, $filters, true, $filter );
			}

			if( $result['blocked'] == true ) {
				$data[$module][] = $filter;
			}

			if ( !empty( $data[$module] ) ) {
				$output .= Xml::element( 'h2', null, $name );

				$output .= Xml::openElement( 'ul' );

				foreach ( $data[$module] as $match ) {
					$phalanxUrl = Title::newFromText( 'Phalanx', NS_SPECIAL )->getFullUrl( array( 'id' => $match['id'] ) );
					$statsUrl = Title::newFromText( 'PhalanxStats', NS_SPECIAL )->getFullUrl() . '/' . $match['id'];

					$line = htmlspecialchars( $match['text'] ) . ' &bull; ' .
						Xml::element( 'a', array( 'href' => $phalanxUrl, 'class' => 'unblock' ), $link_unblock ) . ' &bull; ' .
						Xml::element( 'a', array( 'href' => $phalanxUrl, 'class' => 'modify' ), $link_modify ) . ' &bull; ' .
						Xml::element( 'a', array( 'href' => $statsUrl, 'class' => 'stats' ), $link_stats ) . ' &bull; ' .
						'#' . $match['id'];
					$output .= Xml::tags( 'li', null, $line );
				}

				$output .= Xml::closeElement( 'ul' );
			}
		}

		if ( empty( $output ) ) {
			$output = 'No matches found.';
		}
		return $output;
	}
}
