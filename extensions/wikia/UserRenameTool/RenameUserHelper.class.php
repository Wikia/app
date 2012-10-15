<?php
/**
 * @author: Federico "Lox" Lucignano
 *
 * A helper class for the User rename tool
 * @copyright (C) 2010, Wikia Inc.
 * @licence GNU General Public Licence 3.0 or later
 */
class RenameUserHelper {

	const CLUSTER_DEFAULT = 'c1';

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
		wfProfileIn(__METHOD__);

		global $wgDevelEnvironment, $wgStatsDB, $wgStatsDBEnabled;
		
		//check for non admitted values
		if(empty($userID) || !is_int($userID)){
			wfProfileOut( __METHOD__ );
			return false;
		}

		wfDebugLog(__CLASS__.'::'.__METHOD__, "Looking up registered user activity for user with ID {$userID}");

		$result = array();
		if ( empty($wgDevelEnvironment) ) { // on production
			if ( !empty( $wgStatsDBEnabled ) ) {
				$dbr =& wfGetDB(DB_SLAVE, array(), $wgStatsDB);
				$res = $dbr->select('events', 'wiki_id', array('user_id' => $userID), __METHOD__, array('DISTINCT'));
				$result = array();

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
}
