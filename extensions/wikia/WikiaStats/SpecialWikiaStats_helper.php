<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Piotr Molski <moli@wikia.com>
 * @version: $Id$
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension and cannot be used standalone.\n";
    exit( 1 ) ;
}

define ('ABSENT_TIME', 60 * 60 * 24 * 30);
define ('ANON_ARRAY_LGTH', 30);

if ( (!class_exists('WikiFactory')) && (file_exists($IP."/extensions/wikia/WikiFactory/SpecialWikiFactory_helper.php")) )
{
	require_once ($IP."/extensions/wikia/WikiFactory/SpecialWikiFactory_helper.php");
}

class WikiaGenericStats {

    var $mUserID;	#--- just used id
    var $mUser;		#--- whole user object
    var $mSize = 0;
    var $mSelectedCityId = -1;

    const MONTHLY_STATS = 7;
    const USE_MEMC = 0;
    const USE_OLD_DB = 0;
	const IGNORE_WIKIS = "5, 11, 6745";

	var $columnMapIndex = null;
	// show only local statistics for wikia
	var $localStats = false;

    #--- constructor
    public function __construct($userid)
    {
    	global $wgMessageCache, $wgWikiaStatsMessages;

		#--- Add messages
		wfLoadExtensionMessages("WikiaStats");
    	$this->mUserID = $userid;
        $this->mUser = User::newFromId($userid);
        if (is_object( $this->mUser ) && !is_null( $this->mUser )) {
            $this->mUser->load();
        }
    }

	public function setLocalStats($value) {
		$this->localStats = $value;
	}

	public function getLocalStats() {
		return $this->localStats;
	}

    public function getRangeColumns()
    {
		wfProfileIn( __METHOD__ );
    	$this->columnMapIndex = range(RANGE_STATS_MIN,RANGE_STATS_MAX);
		wfProfileOut( __METHOD__ );
    	return $this->columnMapIndex;
	}

