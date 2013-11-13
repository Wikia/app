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

if ( (!class_exists('WikiFactory')) && (file_exists($IP."/extensions/wikia/WikiFactory/SpecialWikiFactory_helper.php")) ) {
	require_once ($IP."/extensions/wikia/WikiFactory/SpecialWikiFactory_helper.php");
}

class WikiStats {
    var $mCityId;

    var $mDateRange;
    var $mUpdateDate;
    var $mStatsDate;
    var $mLocalStats;
    var $mMonthDiffs;
    var $mLang;
    var $mHub;
    var $mPageNS;

    var $mExcludedWikis;
    var $mAllStats;
    var $mMonthDiffsStats;
    var $mSkin;
    var $oWikia;

    var $mRange;
    var $mSize = 0;

    const MONTHLY_STATS = 7;
    const USE_MEMC = 0;
    const EVENT_LOG_TYPE = 'stats';
    const PV_LIMIT = 100;
    const PV_DELTA = 180;
    const DEF_LIMIT = 25;

	/**
	 * initialization
	 * @param $cityid
	 */
	function __construct( $mCityId ) {
		$this->mCityId = $mCityId;
		$this->mAllStats = ( $this->mCityId === 0 );

		$this->__load();
	}

	/**
	 * newFromId
	 *
	 * @access public
	 *
	 * @param Integer $cityId
	 */

	public static function newFromId($cityId) {
		return new WikiStats($cityId);
	}

	public static function allowedGroups() { return array('staff', 'sysop', 'janitor', 'bureaucrat'); }

	/**
	 * newFromName
	 *
	 * @access public
	 *
	 * @param String $dbname
	 */
	public function newFromName($dbname) { return new WikiStats(WikiFactory::DBToId($dbname)); }

	public function setLocalStats($value) 	{ $this->mLocalStats = $value; }
	public function setRangeColumns($value)	{ $this->mRange = $value; }
	public function setRangeDate($value) 	{ $this->mDateRange = $value; }
	public function setUpdateDate($value) 	{ $this->mUpdateDate = $value; }
    public function setStatsDate($value)	{ $this->mStatsDate = $value; }
    public function setMonthDiffs($value)	{ $this->mMonthDiffs = $value; }
    public function setHub($value)			{ $this->mHub = $value; }
    public function setLang($value)			{ $this->mLang = $value; }
    public function setPageNS($value)		{ $this->mPageNS = $value; }
    public function setPageNSList($value)	{ $this->mPageNSList = $value; }

	public function getLocalStats() 		{ return $this->mLocalStats; }
    public function getRangeColumns() 		{ return $this->mRange; }
    public function getRangeDate() 			{ return $this->mDateRange; }
    public function getUpdateDate() 		{ return $this->mUpdateDate; }
    public function getStatsDate()			{ return $this->mStatsDate; }
    public function getMonthDiffs()			{ return $this->mMonthDiffs; }
    public function getHub()				{ return $this->mHub; }
    public function getLang()				{ return $this->mLang; }
    public function getPageNS()				{ return $this->mPageNS; }
    public function getPageNSList()			{
		if ( empty($this->mPageNSList) ) {
			global $wgEnableTopListsExt, $wgEnableBlogArticles;
			$this->mPageNSList = array(
				-1001 => array(
					'name' => wfMsg('wikistats_namespaces_talk'),
					'value' => 'page_ns % 2 = 1'
				),
				-1002 => array(
					'name' => wfMsg('wikistats_namespaces_top10list'),
					'value' => ( !empty($wgEnableTopListsExt) ) ? sprintf ('page_ns = %d', NS_TOPLIST) : null,
				),
				-1003 => array(
					'name' => wfMsg('wikistats_namespaces_blog'),
					'value' => ( !empty($wgEnableBlogArticles) ) ? sprintf (' (page_ns = %d or page_ns = %d) ', NS_BLOG_ARTICLE, NS_BLOG_ARTICLE_TALK) : null,
				),
				-1004 => array(
					'name' => wfMsg('wikistats_namespaces_user'),
					'value' => sprintf (' (page_ns = %d or page_ns = %d) ', NS_USER, NS_USER_TALK)
				),
				-1005 => array(
					'name' => wfMsg('wikistats_namespaces_maintenance'),
					'value' => sprintf (' (page_ns = %d or page_ns = %d or page_ns = %d) ', NS_MEDIAWIKI, NS_TEMPLATE, NS_PROJECT)
				)
			);
		}
		return $this->mPageNSList;
	}

	private function getSkin() {
		if ( !isset( $this->mSkin ) ) {
			$this->mSkin = RequestContext::getMain()->getSkin();
		}
		return $this->mSkin;
	}

	public static function isAllowed() {
		global $wgUser;
		$userRights = $wgUser->getEffectiveGroups();
		$allowed = 0;
		foreach ( $userRights as $right ) {
			if ( in_array( $right, WikiStats::allowedGroups() ) ) {
				$allowed = 1;
				break;
			}
		}

		return $allowed;
	}

	private function __load() {
		if ( !isset($this->oWikia) ) {
			$this->__loadWikia();
		}
		if ( !isset($this->mRange) ) {
			$this->__loadRange();
		}
		if ( !isset($this->mDateRange) ) {
			$this->__loadMonths();
		}
		if ( !isset($this->mUpdateDate) ) {
			$this->__loadDate();
		}
		if ( !isset($this->mMonthDiffs) ) {
			$this->__loadMonthDiffs();
		}
	}

	/**
	 * __loadWikia
	 *
	 * @access private
	 *
	 * @param Array range of columns in main table (A..Z)
	 */
    private function __loadWikia() {
    	global $wgLang, $wgContLang;

    	$this->oWikia = WikiFactory::getWikiByID($this->mCityId);
		if ( isset($this->oWikia) && !empty($this->oWikia) ) {
			# created
			$this->oWikia->city_created_txt = "";
			if ( isset($this->oWikia->city_created) ) {
				$city_created = preg_replace("/(\s|\:|\-)/", "", $this->oWikia->city_created);
				$this->oWikia->city_created_txt = $wgLang->timeanddate( $city_created, true );
			}
			# category
			$this->oWikia->category = WikiFactory::getCategory($this->mCityId);
			# language name
			$this->oWikia->languageName = ( isset($this->oWikia->city_lang) )
				? $wgContLang->getLanguageName( $this->oWikia->city_lang )
				: " - ";
			# Wikia title
			$this->oWikia->city_title = ( $this->mCityId > 0 )
				? ucfirst($this->oWikia->city_title)
				: wfMsg( "wikistats_trend_all_wikia_text" );
			# Wikia url
			$this->oWikia->city_url = ( $this->mCityId > 0 )
				? Xml::openElement( 'a', array('target' => 'new', 'href' => $this->oWikia->city_url) ) . $this->oWikia->city_url . Xml::closeElement( 'a' )
				: "";
			# Wikia domain
			$this->oWikia->city_domain = WikiFactory::getVarValueByName( "wgServer", $this->mCityId );
		}
    }

	/**
	 * __loadRange
	 *
	 * @access private
	 *
	 * @param Array range of columns in main table (A..Z)
	 */
    private function __loadRange() {
    	$this->mRange = range(WIKISTATS_RANGE_STATS_MIN, WIKISTATS_RANGE_STATS_MAX);
    }

