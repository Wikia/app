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
    
    var $mExcludedWikis;
    var $mAllStats;
    var $mMonthDiffsStats;
    var $mSkin;
    var $oWikia;

    var $mRange;
    var $mSize = 0;

    const MONTHLY_STATS = 7;
    const USE_MEMC = 0;
	const IGNORE_WIKIS = "5, 11, 6745";
	
	// show only local statistics for wikia
	var $localStats = false;

	/**
	 * initialization
	 * @param $cityid
	 */
	function __construct( $mCityId ) {
		wfLoadExtensionMessages("WikiStats");
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

	public function getLocalStats() 		{ return $this->localStats; }
    public function getRangeColumns() 		{ return $this->mRange; }
    public function getRangeDate() 			{ return $this->mDateRange; }
    public function getUpdateDate() 		{ return $this->mUpdateDate; }
    public function getStatsDate()			{ return $this->mStatsDate; }
    public function getMonthDiffs()			{ return $this->mMonthDiffs; }
    public function getHub()				{ return $this->mHub; }
    public function getLang()				{ return $this->mLang; }

	private function getSkin() {
		if ( !isset( $this->mSkin ) ) {
			global $wgUser;
			$this->mSkin = $wgUser->getSkin();
		}
		return $this->mSkin;
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
			if ( isset($cityInfo->city_created) ) {
				$city_created = preg_replace("/(\s|\:|\-)/", "", $cityInfo->city_created);
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
		global $wgStatsDB, $wgMemc;
		#---
		wfProfileIn( __METHOD__ );
    	#---
    	$monthsArray = array(); for ($i = 0; $i < 12; $i++) {
    		$monthsArray[] = wfMsg( strtolower( date( "F", mktime(23,59,59,$i+1,1,1970) ) ) );
		}
    	#---
    	$memkey = sprintf( "%s_%d", __METHOD__, intval(WIKISTATS_MIN_COUNT_STATS_YEAR) );
		$this->mDateRange = $wgMemc->get( $memkey );

		if ( empty($this->mDateRange) ) {
			$this->mDateRange = array("months" => $monthsArray, "minYear" => WIKISTATS_MIN_COUNT_STATS_YEAR, "maxYear" => date('Y'));
			$dbr = wfGetDB(DB_SLAVE, array(), $wgStatsDB);
			#---
			$oRow = $dbr->selectRow( 
				'stats_summary_part',
				array( 'substr(min(stats_date), 1, 4) as minYear' ),
				array( 'stats_date > ' . intval(WIKISTATS_MIN_COUNT_STATS_YEAR), 'wikia_id > 0' ), 
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
		global $wgStatsDB, $wgMemc, $wgLang;
		#---
		wfProfileIn( __METHOD__ );
    	#---
    	$memkey = sprintf( "%s_%d", __METHOD__, intval($this->mCityId) );
		$this->mUpdateDate = $wgMemc->get( $memkey );

		#---
		if ( empty($this->mUpdateDate) ) {
			$dbr =& wfGetDB(DB_SLAVE, array(), $wgStatsDB);
			#---
			if ( !empty($this->mCityId) ) {
				$oRow = $dbr->selectRow( 
					"stats_summary_part",
					array( "max(unix_timestamp(ts)) as date" ),
					array( "wikia_id" => $this->mCityId ), 
					__METHOD__
				);
				if ( $oRow->date ) {
					$this->mUpdateDate = $oRow->date ;
				}
			} else {
				$oRow = $dbr->selectRow( 
					"stats_summary_part",
					array( "min(unix_timestamp(ts)) as date" ),
					array( "ts >= date_format(now(), '%Y-%m-%d') " ), 
					__METHOD__
				);
				if ( $oRow->date ) {
					$this->mUpdateDate = $oRow->date ;
				}
			}
			
			$this->mUpdateDate = ( isset($this->mUpdateDate) ) 
				? $wgLang->timeanddate( wfTimestamp( TS_MW, $this->mUpdateDate ), true ) 
				: "";
			
			if (self::USE_MEMC) $wgMemc->set($memkey, $this->mUpdateDate, 60*60);
		}

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
		$today = date("Y-m");
		$k = 0; for ($i = 0; $i < self::MONTHLY_STATS + 1; $i++) {
			$date = date("Ym", strtotime("-$i months"));
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
			$res = $oTmpl->execute("stats-wikia-info");
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
   		$memkey = __METHOD__;
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
        return $oTmpl->execute("main-table-stats");
	}
	 
	/**
	 * __loadStatsFromDB
	 * 
	 * Main table with statistics
	 * @access public
	 * 
	 */
	public function loadStatsFromDB() {
    	global $wgMemc, $wgStatsDB;
    	#---
		wfProfileIn( __METHOD__ );
		#---
		$result = array();
		#---
		if ( !isset($this->mCityId) || ( $this->mCityId < 0 ) ) {
			wfProfileOut( __METHOD__ );
			Wikia::log( __METHOD__, false, wfMsg('wikiastats_nostats_found') );
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
			Wikia::log( _METHOD__, false, wfMsg('wikiaststs_invalid_date') );
			return false;
		} 

		$memkey = md5($this->mCityId . "-" . implode("-", array_values($this->mStatsDate)) . "-" . $this->mLocalStats . "-" . $this->mLang . "-" . $this->mHub );
    	$memkey = __METHOD__ . "_" . $memkey;
    	#---
		$columns = array();
		$this->mMainStats = $wgMemc->get($memkey);
    	if ( empty($this->mMainStats) ) {
			#--- database instance - DB_SLAVE
			$dbr = wfGetDB(DB_SLAVE, array(), $wgStatsDB);

			$db_fields = array(
				'date' => "stats_date",
				'A' => empty($this->mAllStats) ? 'editors_allns' : 'sum(editors_allns)',
				'B' => empty($this->mAllStats) ? 'editors_contentns' : 'sum(editors_contentns)',
				'C'	=> empty($this->mAllStats) ? 'editors_userns' : 'sum(editors_userns)',
				'D'	=> empty($this->mAllStats) ? 'editors_5times' : 'sum(editors_5times)',
				'E'	=> empty($this->mAllStats) ? 'editors_100times' : 'sum(editors_100times)',
				'F' => empty($this->mAllStats) ? 'editors_month_allns' : 'sum(editors_month_allns)',
				'G' => empty($this->mAllStats) ? 'editors_month_contentns' : 'sum(editors_month_contentns)',
				'H' => empty($this->mAllStats) ? 'editors_month_userns' : 'sum(editors_month_userns)',
				'I' => empty($this->mAllStats) ? 'articles' : 'sum(articles)',
				'J' => empty($this->mAllStats) ? 'articles_day' : 'sum(articles_day)',
				'K' => empty($this->mAllStats) ? 'articles_0_5_size' : 'sum(articles_0_5_size)',
				'L' => empty($this->mAllStats) ? 'database_edits' : 'sum(database_edits)',
				'M' => empty($this->mAllStats) ? 'database_words' : 'sum(database_words)',
				'N' => empty($this->mAllStats) ? 'images_links' : 'sum(images_links)',
				'O' => empty($this->mAllStats) ? 'images_uploaded' : 'sum(images_uploaded)',
				'P' => empty($this->mAllStats) ? 'video_embeded' : 'sum(video_embeded)',
				'Q' => empty($this->mAllStats) ? 'video_uploaded' : 'sum(video_uploaded)',
			);
			
			array_walk($db_fields, create_function('&$v,$k', '$v = $v . " as " . $k;'));

			$where = $options = array();
			# set city_id 
			if ( !empty( $this->mCityId ) ) {
				$where['wikia_id'] = $this->mCityId;
			} else {
				if ( !empty($this->mLang) ) {
					$where['wikia_lang'] = $this->mLang;
				}
				if ( !empty($this->mHub) ) {
					$where['wikia_hub'] = $this->mHub;
				}
			}

			# set date range
			$where[] = sprintf(
				" stats_date between '%04d%02d' and '%04d%02d' ", 
				$this->mStatsDate['fromYear'], $this->mStatsDate['fromMonth'],
				$this->mStatsDate['toYear'], $this->mStatsDate['toMonth']
			);

			if ( !empty($this->mAllStats) ) {
				$this->excludedWikis($db_fields, $where);
			}

			#options
			#if ( !empty( $this->mCityId ) ) {
			$options = array('GROUP BY' => 'stats_date');
			#}

			$oRes = $dbr->select(
				array( "stats_summary_part" ),
				array( implode(", ", array_values( $db_fields ) ) ),
				$where,
				__METHOD__,
				$options
			);
			$this->mMainStats = array();
			while( $oRow = $dbr->fetchObject( $oRes ) ) {
				if ( !isset($this->mMainStats[$oRow->date]) ) {
					$this->mMainStats[$oRow->date] = array();
				}
				foreach ( $oRow as $field => $value ) {
					$excludedValues = isset($this->mExcludedWikis[$oRow->date][$field]) ? intval($this->mExcludedWikis[$oRow->date][$field]) : 0;
					$this->mMainStats[$oRow->date][$field] = $value - $excludedValues;
				}
			}
			$dbr->freeResult( $oRes );
			#---
			if ( !empty($this->mMainStats) ) {
				krsort($this->mMainStats);
			}
			$wgMemc->set( $memkey, $this->mMainStats, 60*10 );
		}
		#---
		wfProfileOut( __METHOD__ );
		return $this->mMainStats;
	}

	/**
	 * loadMonthlyDiffs
	 * 
	 * generate montly differences for the last 6 months
	 * @access public
	 * 
	 */
	private function excludedWikis($db_fields, $where) {
		global $wgMemc, $wgStatsDB; 
		
		wfProfileIn( __METHOD__ );
    	$memkey = __METHOD__ . "_" . $this->mCityId;
    	#---
		$this->mExcludedWikis = $wgMemc->get($memkey);
		if ( empty($this->mExcludedWikis) ) {
			$dbr = wfGetDB(DB_SLAVE, array(), $wgStatsDB);
			$where[] = "wikia_id in (" . $dbr->makeList( $this->getClosedWikis() ) . ")";
			$options = array('GROUP BY' => 'stats_date');

			$oRes = $dbr->select(
				array( "stats_summary_part" ),
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
		$this->mMonthDiffsStats = array();
		#---
		$prev_month = "";
		foreach ( $this->mMonthDiffs as $id => $date ) {
			# next record 
			$next = $id + 1;
			# 
		    $record = false;
		    if ( array_key_exists($date, $this->mMainStats) ) {
			    $record = $this->mMainStats[$date];
            }
			if ( empty($record) ) continue;
			if ( empty( $this->mMonthDiffs[$next] ) ) continue;
			#---
			$prev_record = "";
			if ( array_key_exists( $this->mMonthDiffs[$next], $this->mMainStats) ) {
			    $prev_record = $this->mMainStats[ $this->mMonthDiffs[$next] ];
            }
			if ( empty($prev_record) ) continue;

			$this->mMonthDiffsStats[$date] = array( 'visible' => 0 );
			foreach ( array_keys( $this->mMainStats[$date] ) as $column ) {
			    #---
				if ($column != 'date') {
					#---
					if ( empty( $record[$column] ) ) {
						$diff = 0;
					} 
					else {
						$diff = $record[$column] - $prev_record[$column];
						if ( $prev_record[$column] != 0 ) {
							$diff = $wgLang->formatNum( sprintf("%0.2f", ($diff / $prev_record[$column]) * 100) );
						} else {
							$diff = 0;
						}
					}
					#---
					if ( empty($diff) ) {
						$diff = 0;
					} else {
						$this->mMonthDiffsStats[ $date ][ 'visible' ] = 1;
					}
					#---
					$this->mMonthDiffsStats[ $date ][ $column ] = $diff ;
				}
			}
			$prev_month = $date;
		}

		#---
		krsort($this->mMonthDiffsStats);
		wfProfileOut( __METHOD__ );
		return $this->mMonthDiffsStats;
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
		$out = sprintf("%0.0f%%", $number);
		$values = array( -100, 0, 25, 75, 100 );
		$colors = array( "800000", "555555", "008000", "#0000FF" );
		$loop = 0;
		foreach ( $values as $idx => $value ) {
			$min = isset($values[$idx-1]) ? $values[$idx-1] : $values[$idx];
			$max = isset($values[$idx+1]) ? $values[$idx+1] : $values[$idx];
		
			if ( $min <= $number && $number < $max ) {
				$out = Xml::openElement( 'span', array( 'style' => 'color:#' . $colors[$loop] ) ) . $out . Xml::closeElement('span');
				break;
			}
			$loop++;
		}
		wfProfileOut( __METHOD__ );
		return $out;
	}
	
};
