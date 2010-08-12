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

		global $wgStatsDB;
		
		//check for non admitted values
		if(empty($userID) || !is_int($userID)){
			wfProfileOut( __METHOD__ );
			return false;
		}

		wfDebugLog(__CLASS__.'::'.__METHOD__, "Looking up registered user activity for user with ID {$userID}");

		if(!defined('ENV_DEVBOX')){
			$dbr =& wfGetDB(DB_SLAVE, array(), $wgStatsDB);
			$res = $dbr->select('events', 'wiki_id', array('user_id' => $userID), __METHOD__, array('DISTINCT'));
			$result = array();

			while($row = $dbr->fetchObject($res)) {
				$result[] = (int)$row->wiki_id;

				wfDebugLog(__CLASS__.'::'.__METHOD__, "Registered user with ID {$userID} was active on wiki with ID {$row->wiki_id}");
			}

			$dbr->freeResult($res);
		}
		else {
			$result = array(
				673,//simpsons
				831,//muppets
				49688//farmville
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
?>