	/**
	 * __loadMonths
	 *
	 * @access private
	 *
	 * @param Array : months (1 ..12, minYear, maxYear );
	 */
	private function __loadMonths() {
		global $wgStatsDB, $wgMemc, $wgLang, $wgStatsDBEnabled;
		#---
		wfProfileIn( __METHOD__ );
    	#---
    	$monthsArray = array(); for ($i = 0; $i < 12; $i++) {
    		$monthsArray[] = wfMsg( strtolower( date( "F", mktime(23,59,59,$i+1,1,1970) ) ) );
		}
    	#---
    	$memkey = sprintf( "%s_%d_%s", __METHOD__, intval(WIKISTATS_MIN_COUNT_STATS_YEAR), $wgLang->getCode() );
		$this->mDateRange = $wgMemc->get( $memkey );

		if ( empty($this->mDateRange) && !empty( $wgStatsDBEnabled ) ) {
			$this->mDateRange = array("months" => $monthsArray, "minYear" => WIKISTATS_MIN_COUNT_STATS_YEAR, "maxYear" => date('Y'));
			$dbr = wfGetDB(DB_SLAVE, array(), $wgStatsDB);
			#---
			$oRow = $dbr->selectRow(
				'summary_monthly_stats',
				array( 'substr(min(stats_date), 1, 4) as minYear' ),
				array( 'stats_date > ' . intval(WIKISTATS_MIN_COUNT_STATS_YEAR_MONTH) ),
				__METHOD__
			);
			if ( $oRow->minYear ) {
				$this->mDateRange['minYear'] = $oRow->minYear ;
			}
			$wgMemc->set($memkey, $this->mDateRange, 60*30);
			#---
		}
		wfProfileOut( __METHOD__ );
		return $this->mDateRange;
	}

	/**
	 * __loadDate
	 *
	 * @access private
	 *
	 * @param
	 */
	private function __loadDate() {
		global $wgStatsDB, $wgMemc, $wgLang, $wgCityId, $wgStatsDBEnabled;
		#---
		wfProfileIn( __METHOD__ );
    	#---
    	$memkey = sprintf( "%s_%d_%s", __METHOD__, intval($this->mCityId), $wgLang->getCode() );
		$this->mUpdateDate = $wgMemc->get( $memkey );

		#---
		if ( empty($this->mUpdateDate) && !empty( $wgStatsDBEnabled ) ) {
			$dbr = wfGetDB(DB_SLAVE, array(), $wgStatsDB);
			#---
			if ( !empty($this->mCityId) ) {
				$oRow = $dbr->selectRow(
					'wikia_monthly_stats',
					array( 'unix_timestamp(ts) as lastdate' ),
					array( 'wiki_id' => $wgCityId ),
					__METHOD__,
					array('ORDER BY' => 'ts DESC')
				);
			}
			if ( isset($oRow) && isset($oRow->lastdate) ) {
				$this->mUpdateDate = $oRow->lastdate ;
			}

			$this->mUpdateDate = ( isset($this->mUpdateDate) )
				? $wgLang->timeanddate( wfTimestamp( TS_MW, $this->mUpdateDate ), true )
				: "";

			if (self::USE_MEMC) $wgMemc->set($memkey, $this->mUpdateDate, 60*60);
		}

		wfProfileOut( __METHOD__ );

		return $this->mUpdateDate;
	}

	/**
	 * __loadMonthDiffs
	 *
	 * @access private
	 *
	 * @param
	 */
	private function __loadMonthDiffs() {
		$today = date('Y-m');
		$k = 0; for ($i = 0; $i < self::MONTHLY_STATS + 1; $i++) {
			$date = date('Ym', strtotime("-$i months"));
			if ($today == $date) continue;
			$this->mMonthDiffs[$k] = $date;
			$k++;
		}
		krsort($this->mMonthDiffs, SORT_NUMERIC);
		return $this->mMonthDiffs;
	}

	/**
	 * getBasicInformation
	 *
	 * @access public
	 *
	 */
	public function getBasicInformation() {
        global $wgUser, $wgContLang, $wgLang;
		wfProfileIn( __METHOD__ );
		#---
		$res = "";
		if ( empty($this->mAllStats) ) {
			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
			$oTmpl->set_vars( array(
				"today" 		=> date("Y-m"),
				"updateDate"    => $this->mUpdateDate,
				"user"			=> $wgUser,
				"oWikia"		=> $this->oWikia,
				"cityId"		=> $this->mCityId,
				"wgContLang" 	=> $wgContLang,
				"wgLang"		=> $wgLang,
			));
			$res = $oTmpl->render("stats-wikia-info");
		}
        #---
		wfProfileOut( __METHOD__ );
        return $res;
	}