    public function getWikiaCityList()
    {
    	global $wgMemc, $wgExternalSharedDB;
    	#---
		wfProfileIn( __METHOD__ );

   		$wkCityDomains = "";
   		if (self::USE_MEMC) $wkCityDomains = $wgMemc->get('wikiacitystatslist');
    	if (empty($wkCityDomains))
    	{
			$dbr =& wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);
			#---

			$where = array('city_public = 1 and city_id not in ('.self::IGNORE_WIKIS.')');
			$res = $dbr->select (
				array( "city_list" ),
				array( 'city_id', 'city_dbname', 'city_title', 'city_url', 'city_public' ),
				$where ,
				__METHOD__,
				array( 'ORDER BY' => 'city_dbname' )
			);

			while ( $row = $dbr->fetchObject( $res ) ) {
				if (is_numeric($row->city_dbname)) {
					$row->city_dbname = sprintf("%s ", $row->city_dbname);
				}
				$urlshort = explode(".", str_replace("http://", "", $row->city_url));
				$shorturl = self::makeWikiNameFromUrl($urlshort);
				$wkCityDomains[ucfirst(strtolower($shorturl))] = $row->city_id;
			}
			$dbr->freeResult( $res );

			$wkCityDomains["&Sigma;"] = 0;
			#---
			ksort($wkCityDomains, SORT_STRING);
			#---
			if (self::USE_MEMC) $wgMemc->set("wikiacitystatslist", $wkCityDomains, 60*60);
		}
		wfProfileOut( __METHOD__ );
		return $wkCityDomains;
	}

    public function getWikiaAllCityList($keys = array())
    {
    	global $wgMemc, $wgExternalSharedDB;
    	#---
		wfProfileIn( __METHOD__ );

		$implode_keys = "";
		if (!empty($keys))
		{
			$implode_keys = "'".implode("','", $keys)."'";
		}
		$memckey = 'wikiacityallstatslist' . md5($implode_keys);
   		$wkCityAllDomains = array();
   		if (self::USE_MEMC) $wkCityAllDomains = $wgMemc->get($memckey);
    	if (empty($wkCityAllDomains)) {
    		/* */
			$dbr =& wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);

			$where = array('city_public = 1 and city_id not in ('.self::IGNORE_WIKIS.')');
			if (!empty($implode_keys)) {
				$where[] = " city_id in (".$implode_keys.") ";
			}

			$res = $dbr->select(
				array( 'city_list' ),
				array( 'city_id', 'city_dbname', 'city_title', 'city_url', 'city_public' ),
				$where ,
				__METHOD__,
				array( 'ORDER BY' => 'city_id' )
			);

			while ( $row = $dbr->fetchObject( $res ) ) {
				$urlshort = explode(".", str_replace("http://", "", $row->city_url));
				$shorturl = self::makeWikiNameFromUrl($urlshort);
				$wkCityAllDomains[$row->city_id] = array("dbname" => $row->city_dbname, "title" => ($row->city_title) ? $row->city_title : ucfirst($row->city_dbname), "url" => $row->city_url, "urlshort" => ucfirst($shorturl));
			}
			$dbr->freeResult( $res );

			$wkCityAllDomains[0] = array("dbname" => "wikicities", "title" => "&Sigma;", "url" => "http://www.wikipedia.org/", "urlshort" => "");
			#---
			if (self::USE_MEMC) $wgMemc->set($memckey, $wkCityAllDomains, 60*60);
		}
		wfProfileOut( __METHOD__ );
		return $wkCityAllDomains;
	}

	public function getWikiaOrderStatsList($column_name = '', $cities = array())
	{
    	global $wgMemc, $wgExternalStatsDB;
    	#---
		wfProfileIn( __METHOD__ );

		$implode_keys = "";
		if (!empty($cities))
		{
			$implode_keys = "'".implode("','", $cities)."'";
		}
		$memckey = 'wikiaorderstatslist' . $column_name . md5($implode_keys);

   		$wkCityOrderStats = "";
   		if (self::USE_MEMC) $wkCityOrderStats = $wgMemc->get($memckey);
    	if (empty($wkCityOrderStats))
    	{
			$dbs =& wfGetDB(DB_SLAVE, array(), $wgExternalStatsDB);
			#---
			$column = "avg(c1.cw_wikians_total) as cnt";
			$order_by = "cnt";
			if (!empty($column_name))
			{
				if (in_array($column_name, array('cw_article_mean_nbr_revision', 'cw_article_mean_size', 'cw_article_perc_0_5_size', 'cw_article_perc_2_0_size')))
					$column = "avg(c1.$column_name) as cnt";
				else
					$column = "sum(c1.$column_name) as cnt";
			}
			#---
			$noactive_citylist = self::getNoPublicCities();
			$no_cities = (!empty($noactive_citylist)) ? " and c1.cw_city_id not in ('".implode("','", $noactive_citylist)."') " : "";
			#---
			$with_cities = (!empty($implode_keys)) ? " and c1.cw_city_id in ({$implode_keys})" : "";
			#---
			$sql = "select SQL_CACHE cw_city_id as city, $column ";
			$sql .= "from `city_stats_full` c1 where c1.cw_city_id > 0 {$no_cities} {$with_cities} group by c1.cw_city_id having (cnt > 0) order by {$order_by} desc";
			#---
			$res = $dbs->query($sql);
			$loop = 1;
			$wkCityOrderStats = array(); // for &Sigma;
			while ( $row = $dbs->fetchObject( $res ) )
			{
				$wkCityOrderStats[$loop] = $row->city;
				$loop++;
			}
			$dbs->freeResult( $res );
			#---
			#---
			if (self::USE_MEMC) $wgMemc->set($memckey, $wkCityOrderStats, 60*60);
		}
		wfProfileOut( __METHOD__ );
		return $wkCityOrderStats;
	}

	public function getCreationWikiansList(&$min_date)
	{
    	global $wgMemc, $wgExternalStatsDB;
    	#---
		wfProfileIn( __METHOD__ );

   		$wkCreationWikiansList = "";
   		if (self::USE_MEMC) $wkCreationWikiansList = $wgMemc->get('wikiacreationwikiansstats');
    	if (empty($wkCreationWikiansList))
    	{
			$dbs =& wfGetDB(DB_SLAVE, array(), $wgExternalStatsDB);
			#---
			$whereCity = " c1.cw_city_id > 0 ";
			$noactive_citylist = self::getNoPublicCities();
			$whereCity .= (!empty($noactive_citylist)) ? " and c1.cw_city_id not in ('".implode("','", $noactive_citylist)."') " : "";

			$sql = "select SQL_CACHE c1.cw_city_id as city, min(date_format(cw_stats_date, '%Y-%m')) as date, ";
			$sql .= "(select cw_wikians_total from `city_stats_full` c2 where c1.cw_city_id = c2.cw_city_id and date_format(c2.cw_stats_date, '%Y-%m') <= date_format(now(), '%Y-%m') order by c2.cw_stats_date desc limit 1) as cnt ";
			$sql .= "from `city_stats_full` c1 where {$whereCity} group by cw_city_id having (cnt > 0) order by date, cnt desc ";

			#---
			#echo $sql."<br />";
			$res = $dbs->query($sql);
			$loop = 0;
			$wkCreationWikiansList = array();
			$result = array();
			$max_values = 0;
			while ( $row = $dbs->fetchObject( $res ) )
			{
				if ($loop == 0) $min_date = $row->date;
				#---
				if (empty($row->cnt)) continue;
				#---
				$result[$row->date][] = array("city_id" => $row->city, "cnt" => $row->cnt);
				$x = count($result[$row->date]);
				$max_values = ($x > $max_values) ? $x : $max_values;
				$loop++;
			}
			$dbs->freeResult( $res );
			#---
			$wkCreationWikiansList = array(0 => $result, 1 => $max_values);
			if (self::USE_MEMC) $wgMemc->set("wikiacreationwikiansstats", $wkCreationWikiansList, 60*60);
		}
		wfProfileOut( __METHOD__ );
		return $wkCreationWikiansList;
	}


	public function getCreationArticleList ()
	{
    	global $wgMemc, $wgExternalStatsDB;
    	#---
		wfProfileIn( __METHOD__ );
   		$max_values = 0;

   		$wkCreationArticleList = "";
   		if (self::USE_MEMC) $wkCreationArticleList = $wgMemc->get('wikiacreationarticlestats');
    	if (empty($wkCreationWikiansList))
    	{
			$dbs =& wfGetDB(DB_SLAVE, array(), $wgExternalStatsDB);
			#---
			$whereCity = " c1.cw_city_id > 0 ";
			$noactive_citylist = self::getNoPublicCities();
			$whereCity .= (!empty($noactive_citylist)) ? " and c1.cw_city_id not in ('".implode("','", $noactive_citylist)."') " : "";

			$sql = "select c1.cw_city_id as city, min(date_format(cw_stats_date, '%Y-%m')) as date, ";
			$sql .= "(select cw_article_count_link from `city_stats_full` c2 where c1.cw_city_id = c2.cw_city_id and date_format(c2.cw_stats_date, '%Y-%m') <= date_format(now(), '%Y-%m') order by c2.cw_stats_date desc limit 1) as cnt ";
			$sql .= "from `city_stats_full` c1 where {$whereCity} group by cw_city_id having (cnt > 0) order by date, cnt desc ";

			//echo $sql."<br />";
			#---
			$res = $dbs->query($sql);
			$loop = 1;
			$wkCreationArticleList = array();
			$result = array();
			$max_values = 0;
			while ( $row = $dbs->fetchObject( $res ) )
			{
				if (empty($row->cnt)) continue;
				#---
				$result[$row->date][] = array("city_id" => $row->city, "cnt" => $row->cnt);

				$x = count($result[$row->date]);
				$max_values = ($x > $max_values) ? $x : $max_values;

				$loop++;
			}
			$dbs->freeResult( $res );
			#---
			$wkCreationArticleList = array(0 => $result, 1 => $max_values);
			if (self::USE_MEMC) $wgMemc->set("wikiacreationarticlestats", $wkCreationArticleList, 60*60);
		}
		wfProfileOut( __METHOD__ );
		return $wkCreationArticleList;
	}


	public function getStatisticsColumnNames($index = 0)
	{
    	global $wgMemc;
    	#---
		wfProfileIn( __METHOD__ );

		$wkStatsColumnNames = array(
			3 => "cw_users_all_reg_main_ns",
			4 => "cw_wikians_edits_5",
			5 => "cw_wikians_edits_100",
			6 => "cw_users_all_reg_user_ns",
			7 => "cw_users_all_reg_image_ns",
			8 => "cw_users_all_reg",
			9 => "cw_article_count_link",
			10 => "cw_article_new_per_day",
			11 => "cw_article_perc_0_5_size",
			12 => "cw_db_edits",
			13 => "cw_db_size",
			14 => "cw_db_words",
			15 => "cw_links_image",
			16 => "cw_links_external",
			17 => "cw_images_uploaded",
		);

		$columnName = "";
		if (isset($index) && !empty($wkStatsColumnNames)) {
			$columnName = $wkStatsColumnNames[$index];
		}

		wfProfileOut( __METHOD__ );
		return $columnName;
	}

	static private function getContentNamespaces() {
		global $wgContentNamespaces;
		$namespaces = array_merge(array(NS_MAIN), $wgContentNamespaces);

		/* DON'T CHANGE IT AND REMOVE IT !!!! */
		$otherNamespace = array(
			500 /* NS_BLOG_ARTICLE */,
			502 /* NS_BLOG_LISTING */
		);

		$namespaces = array_merge($namespaces, $otherNamespace);

		return $namespaces;
	}

	static private function makeWikiNameFromUrl($urlshort) {
		$shorturl = "";
		if (is_array($urlshort)) {
			if (count($urlshort) <= 3) {
				$shorturl = ($urlshort[1] == 'wikia') ? $urlshort[0] : $urlshort[0] . "." . $urlshort[1];
			} else {
				$shorturl = $urlshort[0] . "." . $urlshort[1];
			}
			$shorturl = ($shorturl == 'www') ? $urlshort[1] : $shorturl;
			$pos = strrpos($shorturl, "/");
			$len = strlen($shorturl);
			if (($pos == ($len-1)) && ($len > 2)) {
				$shorturl = substr($shorturl, 0, $pos);
			}
		}
		return $shorturl;
	}

	static private function getWikiaDBCityListById($city_id)
	{
    	global $wgMemc;
    	#---
		wfProfileIn( __METHOD__ );
		$memkey = 'wikiastatsdbnamebyid_' . $city_id;
   		$wkStatsDBName = "";
   		if (self::USE_MEMC) $wkStatsDBName = $wgMemc->get($memkey);
   		if (empty($wkStatsDBName)) {
			$wkStatsDBName = WikiFactory::IDtoDB($city_id);
			if (self::USE_MEMC) $wgMemc->set($memkey, $wkStatsDBName, 60*60*3);
		}

		wfProfileOut( __METHOD__ );
		return $wkStatsDBName;
	}

	static private function getWikiaCityUrlById($city_id)
	{
    	global $wgMemc;
    	#---
		wfProfileIn( __METHOD__ );
		$wkStatsUrl = "";
		$memkey = 'wikiastatsurlbyid_' . $city_id;
   		$wkStatsUrl = "";
   		if (self::USE_MEMC) $wkStatsUrl = $wgMemc->get($memkey);
		#---
   		if (empty($wkStatsUrl)) {
			$wkStatsUrl = WikiFactory::getVarValueByName('wgServer', $city_id);
			if (self::USE_MEMC) $wgMemc->set($memkey, $wkStatsUrl, 60*60);
		}

		wfProfileOut( __METHOD__ );
		return $wkStatsUrl;
	}

	static private function getUserEditCountFromDB($cityDBName, $value)
	{
    	global $wgMemc;
    	#---
		wfProfileIn( __METHOD__ );
		$result = array('count' => 0, 'sum' => 0);
		#---
		$memkey = 'wikiacitystatseditcount_'.$cityDBName.'_'.$value;
		$wikiacityedits = "";
		#---
		$namespaces = self::getContentNamespaces();

		if (self::USE_MEMC) $wikiacityedits = $wgMemc->get($memkey);
		if (empty($wikiacityedits)) {
			if (!empty($cityDBName)) {
				$dbs =& wfGetDB(DB_SLAVE, array(), 'wikiastats');
				#---
				$sql = "select count(wf_user) as cnt, sum(s) as s from ";
				$sql .= "(select wf_user,sum(wf_contributed) as s from `{$cityDBName}_wikians_full` where ";
				$sql .= "wf_user > 0 and wf_namespace in (".implode(",", $namespaces).") group by wf_user having (sum(wf_contributed) >= {$value})) as query";
				$res = $dbs->query($sql);
				if ( $row = $dbs->fetchRow( $res ) )
				{
					$result = array('count' => $row["cnt"], 'sum' => $row["s"]);
				}
				$dbs->freeResult( $res );
				#---
				if (self::USE_MEMC) $wgMemc->set($memkey, $result, 60*60);
			}
		}
		else {
			$result = $wikiacityedits;
		}

		wfProfileOut( __METHOD__ );
		#---
		return $result;
	}

	static private function getWikiaTrendsFromDB(&$months, $keys, $all = 0)
	{
    	global $wgMemc, $wgExternalStatsDB;
    	#---
		wfProfileIn( __METHOD__ );
		$wkStatsDBName = "";
		#---
		$dbs =& wfGetDB( DB_SLAVE );
		#---
		$wkCityTrendStatistics = array();
		#---
		$tmp_key = md5(implode(",", $months));
		#---
		$whereCity = "";
		if (!empty($keys))
		{
			$where_key = implode("','", $keys);
			$tmp_key .= md5($where_key);
			$whereCity = " and cw_city_id in ('".$where_key."') ";
		}
    	$memkey = "wikiatrendstatistics_".$all.$tmp_key;
    	#---
		$columns = array();
		$wkCityTrendStatistics = "";
		if (self::USE_MEMC) $wkCityTrendStatistics = $wgMemc->get($memkey);
		#---
		if (empty($wkCityTrendStatistics)) {
			try
			{
				#--- database instance - DB_SLAVE
				$dbs =& wfGetDB(DB_SLAVE, array(), $wgExternalStatsDB);
				if ( is_null($dbs) ) {
					throw new DBConnectionError($dbs, wfMsg("wikiastats_connection_error"));
				}

				if (!empty($months)) {
					foreach ($months as $id => $month) {
						$wkCityTrendStatistics[str_replace('\'', '', $month)] = array();
					}
				}
				#---
				$db_fields[] = (empty($all)) ? "cw_users_all_reg_main_ns as A" : "sum(cw_users_all_reg_main_ns) as A";
				$db_fields[] = (empty($all)) ? "cw_wikians_edits_5 as B" : "sum(cw_wikians_edits_5) as B";
				$db_fields[] = (empty($all)) ? "cw_wikians_edits_100 as C" : "sum(cw_wikians_edits_100) as C";
				$db_fields[] = (empty($all)) ? "cw_users_all_reg_user_ns as D" : "sum(cw_users_all_reg_user_ns) as D";
				$db_fields[] = (empty($all)) ? "cw_users_all_reg_image_ns as E" : "sum(cw_users_all_reg_image_ns) as E";
				$db_fields[] = (empty($all)) ? "cw_users_all_reg as F" : "sum(cw_users_all_reg) as F";
						//$db_fields[] = (empty($all)) ? "cw_wikians_total as G" : "sum(cw_wikians_total) as G";
						//$db_fields[] = (empty($all)) ? "cw_wikians_total_inc as C" : "sum(cw_wikians_total_inc) as C";
				$db_fields[] = (empty($all)) ? "cw_article_count_link as G" : "sum(cw_article_count_link) as G";
						//$db_fields[] = (empty($all)) ? "cw_article_count_200_link as I" : "sum(cw_article_count_200_link) as I";
				$db_fields[] = (empty($all)) ? "cw_article_new_per_day as H" : "sum(cw_article_new_per_day) as H";
						//$db_fields[] = (empty($all)) ? "cw_article_mean_nbr_revision as K" : "avg(cw_article_mean_nbr_revision) as K";
						//$db_fields[] = (empty($all)) ? "cw_article_mean_size as J" : "avg(cw_article_mean_size) as L";
				$db_fields[] = (empty($all)) ? "cw_article_perc_0_5_size as I" : "avg(cw_article_perc_0_5_size) as I";
						//$db_fields[] = (empty($all)) ? "cw_article_perc_2_0_size as N" : "avg(cw_article_perc_2_0_size) as N";
				$db_fields[] = (empty($all)) ? "cw_db_edits as J" : "sum(cw_db_edits) as J";
				$db_fields[] = (empty($all)) ? "cw_db_size as K" : "sum(cw_db_size) as K";
				$db_fields[] = (empty($all)) ? "cw_db_words as L" : "sum(cw_db_words) as L";
						//$db_fields[] = (empty($all)) ? "cw_links_internal as R" : "sum(cw_links_internal) as R";
						//$db_fields[] = (empty($all)) ? "cw_links_interwiki as S" : "sum(cw_links_interwiki) as S";
				$db_fields[] = (empty($all)) ? "cw_links_image as M" : "sum(cw_links_image) as M";
				$db_fields[] = (empty($all)) ? "cw_links_external as N" : "sum(cw_links_external) as N";
						//$db_fields[] = (empty($all)) ? "cw_links_redirects as V" : "sum(cw_links_redirects) as V";
				$db_fields[] = (empty($all)) ? "cw_images_uploaded as O" : "sum(cw_images_uploaded) as O";
						//$db_fields[] = (empty($all)) ? "cw_images_linked as X" : "sum(cw_images_linked) as X";

				if (!empty($all))
				{
					$noactive_citylist = self::getNoPublicCities();
					$whereCity .= (!empty($noactive_citylist)) ? " and cw_city_id not in ('".implode("','", $noactive_citylist)."') " : "";
				}

				#---
				$selcity = (empty($all)) ? "cw_city_id as city_id" : "0 as city_id";
				$group = (empty($all)) ? "cw_city_id, date" : "date";

				$sql = "select {$selcity}, date_format(cw_stats_date, '%Y-%m') as date, ".implode(",", $db_fields)." from `city_stats_full` ";
				$sql .= "where date_format(cw_stats_date, '%Y-%m') in (".implode(",", $months).") {$whereCity} group by {$group} order by {$group} desc";
				#---
				$res = $dbs->query($sql);
				while ( $row = $dbs->fetchObject( $res ) )
				{
					foreach ($row as $field => $value)
					{
						if (!in_array($field, array('city_id', 'date')))
						{
							$wkCityTrendStatistics[$row->date][$row->city_id][$field] = $value;
						}
					}
				}
				$dbs->freeResult( $res );
				#---
				if (self::USE_MEMC) $wgMemc->set($memkey, $wkCityTrendStatistics, 60*60);
			} catch (DBConnectionError $e) {
				return -1;
			} catch (DBQueryError $e) {
				return -1;
			} catch (DBError $e) {
				return -1;
			}
		}

		wfProfileOut( __METHOD__ );
		return $wkCityTrendStatistics;
	}

	static private function getWikiansListStatsFromDB($cityDBName, $namespace=0, $limit=STATS_WIKIANS_RANK_NBR, $stats_date=0, $userlist=array())
	{
    	global $wgMemc;
    	#---
		wfProfileIn( __METHOD__ );
		#---
		$namespace = intval($namespace);
		$namespaces = self::getContentNamespaces();
		$namespaceList = implode(",", $namespaces);
		#---
		$whereUserList = "";
		if (!empty($userlist)) {
			$whereUserList = "'".implode("','", $userlist)."'";
		}

		$memkey = 'wikiacitystatswikiansrank_'.md5($cityDBName.'_'.$namespace.'_'.$stats_date.'_'.$limit.'_'.$whereUserList);
		#---
		$result = array();
		if (self::USE_MEMC) $result = $wgMemc->get($memkey);

		if (empty($result)) {
			if (!empty($cityDBName)) {
				$dbs =& wfGetDB(DB_SLAVE, array(), 'wikiastats');
				#---
				$where = " wf_user > 0 ";
				if (empty($namespace)) {
					$where .= " and wf_namespace in (".$namespaceList.") ";
				}
				else {
					$where .= " and wf_namespace not in (".$namespaceList.") ";
				}
				#---
				if (!empty($whereUserList))
					$where .= " and wf_user in (".$whereUserList.") ";
				if (!empty($stats_date))
					$where .= " and date_format(wf_stats_date, '%Y-%m') <= '{$stats_date}' ";

				#---
				$sql = "select min(unix_timestamp(wf_first_day_edit)) as wf_min, max(unix_timestamp(wf_last_day_edit)) as wf_max, sum(wf_contributed) as wf_cnt, wf_user, wf_user_text ";
				$sql .= "from `{$cityDBName}_wikians_full` where {$where} ";
				$sql .= "group by wf_user_text, wf_user order by wf_cnt desc, wf_max desc limit {$limit}";
				#---
				$res = $dbs->query($sql);
				#---
				$rank = 1;
				while ( $row = $dbs->fetchObject( $res ) ) {
					$result[$row->wf_user] = array(
						'min' => $row->wf_min,
						'max' => $row->wf_max,
						'cnt' => $row->wf_cnt,
						'rank' => $rank,
						'user_id' => $row->wf_user,
						'user_name' => $row->wf_user_text
					);
					$rank++;
				}
				$dbs->freeResult( $res );
				#---
				if (self::USE_MEMC) $wgMemc->set($memkey, $result, 60*60);
			}
		}

		wfProfileOut( __METHOD__ );
		#---
		return $result;
	}

	static private function getArticlesCountsFromDB($cityDBName, $size = 0, $namespace=0)
	{
    	global $wgMemc;
    	#---
		wfProfileIn( __METHOD__ );
		$result = array();
		$memkey = 'wikiacitystatsarticlecount_'.$cityDBName.'_'.$size.'_'.$namespace;
		$namespaces = self::getContentNamespaces();
		$namespaceList = implode(",", $namespaces);
		#---
		if (self::USE_MEMC) $result = $wgMemc->get($memkey);

		if (empty($result)) {
			if (!empty($cityDBName)) {
				$dbs =& wfGetDB(DB_SLAVE, array(), 'wikiastats');
				#---
				$where = "af_int_link_article > 0";
				if (empty($namespace))
					$where .= " and af_namespace in (".$namespaceList.") ";
				else
					$where .= " and af_namespace not in (".$namespaceList.") ";
				#---
				if (!empty($size)) $where .= " and af_mean_size_article < {$size} ";
				#---
				$sql = "select count(*) as cnt, date_format(af_stats_date, '%Y-%m') as dt from `{$cityDBName}_articles_full` ";
				$sql .= "where {$where} group by dt order by dt desc";
				$res = $dbs->query($sql);
				while ( $row = $dbs->fetchObject( $res ) ) {
					$result[$row->dt] = array('count' => $row->cnt, 'date' => $row->dt);
				}
				$dbs->freeResult( $res );
				#---
				if (self::USE_MEMC) $wgMemc->set($memkey, $result, 60*60);
			}
		}

		wfProfileOut( __METHOD__ );
		#---
		return $result;
	}

	static private function getNamespaceStatFromDB($cityDBName, $namespace = array())
	{
    	global $wgMemc;
    	#---
		wfProfileIn( __METHOD__ );
		$result = array();
		$memkey = 'wikiacitystatsnamespace_'.$cityDBName.'_'.implode(',',$namespace);
		#---
		if (self::USE_MEMC) $result = $wgMemc->get($memkey);

		if (empty($result)) {
			if (!empty($cityDBName)) {
				$dbs =& wfGetDB(DB_SLAVE, array(), 'wikiastats');
				#---
				$where = "1=1";
				if (!empty($namespace))
					$where .= " and af_namespace in ('".implode("','",$namespace)."') ";

				#---
				$sql = "select count(*) as cnt, af_namespace, date_format(af_stats_date, '%Y-%m') as dt from `{$cityDBName}_articles_full` ";
				$sql .= " where {$where} group by af_namespace, dt order by dt desc, af_namespace ";
				$res = $dbs->query($sql);
				while ( $row = $dbs->fetchObject( $res ) ) {
					$result[$row->dt][$row->af_namespace] = $row->cnt;
				}
				$dbs->freeResult( $res );
				#---
				if (self::USE_MEMC) $wgMemc->set($memkey, $result, 60*60);
			}
		}

		wfProfileOut( __METHOD__ );
		#---
		return $result;
	}

	static private function getAnonUserStatisticsFromDB($cityDBName, $namespace=0, $limit=50)
	{
    	global $wgMemc;
    	#---
		wfProfileIn( __METHOD__ );
		#---
		$namespace = intval($namespace);
		$namespaces = self::getContentNamespaces();
		$namespaceList = implode(",", $namespaces);
		$result = array();
		#---
		$memkey = 'wikiacitystatsusersanon_'.md5($cityDBName.'_'.$namespace.'_'.$limit);
		#---
		if (self::USE_MEMC) $result = $wgMemc->get($memkey);

    	$no_ip = array();
		if (empty($result)) {
			if (!empty($cityDBName)) {
				$dbs =& wfGetDB(DB_SLAVE, array(), 'wikiastats');
				#---
				$where = " wf_user = 0 ";
				if (empty($namespace))
					$where .= " and wf_namespace in (".$namespaceList.") ";
				else
					$where .= " and wf_namespace not in (".$namespaceList.") ";

				#---
				$sql = "select min(unix_timestamp(wf_first_day_edit)) as wf_min, max(unix_timestamp(wf_last_day_edit)) as wf_max, sum(wf_contributed) as wf_cnt, wf_user_text, wf_user ";
				$sql .= "from `{$cityDBName}_wikians_full` where {$where} ";
				$sql .= "group by wf_user_text, wf_user order by wf_cnt desc, wf_max desc limit {$limit}";
				#---
				$res = $dbs->query($sql);
				#---
				$rank = 1;
				while ( $row = $dbs->fetchObject( $res ) ) {
					$is_ip = ip2long($row->wf_user_text);

					if ($is_ip == -1 || $is_ip === false)
						$no_ip[] = $row->wf_user_text;
					else
					{
						$result[$row->wf_user_text] = array(
							'min' => $row->wf_min,
							'max' => $row->wf_max,
							'cnt' => $row->wf_cnt,
							'rank' => $rank,
							'user_id' => $row->wf_user,
							'user_name' => $row->wf_user_text
						);
						$rank++;
					}
				}
				$dbs->freeResult( $res );
				#---
				if (self::USE_MEMC) $wgMemc->set($memkey, $result, 60*60);
			}
		}

		wfProfileOut( __METHOD__ );
		#---
		return $result;
	}

	static private function getPageEdistFromDB($cityDBName, $namespace = 0, $reg_users = 0, $limit=50)
	{
    	global $wgMemc;
    	#---
		wfProfileIn( __METHOD__ );
		#---
		$namespace = intval($namespace);
		$namespaces = self::getContentNamespaces();
		$namespaceList = implode(",", $namespaces);

		$result = array();
		#---
		$memkey = 'wikiacitystatseditpages_'.md5($cityDBName.'_'.$namespace.'_'.$reg_users.'_'.$limit);
		#---
		if (self::USE_MEMC) $result = $wgMemc->get($memkey);

    	$no_ip = array();
		if (empty($result)) {
			if (!empty($cityDBName)) {
				$dbs =& wfGetDB(DB_SLAVE, array(), 'wikiastats');
				#---
				$where = " ";
				if (empty($reg_users))
					$where .= " ef_user = {$reg_users}	";
				else
					$where .= " ef_user > 0 ";

				if (empty($namespace))
					$where .= " and ef_page_namespace in (".$namespaceList.") ";
				else
					$where .= " and ef_page_namespace not in (".$namespaceList.") ";

				#---
				$sql = "select ef_page_id, ef_page_title, sum(ef_number_edits) as sum, count(ef_page_id) as cnt, sum(ef_archived) as archived, ef_page_namespace ";
				$sql .= "from `{$cityDBName}_edits_full` where {$where} ";
				$sql .= "group by ef_page_id, ef_page_title, ef_page_namespace order by cnt desc limit {$limit}";

				$res = $dbs->query($sql);
				#---
				while ( $row = $dbs->fetchObject( $res ) ) {
					$result[$row->ef_page_id] = array(
						'page_id' => $row->ef_page_id,
						'page_title' => $row->ef_page_title,
						'nbr_edits' => $row->sum,
						'page_cnt' => $row->cnt,
						'archived' => $row->archived,
						'namespace' => $row->ef_page_namespace,
					);
				}
				$dbs->freeResult( $res );
				#---
				if (self::USE_MEMC) $wgMemc->set($memkey, $result, 60*60);
			}
		}

		wfProfileOut( __METHOD__ );
		#---
		return $result;
	}

	static private function getPageViewsFromDB($city_id)
	{
    	global $wgMemc, $wgExternalStatsDB;
    	#---
		wfProfileIn( __METHOD__ );
		#---
		$result = array();
		#---
		$namespaces = self::getContentNamespaces();
		$memkey = 'wikiacitystatspageviews_'.$city_id;
		#---
		if (self::USE_MEMC) $result = $wgMemc->get($memkey);

    	$no_ip = array();
		if (empty($result)) {
			if (!is_null($city_id)) {
				$dbs =& wfGetDB(DB_SLAVE, array(), $wgExternalStatsDB);
				#---
				$where_city = ($city_id > 0) ? " pv_city_id = {$city_id} " : " pv_city_id > 0 ";
				$sql = "set @day = date_format(now(), '%d') + 1";
				$res = $dbs->query($sql);
				$sql = "select pv_use_date, sum(pv_views) as cnt, pv_namespace from `city_page_views` ";
				$sql .= "where {$where_city} and pv_use_date >= last_day(now() - interval @day day) group by pv_use_date, pv_namespace order by pv_use_date";
				$res = $dbs->query($sql);
				#---
				while ( $row = $dbs->fetchObject( $res ) ) {
					$nspace = (in_array($row->pv_namespace, $namespaces)) ? NS_MAIN : $row->pv_namespace;
					if (isset($result['months'][$row->pv_use_date][$nspace])) {
						$result['months'][$row->pv_use_date][$nspace] += intval($row->cnt);
					} else {
						$result['months'][$row->pv_use_date][$nspace] = intval($row->cnt);
					}
					if (!isset($result['namespaces'][$nspace])) {
						$result['namespaces'][$nspace] = 0;
					}
					$result['namespaces'][$nspace] += intval($row->cnt);
				}

				if (empty($result['months'])) {
					$result['months'] = array();
				}

				$prevValues = array();
				if (!empty($result) && is_array($result['months'])) {
					foreach ($result['months'] as $date => $rowNspace) {
						foreach ($rowNspace as $nspace => $value) {
							if (isset($prevValues[$nspace])) {
								if (isset($result['trends'][$date][$nspace])) {
									$result['trends'][$date][$nspace] += self::calculateTrend($result['months'][$date][$nspace], $prevValues[$nspace]);
								} else {
									$result['trends'][$date][$nspace] = self::calculateTrend($result['months'][$date][$nspace], $prevValues[$nspace]);
								}
							}
							$prevValues[$nspace] = $result['months'][$date][$nspace];
						}
					}
				}

				unset($prevValues);
				$prevValues = array();
				$result_months = array();

				$sql = "select date_format(pv_use_date, '%Y-%m') as pv_date, sum(pv_views) as cnt, pv_namespace from `city_page_views` ";
				$sql .= "where {$where_city} and date_format(pv_use_date, '%Y-%m') <= date_format(now(), '%Y-%m') group by pv_date, pv_namespace order by pv_date";
				$res = $dbs->query($sql);
				#---
				while ( $row = $dbs->fetchObject( $res ) ) {
					$nspace = (in_array($row->pv_namespace, $namespaces)) ? NS_MAIN : $row->pv_namespace;
					if (isset($result_month['months'][$row->pv_date][$nspace])) {
						$result_month['months'][$row->pv_date][$nspace] += intval($row->cnt);
					} else {
						$result_month['months'][$row->pv_date][$nspace] = intval($row->cnt);
					}
					if (!isset($result['namespaces'][$nspace])) {
						$result['namespaces'][$nspace] = 0;
					}
					$result['namespaces'][$nspace] += intval($row->cnt);
				}

				if (!empty($result_month) && is_array($result_month['months'])) {
					foreach ($result_month['months'] as $date => $rowNspace) {
						foreach ($rowNspace as $nspace => $value) {
							if (isset($prevValues[$nspace])) {
								if (isset($result_month['trends'][$date][$nspace])) {
									$result_month['trends'][$date][$nspace] += self::calculateTrend($result_month['months'][$date][$nspace], $prevValues[$nspace]);
								} else {
									$result_month['trends'][$date][$nspace] = self::calculateTrend($result_month['months'][$date][$nspace], $prevValues[$nspace]);
								}
							}
							$prevValues[$nspace] = $result_month['months'][$date][$nspace];
						}
					}
				}

				if (isset($result['trends']) && isset($result_month['trends'])) {
					$result['trends'] = array_merge($result['trends'], $result_month['trends']);
				}
				if (isset($result['months']) && isset($result_month['months'])) {
					$result['months'] = array_merge($result['months'], $result_month['months']);
				}

				$dbs->freeResult( $res );
				#---
				if (self::USE_MEMC) $wgMemc->set($memkey, $result, 60*60);
			}
		}

		if ( empty($result) ) {
			$result = array(
				'months' => '',
				'trends' => '',
				'namespaces' => ''
			);
		}
		wfProfileOut( __METHOD__ );
		#---
		return $result;
	}

	static private function getPageEdistDetailsFromDB($cityDBName, $page_id, $reg_users = 0, $limit=30)
	{
    	global $wgMemc;
    	#---
		wfProfileIn( __METHOD__ );
		#---
		$memkey = 'wikiacitystatseditpagesdetails_'.md5($cityDBName.'_'.$page_id.'_'.$reg_users.'_'.$limit);
		#---
		$result = array();
		if (self::USE_MEMC) $result = $wgMemc->get($memkey);
    	$no_ip = array();
		if (empty($result))
		{
			if (!empty($cityDBName))
			{
				$dbs =& wfGetDB(DB_SLAVE, array(), 'wikiastats');
				#---
				$where = " ef_page_id = '".intval($page_id)."' ";
				if (empty($reg_users))
					$where .= " and ef_user = {$reg_users}	";
				else
					$where .= " and ef_user > 0 ";

				#---
				$sql = "select ef_user, ef_user_text, sum(ef_number_edits) as sum ";
				$sql .= "from `{$cityDBName}_edits_full` where {$where} ";
				$sql .= "group by ef_user, ef_user_text order by sum desc limit {$limit}";

				$res = $dbs->query($sql);
				#---
				while ( $row = $dbs->fetchObject( $res ) )
				{
					$result[$row->sum] = array(
						'user_id' => $row->ef_user,
						'user_text' => $row->ef_user_text,
						'nbr_edits' => $row->sum,
					);
				}
				$dbs->freeResult( $res );
				#---
				if (self::USE_MEMC) $wgMemc->set($memkey, $result, 60*60);
			}
		}

		wfProfileOut( __METHOD__ );
		#---
		return $result;
	}

	public function getRangeDateStatistics()
	{
		global $wgExternalStatsDB, $wgMemc;
		#---
		wfProfileIn( __METHOD__ );
    	#---
    	$monthsArray = array();
    	for ($i = 0; $i < 12; $i++) {
    		$minDate = mktime(23,59,59,$i+1,1,1970); // min date
    		$monthsArray[] = wfMsg(strtolower(date("F",$minDate)));
		}
    	#---
		$memkey = 'wikiastatsdatestatistics';
		#---
		$lStatsRangeTime = array();
		if (self::USE_MEMC) $lStatsRangeTime = $wgMemc->get($memkey);

		if ( empty($lStatsRangeTime) ) {
			$lStatsRangeTime = array("months" => $monthsArray, "minYear" => "2002", "maxYear" => date('Y'));
			try {
				#--- database instance - DB_SLAVE
				$dbs =& wfGetDB(DB_SLAVE, array(), $wgExternalStatsDB);

				if ( is_null($dbs) ) {
					throw new DBConnectionError($dbs, wfMsg("wikiastats_connection_error"));
				}
				#---
				$sql = "SELECT SQL_CACHE min(date_format(cw_stats_date, '%Y')) as minYear, max(date_format(cw_stats_date, '%Y')) as maxYear FROM `city_stats_full` ";
				#---
				$res = $dbs->query($sql);
				#---
				$years = $dbs->fetchRow( $res );
				$lStatsRangeTime['minYear'] = $years['minYear'];
				$lStatsRangeTime['maxYear'] = $years['maxYear'];
				#---
				$dbs->freeResult( $res );
				if (self::USE_MEMC) $wgMemc->set($memkey, $lStatsRangeTime, 60*60);
				#---
			} catch (DBConnectionError $e) {
				$result = array("code" => -1, "text" => $e->getText());
			} catch (DBQueryError $e) {
				$result = array("code" => -2, "text" => $e->getText());
			} catch (DBError $e) {
				$result = array("code" => -3, "text" => $e->getLogMessage());
			}
		}
		$lStatsRangeTime["months"] = $monthsArray;

		wfProfileOut( __METHOD__ );
		#----

		return $lStatsRangeTime;
	}

	static public function getCategoryForCityFromDB($city)
	{
    	global $wgMemc, $wgExternalSharedDB;
    	#---
		wfProfileIn( __METHOD__ );
		$result = array();
		$memkey = 'wikiastatscategorycity_'.$city;
		#---
		if (self::USE_MEMC) $result = $wgMemc->get($memkey);

		if (empty($result)) {
			if (!empty($city)) {
				$dbr =& wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);
				$res = $dbr->select(
					array( "city_cats", "city_cat_mapping" ),
					array( 'cat_name', 'cat_url' ),
					array(
						'city_id' => $city,
						"city_cats.cat_id = city_cat_mapping.cat_id",
					),
					__METHOD__,
					array( 'LIMIT' => '1' )
				);

				if ( $row = $dbr->fetchObject( $res ) ) {
					$result[$city] = array("name" => $row->cat_name, "url" => $row->cat_url);
				}
				#---
				if (self::USE_MEMC) $wgMemc->set($memkey, $result, 60*60);
			}
		}

		wfProfileOut( __METHOD__ );
		#---
		return $result;
	}

	static public function getWikisListByValue($value)
	{
    	global $wgMemc, $wgExternalSharedDB;
    	#---
		wfProfileIn( __METHOD__ );
		$result = array();

		if (empty($value)) {
			wfProfileOut( __METHOD__ );
			return array("0" => wfMsg('wikiastats_trend_all_wikia_text'));
		}

		$memkey = 'wikiastatslistbyvalue_'.md5($value);
		#---
		if (self::USE_MEMC) $result = $wgMemc->get($memkey);

		if (empty($result)) {
			$dbr =& wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);
			$value = htmlspecialchars($value);
			$res = $dbr->select (
				array( 'city_list' ),
				array( 'city_id', 'city_dbname', 'city_url' ),
				array(
					"lower(city_url) like lower('%$value%')",
					"city_id not in (".self::IGNORE_WIKIS.")",
					"city_public = 1",
				),
				__METHOD__,
				array( 'LIMIT' => '100' )
			);

			$result[0] = wfMsg('wikiastats_trend_all_wikia_text');
			while ( $row = $dbr->fetchObject( $res ) ) {
				$urlshort = explode(".", str_replace("http://", "", $row->city_url));
				$shorturl = self::makeWikiNameFromUrl($urlshort);
				$result[$row->city_id] = ucfirst($shorturl);
			}
			if (self::USE_MEMC) $wgMemc->set($memkey, $result, 60*60);
		}
		wfProfileOut( __METHOD__ );
		#---
		return $result;
	}

	static public function getDateStatisticGenerate($city_id)
	{
		global $wgExternalStatsDB, $wgMemc;

		$memkey = 'wikiastatsstatsdate_'.intval($city_id);
		$stats_date = "";
		#---
		if (self::USE_MEMC) $stats_date = $wgMemc->get($memkey);
		if (empty($stats_date)) {
			$dbs =& wfGetDB(DB_SLAVE, array(), $wgExternalStatsDB);
			#---
			if ( !is_null($dbs) ) {
				$sql = "SELECT max(unix_timestamp(cw_timestamp)) as date FROM `city_stats_full` WHERE cw_city_id = '".$city_id."'";
				$res = $dbs->query($sql);
				$row = $dbs->fetchObject( $res );
				$stats_date = $row->date;
				$dbs->freeResult( $res );

			}
			if (empty($stats_date)) {
				$stats_date = time();
			}
			if (self::USE_MEMC) $wgMemc->set($memkey, $stats_date, 60*60);
		}

		return $stats_date;
	}

	static public function getMinDateStatisticGenerate()
	{
		global $wgExternalStatsDB, $wgMemc;

		$memkey = 'wikiastatsminstatsdate';
		$stats_date = "";
		#---
		if (self::USE_MEMC) $stats_date = $wgMemc->get($memkey);
		if (empty($stats_date)) {
			$dbs =& wfGetDB(DB_SLAVE, array(), $wgExternalStatsDB);
			#---
			if ( !is_null($dbs) ) {
				$sql = "SELECT min(unix_timestamp(cw_timestamp)) as date FROM `city_stats_full` WHERE cw_timestamp >= date_format(now(), '%Y-%m-%d') ";
				$res = $dbs->query($sql);
				$row = $dbs->fetchObject( $res );
				$stats_date = $row->date;
				$dbs->freeResult( $res );
			}
			if (empty($stats_date)) {
				$stats_date = false;
			}
			if (self::USE_MEMC) $wgMemc->set($memkey, $stats_date, 60*60);
		}

		return $stats_date;
	}


	public function getColumnStats($column, $all = 0, $keys = '')
	{
    	global $wgMemc, $wgExternalStatsDB;
    	#---
		wfProfileIn( __METHOD__ );
		$wkStatsDBName = "";
		#---
		$dbs =& wfGetDB( DB_SLAVE );
		#---
		$wkColumnStatistics = array();
		#---
		$whereCity = "";
		$flipKeys = array(0 => 0);
		$tmp_key = "";
		if (!empty($keys)) {
			$where_key = implode("','", $keys);
			$tmp_key .= md5($where_key);
			$whereCity = " and cw_city_id in ('".$where_key."') ";
			$flipKeys = array_flip($keys);
		}
    	$memkey = "wikiacolumnstats_".$column.$all.$tmp_key;
    	#---
		$columns = array();
		$wkColumnStatistics = "";
		if (self::USE_MEMC) $wkColumnStatistics = $wgMemc->get($memkey);
		#---
		if (empty($wkColumnStatistics))
		{
			try
			{
				#--- database instance - DB_SLAVE
				$dbs =& wfGetDB(DB_SLAVE, array(), $wgExternalStatsDB);
				if ( is_null($dbs) ) {
					throw new DBConnectionError($dbs, wfMsg("wikiastats_connection_error"));
				}
				#---
				$db_fields = array(0 => "date_format(cw_stats_date, '%Y-%m') as date");
				$groupby = "";
				if (in_array($column, array('cw_article_mean_nbr_revision', 'cw_article_mean_size', 'cw_article_perc_0_5_size', 'cw_article_perc_2_0_size')))
					$db_fields[] = (empty($all)) ? "$column as value" : "avg($column) as value";
				else
					$db_fields[] = (empty($all)) ? "$column as value" : "sum($column) as value";

				#---
				$db_fields[] = (empty($all)) ? "cw_city_id as city_id" : "0 as city_id";
				$group = (empty($all)) ? "cw_city_id, date" : "cw_stats_date desc";
				$groupby = (!empty($all)) ? "group by {$group}" : "";
				$orderby = (empty($all)) ? "order by cw_city_id" : "";

				$noactive_citylist = self::getNoPublicCities();
				$whereCity .= (!empty($noactive_citylist)) ? " and cw_city_id not in ('".implode("','", $noactive_citylist)."') " : "";

				$sql = "select ".implode(",", $db_fields)." from `city_stats_full` ";
				$sql .= "where date_format(cw_stats_date, '%Y-%m') >= '".MIN_STATS_DATE."' {$whereCity} ";
				$sql .= "{$groupby} {$orderby}";
				unset($db_fields);
				$res = $dbs->query($sql);
				$columns = array();
				$colMonthlyStats = array();

				while ( $row = $dbs->fetchObject( $res ) ) {
					foreach ($row as $field => $value) {
						if (!in_array($field, array('city_id', 'date'))) {
							$colMonthlyStats[$row->city_id][$row->date][$field] = $value;
							if (empty($columns[$field])) {
								$columns[$field] = $field;
							}
						}
					}
				}
				$dbs->freeResult( $res );

				if (empty($colMonthlyStats) && empty($columns)) {
					unset($colMonthlyStats);
					unset($columns);
					return -2;
				}
				#--- serialize data to correct view
				$dateArr = self::makeDateMonthArray();

				foreach ($colMonthlyStats as $city_id => $cityStats) {
					if (empty($wkColumnStatistics[$flipKeys[$city_id]])) {
						$wkColumnStatistics[$flipKeys[$city_id]] = array();
					}
					#---
					$monthlyStats = self::setWikiMonthlyStats($cityStats, $columns, STATS_COLUMN_PREFIX, $dateArr);
					if (!empty($monthlyStats)) {
						$wkColumnStatistics[$flipKeys[$city_id]] = array_merge($wkColumnStatistics[$flipKeys[$city_id]], $monthlyStats);
					}
					$wkColumnStatistics[$flipKeys[$city_id]] = array_merge($wkColumnStatistics[$flipKeys[$city_id]], $cityStats);
				}
				unset($columns);
				unset ($monthlyStats);
				unset($cityStats);
				unset($flipKeys);
				#---
				unset($colMonthlyStats);
				#---
				ksort($wkColumnStatistics);
				#---
				if (self::USE_MEMC) $wgMemc->set($memkey, $wkColumnStatistics, 60*60);
			} catch (DBConnectionError $e) {
				return -1;
			} catch (DBQueryError $e) {
				return -1;
			} catch (DBError $e) {
				return -1;
			}
		}

		wfProfileOut( __METHOD__ );
		return $wkColumnStatistics;
	}

	static function makeDateMonthArray() {
		$today = date("Y-m");
		$k = 0; for ($i = 0; $i < self::MONTHLY_STATS + 1; $i++) {
			$date = date("Y-m", strtotime("-$i months"));
			if ($today == $date) continue;
			$dateArr[$k] = $date;
			$k++;
		}
		krsort($dateArr, SORT_NUMERIC);
		return $dateArr;
	}

	public function serializeColumnStats($columnStats, $cities)
	{
		$result = array();
		wfProfileIn( __METHOD__ );
		#---
		$loop = 0;
		if (!empty($columnStats) && is_array($columnStats)) {
			foreach ($columnStats as $id => $dateValues) {
				if (!empty($dateValues) && is_array($dateValues)) {
					foreach ($dateValues as $date => $dateValue) {
						#---
						if (!array_key_exists($date, $result)) {
							$result[$date] = array();
						}
						#---
						if (array_key_exists('visible', $dateValue)) {
							if ($dateValue['visible'] == 1)
								$result[$date][$cities[$id]] = (array_key_exists('value', $dateValue)) ? $dateValue['value'] : "null";
							else
								$result[$date][$cities[$id]] = "null";
						} else {
							$result[$date][$cities[$id]] = $dateValue['value'];
						}
						#----
					}
				}
				$loop++;
			}
		}
		#---
		wfProfileOut( __METHOD__ );
		return $result;
	}

	static public function checkColumnStatDate($date, $prev_date)
	{
		$addEmptyLine = false;
		wfProfileOut( __METHOD__ );
		#---
		if ( (strpos($prev_date,STATS_COLUMN_PREFIX) !== false) && (strpos($date,STATS_COLUMN_PREFIX) === false) ) {
			$addEmptyLine = 4;
		}
		elseif (strpos($prev_date,STATS_COLUMN_PREFIX) === false) {
			$datePrevArr = explode("-", $prev_date);
			$dateArr = explode("-", $date);
			if ($datePrevArr[0] != $dateArr[0]) { // years
				$addEmptyLine = 1;
			}
		}
		#---
		wfProfileOut( __METHOD__ );
		return $addEmptyLine;
	}

	static public function makeCorrectDate($date, $today = 0) {
		global $wgLang;
		wfProfileIn( __METHOD__ );
		$dateArr = explode("-", $date);
		$stamp = mktime(23,59,59,$dateArr[1],1,$dateArr[0]);
		$corDate = ($today) ? $wgLang->sprintfDate(self::getStatsDateFormat(0), wfTimestamp(TS_MW, $stamp))
						: $wgLang->sprintfDate("M Y", wfTimestamp(TS_MW, $stamp));
		wfProfileOut( __METHOD__ );
		return $corDate;
	}

	static public function getWikiaInfoOutput($city_id)
	{
        global $wgUser, $wgContLang, $wgLang;
		wfProfileIn( __METHOD__ );
		#---
		$cityInfo = array();
		$stats_date = time();
		if ($city_id > 0) {
			#---
			$cityInfo = WikiFactory::getWikiByID( $city_id );
			$stats_date = self::getDateStatisticGenerate($city_id);
		} else {
			$stats_date = self::getMinDateStatisticGenerate();
		}

		$cats = array();
		if (!empty($city_id)) {
			$cats = self::getCategoryForCityFromDB($city_id);
		}

		#---
        $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $oTmpl->set_vars( array(
            "today" 		=> date("Y-m"),
            "today_day"     => $stats_date,
            "user"			=> $wgUser,
            "cityInfo"		=> $cityInfo,
            "cityId"		=> $city_id,
			"wgContLang" 	=> $wgContLang,
			"cats"		 	=> $cats,
			"wgLang"		=> $wgLang,
        ));
        #---
		wfProfileOut( __METHOD__ );
        return $oTmpl->execute("stats-wikia-info");
	}

	static public function setWikiMainStatisticsOutput($city_id, $data, $columns, $monthlyStats, $show_local = 0)
	{
        global $wgUser, $wgContLang, $wgLang;
        global $wgStatsExcludedNonSpecialGroup;
		wfProfileIn( __METHOD__ );
		#---
		$cityInfo = array();
		$stats_date = time();
		if ($city_id > 0) {
			#---
			$cityInfo = WikiFactory::getWikiByID( $city_id );
			$stats_date = self::getDateStatisticGenerate($city_id);
		}

		$cats = array();
		if (!empty($city_id)) {
			$cats = self::getCategoryForCityFromDB($city_id);
		}

		$userIsSpecial = 0;
		$rights = $wgUser->getGroups();
		foreach ($rights as $id => $right) {
			if (in_array($right, array('staff', 'sysop', 'janitor', 'bureaucrat'))) {
				$userIsSpecial = 1;
				break;
			}
		}
		#---
        $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $oTmpl->set_vars( array(
            "statsData" 	=> $data,
            "columns"		=> $columns,
            "today" 		=> date("Y-m"),
            "today_day"     => $stats_date,
            "user"			=> $wgUser,
            "monthlyStats"	=> $monthlyStats,
            "cityInfo"		=> $cityInfo,
            "cityId"		=> $city_id,
			"wgContLang" 	=> $wgContLang,
			"wgLang"		=> $wgLang,
			"cats"		 	=> $cats,
			"userIsSpecial" => $userIsSpecial,
			"wgStatsExcludedNonSpecialGroup" => $wgStatsExcludedNonSpecialGroup
        ));
        #---
		wfProfileOut( __METHOD__ );
        return $oTmpl->execute("main-table-stats");
	}

	static public function setWikiDistribStatisticsOutput($data)
	{
        global $wgUser;
		wfProfileIn( __METHOD__ );
		#---
        $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $oTmpl->set_vars( array(
            "statsData" 	=> $data,
            "user"			=> $wgUser,
        ));
        #---
		wfProfileOut( __METHOD__ );
        return $oTmpl->execute("distrib-table-stats");
	}

	static public function setWikiWikiansStatisticsOutput($city_id, $month, $wikians_active, $wikians_absent)
	{
        global $wgUser, $wgLang;
		wfProfileIn( __METHOD__ );
		#---
        $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $oTmpl->set_vars( array(
            "wkActive" 		=> $wikians_active,
            "wkAbsent"		=> $wikians_absent,
            "city_url"		=> self::getWikiaCityUrlById($city_id),
            "cur_month"		=> $month,
            "wgLang"		=> $wgLang
        ));
        #---
        $active = $oTmpl->execute("wikians-active-stats");
        $absent = $oTmpl->execute("wikians-absent-stats");
		wfProfileOut( __METHOD__ );
        return $active . $absent;
	}

	static private function setWikiAnonsStatisticsOutput($city_id, $data)
	{
        global $wgUser, $wgLang;
		wfProfileIn( __METHOD__ );
		#---
        $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $oTmpl->set_vars( array(
            "anonData" 		=> $data,
            "city_url"		=> self::getWikiaCityUrlById($city_id),
            "wgLang"		=> $wgLang,
        ));
        #---
        $active = $oTmpl->execute("anon-users-stats");
		wfProfileOut( __METHOD__ );
        return $active;
	}

	static private function setWikiArticleSizeOutput($city_id, $articleCount, $articleSize)
	{
        global $wgUser, $wgLang;
		wfProfileIn( __METHOD__ );
		#---
        $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $oTmpl->set_vars( array(
            "articleCount" 		=> $articleCount,
            "articleSize" 		=> $articleSize,
            "wgLang"			=> $wgLang,
        ));
        #---
        $res = $oTmpl->execute("articles-size-stats");
        #---
		wfProfileOut( __METHOD__ );
        return $res;
	}

	static private function setWikiNamespaceOutput($city_id, $namespaceCount, $nspaces, $allowedNamespace)
	{
		global $wgLang;
		wfProfileIn( __METHOD__ );
        $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $oTmpl->set_vars( array(
            "namespaceCount" 	=> $namespaceCount,
            "namespaces" 		=> $nspaces,
            "allowedNamespaces"	=> $allowedNamespace,
            "wgLang" 			=> $wgLang
        ));
        #---
        $res = $oTmpl->execute("namespace-count-stats");
        #---
		wfProfileOut( __METHOD__ );
        return $res;
	}

	static private function setWikiEditPagesOutput($city_id, $statsCount, $mSourceMetaSpace, $otherNspaces)
	{
        global $wgUser, $wgCanonicalNamespaceNames, $wgLang;
        global $wgDBname, $wgScript;
		wfProfileIn( __METHOD__ );

		$aNamespaces = WikiFactory::getVarValueByName('wgExtraNamespacesLocal', $city_id);
		$_wgScript = ($wgDBname != CENTRAL_WIKIA_ID) ? $wgScript : WikiFactory::getVarValueByName('wgScript', $city_id) ;
		if ( is_array($aNamespaces) ) {
			$aNamespaces = array_merge($wgCanonicalNamespaceNames, $aNamespaces);
		} else {
			$aNamespaces = $wgCanonicalNamespaceNames;
		}

		#---
        $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $oTmpl->set_vars( array(
            "city_url"		=> self::getWikiaCityUrlById($city_id),
            "statsCount" 	=> $statsCount,
            "projectNamespace" => $mSourceMetaSpace,
            "canonicalNamespace" => $aNamespaces,
            "centralVersion" => ($wgDBname == CENTRAL_WIKIA_ID),
            "otherNspaces" => $otherNspaces,
            "wgLang" => $wgLang,
            "_wgScript" => $_wgScript
        ));
        #---
        $res = $oTmpl->execute("page-counts-stats");
        #---
		wfProfileOut( __METHOD__ );
        return $res;
	}

	static private function setWikiPageViewsOutput($city_id, $statsCount, $mSourceMetaSpace)
	{
        global $wgUser, $wgCanonicalNamespaceNames, $wgLang;
        global $wgDBname, $wgScript;
		wfProfileIn( __METHOD__ );

		$aNamespaces = WikiFactory::getVarValueByName('wgExtraNamespacesLocal', $city_id);
		if ( is_array($aNamespaces) ) {
			$aNamespaces = array_merge($wgCanonicalNamespaceNames, $aNamespaces);
		} else {
			$aNamespaces = $wgCanonicalNamespaceNames;
		}

		#- charts
		$chartHTML = "";
		if (!empty($statsCount)) {
			$stats = $statsCount['months'];
			$nspaces = $statsCount['namespaces'];
			$chartData = self::makePageViewsChartsData($stats, $nspaces);

			#---
			$chartSettings = array(
				'maxsize' => MAX_CHART_HEIGHT,
				'barwidth' => CHART_BAR_WIDTH,
				'barunit' => CHART_BAR_WIDTH_UNIT,
			);

			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
			$oTmpl->set_vars( array(
				"city_id"				=> $city_id,
				"statsKind"				=> "daily",
				"chartValues"			=> $chartData['days'],
				"days"					=> $chartData['date-days'],
				"nspaces"				=> $nspaces,
				"projectNamespace"		=> $mSourceMetaSpace,
				"canonicalNamespace"	=> $aNamespaces,
				"centralVersion" 		=> ($wgDBname == CENTRAL_WIKIA_ID),
				"wgLang" 				=> $wgLang,
				"chartSettings"			=> $chartSettings
			));
			#---
			$chartHTML = $oTmpl->execute("pageviews-charts");

			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
			$oTmpl->set_vars( array(
				"city_id"				=> $city_id,
				"statsKind"				=> "monthly",
				"chartValues"			=> $chartData['months'],
				"days"					=> $chartData['date-years'],
				"nspaces"				=> $nspaces,
				"projectNamespace"		=> $mSourceMetaSpace,
				"canonicalNamespace"	=> $aNamespaces,
				"centralVersion" 		=> ($wgDBname == CENTRAL_WIKIA_ID),
				"wgLang" 				=> $wgLang,
				"chartSettings"			=> $chartSettings
			));

			$chartHTML .= $oTmpl->execute("pageviews-charts");
		}

		#---
        $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $oTmpl->set_vars( array(
            "city_url"				=> self::getWikiaCityUrlById($city_id),
            "statsCount"			=> $statsCount,
            "projectNamespace"		=> $mSourceMetaSpace,
            "canonicalNamespace"	=> $aNamespaces,
            "centralVersion"		=> ($wgDBname == CENTRAL_WIKIA_ID),
            "wgLang"				=> $wgLang,
            "chartHTML"				=> $chartHTML
        ));
        #---
        $res = $oTmpl->execute("pageviews-counts-stats");

        #---
		wfProfileOut( __METHOD__ );
        return $res;
	}

	static private function makePageViewsChartsData($statsData, $nspaces) {
		wfProfileIn( __METHOD__ );
		$result = array( 'days' => array(), 'months' => array(), 'date-days' => array(), 'date-years' => array() );
		if (!empty($statsData) && !empty($nspaces)) {
			foreach ($statsData as $date => $row) {
				$dateArr = explode("-",$date);
				$is_month = 0;
				if (!isset($dateArr[2])) {
					$is_month = 1;
				}
				$result[($is_month == 1) ? 'date-years' : 'date-days'][$date] = 1;
				foreach ($row as $n => $value) {
					$result[($is_month == 1) ? 'months' : 'days'][$n][$date] = $value;
				}
			}
		}
		wfProfileOut( __METHOD__ );
		return $result;
	}

	static private function setWikiEditPageDetailsOutput($city_id, $regCount, $unregCount)
	{
        global $wgUser;
		wfProfileIn( __METHOD__ );
		#---
        $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $oTmpl->set_vars( array(
            "city_url"		=> self::getWikiaCityUrlById($city_id),
            "userStats" 	=> array(0 => $regCount, 1 => $unregCount),
        ));
        #---
        $res = $oTmpl->execute("page-counts-details-stats");
        #---
		wfProfileOut( __METHOD__ );
        return $res;
	}

	static public function setWikiMonthlyStats($statistics, &$columns, $prefix = "", $dateArr = array())
	{
		global $wgLang;
		wfProfileIn( __METHOD__ );
		$mothlyStatsArray = array();
		#---
		if (empty($dateArr)) {
			$dateArr = self::makeDateMonthArray();
		}

		$prev_month = "";
		foreach ($dateArr as $id => $date) {
		    $record = false;
		    if (array_key_exists($date, $statistics)) {
			    $record = $statistics[$date];
            }
			if (empty($record)) continue;
			if (empty($dateArr[$id + 1])) continue;
			#---
			$prev_record = "";
			if (array_key_exists(($id + 1), $dateArr) && array_key_exists($dateArr[$id + 1], $statistics)) {
			    $prev_record = $statistics[$dateArr[$id + 1]];
            }
			if (empty($prev_record)) continue;

			$mothlyStatsArray[$prefix.$date] = array('visible' => 0);
			foreach ($columns as $column) {
			    #---
				if ($column != 'date') {
					#---
					if (empty($record[$column])) $diff = 0;
					else {
						$diff = $record[$column] - $prev_record[$column];
						if ($prev_record[$column] != 0)
							$diff = $wgLang->formatNum(sprintf("%0.2f", ($diff / $prev_record[$column]) * 100));
						else
							$diff = 0;
					}
					#---
					if (empty($diff)) $diff = 0;
					else $mothlyStatsArray[$prefix.$date]['visible'] = 1;
					#---
					$mothlyStatsArray[$prefix.$date][$column] = $diff ;
				}
			}
			$prev_month = $date;
		}

		#---
		krsort($mothlyStatsArray);
		wfProfileOut( __METHOD__ );
		return $mothlyStatsArray;
	}

	static public function getNoPublicCities()
	{
    	global $wgMemc, $wgExternalSharedDB;
    	#---
		wfProfileIn( __METHOD__ );

   		$result = array();
   		$memkey = 'wikiastatsinactivewikialist';
   		if (self::USE_MEMC) $result = $wgMemc->get($memkey);
    	if (empty($result)) {
			$dbr =& wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);
			$res = $dbr->select(
				array( 'city_list' ),
				array( 'city_id' ),
				array(
					'city_public' => 0,
					'city_id > 0',
					'city_id not in ('.self::IGNORE_WIKIS.')'
				),
				__METHOD__
			);
			$result = array(0);
			while ( $row = $dbr->fetchObject( $res ) ) {
				$result[] = $row->city_id;
			}
			$dbr->freeResult( $res );
			#---
			$wgMemc->set($memkey, $result, 60*60);
		}
		wfProfileOut( __METHOD__ );
		return $result;
	}

	public function getWikiMainStatistics($city_id,$year_from=MIN_STATS_YEAR,$month_from=MIN_STATS_MONTH,$year_to='',$month_to='',$charts=0,$xls=0)
	{
    	global $wgMemc, $wgExternalStatsDB;
    	#---
		wfProfileIn( __METHOD__ );
		#---
		$result = array();
		#---
		if (empty($year_to)) $year_to = date("Y");
		if (empty($month_to)) $month_to = date("m");
		#---
		if (!is_numeric($city_id)) $result = array("code" => "-11", "text" => wfMsg('wikiastats_nostats_found'));
		#---
		if (!is_numeric($year_from) && !is_numeric($month_from)) $result = array("code" => "-12", "text" => wfMsg('wikiaststs_invalid_date'));
		if (!is_numeric($year_to) && !is_numeric($month_to)) $result = array("code" => "-13", "text" => wfMsg('wikiaststs_invalid_date'));
		#---
		$stats_date = time();
		if ($city_id > 0) {
			$stats_date = self::getDateStatisticGenerate($city_id);
		}

		$all = (!empty($city_id)) ? 0 : 1;

		$localStats = $this->getLocalStats();
		$memkey = md5($city_id."_".$year_from."_".$month_from."_".$year_to."_".$month_to."_".intval($localStats));
    	$memkey = "wikiamainstatistics_".$memkey;
    	#---
		$columns = array();
		$wkCityMainStatistics = array();
		if (self::USE_MEMC) {
			$wkCityMainStatistics = $wgMemc->get($memkey);
		}
    	if (empty($wkCityMainStatistics)) {
			try {
				#--- database instance - DB_SLAVE
				$dbs =& wfGetDB(DB_SLAVE, array(), $wgExternalStatsDB);
				if ( is_null($dbs) ) {
					throw new DBConnectionError($dbs, wfMsg("wikiastats_connection_error"));
				}

				$db_fields = array("date_format(cw_stats_date, '%Y-%m') as date");
				$db_fields[] = (empty($all)) ? "cw_users_all_reg_main_ns as A" : "sum(cw_users_all_reg_main_ns) as A";
				$db_fields[] = (empty($all)) ? "cw_wikians_edits_5 as B" : "sum(cw_wikians_edits_5) as B";
				$db_fields[] = (empty($all)) ? "cw_wikians_edits_100 as C" : "sum(cw_wikians_edits_100) as C";
				$db_fields[] = (empty($all)) ? "cw_users_all_reg_user_ns as D" : "sum(cw_users_all_reg_user_ns) as D";
				$db_fields[] = (empty($all)) ? "cw_users_all_reg_image_ns as E" : "sum(cw_users_all_reg_image_ns) as E";
				$db_fields[] = (empty($all)) ? "cw_users_all_reg as F" : "sum(cw_users_all_reg) as F";
						//$db_fields[] = (empty($all)) ? "cw_wikians_total as G" : "sum(cw_wikians_total) as G";
						//$db_fields[] = (empty($all)) ? "cw_wikians_total_inc as C" : "sum(cw_wikians_total_inc) as C";
				$db_fields[] = (empty($all)) ? "cw_article_count_link as G" : "sum(cw_article_count_link) as G";
						#$db_fields[] = (empty($all)) ? "cw_article_count_200_link as I" : "sum(cw_article_count_200_link) as I";
				$db_fields[] = (empty($all)) ? "cw_article_new_per_day as H" : "sum(cw_article_new_per_day) as H";
						#$db_fields[] = (empty($all)) ? "cw_article_mean_nbr_revision as K" : "avg(cw_article_mean_nbr_revision) as K";
						#$db_fields[] = (empty($all)) ? "cw_article_mean_size as L" : "avg(cw_article_mean_size) as L";
				$db_fields[] = (empty($all)) ? "cw_article_perc_0_5_size as I" : "avg(cw_article_perc_0_5_size) as I";
						#$db_fields[] = (empty($all)) ? "cw_article_perc_2_0_size as N" : "avg(cw_article_perc_2_0_size) as N";
				$db_fields[] = (empty($all)) ? "cw_db_edits as J" : "sum(cw_db_edits) as J";
				$db_fields[] = (empty($all)) ? "cw_db_size as K" : "sum(cw_db_size) as K";
				$db_fields[] = (empty($all)) ? "cw_db_words as L" : "sum(cw_db_words) as L";
						#$db_fields[] = (empty($all)) ? "cw_links_internal as R" : "sum(cw_links_internal) as R";
						#$db_fields[] = (empty($all)) ? "cw_links_interwiki as S" : "sum(cw_links_interwiki) as S";
				$db_fields[] = (empty($all)) ? "cw_links_image as M" : "sum(cw_links_image) as M";
				$db_fields[] = (empty($all)) ? "cw_links_external as N" : "sum(cw_links_external) as N";
						#$db_fields[] = (empty($all)) ? "cw_links_redirects as V" : "sum(cw_links_redirects) as V";
				$db_fields[] = (empty($all)) ? "cw_images_uploaded as O" : "sum(cw_images_uploaded) as O";
						#$db_fields[] = (empty($all)) ? "cw_images_linked as X" : "sum(cw_images_linked) as X";
				#---
				$where = (!empty($city_id)) ? "cw_city_id = '".intval($city_id)."'" : "cw_city_id not in ('".implode("','", self::getNoPublicCities()) ."')";
				#---
				if ($year_from && $month_from)
					$where .= sprintf(" and date_format(cw_stats_date, '%%Y-%%m') >= '%04d-%02d' ", $year_from, $month_from);
				#---
				if ($year_to && $month_to)
					$where .= sprintf(" and date_format(cw_stats_date, '%%Y-%%m') <= '%04d-%02d' ", $year_to, $month_to);
				#---
				$group = (empty($city_id)) ? "group by date" : "";

				$sql = "SELECT ".implode(",", $db_fields)." FROM `city_stats_full` WHERE {$where} {$group} order by date desc";
				#---
				$res = $dbs->query($sql);
				while ( $row = $dbs->fetchObject( $res ) ) {
					$wkCityMainStatistics[$row->date] = array();
					foreach ($row as $field => $value) {
					    $wkCityMainStatistics[$row->date][$field] = $value;
					}
				}
				$dbs->freeResult( $res );

				#---
				if (self::USE_MEMC) $wgMemc->set($memkey, $wkCityMainStatistics, 60*60);
			} catch (DBConnectionError $e) {
				$result = array("code" => -1, "text" => $e->getText());
			} catch (DBQueryError $e) {
				$result = array("code" => -2, "text" => $e->getText());
			} catch (DBError $e) {
				$result = array("code" => -3, "text" => $e->getLogMessage());
			}
		}

		if (empty($columns)) {
			if (!empty($wkCityMainStatistics)) {
				list ($date, $values) = each($wkCityMainStatistics);
				$columns = array_keys($wkCityMainStatistics[$date]);
			}
		}

		$output = "";
		if ($xls) {
		    // xls
			$monthlyStats = self::setWikiMonthlyStats($wkCityMainStatistics, $columns);
			// generate output table with HTML or XLS
			wfProfileOut( __METHOD__ );
			$output = self::setWikiMainStatisticsXLS($city_id, $wkCityMainStatistics, $columns, $monthlyStats);
		} elseif (empty($result)) {
		    // html page
			if (empty($wkCityMainStatistics) && empty($columns)) {
			    #---
				$result = array("code" => 1, "text" => wfMsg("wikiastats_nostats_found"));
			} else {
				$output = self::getWikiaInfoOutput($city_id);
				$monthlyStats = array();
				if (empty($charts)) { // --- no charts - html or xls
					// generate monthly increase for statistics
					$monthlyStats = self::setWikiMonthlyStats($wkCityMainStatistics, $columns);
					// standard HTML output
					$output .= self::setWikiMainStatisticsOutput($city_id, $wkCityMainStatistics, $columns, $monthlyStats, (!empty($localStats)));
				} else {
			        // charts
					// serialize data for charts
					$charts = array();
					foreach ($wkCityMainStatistics as $date => $columns) {
						foreach ($columns as $column => $value) {
							if ($column != 'date') {
								if (!array_key_exists($column, $charts)) {
									$charts[$column] = array();
								}
								#---
								$charts[$column][$date] = $value;
							}
						}
					}
					unset($wkCityMainStatistics);

					// generate charts
					$i = 0;
					foreach ($charts as $column => $data) {
						$main_title = "";
						$dataSort = $data;
						#if ($i > 0) continue;
						#---
						if ($i == 0) $main_title = wfMsg("wikiastats_wikians");
						elseif ($i == 7) $main_title = wfMsg("wikiastats_articles");
						elseif ($i == 14) $main_title = wfMsg("wikiastats_database");
						elseif ($i == 17) $main_title = wfMsg("wikiastats_links");
						elseif ($i == 22) $main_title = wfMsg("wikiastats_images");

						#---
						ksort($dataSort);
						$output .= self::generateHtmlCharts((empty($id))?$city_id:0, $dataSort, $column, $main_title, $stats_date);
						$i++;
					}
					unset($charts);
				}
				unset($wkCityMainStatistics);
				unset($monthlyStats);
				$result = array("code" => 1, "text" => $output);
			}
		}
		unset($columns);

		#---
		wfProfileOut( __METHOD__ );
		return $result;
	}

	static public function generateHtmlCharts ($city_id, $chData, $column, $chMainTitle = "", $stats_date = "")
	{
        global $wgUser, $wgLang;

		wfProfileIn( __METHOD__ );
        $chartSettings = array(
        	'maxsize' => MAX_CHART_HEIGHT,
        	'barwidth' => CHART_BAR_WIDTH,
        	'barunit' => CHART_BAR_WIDTH_UNIT,
        );
		if (empty($stats_date)) {
			$stats_date = time();
		}

		#---
        $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $oTmpl->set_vars( array(
            "chartSettings"	=> $chartSettings,
            "city_id" 		=> $city_id,
            "data" 			=> $chData,
            "mainTitle"		=> $chMainTitle,
            "stats_date"	=> $stats_date,
            "column"		=> $column,
            "wgLang"		=> $wgLang,
        ));
        #---
        $res = $oTmpl->execute("stats-chart");
        #---
		wfProfileOut( __METHOD__ );
        return $res;
	}

	static public function getWikiDistribStatistics($city_id, $xls = 0)
	{
		global $wgLang;
		#---
		$data = array("code" => 0, "text" => "");
		#---
		wfProfileIn( __METHOD__ );
    	#---
    	$sqrt10 = sqrt(10);
    	$bins = 15 ;
    	$wikiansTotal = $editsTotal = 0;
    	$edits = array();
  		$j = 1 ;
  		for ($i = 0 ; $i < $bins ; $i++) {
  			$edits[$i] = sprintf("%.0f", $j - 0.01);
  			$j *= $sqrt10 ;
  		};
  		#---
  		$cityDBName = self::getWikiaDBCityListById($city_id);
 		$wikians_perc = 100;
  		foreach ($edits as $id => $value) {
  			$res = self::getUserEditCountFromDB($cityDBName, $value);
  			if (empty($res['count'])) {
  				break; // no more data
			}
  			#---
  			if ( $id == 0 ) {
  				$wikiansTotal = $res['count'];
  				$editsTotal = $res['sum'];
			}
  			$result[$id] = array (
  				'edits' => $value,
  				'wikians' => $res['count'],
  				'wikians_perc' => sprintf("%s%%", $wgLang->formatNum(sprintf("%0.1f", ($res['count']/$wikiansTotal) * 100))), //sprintf("%0.1f%%", ($res['count']/$wikiansTotal) * 100),
  				'edits_total' => $res['sum'],
  				'edits_total_perc' => sprintf("%s%%", $wgLang->formatNum(sprintf("%0.1f", ($res['sum']/$editsTotal) * 100))), //sprintf("%0.1f%%", ($res['sum']/$editsTotal) * 100),
  			);
		}

		if (!empty($xls)) {
			wfProfileOut( __METHOD__ );
			self::makeWikiDistribXLS($city_id, $result);
		}
		elseif (!empty($result)) {
			$data = array("code" => 1, "text" => self::setWikiDistribStatisticsOutput($result));
		}

		#---
		wfProfileOut( __METHOD__ );
		return $data;
	}

	static public function getWikiWikiansRank($city_id, $month, $xls = 0)
	{
		#---
		wfProfileIn( __METHOD__ );
		#---
		$data = array("code" => 0, "text" => "");
		#---
		$cityDBName = self::getWikiaDBCityListById($city_id);
		#---
		if (!empty($cityDBName)) {
			$rankUsers = self::getWikiansListStatsFromDB($cityDBName, 0, STATS_WIKIANS_RANK_NBR);
			$rankUsersNamespace = array();
			#--- get list of user id
			$userIDs = array();
			if (!empty($rankUsers)) {
				$userIDs = array_keys($rankUsers);
			}
			#---
			if (!empty($userIDs)) {
				$rankUsersNamespace = self::getWikiansListStatsFromDB($cityDBName, 1, STATS_WIKIANS_RANK_NBR, 0, $userIDs);
			}
			#--- previous ranking
			$stamp = date( "Y-m", mktime(23,59,59,date("m")- (1 + $month),1,date("Y")) );
			$rankUsersPrev = self::getWikiansListStatsFromDB($cityDBName, 0, STATS_WIKIANS_RANK_NBR, $stamp);
			$userIDs = array();
			if (!empty($rankUsersPrev)) {
				$userIDs = array_keys($rankUsersPrev);
			}
			if (!empty($userIDs)) {
				$rankUsersPrevNamespace = self::getWikiansListStatsFromDB($cityDBName, 1, STATS_WIKIANS_RANK_NBR, $stamp, $userIDs);
			}

			$wikians_active = array();
			$wikians_absent = array();
			if (!empty($rankUsers)) {
				foreach ($rankUsers as $user_id => $rankInfo) {
					#$time_diff = time(mktime(23,59,59,date("m"),1,date("Y"))) - $rankInfo["max"];
					if (!is_array($rankInfo)) continue;

					$time_diff = time() - $rankInfo["max"];
					if ($time_diff >= $month * ABSENT_TIME) {
						$wikians_absent[$rankInfo["rank"]] = array(
							'user_id' => $rankInfo["user_id"],
							'user_name' => $rankInfo["user_name"],
							'total' => $rankInfo["cnt"],
							'first_edit' => $rankInfo["min"],
							'first_edit_ago' => sprintf("%0.0f", (time() - $rankInfo["min"])/(60*60*24)),
							'last_edit' => $rankInfo["max"],
							'last_edit_ago' => sprintf("%0.0f", (time() - $rankInfo["max"])/(60*60*24)),
						);
					} else {
					    $rank = (array_key_exists($user_id, $rankUsersPrev)) ? intval($rankUsersPrev[$user_id]["rank"]) : 50;
					    $cnt_ns = (array_key_exists($user_id, $rankUsersNamespace)) ? $rankUsersNamespace[$user_id]["cnt"] : 0;
					    $prev_cnt_ns = (array_key_exists($user_id, $rankUsersPrevNamespace) && isset($rankUsersPrevNamespace[$user_id]["cnt"]) ) 
					    	? intval($rankUsersPrevNamespace[$user_id]["cnt"]) : intval($cnt_ns);
					    $cnt = (array_key_exists($user_id, $rankUsersPrev)) ? intval($rankUsersPrev[$user_id]["cnt"]) : intval($rankInfo["cnt"]);
						$wikians_active[$rankInfo["rank"]] = array(
							'user_id' => $rankInfo["user_id"],
							'user_name' => $rankInfo["user_name"],
							'prev_rank' => $rank,
							'rank_change' => $rank - intval($rankInfo["rank"]),
							'total' => intval($rankInfo["cnt"]),
							'total_other' => intval($cnt_ns),
							'edits_last' => (intval($rankInfo["cnt"]) - $cnt),
							'edits_other_last' => (intval($cnt_ns) - intval($prev_cnt_ns)),
							'first_edit' => $rankInfo["min"],
							'first_edit_ago' => sprintf("%0.0f", (time() - $rankInfo["min"])/(60*60*24)),
							'last_edit' => $rankInfo["max"],
							'last_edit_ago' => sprintf("%0.0f", (time() - $rankInfo["max"])/(60*60*24)),
						);
					}
				}
			}

			if (empty($xls)) {
				if (empty($rankUsers)) {
					wfProfileOut( __METHOD__ );
					return $data;
				}
				$text = self::setWikiWikiansStatisticsOutput($city_id, $month, $wikians_active, $wikians_absent);
				$data = array("code" => 1, "text" => $text);
			} else {
				wfProfileOut( __METHOD__ );
				self::makeWikiActiveWikiansXLS($city_id, $wikians_active, $wikians_absent);
			}
		}

		#---
		wfProfileOut( __METHOD__ );
		return $data;
	}

	static public function getWikiAnonUsers($city_id, $xls = 0)
	{
		#---
		wfProfileIn( __METHOD__ );
		#---
		$data = array("code" => 0, "text" => "");
		#---
		$cityDBName = self::getWikiaDBCityListById($city_id);
		#---
		if (!empty($cityDBName)) {
			$rankUsers = self::getAnonUserStatisticsFromDB($cityDBName);
			if (empty($xls)) {
				if (!empty($rankUsers)) {
					$rankUsers = array_slice($rankUsers, 0, ANON_ARRAY_LGTH);
					$text = self::setWikiAnonsStatisticsOutput($city_id, $rankUsers);
					$data = array("code" => 1, "text" => $text);
				}
			} else {
				if (empty($rankUsers)) {
					$rankUsers = array();
				}
				#--
				$rankUsers = array_slice($rankUsers, 0, ANON_ARRAY_LGTH);
				wfProfileOut( __METHOD__ );
				self::makeWikiAnonUsersXLS($city_id, $rankUsers);
			}
		}

		#---
		wfProfileOut( __METHOD__ );
		return $data;
	}

	static public function getWikiArticleSize($city_id, $sizeList = '', $xls = 0)
	{
		#---
		wfProfileIn( __METHOD__ );
		#---
		$data = array("code" => 0, "text" => "");
		#---
		if (!empty($sizeList)) {
			$cityDBName = self::getWikiaDBCityListById($city_id);
			#---
			if (!empty($cityDBName)) {
				$articleCount = self::getArticlesCountsFromDB($cityDBName);
				#---
				$sizes = explode(",", $sizeList);
				#---
				$articleSize = array();
				if (!empty($sizes)) {
					foreach ($sizes as $i => $size) {
						if (!empty($size)) {
							$articleSize[$size] = self::getArticlesCountsFromDB($cityDBName, $size, 0);
						}
					}
				}
				if (empty($xls)) {
					$text = self::setWikiArticleSizeOutput($city_id, $articleCount, $articleSize);
					$data = array("code" => 1, "text" => $text);
				} else {
					wfProfileOut( __METHOD__ );
					self::makeWikiArticleSizeXLS($city_id, $articleCount, $articleSize);
				}
			}
		}

		#---
		wfProfileOut( __METHOD__ );
		return $data;
	}

	static public function getWikiNamespaceCount($city_id, $xls = 0)
	{
		global $wgUser, $wgCanonicalNamespaceNames;
		#---
		wfProfileIn( __METHOD__ );
		#---
		$data = array("code" => 0, "text" => "");
		$allowedNamespace = array(0,2,3,4,6,8,10,12,14);
		#---
		$namespaces = $wgCanonicalNamespaceNames;
		if (empty($namespaces[0])) {
			$namespaces[0] = wfMsg('wikiastats_articles_text');
		}
		ksort($namespaces);

		#---
		if (!empty($city_id)) {
			$cityDBName = self::getWikiaDBCityListById($city_id);
			#---
			if (!empty($cityDBName)) {
				$namespaceCount = self::getNamespaceStatFromDB($cityDBName);
				#---
				if (empty($xls)) {
					$text = self::setWikiNamespaceOutput($city_id, $namespaceCount, $namespaces, $allowedNamespace);
					$data = array("code" => 1, "text" => $text);
				} else { // xls
					wfProfileOut( __METHOD__ );
					self::makeWikiaDBNamespaceXLS($city_id, $namespaceCount, $namespaces, $allowedNamespace);
				}
			}
		}

		#---
		wfProfileOut( __METHOD__ );
		return $data;
	}

	static private function serializeWikiaTrendsData($data = array(), $alldata = array())
	{
		#---
		wfProfileIn( __METHOD__ );
		#---
		$result = array();
		#---
		$curdate = date('Y-m');
		$trendData = array();
		if (!empty($data)) {
			foreach ($data as $date => $city_data) { #--- month iterration
				$loop = 0;
				$date_array = explode("-", $date); // YYYY-MM
				$day_nbr = ($date == $curdate) ? date("d") : date("t", mktime(23,59,59,$date_array[1],1,$date_array[0]));

				if ((!empty($city_data)) && (!empty($alldata))) {
					foreach ($city_data as $city_id => $records) { #--- city iterration
						foreach ($records as $id => $value) { #--- columns iterration
							#---
							$result[$id][$date][0] = $alldata[$date][0][$id];
							if ($loop == 0)
								$trendData[$id][0][$date] = array("daynbr" => $day_nbr, "value" => $alldata[$date][0][$id]);
							#---
							$result[$id][$date][$city_id] = $value;
							#---
							$trendData[$id][$city_id][$date] = array("daynbr" => $day_nbr, "value" => $value);
							#---
							krsort($result[$id]);
						}
						$loop++;
					}
				}
			}
		}

		foreach ($trendData as $column => $cities) {
			$values = self::calculateAllTrendValues($cities, $curdate, $column);
			$result[$column] = self::mergeTrends($result[$column], 1, $values, 'trend');
			$result[$column] = self::mergeTrends($result[$column], count($result[$column]), $values, 'mean');
			$result[$column] = self::mergeTrends($result[$column], count($result[$column]), $values, 'growth');
		}
		unset($trendData);
		#---
		wfProfileOut( __METHOD__ );
		return $result;
	}

	static private function calculateAllTrendValues($cities, $curdate, $column)
	{
		$res = array('trend' => array(), 'mean' => array(), 'growth' => array());
		#---
		wfProfileIn( __METHOD__ );

		if (is_array($cities)) {
			foreach ($cities as $city_id => $dateArray) {
				$prev_date = '';
				$growth = $mean = $sumDaysMean = $sumDaysGrowth = 0;
				ksort($dateArray);
				$res['trend'][$city_id] = $res['mean'][$city_id] = $res['growth'][$city_id] = 0;
				foreach ($dateArray as $date => $values) {
					if ($curdate == $date) {
						$res['trend'][$city_id] = $values['value'];
						if ($prev_date) {
							$prev_month_value = intval($dateArray[$prev_date]['value']);
							#$diff = intval($values['value']) - $prev_month_value;
							$res['trend'][$city_id] = self::makeTrend($column, $prev_month_value, $values['value'], ($values['daynbr']));
						}
					}
					#---
					$mean = $mean + (intval($values['daynbr']) * intval($values['value']));
					$sumDaysMean += $values['daynbr'];
					#---
					if (!empty($prev_date)) {
						$prev_value = intval($dateArray[$prev_date]['value']);
						if (!empty($prev_value)) {
							$growth = $growth + ((intval($values['daynbr']) * (intval($values['value']) - $prev_value)) / $prev_value);
						}
						$sumDaysGrowth += $values['daynbr'];
					}
					#---
					$prev_date = $date;
				}
				#---
				if (!empty($sumDaysMean)) $res['mean'][$city_id] = round($mean/$sumDaysMean, 0);
				if (!empty($sumDaysGrowth)) $res['growth'][$city_id] = round((100 * $growth)/$sumDaysGrowth, 0);
				#---
			}
		}
		#---
		wfProfileOut( __METHOD__ );
		return $res;
	}

	static private function makeTrend($c, $prev_value, $cur_value, $cur_day)
	{
		global $wgLang;
		wfProfileIn( __METHOD__ );
		$factor = ($cur_day) ? round((date('t')/$cur_day), 2) : 0;
		if ( ($c == 'C') || ($c == 'D') ) {
   			$forecast = $cur_value + ($cur_value * 1/$factor) ;
        } elseif ( ($c == 'B') || ($c == 'G') || ($c == 'H') || ($c == 'I') || ($c == 'L') || ($c == 'T') || ($c == 'U') ) {
        	$forecast = $factor * $cur_value;
        } elseif (strpos($cur_value, "%") !== false) {
        	$forecast = $cur_value;
        } elseif ($cur_value < $prev_value) {
        	$forecast = 0 ;
        } else {
        	$forecast = $prev_value + $factor * ($cur_value - $prev_value);
        }

        $decimal = strpos($cur_value, ".") ;
        if ($decimal !== $decimal)
        	$forecast = $wgLang->formatNum(sprintf ("%.1f", $forecast));
        else
        	$forecast = $wgLang->formatNum(sprintf ("%.0f", $forecast));
        #---
        $perc = strpos($cur_value, "%");
        if ($perc !== false)
        	$forecast .= "%" ;

        #----
		wfProfileOut( __METHOD__ );
        return $forecast;
	}

    static private function mergeTrends($array, $position, $insert_array, $key)
    {
		wfProfileIn( __METHOD__ );
        $first_array = array_splice ($array, 0, $position);
        $merge_array = array($key => $insert_array[$key]);
        $array = array_merge ($first_array, $merge_array, $array);
		wfProfileOut( __METHOD__ );
        return $array;
    }

    static private function calculateTrend($new_value, $prev_value) {
    	$res = $new_value;
    	if ($prev_value > 0) {
    		$res = 100 * (($new_value - $prev_value)/$prev_value);
		}
		return $res;
	}

	static public function getHtmlColorValue($R, $G, $B) {
		$colorValue = '#' . (strlen($R) == 1 ? ('0' . $R) : $R);
		$colorValue.= (strlen($G) == 1 ? ('0' . $G) : $G);
		$colorValue.= (strlen($B) == 1 ? ('0' . $B) : $B);
		return $colorValue;
	}

	static public function colorizeTrend($value) {
		$res = "#FFFFFF";
		$oryg_value = $value;
		$value = sprintf("%0.0f", $value);
		if ($value != 0) {
			$dec = abs(($value < -50) ? -5 : (($value > 50) ? 5 : floor($value/10)));
			$value = ($value < -50) ? -5 : (($value > 50) ? 5 : ceil($value/10)) - 1;
			if ($value < 0) {
				$redComponent = dechex(255);
				$greenComponent = dechex(255 - 20 * ($dec - $value + 1));
				$blueComponent = dechex(255 - 20 * ($dec - $value + 1));
			} else {
				$redComponent = dechex(255 - 40 * ($dec + 1));
				$greenComponent = dechex(255);
				$blueComponent = dechex(255 - 40 * ($dec + 1));
			}
			$res = self::getHtmlColorValue($redComponent, $greenComponent, $blueComponent);
		}
		return $res;
	}

	static public function getWikiPageEditsCount($city_id, $xls = 0, $otherNspaces = 0)
	{
		#---
		wfProfileIn( __METHOD__ );
		#---
		$data = array("code" => 0, "text" => "");
		#---
		if (!empty($city_id)) {
			$cityDBName = self::getWikiaDBCityListById($city_id);
			#---
			$sortData = array();
			if (!empty($cityDBName)) {
				$regCount = self::getPageEdistFromDB($cityDBName, $otherNspaces, 0, 50);
				$unregCount = self::getPageEdistFromDB($cityDBName, $otherNspaces, 1, 50);
				#---
				$setRegPages = array();
				foreach ($regCount as $page_id => $values) {
					$cnt = ( is_array($unregCount) && array_key_exists($page_id, $unregCount) &&  (!empty($unregCount[$page_id])) )
					       ? $values['nbr_edits'] + intval($unregCount[$page_id]['nbr_edits'])
					       : $values['nbr_edits'];
					#---
					if ($cnt > 0) {
						$setRegPages[$page_id] = 1;
						#---
						$sortData[$cnt] = array(
							'page_id'     => $page_id,
							'page_title'  => $values['page_title'],
							'nbr_edits'   => $cnt,
							'reg_edits'   => $values['nbr_edits'],
							'reg_users'   => $values['page_cnt'],
							'namespace'   => $values['namespace'],
							'unreg_users' => ( is_array($unregCount) && array_key_exists($page_id, $unregCount) && (!empty($unregCount[$page_id]['page_cnt'])) )
							                 ? intval($unregCount[$page_id]['page_cnt'])
							                 : 0,
							'archived'    => ( is_array($unregCount) && array_key_exists($page_id, $unregCount) && (!empty($unregCount[$page_id]['archived'])) )
							                 ? intval($values['archived']) + intval($unregCount[$page_id]['archived'])
							                 : intval($values['archived']),
						);
					}
					#---
				}

				#--- check unregister users
				if (is_array($unregCount)) {
                    foreach ($unregCount as $page_id => $values) {
                        if (empty($setRegPages)) {
                            $cnt = $values['nbr_edits'];
                            #---
                            $sortData[$cnt] = array(
                                'page_id' => $page_id,
                                'page_title' => $values['page_title'],
                                'nbr_edits' => $cnt,
                                'reg_edits' => 0,
                                'reg_users' => 0,
                                'unreg_users' => $values['page_cnt'],
                                'archived' => intval($values['archived']),
                                'namespace' => $values['namespace'],
                            );
                        }
                    }
                }
				#---
				krsort($sortData);
				#---
				#--- source wgMetaNamespace
				$mSourceMetaSpace = '';
				$mSourceMetaSpace = WikiFactory::getVarValueByName( "wgMetaNamespace", $city_id );

				if( empty($mSourceMetaSpace) ) {
					$mSourceMetaSpace = str_replace( ' ', '_', WikiFactory::getVarValueByName( "wgSitename", $city_id ) );
				}
				#---
				if (empty($xls)) {
					$text = self::setWikiEditPagesOutput($city_id, $sortData, $mSourceMetaSpace, $otherNspaces);
					$data = array("code" => 1, "text" => $text);
				} else {
					wfProfileOut( __METHOD__ );
					if ($otherNspaces == 1) {
						self::makeWikiaMostEditOtherNspacesPagesXLS($city_id, $sortData, $mSourceMetaSpace);
					} else {
						self::makeWikiaMostEditPagesXLS($city_id, $sortData, $mSourceMetaSpace);
					}
				}
			}
		}

		#---
		wfProfileOut( __METHOD__ );
		return $data;
	}

	static public function getWikiPageViewsCount($city_id, $xls = 0, $otherNspaces = 0)
	{
		#---
		wfProfileIn( __METHOD__ );
		#---
		$data = array("code" => 0, "text" => "");
		#---
		if (!is_null($city_id)) {
			$cityDBName = (!empty($city_id)) ? self::getWikiaDBCityListById($city_id) : "wikicities";
			#---
			if (!empty($cityDBName)) {
				$pageViewsCount = self::getPageViewsFromDB( $city_id );
				if (!empty($pageViewsCount)) {
					$city_id = (!empty($city_id)) ? $city_id : WikiFactory::DBtoID($cityDBName);
					$mSourceMetaSpace = WikiFactory::getVarValueByName( "wgMetaNamespace", $city_id );
					if (empty($xls)) {
						$text = self::setWikiPageViewsOutput($city_id, $pageViewsCount, $mSourceMetaSpace, $otherNspaces);
						$data = array("code" => 1, "text" => $text);
					} else {
						wfProfileOut( __METHOD__ );
						self::makeWikiaPageViewsXLS($city_id, $pageViewsCount, $mSourceMetaSpace, $otherNspaces);
						//self::makeWikiaMostEditOtherNspacesPagesXLS($city_id, $sortData, $mSourceMetaSpace);
					}
				}

			}
		}

		#---
		wfProfileOut( __METHOD__ );
		return $data;
	}

	public function getWikiCreationHistoryXLS($city_id) {
		wfProfileIn( __METHOD__ );
		$cityList = $this->getWikiaAllCityList();
		list ($arr_wikians, $dWikians, $arr_article, $dArticles) = $this->getWikiCreationHistory();
		#---
		wfProfileOut( __METHOD__ );
		self::makeCreationStatsXLS($cityList, $arr_wikians, $dWikians, $arr_article, $dArticles);
	}

	static public function getWikiPageEditsDetailsCount($city_id, $page_id)
	{
		#---
		wfProfileIn( __METHOD__ );
		#---
		$data = array("code" => 0, "text" => "");
		#---
		if (!empty($city_id)) {
			$cityDBName = self::getWikiaDBCityListById($city_id);
			#---
			$sortData = array();
			if (!empty($cityDBName)) {
				$regCount = self::getPageEdistDetailsFromDB($cityDBName, $page_id, 1);
				$unregCount = self::getPageEdistDetailsFromDB($cityDBName, $page_id, 0);
				#---
				$text = self::setWikiEditPageDetailsOutput($city_id, $regCount, $unregCount);
				$data = array("code" => 1, "text" => $text);
			}
		}
		#---
		return $data;
		wfProfileOut( __METHOD__ );
	}

	static public function getWikiTrendStatistics ($keys = array(), $prev_months = 5)
	{
		wfProfileIn( __METHOD__ );
		#---
		$month_array = array();
		if ( !empty($prev_months) ) {
			for ($i = 0; $i < $prev_months; $i++) {
				$date = strtotime("-$i month");
				$month_array[] = sprintf("'%s'", date('Y-m', $date));
			}
		}
		#---
		$data = self::getWikiaTrendsFromDB($month_array, $keys, 0);
		unset($keys);
		#--- stats for all wikia
		$alldata = self::getWikiaTrendsFromDB($month_array, 0, 1);
		#--- rebuild data to table view
		$serialize_data = self::serializeWikiaTrendsData($data, $alldata);
		#---
		unset($alldata);
		unset($data);

		wfProfileOut( __METHOD__ );
		return array(0 => $serialize_data, 1 => $month_array);
	}

	public function generateMonthArray($min_date, $max_date = '')
	{
		$array = array();
		wfProfileIn( __METHOD__ );
		#---
		if (empty($max_date)) {
			$max_date = date('Y-m');
		}
		if ($min_date <= $max_date) {
			while ($min_date < $max_date) {
				$array[] = $min_date;
				$dataArr = explode("-", $min_date);
				$mon = $dataArr[1]; $year = $dataArr[0];
				if ($mon == 12) { $mon = 1; $year++; }
				else { $mon++; }
				if ($mon < 10) $mon = "0".$mon;
				$min_date = $year."-".$mon;
			}
		}
		#---
		wfProfileOut( __METHOD__ );
		return $array;
	}

    static public function getFileMTimeRemove($uri)
    {
		wfProfileIn( __METHOD__ );
        $uri = parse_url($uri);
        $uri['port'] = isset($uri['port']) ? $uri['port'] : 80;
        $handle = @fsockopen($uri['host'],$uri['port']);
        if(!$handle) return 0;

        fputs($handle,"GET $uri[path] HTTP/1.1\r\nHost: $uri[host]\r\n\r\n");
        $result = 0;
        while(!feof($handle)) {
            $line = fgets($handle,1024);
            if(!trim($line)) {
                break;
            }

            $col = strpos($line,':');
            if($col !== false) {
                $header = trim(substr($line,0,$col));
                $value = trim(substr($line,$col+1));
                if(strtolower($header) == 'last-modified')
                {
                    $result = strtotime($value);
                    break;
                }
            }
        }
        fclose($handle);
		wfProfileOut( __METHOD__ );
        return $result;
    }

	static public function getStatsDateFormat($showYear = 1) {
		global $wgUser;
		$return = $dateFormat = $wgUser->getDatePreference();
		switch ($dateFormat) {
			case "mdy" : $return = (!empty($showYear)) ? "M j, Y" : "M j"; break;
			case "dmy" : $return = (!empty($showYear)) ? "j M Y" : "j M"; break;
			case "ymd" : $return = (!empty($showYear)) ? "Y M j" : "M j"; break;
			case "ISO 8601" : $return = (!empty($showYear)) ? "xnY-xnM-xnd" : "xnM-xnd"; break;
			default : $return = (!empty($showYear)) ? "M j, Y" : "M j"; break;
		}
		return $return;
	}

    static public function getUrlFilesize($url)
    {
		wfProfileIn( __METHOD__ );
        if (substr($url,0,4)=='http') {
            $x = array_change_key_case(get_headers($url, 1),CASE_LOWER);
            $x = $x['content-length'];
        } else {
            $x = @filesize($url);
        }

        $file_size = array_reduce (
            array (" B", " KB", " MB", " GB"), create_function (
                '$a,$b', 'return is_numeric($a)?($a>=1024?$a/1024:number_format($a,2).$b):$a;'
            ), $x
        );
		wfProfileOut( __METHOD__ );
        return $file_size ;
    }


    static public function getNumberFormat($value)
    {
    	global $wgLang;

		wfProfileIn( __METHOD__ );
		$Kb = 1000;
		$Mb = $Kb * $Kb;
		$Gb = $Kb * $Kb * $Kb;
		$Tb = $Kb * $Kb * $Kb * $Kb;
		$res = $value;
		if ($value < $Kb) {
			$res = $wgLang->formatNum(sprintf("%0.1f", $value));
		} elseif ($value < $Mb) {
			$res = $wgLang->formatNum(sprintf("%0.1f", $value/$Kb)) . "K";
		} elseif ($value < $Gb) {
			$res = $wgLang->formatNum(sprintf("%0.1f", $value/$Mb)) . "M";
		} else {
			$res = $wgLang->formatNum(sprintf("%0.1f", $value/$Gb)) . "G";
		}
		wfProfileOut( __METHOD__ );
        return $res;
    }

	public function getStatisticsPager($total, $page, $link, $order="", $offset, $only_next=0)
	{
		$lcNEXT = "&nbsp;";
		$lcPREVIOUS = "&nbsp;";
		$lcR_ARROW = "&rArr;";
		$lcL_ARROW = "&lArr;";
		$NUM_NUMBER = 5;
		wfProfileIn( __METHOD__ );

		if ($total<=0 || empty($total)) {
			wfProfileOut( __METHOD__ );
			return "";
		}

		$page_count = ceil($total/$offset);
		if ($only_next == 1) $page_count = $page+1;

        $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $oTmpl->set_vars( array(
            "page_count" 	=> $page_count,
            "only_next"		=> $only_next,
            "page"			=> $page,
            "link"			=> $link,
			"lcNEXT" 		=> $lcNEXT,
			"lcPREVIOUS" 	=> $lcPREVIOUS,
			"lcR_ARROW"		=> $lcR_ARROW,
			"lcL_ARROW" 	=> $lcL_ARROW,
			"NUM_NUMBER" 	=> $NUM_NUMBER,
        ));

        $pager = $oTmpl->execute("stats-pager");
        #---
		wfProfileOut( __METHOD__ );
		return $pager;
	}

	public function getWikiCreationHistory($xls = 0)
	{
		wfProfileIn( __METHOD__ );
		$min_date_articles = $min_date_wikians = MIN_STATS_DATE;
		$arr_wikians = $this->getCreationWikiansList($min_date_wikians);
		$dWikians = $this->generateMonthArray($min_date_wikians);
		#---
		$arr_article = $this->getCreationArticleList($min_date_articles);
		$dArticles = $this->generateMonthArray($min_date_articles);
		wfProfileOut( __METHOD__ );
		return array($arr_wikians, $dWikians, $arr_article, $dArticles);
	}

	public function getWikiCompareColumnsStats($column, $cityKeys = array(), $select = 0)
	{
		wfProfileIn( __METHOD__ );
		$column_str = "";
		$column_str = $this->getStatisticsColumnNames($column);
		if (empty($column_str)) {
			wfProfileOut( __METHOD__ );
			return false;
		}
		#---
		$cityList = $this->getWikiaAllCityList($cityKeys);
		#---
		$cityOrderList = $this->getWikiaOrderStatsList($column_str, $cityKeys);
		#--- split table to get list of id of cities

		$array_sli = array_slice($cityOrderList, $select, STATS_COLUMN_CITY_NBR);
		$splitCityList = array_merge(array(0 => 0) /* all stats */, (is_array($array_sli)) ? $array_sli : array());
		#---
		$nbrCities = count($cityOrderList);
		unset($cityOrderList);
		#---
		$columnCitiesHistory = $this->getColumnStats($column_str, 0, $splitCityList);
		#---
		$columnAllHistory = $this->getColumnStats($column_str, 1, 0);
		$columnHistory = array_merge($columnAllHistory, (is_array($columnCitiesHistory)) ? $columnCitiesHistory : array());
		#---
		unset($columnAllHistory);
		unset($columnCitiesHistory);
		#----
		$columnHistory = $this->serializeColumnStats($columnHistory, $splitCityList);
		$columnRange = $this->getRangeColumns();
		wfProfileOut( __METHOD__ );
		return array($cityList,$nbrCities,$splitCityList,$columnHistory,$columnRange);
	}

	public function getWikiTrendStatisticsXLS($city, $city_keys)
	{
        global $wgUser;
        #---
		wfProfileIn( __METHOD__ );
		$cityList = $this->getWikiaAllCityList($city_keys);
		$cityOrderList = $this->getWikiaOrderStatsList('', $city_keys);
		#--- split table to get list of id of cities
		$array_sli = array_slice($cityOrderList, 0, STATS_TREND_CITY_NBR);
		$cityOrderList = array_merge(array(0 => 0) /* all stats */, (is_array($array_sli)) ? $array_sli : array());

		$res = self::getWikiTrendStatistics($city_keys, STATS_TREND_MONTH);
		$trend_stats = $res[0];
		$month_array = $res[1];
		unset($city_keys);
		unset($res);

		wfProfileOut( __METHOD__ );
		self::makeTrendStatsXLS($city, $trend_stats, $month_array, $cityList, $cityOrderList);
	}

	public function getWikiCompareColumnsStatsXLS($column, $cityKeys = array())
	{
		wfProfileIn( __METHOD__ );
		$columnStats = $this->getWikiCompareColumnsStats($column, $cityKeys);
		if ($columnStats === false) return false;
		list ($cityList,$nbrCities,$splitCityList,$columnHistory,$columnRange) = $columnStats;
		wfProfileOut( __METHOD__ );
		self::makeColumnStatsXLS($column, $cityList,$nbrCities,$splitCityList,$columnHistory,$columnRange);
	}

	/******************
	 *
	 * XLS functions
	 *
	 */

	static private function setWikiMainStatisticsXLS($city_id, $data, $columns, $monthlyStats)
	{
		#---
		$XLSObj = new WikiaStatsXLS();
		$XLSObj->makeMainStats($data, $columns, $monthlyStats, $city_id);
		return;
	}

	static private function makeWikiDistribXLS($city_id, $data)
	{
		#---
		$XLSObj = new WikiaStatsXLS();
		$XLSObj->makeDistribStats($city_id, $data);
		return;
	}

	static private function makeWikiActiveWikiansXLS($city_id, $active, $absent)
	{
		#---
		$XLSObj = new WikiaStatsXLS();
		$XLSObj->makeActiveWikiansStats($city_id, $active, $absent);
		return;
	}

	static private function makeWikiAnonUsersXLS($city_id, $rankUsers)
	{
		#---
		$XLSObj = new WikiaStatsXLS();
		$XLSObj->makeWikiaAnonUsersStats($city_id, $rankUsers);
		return;
	}

	static private function makeWikiArticleSizeXLS($city_id, $articleCount, $articleSize)
	{
		#---
		$XLSObj = new WikiaStatsXLS();
		$XLSObj->makeArticleSizeStats($city_id, $articleCount, $articleSize);
		return;
	}

	static private function makeWikiaDBNamespaceXLS($city_id, $namespaceCount, $nspaces, $allowedNamespace)
	{
		#---
		$XLSObj = new WikiaStatsXLS();
		$XLSObj->makeDBNamespaceStats($city_id, $namespaceCount, $nspaces, $allowedNamespace);
		return;
	}

	static private function makeWikiaPageViewsXLS($city_id, $pageViewsCount, $mSourceMetaSpace, $otherNspaces)
	{
		#---
		$XLSObj = new WikiaStatsXLS();
		$XLSObj->makePageViewsXLS($city_id, $pageViewsCount, $mSourceMetaSpace, $otherNspaces);
		return;
	}

	static private function makeWikiaMostEditPagesXLS($city_id, $sortData, $mSourceMetaSpace)
	{
		#---
		$XLSObj = new WikiaStatsXLS();
		$XLSObj->makeMostEditPagesStats($city_id, $sortData, $mSourceMetaSpace);
		return;
	}

	static private function makeWikiaMostEditOtherNspacesPagesXLS($city_id, $sortData, $mSourceMetaSpace)
	{
		#---
		$XLSObj = new WikiaStatsXLS();
		$XLSObj->makeMostEditOtherNspacesStats($city_id, $sortData, $mSourceMetaSpace);
		return;
	}

	static private function makeTrendStatsXLS($city_id, $trend_stats, $month_array, $cityList, $cityOrderList)
	{
		$XLSObj = new WikiaStatsXLS();
		$XLSObj->makeTrendStats($city_id, $trend_stats, $month_array, $cityList, $cityOrderList);
		return;
	}

	static private function makeCreationStatsXLS($cityList, $arr_wikians, $dWikians, $arr_article, $dArticles)
	{
		$XLSObj = new WikiaStatsXLS();
		$XLSObj->makeCreationStats($cityList, $arr_wikians, $dWikians, $arr_article, $dArticles);
		return;
	}

	static private function makeColumnStatsXLS($column,$cityList,$nbrCities,$splitCityList,$columnHistory,$columnRange)
	{
		$XLSObj = new WikiaStatsXLS();
		$XLSObj->makeColumnStats($column,$cityList,$nbrCities,$splitCityList,$columnHistory,$columnRange);
		return;
	}
};
