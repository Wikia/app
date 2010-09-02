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
    const EVENT_LOG_TYPE = 'stats';
    const PV_LIMIT = 100;
    const PV_DELTA = 180;
	
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
		global $wgStatsDB, $wgMemc, $wgLang;
		#---
		wfProfileIn( __METHOD__ );
    	#---
    	$monthsArray = array(); for ($i = 0; $i < 12; $i++) {
    		$monthsArray[] = wfMsg( strtolower( date( "F", mktime(23,59,59,$i+1,1,1970) ) ) );
		}
    	#---
    	$memkey = sprintf( "%s_%d_%s", __METHOD__, intval(WIKISTATS_MIN_COUNT_STATS_YEAR), $wgLang->getCode() );
		$this->mDateRange = $wgMemc->get( $memkey );

		if ( empty($this->mDateRange) ) {
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
		global $wgStatsDB, $wgMemc, $wgLang, $wgCityId;
		#---
		wfProfileIn( __METHOD__ );
    	#---
    	$memkey = sprintf( "%s_%d_%s", __METHOD__, intval($this->mCityId), $wgLang->getCode() );
		$this->mUpdateDate = $wgMemc->get( $memkey );

		#---
		if ( empty($this->mUpdateDate) ) {
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

			} else {
				$oRow = $dbr->selectRow( 
					'events_log',
					array( 'unix_timestamp(el_end) as lastdate' ),
					array( 'el_type' => self::EVENT_LOG_TYPE ), 
					__METHOD__
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
			Wikia::log( _METHOD__, false, wfMsg('wikistats_invalid_date') );
			return false;
		} 

		$memkey = md5($this->mCityId . implode("-", array_values($this->mStatsDate)) . $this->mLocalStats . $this->mLang . $this->mHub );
    	$memkey = __METHOD__ . "_" . $memkey . '_v2';
    	#---
		$columns = array();
		$this->mMainStats = ( self::USE_MEMC ) ? $wgMemc->get($memkey) : array();
    	if ( empty($this->mMainStats) ) {
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
				'K' => 'video_uploaded'				
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
	 * loadMonthlyDiffs
	 * 
	 * generate montly differences for the last 6 months
	 * @access public
	 * 
	 */
	private function excludedWikis($db_fields, $where) {
		global $wgMemc, $wgStatsDB; 
		
		wfProfileIn( __METHOD__ );
    	$memkey = __METHOD__ . "_" . $this->mCityId . '_v2';
    	#---
		$this->mExcludedWikis = $wgMemc->get($memkey);
		if ( empty($this->mExcludedWikis) ) {
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
	
	/*
	 * getWikiansActivity
	 * 
	 * @access public
	 * 
	 */
	public function getWikiansActivity($content = 1, $anons = 0, $date = '', $limit = WIKISTATS_WIKIANS_RANK_NBR, $users = array()) {
		global $wgMemc, $wgStatsDB;
		wfProfileIn( __METHOD__ );
		#---
		$memkey = sprintf( "%s_%s", __METHOD__, md5($this->mCityId . $date . $content . $anons . $limit) );
		#---
		$result = array();
		if (self::USE_MEMC) $result = $wgMemc->get($memkey);

		if (empty($result)) {
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
			#error_log ("active = " . print_r($wikians_active, true));
			#error_log ("absent = " . print_r($wikians_absent, true));
			
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
			$active = $oTmpl->execute("wikians-active-stats");
			$absent = $oTmpl->execute("wikians-absent-stats");
			
			$data = $active . $absent;
			#$data = array("code" => 1, "text" => $text);
		}

		#---
		wfProfileOut( __METHOD__ );
		return $data;
	}
	
	/*
	 * most vistied pages
	 * 
	 * @access public
	 * 
	 * list of most visited pages
	 */	
	public function latestViewPages($namespace = -1) {
		global $wgStatsDB;
		wfProfileIn( __METHOD__ );

		$dbr = wfGetDB(DB_SLAVE, array(), $wgStatsDB);
		
		$where = array( 
			"pv_city_id" => $this->mCityId,
			"pv_ts >= '" . date('Y-m-d H-i-s', time() - self::PV_DELTA) . "'"
		);		
		
		if ( $namespace > 0 ) {
			$where['pv_namespace'] = $namespace;
		} 

		$res = $dbr->select(
			array( 'page_views_articles' ),
			array( 'pv_page_id', 'pv_views'  ),
			$where,
			__METHOD__,
			array(
				'ORDER BY'	=> 'pv_ts DESC',
				'LIMIT'		=> self::PV_LIMIT
			)
		);
		
		$ids = array();
		$count = array(); $loop = 0;
		while ( $oRow = $dbr->fetchObject( $res ) ) {
			if ( !isset($ids[$oRow->pv_page_id]) ) { 
				$ids[$oRow->pv_page_id] = $loop;
				$loop++;
			}
			$count[$oRow->pv_page_id] += $oRow->pv_views;
		}
		$dbr->freeResult( $res );
				
		$titles = Title::newFromIDs( array_keys($ids) );
		
		$urls = array();
		foreach ( $titles as $oTitle ) {
			$page_id = $oTitle->getArticleID();
			$urls[$page_id] = Xml::element("a", array("href" => $oTitle->getLocalURL()), $oTitle->getFullText());
		}
		
		$result = array(); 
		foreach ( $ids as $page_id => $position ) {
			if ( isset( $urls[$page_id] ) ) {
				$result[] = wfSpecialList( $urls[$page_id], $count[$page_id]. "x" );
			}
		}
		
		wfProfileOut( __METHOD__ );
		#---
		return $result;				
	}
	
	/*
	 * latest user activity
	 * 
	 * @access public
	 * 
	 * list of most visited pages
	 */	
	public function userViewPages($hours = 1) {
		global $wgStatsDB;
		wfProfileIn( __METHOD__ );

		$dbr = wfGetDB(DB_SLAVE, array(), $wgStatsDB);

		$ts = strftime("%F %T", strtotime("-$hours hour"));
		
		$where = array( 
			"pv_city_id" => $this->mCityId,
			"pv_ts >= '$ts' "
		);

		$res = $dbr->select(
			array( 'page_views_user' ),
			array( 'pv_user_id', 'count(*) as cnt'  ),
			$where,
			__METHOD__,
			array(
				'GROUP BY'	=> 'pv_user_id',
				'ORDER BY'	=> 'pv_ts desc',
				'LIMIT'		=> self::PV_LIMIT
			)
		);
		
		$result = array(); 
		while ( $oRow = $dbr->fetchObject( $res ) ) {
			$oUser = User::newFromId($oRow->pv_user_id);
			if ( is_object($oUser) ) {
				$oTitle = Title::newFromText($oUser->getName(), NS_USER);
				if ( $oTitle ) {
					$oRow->page_title = Xml::element("a", array("href" => $oTitle->getLocalURL()), $oTitle->getFullText()) ;
				} 
				$result[$oRow->pv_user_id] = wfSpecialList( $oRow->page_title, wfMsgExt("wikistats_latest_userviews_pages", 'parsemag', $oRow->cnt) );
			}
		}
		$dbr->freeResult( $res );
		
		wfProfileOut( __METHOD__ );
		#---
		return $result;				
	}	
	
	public function getLatestStats() {
		global $wgStatsDB;
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
		
		return $date;
	}
};