	/**
	 * getAddInformation
	 *
	 * @access public
	 *
	 */
	public function getAddInformation() {
        global $wgUser, $wgContLang, $wgLang;
		wfProfileIn( __METHOD__ );
		#---
		$res = "";
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"user"			=> $wgUser,
			"oWikia"		=> $this->oWikia,
			"cityId"		=> $this->mCityId,
			"wgContLang" 	=> $wgContLang,
			"wgLang"		=> $wgLang,
		));
        #---
		wfProfileOut( __METHOD__ );
        return $res;
	}

	/**
	 * getMainStatistics
	 *
	 * @access public
	 */
	private function getClosedWikis() {
    	global $wgMemc, $wgExternalSharedDB, $wgStatsIgnoreWikis;
    	#---
		wfProfileIn( __METHOD__ );

   		$result = array();
   		$memkey = __METHOD__ . 'v2';
   		$result = $wgMemc->get( $memkey );
    	if (empty($result)) {
			$dbr = wfGetDB(DB_SLAVE, 'stats', $wgExternalSharedDB);
			$where = array(
				'city_public' => 0,
				'city_id > 0'
			);
			if ( !empty($wgStatsIgnoreWikis) ) {
				$where[] = 'city_id not in ('.$dbr->makeList( $wgStatsIgnoreWikis ).')';
			}
			$res = $dbr->select(
				array( 'city_list' ),
				array( 'city_id' ),
				$where,
				__METHOD__
			);
			$result = array(0); while ( $row = $dbr->fetchObject( $res ) ) {
				$result[] = $row->city_id;
			}
			$dbr->freeResult( $res );
			#---
			$wgMemc->set($memkey, $result, 60*60*3);
		}
		wfProfileOut( __METHOD__ );
		return $result;
	}

	/**
	 * getMainStatistics
	 *
	 * @access public
	 */
	public function setWikiMainStatisticsOutput($city_id, $data, $columns, $monthlyStats, $show_local = 0) {
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
        return $oTmpl->render("main-table-stats");
	}

	/**
	 * __loadStatsFromDB
	 *
	 * Main table with statistics
	 * @access public
	 *
	 */
	public function loadStatsFromDB() {
    	global $wgMemc, $wgStatsDB, $wgStatsDBEnabled;
    	#---
		wfProfileIn( __METHOD__ );
		#---
		$result = array();
		#---
		if ( !isset($this->mCityId) || ( $this->mCityId < 0 ) ) {
			wfProfileOut( __METHOD__ );
			Wikia::log( __METHOD__, false, wfMsg('wikistats_nostats_found') );
			return false;
		}

		#---
		if ( !isset($this->mStatsDate) ||
			(
				empty( $this->mStatsDate['fromMonth'] ) ||
				empty( $this->mStatsDate['fromYear'] ) ||
				empty( $this->mStatsDate['toMonth'] ) ||
				empty( $this->mStatsDate['toYear'] )
			)
		) {
			wfProfileOut( __METHOD__ );
			Wikia::log( __METHOD__, false, wfMsg('wikistats_invalid_date') );
			return false;
		}

		$memkey = md5($this->mCityId . implode("-", array_values($this->mStatsDate)) . $this->mLocalStats . $this->mLang . $this->mHub );
    	$memkey = __METHOD__ . "_" . $memkey . '_v2';
    	#---
		$columns = array();
		$this->mMainStats = ( self::USE_MEMC ) ? $wgMemc->get($memkey) : array();
    	if ( empty($this->mMainStats) && !empty( $wgStatsDBEnabled ) ) {
			#--- database instance - DB_SLAVE
			$dbr = wfGetDB(DB_SLAVE, array(), $wgStatsDB);

			$db_fields = array(
				'date' => "stats_date",
				'A'	=> 'users_all',
				'B'	=> 'users_content_ns',
				'C'	=> 'users_5times',
				'D'	=> 'users_100times',
				'E'	=> 'articles',
				'F'	=> 'articles_daily',
				'G' => 'articles_edits',
				'H'	=> 'images_links',
				'I'	=> 'images_uploaded',
				'J' => 'video_links',
				'K' => 'video_uploaded',
			);

			array_walk($db_fields, create_function('&$v,$k', '$v = $v . " as " . $k;'));

			$table = 'summary_monthly_stats';
			$where = array();
			$options = array( 'ORDER BY' => 'stats_date' );
			# set city_id
			if ( !empty( $this->mCityId ) ) {
				$where['wiki_id'] = $this->mCityId;
				$table = 'wikia_monthly_stats';
			} else {
				if ( !empty($this->mHub) && !empty($this->mLang) ) {
					$where['wiki_cat_id'] = $this->mHub;
					$where['wiki_lang_id'] = WikiFactory::LangCodeToId($this->mLang);
					$table = 'cat_lang_monthly_stats';
				} elseif ( !empty($this->mHub) ) {
					$where['wiki_cat_id'] = $this->mHub;
					$table = 'cat_monthly_stats';
				} elseif ( !empty($this->mLang) ) {
					$where['wiki_lang_id'] = WikiFactory::LangCodeToId($this->mLang);
					$table = 'lang_monthly_stats';
				}
			}

			# to new per month
			$toYear = $this->mStatsDate['toYear'];
			$toMonth = $this->mStatsDate['toMonth'];
			$fromYear = $this->mStatsDate['fromYear'];
			$fromMonth = $this->mStatsDate['fromMonth'];
			if ( $fromMonth == 1 ) {
				$fromMonth = 12;
				$fromYear--;
			} else {
				$fromMonth--;
			}

			$startDate = sprintf("%04d%02d", $this->mStatsDate['fromYear'], $this->mStatsDate['fromMonth']);
			$endDate = sprintf("%04d%02d", $this->mStatsDate['toYear'], $this->mStatsDate['toMonth']);
			# set date range
			$where[] = sprintf( " stats_date between '%04d%02d' and '%04d%02d' ", $fromYear, $fromMonth, $toYear, $toMonth );

			$oRes = $dbr->select(
				array( $table ),
				array( implode(", ", array_values( $db_fields ) ) ),
				$where,
				__METHOD__,
				$options
			);
			$this->mMainStats = $stats_tmp = array();
			$prevArticles = null;
			while( $oRow = $dbr->fetchObject( $oRes ) ) {
				if (
					!isset($this->mMainStats[$oRow->date]) &&
					( $startDate <= $oRow->date && $oRow->date <= $endDate )
				) {
					$this->mMainStats[$oRow->date] = array();
				}

				$new_per_day = 0;
				if ( !is_null($prevArticles) ) {
					if ( $oRow->E > $prevArticles ) {
						$year = substr($oRow->date, 0, 4);
						$month = substr($oRow->date, 4, 2);
						$nbr_days = date("t", strtotime($year . "-" . $month . "-01"));
						$new_per_day = ($oRow->E - $prevArticles) / $nbr_days;
					}
				}
				$prevArticles = $oRow->E;
				if ( $startDate <= $oRow->date && $oRow->date <= $endDate ) {
					foreach ( $oRow as $field => $value ) {
						if ( $field == 'F' ) {
							/*$value = intval($new_per_day);
							if ( $value > 0 ) {
								$value = sprintf("%0.1f", $new_per_day);
							}*/
							$year = substr($oRow->date, 0, 4);
							$month = substr($oRow->date, 4, 2);
							$nbr_days = date("t", strtotime($year . "-" . $month . "-01"));
							$value = sprintf("%0.2f", $value/$nbr_days);
						}
						/*$excludedValues = isset( $this->mExcludedWikis[$oRow->date][$field] )
							? intval( $this->mExcludedWikis[$oRow->date][$field] )
							: 0;
						if ( $field == 'date' ) {
							$this->mMainStats[$oRow->date][$field] = $value;
						} else {
							$this->mMainStats[$oRow->date][$field] = $value - $excludedValues;
						}*/
						$this->mMainStats[$oRow->date][$field] = $value;
					}
				}
			}
			$dbr->freeResult( $oRes );

			// Merge in namespace stats
			// Structure of $ns_action
			// $ns_actions[$NAMESPACE][$DATE][$EVENT_TYPE]
			$ns_actions = $this->loadMonthlyNSActions();
			foreach ($this->mMainStats as $date => &$data) {
				// Add in NS 0 (Main) create events
				$ns = '0'; $event = 2;
				$data['L'] = array_key_exists($ns, $ns_actions) &&
				             array_key_exists($date, $ns_actions[$ns]) &&
				             array_key_exists($event, $ns_actions[$ns][$date])
				             ? $ns_actions[$ns][$date][$event] : 0;

				// Add all NS 1 (Talk + Comment) which is NS 3 edits and creates
				$ns = 1; $event = 1;
				$data['M'] = array_key_exists($ns, $ns_actions) &&
				             array_key_exists($date, $ns_actions[$ns]) &&
				             array_key_exists($event, $ns_actions[$ns][$date])
				             ? $ns_actions[$ns][$date][$event] : 0;
				$event = 2;
				$data['M'] += array_key_exists($ns, $ns_actions) &&
				              array_key_exists($date, $ns_actions[$ns]) &&
				              array_key_exists($event, $ns_actions[$ns][$date])
				              ? $ns_actions[$ns][$date][$event] : 0;

				// Add all NS 500 (Blog) create events
				$ns = 500; $event = 2;
				$data['N'] = array_key_exists($ns, $ns_actions) &&
				             array_key_exists($date, $ns_actions[$ns]) &&
				             array_key_exists($event, $ns_actions[$ns][$date])
				             ? $ns_actions[$ns][$date][$event] : 0;

				// Add all NS 501 (Blog Comment) edit events
				$ns = 501;
				$data['O'] = array_key_exists($ns, $ns_actions) &&
				             array_key_exists($date, $ns_actions[$ns]) &&
				             array_key_exists($event, $ns_actions[$ns][$date])
				             ? $ns_actions[$ns][$date][$event] : 0;

				// Add all NS 6 (File) create events
				// NOTE: effective March 2012, NS 6 may include videos in addition to images.
				// We should exclude files in NS 6 with Media Type 4 from the images
				$ns = 6; $event = 2;
				$data['P'] = array_key_exists($ns, $ns_actions) &&
				             array_key_exists($date, $ns_actions[$ns]) &&
				             array_key_exists($event, $ns_actions[$ns][$date])
				             ? $ns_actions[$ns][$date][$event] : 0;

				// Add all NS 400 (Video) create events
				// NOTE: effective March 2012, NS 400 will not be used anymore.
				// Instead, we should count files in NS 6 with Media Type 4 as videos
				$ns = 400;
				$data['Q'] = array_key_exists($ns, $ns_actions) &&
				             array_key_exists($date, $ns_actions[$ns]) &&
				             array_key_exists($event, $ns_actions[$ns][$date])
				             ? $ns_actions[$ns][$date][$event] : 0;

				// Add all NS 2 (User) edit events
				$ns = 2; $event = 1;
				$data['R'] = array_key_exists($ns, $ns_actions) &&
				             array_key_exists($date, $ns_actions[$ns]) &&
				             array_key_exists($event, $ns_actions[$ns][$date])
				             ? $ns_actions[$ns][$date][$event] : 0;

				// Add all NS 3 (User Talk) edit events
				$ns = 3;
				$data['S'] = array_key_exists($ns, $ns_actions) &&
				             array_key_exists($date, $ns_actions[$ns]) &&
				             array_key_exists($event, $ns_actions[$ns][$date])
				             ? $ns_actions[$ns][$date][$event] : 0;
			}


			if ( !empty($this->mMainStats) ) {
				krsort($this->mMainStats);
			}
			$wgMemc->set( $memkey, $this->mMainStats, 60*60 );
		}
		#---
		wfProfileOut( __METHOD__ );
		return $this->mMainStats;
	}

	/**
	 * namespaceStatsFromDB
	 *
	 * Namespace statistics
	 * @access public
	 *
	 */
	public function namespaceStatsFromDB() {
    	global $wgMemc, $wgStatsDB, $wgStatsDBEnabled;
    	#---
		wfProfileIn( __METHOD__ );
		#---
		$result = array();
		#---
		if ( !isset($this->mCityId) || ( $this->mCityId < 0 ) ) {
			wfProfileOut( __METHOD__ );
			Wikia::log( __METHOD__, false, wfMsg('wikistats_nostats_found') );
			return false;
		}

		if ( !isset($this->mPageNSList) ) {
			$this->getPageNSList();
		}

		if ( empty($this->mPageNS) ) {
			wfProfileOut( __METHOD__ );
			Wikia::log( __METHOD__, false, wfMsg('wikistats_nostats_found') );
			return false;
		}
		#---
		if ( !isset($this->mStatsDate) ||
			(
				empty( $this->mStatsDate['fromMonth'] ) ||
				empty( $this->mStatsDate['fromYear'] ) ||
				empty( $this->mStatsDate['toMonth'] ) ||
				empty( $this->mStatsDate['toYear'] )
			)
		) {
			wfProfileOut( __METHOD__ );
			Wikia::log( __METHOD__, false, wfMsg('wikistats_invalid_date') );
			return false;
		}

		$ns_key = @implode("|", $this->mPageNS);
		$memkey = md5($this->mCityId . implode("-", array_values($this->mStatsDate)) . $this->mLocalStats . $this->mLang . $this->mHub . $ns_key );
    	$memkey = __METHOD__ . "_" . $memkey;
    	#---
		$columns = array();
		$result = ( self::USE_MEMC ) ? $wgMemc->get($memkey) : array();
    	if ( empty($result) && !empty( $wgStatsDBEnabled ) ) {
			#--- database instance - DB_SLAVE
			$dbr = wfGetDB(DB_SLAVE, array(), $wgStatsDB);
			$result = array();

			foreach ( $this->mPageNS as $ns ) {
				if ( empty($ns) ) continue;
				$db_fields = array(
					'date' => "stats_date",
					'A'	=> ( $this->mAllStats || $this->mLang || $this->mHub ) ? 'sum(pages_all)' : 'pages_all',
					'B'	=> ( $this->mAllStats || $this->mLang || $this->mHub ) ? 'sum(pages_daily)' : 'pages_daily',
					'C'	=> ( $this->mAllStats || $this->mLang || $this->mHub ) ? 'sum(pages_edits)' : 'pages_edits'
				);

				array_walk($db_fields, create_function('&$v,$k', '$v = $v . " as " . $k;'));

				$where = array();
				$options = array(
					'ORDER BY' => 'stats_date'
				);
				if ( $this->mAllStats || $this->mLang || $this->mHub ) {
					$options['GROUP BY'] = 'stats_date';
				}
				# set city_id
				if ( !empty( $this->mCityId ) ) {
					$where['wiki_id'] = $this->mCityId;
				} else {
					if ( !empty($this->mHub) && !empty($this->mLang) ) {
						$where['wiki_cat_id'] = $this->mHub;
						$where['wiki_lang_id'] = WikiFactory::LangCodeToId($this->mLang);
					} elseif ( !empty($this->mHub) ) {
						$where['wiki_cat_id'] = $this->mHub;
					} elseif ( !empty($this->mLang) ) {
						$where['wiki_lang_id'] = WikiFactory::LangCodeToId($this->mLang);
					}
				}

				# page_ns
				if ( $ns < 0 ) {
					if ( isset( $this->mPageNSList[$ns] ) && isset($this->mPageNSList[$ns]['value']) ) {
						$where[] = $this->mPageNSList[$ns]['value'];
					} else {
						# shouldn't return any values
						$where[] = 'page_ns < 0';
					}
				} else {
					$where['page_ns'] = $ns;
				}

				# to new per month
				$toYear = $this->mStatsDate['toYear'];
				$toMonth = $this->mStatsDate['toMonth'];
				$fromYear = $this->mStatsDate['fromYear'];
				$fromMonth = $this->mStatsDate['fromMonth'];
				if ( $fromMonth == 1 ) {
					$fromMonth = 12;
					$fromYear--;
				} else {
					$fromMonth--;
				}

				$startDate = sprintf("%04d%02d", $this->mStatsDate['fromYear'], $this->mStatsDate['fromMonth']);
				$endDate = sprintf("%04d%02d", $this->mStatsDate['toYear'], $this->mStatsDate['toMonth']);
				# set date range
				$where[] = sprintf( " stats_date between '%04d%02d' and '%04d%02d' ", $fromYear, $fromMonth, $toYear, $toMonth );

				$oRes = $dbr->select(
					array( 'namespace_monthly_stats' ),
					array( implode(", ", array_values( $db_fields ) ) ),
					$where,
					__METHOD__,
					$options
				);
				$prevArticles = null;
				while( $oRow = $dbr->fetchObject( $oRes ) ) {
					if (
						!isset($result[$oRow->date]) &&
						( $startDate <= $oRow->date && $oRow->date <= $endDate )
					) {
						$result[$oRow->date] = array();
					}

					if ( $startDate <= $oRow->date && $oRow->date <= $endDate ) {
						foreach ( $oRow as $field => $value ) {
							if ( $field == 'B' ) {
								$year = substr($oRow->date, 0, 4);
								$month = substr($oRow->date, 4, 2);
								$nbr_days = date("t", strtotime($year . "-" . $month . "-01"));
								$value = sprintf("%0.2f", $value/$nbr_days);
							}
							# init value
							if ( !isset($result[$oRow->date][$field]) ) {
								$result[$oRow->date][$ns][$field] = 0;
							}
							$result[$oRow->date][$ns][$field] += $value;
						}
					}
				}
				$dbr->freeResult( $oRes );
			}

			if ( !empty($result) ) {
				krsort($result);
			}
			$wgMemc->set( $memkey, $result, 60*60 );
		}

		#---
		wfProfileOut( __METHOD__ );
		return $result;
	}

	public function rollupStats($wiki_id, $by_month=null, $by_day=null) {
		global $wgDWStatsDB;

		$data = $dates = $params = array();

		if ( $by_month ) {
			$params = array(
				'range' 	=> range( 0, 12 ),
				'period'	=> 'months',
				'format'	=> 'Y-m-01',
				'period_id'	=> 3
			);
		} else if ( $by_day ) {
			$params = array(
				'range' 	=> range( 0, 30 ),
				'period'	=> 'days',
				'format'	=> 'Y-m-d',
				'period_id'	=> 1
			);
		} else {
			return $data;
		}

		foreach ( $params['range'] as $num ) {
			$dates[] = date( $params['format'], strtotime("-{$num} {$params['period']}") );
		}

		if ( !empty( $wgDWStatsDB ) ) {
			$dbr = wfGetDB(DB_SLAVE, array(), $wgDWStatsDB);

			foreach ( $dates as $date ) {
				$ts_date = sprintf( "%s 00:00:00", $date );
				$oRes = $dbr->select(
					array( 'statsdb_mart.rollup_wiki_namespace_user_events' ),
					array(
						'wiki_id',
						'namespace_id AS page_ns',
						'SUM(creates) AS stats_2',
						'SUM(edits) AS stats_1',
						'SUM(deletes) AS stats_3',
						'SUM(undeletes) AS stats_4'
					),
					array(
						'wiki_id'	=> $wiki_id,
						'period_id' => $params['period_id'],
						'time_id' 	=> $ts_date
					),
					__METHOD__
				);

				if ( $oRow = $dbr->fetchObject( $oRes ) ) {
					foreach ( range( 1, 4 ) as $id ) {
						$key = 'stats_' . $id;
						$data[ $date ][ $oRow->page_ns ][ $id ] = $oRow->$key;
					}
				}
			}
		}

		return $data;
	}

	/**
	 * loadMonthlyDiffs
	 *
	 * generate montly differences for the last 6 months
	 * @access public
	 *
	 */
	private function excludedWikis($db_fields, $where) {
		global $wgMemc, $wgStatsDB, $wgStatsDBEnabled;

		wfProfileIn( __METHOD__ );
    	$memkey = __METHOD__ . "_" . $this->mCityId . '_v2';
    	#---
		$this->mExcludedWikis = $wgMemc->get($memkey);
		if ( empty($this->mExcludedWikis) && !empty( $wgStatsDBEnabled ) ) {
			$dbr = wfGetDB(DB_SLAVE, array(), $wgStatsDB);
			$where[] = "wikia_id in (" . $dbr->makeList( $this->getClosedWikis() ) . ")";
			$options = array('GROUP BY' => 'stats_date');

			$oRes = $dbr->select(
				array( "wikia_monthly_stats" ),
				array( implode(", ", array_values( $db_fields ) ) ),
				$where,
				__METHOD__,
				$options
			);
			$this->mExcludedWikis = array();
			while( $oRow = $dbr->fetchObject( $oRes ) ) {
				if ( !isset($this->mMainStats[$oRow->date]) ) {
					$this->mExcludedWikis[$oRow->date] = array();
				}
				foreach ( $oRow as $field => $value ) {
					$this->mExcludedWikis[$oRow->date][$field] = $value;
				}
			}
			$dbr->freeResult( $oRes );
			$wgMemc->set( $memkey, $this->mExcludedWikis, 60*60*3 );
		}
		wfProfileOut( __METHOD__ );
	}

	/**
	 * loadMonthlyDiffs
	 *
	 * generate montly differences for the last 6 months
	 * @access public
	 *
	 */
	public function loadMonthlyDiffs() {
		global $wgLang;

		wfProfileIn( __METHOD__ );

		// Get a list of all months that exist for these stats
		$months = array_keys($this->mMainStats);
		sort($months);
		if (empty($months)) {
			wfProfileOut( __METHOD__ );
			return $months;
		}

		// Get the column names used, eliminate the 'date' field.
		$columns = array_keys($this->mMainStats[$months[0]]);
		array_splice($columns, array_search('date', $columns), 1);

		$this->mMonthDiffsStats = array();

		// Create a range of monthly dates and iterate through them
		$prev_month = "";
		foreach ($this->makeMonthRange($months[0], end($months)) as $cur_month) {
			// The first month has nothing previous to diff against
			if (empty($prev_month)) {
				$prev_month = $cur_month;
				continue;
			}

			// Get data for the current month
			if (array_key_exists($cur_month, $this->mMainStats)) {
				$cur_record = $this->mMainStats[$cur_month];
			} else {
				$cur_record = array();
			}

			// Get data for the previous month
			if (array_key_exists($prev_month, $this->mMainStats)) {
				$prev_record = $this->mMainStats[$prev_month];
			} else {
				$prev_record = array();
			}

			// Iterate through tbe column names for this data
			foreach ($columns as $col) {
				// Get the current value or zero if its not defined
				$cur_val = 0;
				if (array_key_exists($col, $cur_record) && !empty($cur_record[$col])) {
					$cur_val = $cur_record[$col];
				}

				// Get the previous value or zero if its not defined
				$prev_val = 0;
				if (array_key_exists($col, $prev_record) && !empty($prev_record[$col])) {
					$prev_val = $prev_record[$col];
				}

				$change = 0;
				if ($prev_val != 0) {
					$change = $wgLang->formatNum(sprintf("%0.2f", (($cur_val - $prev_val)/$prev_val)*100));
				}

				$this->mMonthDiffsStats[$cur_month]['date'] = $cur_month;
				$this->mMonthDiffsStats[$cur_month][$col] = $change;
			}

			$prev_month = $cur_month;
		}

		krsort($this->mMonthDiffsStats);
		wfProfileOut( __METHOD__ );

		return $this->mMonthDiffsStats;
	}

	/**
	 * loadMonthlyNSActions
	 *
	 * Load the monthly totals for creates, edits and deletes in all namespaces
	 *
	 */

	public function loadMonthlyNSActions() {
		global $wgDWStatsDB;

		// The existing index requires a city ID, so don't try anything without it
		if (!$this->mCityId) return array();

		$startDate = sprintf( "%04d-%02d-01", $this->mStatsDate['fromYear'], $this->mStatsDate['fromMonth'] );
		if ( $this->mStatsDate['toMonth'] == 12 ) {
			$this->mStatsDate['toMonth'] = 1;
			$this->mStatsDate['toYear']++;
		}
		$endDate = sprintf( "%04d-%02d-01", $this->mStatsDate['toYear'], $this->mStatsDate['toMonth'] );
		$date = $startDate;

		$dates = array();
		while (strtotime($date) <= strtotime($endDate)) {
			$dates[] = $date;
			$date = date ("Y-m-d", strtotime("+1 month", strtotime($date)));
		}

		$ns_actions = array();
		if ( !empty( $wgDWStatsDB ) ) {
			$dbr = wfGetDB(DB_SLAVE, array(), $wgDWStatsDB);

			$base_where = array( 'period_id' => 3 );
			if ( $this->mCityId ) {
				$base_where[] = array( 'wiki_id' => $this->mCityId );
			}

			foreach ( $dates as $date ) {
				$ts_date = sprintf( "%s 00:00:00", $date );
				$oRes = $dbr->select(
					array( 'statsdb_mart.rollup_wiki_namespace_user_events' ),
					array(
						'wiki_id',
						'time_id as date',
						'namespace_id as page_ns',
						'SUM(creates) AS event_2',
						'SUM(edits) AS event_1',
						'SUM(deletes) AS event_3',
						'SUM(undeletes) AS event_4'
					),
					array(
						'wiki_id' => $this->mCityId,
						'period_id' => 3,
						'time_id' => $ts_date
					),
					__METHOD__,
					array(
						'GROUP BY' => 'wiki_id, namespace_id'
					)
				);

				while( $oRow = $dbr->fetchObject( $oRes ) ) {
					// Initialize this namespace to an empty array if neccessary
					if (!array_key_exists($oRow->page_ns, $ns_actions)) $ns_actions[$oRow->page_ns] = array();
					$for_ns = &$ns_actions[$oRow->page_ns];

					// Initialize this month to an empty array if neccessary
					if (!array_key_exists($oRow->date, $for_ns)) $for_ns[$oRow->date] = array();
					$for_month = &$for_ns[$oRow->date];

					foreach ( range( 1, 4 ) as $id ) {
						$key = 'event_' . $id;
						$for_month[$id] = $oRow->$key;
					}
				}
			}
		}

		return $ns_actions;
	}

	/**
	 * makeMonthRange
	 *
	 * Create an array of sequential months from $start to $end.  Assumes months
	 * are in the format YYYYMM
	 *
	 */

	public function makeMonthRange ($start, $end) {
		// Verify the args to help prevent an infinite loop below
		if (!preg_match('/^\d{6}$/', $start)) return;
		if (!preg_match('/^\d{6}$/', $end))   return;

		$range = array($start);
		$cur_date = $start;

		while ($cur_date != $end) {
			preg_match('/(\d{4})(\d{2})/', $cur_date, $matches);
			if ($matches[2] == 12) {
				$matches[1]++;
				$matches[2] = '01';
				$cur_date = $matches[1].$matches[2];
			} else {
				$cur_date = $cur_date + 1;
			}

			$range[] = $cur_date;
		}

		return $range;
	}

	/**
	 * dateFormat
	 *
	 * show correct date format
	 * @access public
	 *
	 */
	public function dateFormat($showYear = 1) {
		global $wgUser;
		wfProfileIn( __METHOD__ );
		$return = $dateFormat = $wgUser->getDatePreference();
		switch ($dateFormat) {
			case "mdy" 		: $return = ( !empty($showYear) ) ? "M j, Y" : "M j"; break;
			case "dmy" 		: $return = ( !empty($showYear) ) ? "j M Y" : "j M"; break;
			case "ymd" 		: $return = ( !empty($showYear) ) ? "Y M j" : "M j"; break;
			case "ISO 8601" : $return = ( !empty($showYear) ) ? "xnY-xnM-xnd" : "xnM-xnd"; break;
			default 		: $return = ( !empty($showYear) ) ? "M j, Y" : "M j"; break;
		}
		wfProfileOut( __METHOD__ );
		return $return;
	}

	/*
	 * numberFormat
	 *
	 * @access public
	 *
	 */
	public function numberFormat($number, $format = '%0.1f', $type = 'number') {
		global $wgLang;
		wfProfileIn( __METHOD__ );
		$div = 0;
		switch ( $type ) {
			case 'number' : $div = 1000; $values = array("","K","M","G","T","P"); break;
			case 'bytes'  :	$div = 1024; $values = array("B","KB","MB","GB","TB","PB"); break;
			case 'percent': $div = 0; $values = array("%"); break;
		}
		$c = 0;
		if ( $div > 0 ) {
			while ( $number >= $div) {
				$c++; $number = $number/$div;
			}
		}
		wfProfileOut( __METHOD__ );
    	return sprintf("%s%s", $wgLang->formatNum(sprintf($format, $number)), $values[$c]);
	}

	/*
	 * diffFormat
	 *
	 * @access public
	 *
	 */
	public function diffFormat($number) {
		wfProfileIn( __METHOD__ );
		$num = sprintf("%d%%", $number);

		# Set colors for (x > 75), (75 > x > 25), (25 > x > 0) and (x < 0)
		$color = ($num > 75) ? "0000FF"
							 : (($num > 25) ? "008000"
											: (($num > 0) ? "555555" : "800000"));
		$out = "<span style='color:#$color'>$num</span>";

		wfProfileOut( __METHOD__ );
		return $out;
	}

	/*
	 * getWikiansActivity
	 *
	 * @access public
	 *
	 */
	public function getWikiansActivity($content = 1, $anons = 0, $date = '', $limit = WIKISTATS_WIKIANS_RANK_NBR, $users = array()) {
		global $wgMemc, $wgStatsDB, $wgStatsDBEnabled;
		wfProfileIn( __METHOD__ );
		#---
		$memkey = sprintf( "%s_%s", __METHOD__, md5($this->mCityId . $date . $content . $anons . $limit) );
		#---
		$result = array();
		if (self::USE_MEMC) $result = $wgMemc->get($memkey);

		if ( empty($result) && !empty( $wgStatsDBEnabled ) ) {
			if ( !empty($this->mCityId) ) {
				$dbs = wfGetDB(DB_SLAVE, array(), $wgStatsDB);

				# conditions
				$where = array( 'wiki_id' => $this->mCityId );
				if ( !empty($anons) ) {
					$where['user_id'] = 0;
				} else {
					$where[] = 'user_id > 0';
				}

				if ( !empty($content) ) {
					$where['is_content'] = 'Y';
				} else {
					$where['is_content'] = 'N';
				}

				if ( !empty($date) ) {
					$where[] = "rev_timestamp < '".$date."'";
				}

				if ( !empty($users) ) {
					$where[] = " user_id in ( " . $dbs->makeList($users) . " ) ";
				}

				$where[] = " ( event_type = 1 or event_type = 2) ";

				if ( empty($anons) ) {
					$oRes = $dbs->select(
						array( 'events' ),
						array( 'user_id', 'count(user_id) as cnt', 'min(rev_timestamp) as min_date', 'max(rev_timestamp) as max_date' ),
						$where,
						__METHOD__,
						array(
							'GROUP BY'	=> 'user_id',
							'ORDER BY'	=> 'cnt DESC',
							'LIMIT'		=> $limit
						)
					);
				} else {
					$oRes = $dbs->select(
						array( 'events' ),
						array( 'ip', 'count(ip) as cnt', 'min(rev_timestamp) as min_date', 'max(rev_timestamp) as max_date' ),
						$where,
						__METHOD__,
						array(
							'GROUP BY'	=> 'ip',
							'ORDER BY'	=> 'cnt DESC',
							'LIMIT'		=> $limit
						)
					);
				}

				$result = array(); $rank = 1;
				while ( $oRow = $dbs->fetchObject( $oRes ) ) {
					$ip = ( isset($oRow->ip) ) ? long2ip($oRow->ip) : '';
					$host = ( isset($oRow->ip) ) ? gethostbyaddr($ip) : '';
					$result[ ( empty($anons) ) ? $oRow->user_id : $oRow->ip ] = array(
						'min'		=> strtotime( $oRow->min_date ),
						'max' 		=> strtotime( $oRow->max_date ),
						'cnt'		=> intval( $oRow->cnt ),
						'rank'		=> $rank,
						'user_id'	=> ( empty($anons) ) ? intval( $oRow->user_id ) : 0,
						'user_ip'	=> $ip,
						'user_host' => $host
					);
					$rank++;
				}
				$dbs->freeResult( $oRes );

				if (self::USE_MEMC) $wgMemc->set($memkey, $result, 60*60*5);
			}
		}

		wfProfileOut( __METHOD__ );
		#---
		return $result;
	}

	/*
	 * userBreakdown
	 *
	 * @access public
	 *
	 * editors/anons activity breakdown
	 */
	public function userBreakdown($month = 0, $limit = WIKISTATS_WIKIANS_RANK_NBR, $anons = 0) {
		global $wgRequest, $wgOut, $wgUser, $wgLang;

		wfProfileIn( __METHOD__ );

		#$data = array("code" => 0, "text" => "");
		$data = "";
		#---
		$usersRank = $this->getWikiansActivity(1, $anons, '', $limit);
		#---
		$userIDs = $usersRankNotContentNs = array();
		if (!empty($usersRank)) {
			$userIDs = array_keys( $usersRank );
		}

		#---
		if (!empty($userIDs)) {
			$usersRankNotContentNs = $this->getWikiansActivity(0, $anons, '', $limit, $userIDs);
		}

		#--- previous ranking
		$stamp = date( "Y-m-d H:i:s", mktime(0,0,0,date("m")- (1 + $month),1,date("Y")) );
		$usersPrevRank = $this->getWikiansActivity(1, $anons, $stamp, $limit);

		$userIDs = $usersPrevRankNotContentNs = array();
		if ( !empty($usersPrevRank) ) {
			$userIDs = array_keys( $usersPrevRank );
		}

		if ( !empty($userIDs) ) {
			$usersPrevRankNotContentNs = $this->getWikiansActivity(0, $anons, $stamp, $limit, $userIDs);
		}

		$wikians_active = $wikians_absent = array();
		if (!empty($usersRank)) {
			foreach ($usersRank as $user_id => $rankInfo) {
				if ( !is_array($rankInfo) ) continue;

				$time_diff = time() - $rankInfo["max"];
				if ( $time_diff >= $month * WIKISTATS_ABSENT_TIME ) {
					$wikians_absent[ $rankInfo["rank"] ] = array(
						'user_id' 			=> $rankInfo["user_id"],
						'user_ip'			=> $rankInfo["user_ip"],
						'user_host'			=> $rankInfo["user_host"],
						'total' 			=> $rankInfo["cnt"],
						'first_edit' 		=> $rankInfo["min"],
						'first_edit_ago' 	=> sprintf("%0.0f", (time() - $rankInfo["min"])/(60*60*24)),
						'last_edit' 		=> $rankInfo["max"],
						'last_edit_ago' 	=> sprintf("%0.0f", (time() - $rankInfo["max"])/(60*60*24)),
					);
				} else {
					if ( array_key_exists($user_id, $usersPrevRank) ) {
						$rank = intval( $usersPrevRank[$user_id]["rank"] );
					} else {
						$rank = WIKISTATS_WIKIANS_RANK_NBR;
					}

					if ( array_key_exists($user_id, $usersRankNotContentNs) ) {
						$cnt_ns = $usersRankNotContentNs[$user_id]["cnt"];
					} else {
						$cnt_ns = 0;
					}

					if ( array_key_exists($user_id, $usersPrevRankNotContentNs) && isset($usersPrevRankNotContentNs[$user_id]["cnt"]) ) {
						$prev_cnt_ns = intval( $usersPrevRankNotContentNs[$user_id]["cnt"] );
					} else {
						$prev_cnt_ns = intval( $cnt_ns );
					}

					if ( array_key_exists($user_id, $usersPrevRank) ) {
					    $cnt = intval( $usersPrevRank[$user_id]["cnt"] );
					} else {
						$cnt = intval( $rankInfo["cnt"] );
					}

					$wikians_active[ $rankInfo["rank"] ] = array(
						'user_id' 			=> $rankInfo["user_id"],
						'user_ip'			=> $rankInfo["user_ip"],
						'user_host'			=> $rankInfo["user_host"],
						'prev_rank' 		=> $rank,
						'rank_change' 		=> $rank - intval($rankInfo["rank"]),
						'total' 			=> intval($rankInfo["cnt"]),
						'total_other' 		=> intval($cnt_ns),
						'edits_last' 		=> (intval($rankInfo["cnt"]) - $cnt),
						'edits_other_last' 	=> (intval($cnt_ns) - intval($prev_cnt_ns)),
						'first_edit' 		=> $rankInfo["min"],
						'first_edit_ago' 	=> sprintf("%0.0f", (time() - $rankInfo["min"])/(60*60*24)),
						'last_edit' 		=> $rankInfo["max"],
						'last_edit_ago' 	=> sprintf("%0.0f", (time() - $rankInfo["max"])/(60*60*24)),
					);
				}
			}

			#---
			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
			$oTmpl->set_vars( array(
				"wkActive" 		=> $wikians_active,
				"wkAbsent"		=> $wikians_absent,
				"cur_month"		=> $month,
				"wgLang"		=> $wgLang,
				"city_url"		=> $this->oWikia->city_domain,
				"oStats"		=> $this,
				"anons"			=> $anons
			));
			#---
			$active = $oTmpl->render("wikians-active-stats");
			$absent = $oTmpl->render("wikians-absent-stats");

			$data = $active . $absent;
			#$data = array("code" => 1, "text" => $text);
		}

		#---
		wfProfileOut( __METHOD__ );
		return $data;
	}

	public function getLatestStats() {
		global $wgStatsDB, $wgStatsDBEnabled;

		wfProfileIn( __METHOD__ );
		$date = time();
		if ( !empty( $wgStatsDBEnabled ) ) {
			$dbr = wfGetDB(DB_SLAVE, array(), $wgStatsDB);
			#---
			$oRow = $dbr->selectRow(
				'wikia_monthly_stats',
				array( 'unix_timestamp(ts) as lastdate' ),
				array(
					'wiki_id' => $this->mCityId,
					'stats_date' => date('Ym')
				),
				__METHOD__
			);
			if ( isset($oRow) && isset($oRow->lastdate) ) {
				$date = $oRow->lastdate;
			} else {
				$date = time();
			}
		}
		wfProfileOut( __METHOD__ );
		#---
		return $date;
	}

	public function getLatestNSStats() {
		global $wgStatsDB, $wgStatsDBEnabled;

		$date = time();
		if ( !empty( $wgStatsDBEnabled ) ) {
			$dbr = wfGetDB(DB_SLAVE, array(), $wgStatsDB);
			#---
			$oRow = $dbr->selectRow(
				'namespace_monthly_stats',
				array( 'unix_timestamp(ts) as lastdate' ),
				array(
					'wiki_id' => $this->mCityId,
					'stats_date' => date('Ym')
				),
				__METHOD__
			);
			if ( isset($oRow) && isset($oRow->lastdate) ) {
				$date = $oRow->lastdate;
			} else {
				$date = time();
			}
		}

		return $date;
	}

	/*
	 * Wikis activity (per language, category and date)
	 *
	 * @access public
	 *
	 * list of Wikis activity for language, category and date
	 */
	public function getWikiActivity( $params = array(), $xls = 0 ) {
		global $wgLang, $wgStatsDB, $wgUser, $wgMemc, $wgStatsDBEnabled;
		wfProfileIn( __METHOD__ );

		if ( empty($params) ) {
			wfProfileOut( __METHOD__ ) ;
			return false;
		}

		if ( empty( $wgStatsDBEnabled ) ) {
			wfProfileOut( __METHOD__ ) ;
			return false;
		}

		# only for special users
		if ( !WikiStats::isAllowed() ) {
			Wikia::log( __METHOD__, false, "unauthorized user: " . $wgUser->getName() . " tried to retrieve data");
			wfProfileOut( __METHOD__ ) ;
			return false;
		}

		$data = array('cnt' => 0, 'res' => null);

		$year  = ( isset( $params['year']  )  ) ? intval($params['year'])  : date('Y');
		$month = ( isset( $params['month'] )  ) ? intval($params['month']) : date('m');
		$lang  = ( isset( $params['lang']  )  ) ? $params['lang']  : '';
		$cat   = ( isset( $params['cat']   )  ) ? $params['cat'] : '';
		$order = ( isset( $params['order'] )  ) ? $params['order'] : '';
		$limit = ( isset( $params['limit'] )  ) ? intval($params['limit']) : self::DEF_LIMIT;
		$offset =( isset( $params['offset'])  ) ? intval($params['offset']) : 0;
		$summary=( isset( $params['summary']) ) ? intval($params['summary']) : 0;

		$lang_id = WikiFactory::LangCodeToId($lang);

		if ( empty($lang_id) ) {
			Wikia::log( __METHOD__, false, "invalid language code: $lang");
			wfProfileOut( __METHOD__ ) ;
			return false;
		}

		$dbr = wfGetDB( DB_SLAVE, 'stats', $wgStatsDB );

		# order
		$orderOptions = array(
			'id'		=> 'wiki_id',
			'dbname'	=> 'city_dbname',
			'title'		=> 'city_title',
			'url'		=> 'city_url',
			'users'		=> 'users_all',
			'edits'		=> 'articles_edits',
			'articles'	=> 'articles',
			'lastedit' 	=> 'city_last_timestamp'
		);
		$sql_order = 'null';
		if ( !empty($order) ) {
			$options = array();
			$tmp = explode('|', $order);
			if ( !empty($tmp) ) {
				foreach ( $tmp as $inx ) {
					@list ( $val, $desc ) = explode(':', $inx);
					$options[] = $orderOptions[$val] . " " . $desc;
				}
			}

			if ( !empty($options) ) {
				$sql_order = implode(',', $options);
			}
		}

		# tables
		if ( $summary ) {
			$tables = array( 'lang_monthly_stats' ) ;
		} else {
			$tables = array(
				'wikia_monthly_stats',
				'wikicities.city_list AS cl',
				'wikicities.city_cat_mapping AS ccm'
			);
		}

		#conditions
		$conditions = $join = array();
		if ( $summary ) {
			$conditions = array(
				'stats_date' => sprintf("%04d%02d", $year, $month),
				'wiki_lang_id' => $lang_id
			);
		} else {
			$conditions = array(
				'stats_date' => sprintf("%04d%02d", $year, $month),
				'city_public' => 1
			);

			if ( !empty($lang) ) {
				$conditions['cl.city_lang'] = $lang;
			}

			if ( !empty($cat) ) {
				$conditions['ccm.cat_id'] = $cat;
			}
			# join
			$join = array(
				'wikicities.city_list AS cl' => array(
					'JOIN',
					'cl.city_id = wiki_id'
				),
				'wikicities.city_cat_mapping AS ccm' => array(
					'JOIN',
					'ccm.city_id = wiki_id'
				),
			);
		}

    	$memkey = sprintf( "count_%s_%s_%s_%d", __METHOD__, implode('_', array_keys($conditions)), implode('_', array_values($conditions)), $xls );
		$data['cnt'] = $wgMemc->get( $memkey );

		/* number of records */
		if ( $summary ) {
			$data['cnt'] = 1;
		} else {
			if ( empty($data['cnt']) ) {
				$oRow = $dbr->selectRow(
					$tables,
					array ( 'count(0) as cnt' ),
					$conditions,
					__METHOD__,
					'',
					$join
				);

				if ( is_object($oRow) ) {
					$data['cnt'] = $oRow->cnt;
				}
				$wgMemc->set($memkey, $data['cnt'], 60 * 60 * 3);
			}
		}

		if ( $data['cnt'] > 0 ) {

			$memkey = sprintf( "acdata_%s_%s_%d", __METHOD__, $year.'_'.$month.'_'.$lang.'_'.$cat.'_'.$order.'_'.$limit.'_'.$offset.'_'.$wgLang->getCode().'_'.$summary, $xls );

			$data['res'] = $wgMemc->get( $memkey );

			if ( empty($data['res']) ) {
				$data['res'] = array();

				# order & limit
				$order = $xls == 1 ? array() : array(
					'ORDER BY'  => $sql_order,
					'LIMIT' 	=> $limit,
					'OFFSET'	=> $offset
				);

				if ( $summary ) {
					$oRes = $dbr->select (
						$tables,
						array(
							'0 as city_id',
							'\'\' as city_dbname',
							'\'\' as city_title',
							'\'\' as city_url',
							'users_all' ,
							'articles',
							'articles_edits',
							'ts'
						),
						$conditions,
						__METHOD__
					);

				} else {

					$oRes = $dbr->select (
						$tables,
						array(
							'cl.city_id',
							'city_dbname',
							'city_title',
							'city_url',
							'users_all',
							'articles',
							'articles_edits',
							'city_last_timestamp as ts'
						),
						$conditions,
						__METHOD__,
						$order,
						$join
					);

				}

				while ( $oRow = $dbr->fetchObject( $oRes ) ) {
					$data['res'][( $summary ) ? 0 : $oRow->city_id] = array(
						($summary) ? 0 : $oRow->city_id,
						($summary) ? wfMsg('wikistats_summary_data') : $oRow->city_dbname,
						($summary) ? wfMsg('wikistats_summary_data') : $oRow->city_title,
						($summary) ? wfMsg('wikistats_summary_data') : $oRow->city_url,
						$oRow->users_all,
						$oRow->articles_edits,
						$oRow->articles,
						($summary) ? '' : $wgLang->timeanddate( $oRow->ts ),
						0, # prev # users
						0, # prev # edits
						0  # prev # articles
					);
				}
				$dbr->freeResult( $oRes );

				if ( !empty($data['res']) && $xls == 0 ) {
					$prev_year = $year;
					$prev_month = $month - 1;
					if ( $prev_month == 0 ) {
						$prev_month = 12; $prev_year--;
					}

					if ( $summary ) {
						$conditions['stats_date'] = sprintf("%04d%02d", $prev_year, $prev_month);
						$oRes = $dbr->select (
							$tables,
							array(
								'0 as wiki_id',
								'users_all',
								'articles',
								'articles_edits'
							),
							$conditions,
							__METHOD__
						);
					} else {
						$where = array(
							'stats_date' => sprintf("%04d%02d", $prev_year, $prev_month),
							'wiki_id'	 => array_keys($data['res'])
						);

						$oRes = $dbr->select (
							array( 'wikia_monthly_stats' ),
							array(
								'wiki_id',
								'users_all',
								'articles',
								'articles_edits'
							),
							$where,
							__METHOD__
						);
					}

					while ( $oRow = $dbr->fetchObject( $oRes ) ) {
						$data['res'][$oRow->wiki_id][8]  = ($oRow->users_all > $data['res'][$oRow->wiki_id][4]) ? 1 :
														   (($oRow->users_all < $data['res'][$oRow->wiki_id][4]) ? -1 : 0);
						$data['res'][$oRow->wiki_id][9]  = ($oRow->articles_edits > $data['res'][$oRow->wiki_id][5]) ? 1 :
														   (($oRow->articles_edits < $data['res'][$oRow->wiki_id][5]) ? -1 : 0);
						$data['res'][$oRow->wiki_id][10] = ($oRow->articles > $data['res'][$oRow->wiki_id][6]) ? 1 :
														   (($oRow->articles < $data['res'][$oRow->wiki_id][6]) ? -1 : 0);
					}
					$dbr->freeResult( $oRes );
				}

				$wgMemc->set($memkey, $data['res'], 60 * 60 * 3);
			}
		}

		wfProfileOut( __METHOD__ );
		return $data;
	}

};
