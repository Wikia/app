<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Piotr Molski <moli@wikia.com> for Wikia.com
 * @version: $Id$
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension and cannot be used standalone.\n";
    exit( 1 ) ;
}

#--- Add messages
global $wgMessageCache, $wgWikiaStatsMessages;
require_once ( dirname( __FILE__ ) . '/SpecialWikiaStats.i18n.php' );
foreach( $wgWikiaStatsMessages as $key => $value ) {
	$wgMessageCache->addMessages( $wgWikiaStatsMessages[$key], $key );
}

class WikiaStatsClass extends SpecialPage
{
    var $mPosted, $mStats, $mSkinName;
    var $userIsSpecial;
    var $fromDate, $toDate;

    const USE_MEMC = 0;

    #--- constructor
    public function __construct()
    {
		#---
        $this->mPosted = false;
        $this->mSkinName = "monobook";
		wfLoadExtensionMessages("WikiaStats");
        parent::__construct( "WikiaStats", "",  true/*class*/); #--- restriction - user have to be logged
        if (method_exists('SpecialPage', 'setGroup')) { 
			parent::setGroup('WikiaStats', 'wiki');	
		}
    }

    public function execute( $subpage )
    {
        global $wgUser, $wgOut, $wgRequest;
		global $wgStatsExcludedNonSpecialGroup;
		global $wgCityId, $wgDBname;

		wfLoadExtensionMessages("WikiaStats");

        if ( $wgUser->isBlocked() ) {
            $wgOut->blockedPage();
            return;
        }
        if ( wfReadOnly() ) {
            $wgOut->readOnlyPage();
            return;
        }
        if ( !$wgUser->isLoggedIn() ) {
            $this->displayRestrictionErrorExt();
            return;
        }

       	$t = intval($wgRequest->getVal("table"));
		$this->userIsSpecial = 0;
		$rights = $wgUser->getGroups(); 
		foreach ($rights as $id => $right) {
			if (in_array($right, array('staff', 'sysop', 'janitor', 'bureaucrat'))) {
				$this->userIsSpecial = 1; 
				break;
			}
		}

		$this->fromDate = $wgRequest->getVal("from");
		$this->toDate = $wgRequest->getVal("to");
		
        #--- WikiaGenericStats instance
        $this->mStats = new WikiaGenericStats($wgUser->getID());

        $skin = $wgUser->getSkin();
        if (is_object ($skin)){
            $skinname = get_class($skin);
            $skinname = strtolower(str_replace("Skin","", $skinname));
            $this->mSkinName = $skinname;
        }
		$this->mTitle = Title::makeTitle( NS_SPECIAL, "WikiaStats" );
		$wgOut->setPageTitle( wfMsg("wikiastats_pagetitle") );
		$wgOut->setRobotpolicy( "noindex,nofollow" );
		#---
		$wgOut->addScript("<link rel=\"stylesheet\" type=\"text/css\" href=\"/extensions/wikia/WikiaStats/css/wikiastats.css\">\n");
		$wgOut->addScript("<script type=\"text/javascript\" src=\"/extensions/wikia/WikiaStats/js/wikiastats.js\"></script>\n");

		if ($wgDBname == CENTRAL_WIKIA_ID) { // central version
			#--- initial output
			//$wgOut->setArticleBodyOnly(true);
			if ($wgRequest->getVal("action")) {
				$mainPageLink = " - <a href=\"/index.php?title=Special:WikiaStats\">". wfMsg('wikiastats_back_to_mainpage')."</a>";
				$prevPageLink = "<a href=\"javascript:void(0);\" onClick=\"history.go(-1); return true;\"><< ".wfMsg('wikiastats_back_to_prevpage')."</a>";
				$wgOut->setSubtitle($prevPageLink . $mainPageLink);
			}
			#---
			/*switch ($this->mSkinName) {
				case "monobook": 
				case "slate"   :
				case "quartz"  : $this->disableWidgetBarCss(); $wgOut->setArticleRelated( false ); break;
				case "monaco"  : $this->disableWidgetBarCss(); break;
				default        : $wgOut->setArticleRelated( false ); break;
			}*/
			if ($wgRequest->getVal("action") == "generate") {
				$this->mPosted = true;
			} elseif (($wgRequest->getVal("action") == "citystats") || ($wgRequest->getVal("action") == "citycharts")) {
				// main dashboard 
				$this->mainStatsForm( intval($wgRequest->getVal("city")), ($wgRequest->getVal("action") == "citycharts") );
			} elseif ($wgRequest->getVal("action") == "compare") {
				// compare statistics
				if ($t == 1) {
					$this->mainStatsTrendsForm();
				} elseif ($t == 2) {
					$this->mainStatsCreationHistoryForm();
				} elseif ($t > 2) { 
					$memory_limit = ini_get("memory_limit");
					$column = $wgRequest->getVal("table"); 
					$cities = $wgRequest->getVal("cities"); 
					$this->mainStatsColumnHistoryForm($column, $cities); 
				}
			} else {
				$this->mainSelectCityForm();
			}
		} else {
			// local version 
			$this->mainStatsForm( $wgCityId, ($wgRequest->getVal("action") == "citycharts"), 1 );
		}
    }

    private function displayRestrictionErrorExt() {
		$res = wfMsg("wikiastats_restricted_page");
		if (empty($res)) {
			$this->displayRestrictionError();
		} else {
			global $wgOut;
			$wgOut->setPageTitle( wfMsg( 'badaccess' ) );
			$wgOut->setHTMLTitle( wfMsg( 'errorpagetitle' ) );
			$wgOut->setRobotpolicy( 'noindex,nofollow' );
			$wgOut->setArticleRelated( false );
			$wgOut->mBodytext = '';
			$wgOut->addWikiText( $res );
			$wgOut->returnToMain( false );			
		}
		return;
  	}

    private function mainSelectCityForm()
    {
        global $wgUser, $wgOut, $wgCityId;
        global $wgMemc, $wgRequest, $wgContLang;
        global $wgStatsExcludedNonSpecialGroup;

		wfProfileIn( __METHOD__ );
   		$main_select = "";
   		
   		if (self::USE_MEMC) $main_select = $wgMemc->get('wikiastatsmainmenu');
	
		if (empty($main_select))
		{
			$cityStatsList = $this->mStats->getWikiaOrderStatsList();
			if (is_array($cityStatsList) && (empty($cityStatsList[0])))
			{
				$cityStatsList = array_merge(array(0=>0) /*All stats*/, $cityStatsList);
			}
			$cityList = $this->mStats->getWikiaAllCityList();
			$dateRange = $this->mStats->getRangeDateStatistics();

			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
			$oTmpl->set_vars( array(
				"title" 	=> $this->mTitle,
				"stats"		=> $this->mStats,
				"cityStats"	=> $cityStatsList,
				"cityList"	=> $cityList,
				"user"		=> $wgUser,
				"wgCityId"	=> $wgCityId,
				"dateRange" => $dateRange,
				"MAX_NBR"	=> STATS_COLUMN_CITY_NBR,
				"userIsSpecial"=> $this->userIsSpecial,
				"DEF_DATE"	=> MIN_STATS_DATE,
				"wgStatsExcludedNonSpecialGroup" => $wgStatsExcludedNonSpecialGroup,
			));
			
			$main_select = $oTmpl->execute("main-select");
			$wgMemc->set("wikiastatsmainmenu", $main_select, 60*60*3);
		}
        
        $wgOut->addHTML( $main_select );
        #---
		wfProfileOut( __METHOD__ );
        return;
    }

    
    private function mainStatsForm($city, $show_charts = 0, $show_local = 0)
    {
        global $wgUser, $wgOut, $wgRequest;
        global $wgMemc;
		global $wgStatsExcludedNonSpecialGroup;

		list ($fromY, $fromM, $toY, $toM) = array();
		$m = array();
		if (preg_match("/^([0-9]{4})([0-9]{1,2})/", $this->fromDate, $m)) {
			list (, $fromY, $fromM) = $m; 
		} else {
			list ($fromY, $fromM) = array(MIN_STATS_YEAR, MIN_STATS_MONTH);
		}
		//
		if (preg_match("/^([0-9]{4})([0-9]{1,2})/", $this->toDate, $m)) {
			list (, $toY, $toM) = $m; 
		} else {
			list ($toY, $toM) = array(date("Y"), date("m"));
		}

		wfProfileIn( __METHOD__ );
		$memkey = "wikiastatsmainstatsform_".$city."_".$show_charts."_".$show_local."_".$fromY.$fromM."_".$toY.$toM;
		$mainStats = "";
		if (self::USE_MEMC) $mainStats = $wgMemc->get($memkey);

		if (empty($mainStats)) {
			$table_stats = "";
			if ($show_local) {
				$this->mStats->setLocalStats(true);
			}
			if ( (is_numeric($city)) && ($city >= 0) ) {
				$main_stats = $this->mStats->getWikiMainStatistics($city, $fromY, $fromM, $toY, $toM, $show_charts);
				$table_stats = $main_stats["text"];
				unset($main_stats);
			}

			$cityList = $this->mStats->getWikiaCityList();
			$dateRange = $this->mStats->getRangeDateStatistics();

			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
			$oTmpl->set_vars( array(
				"title" 	=> $this->mTitle,
				"stats"		=> $this->mStats,
				"cityList"	=> $cityList,
				"user"		=> $wgUser,
				"is_posted"	=> $this->mPosted,
				"dateRange" => $dateRange,
				"selCity" 	=> $city,
				"main_tbl" 	=> $table_stats,
				"show_chart"=> $show_charts,
				"fromDate"	=> array($fromY, $fromM),
				"toDate"	=> array($toY, $toM),
			));
			$mainStats = "";
			if ($show_local) {
				$mainStats = $oTmpl->execute("main-local-form");
			} else {
				$mainStats = $oTmpl->execute("main-form");
			}

			if (empty($show_charts)) {
				$columns = $this->mStats->getRangeColumns();
				$oTmpl->set_vars( array(
					"columns" => $columns,
					"userIsSpecial"=> $this->userIsSpecial,
					"wgStatsExcludedNonSpecialGroup" => $wgStatsExcludedNonSpecialGroup,
				));
				$mainStats .= $oTmpl->execute("main-stats-definitions");
			}

			$wgMemc->set($memkey, $mainStats, 60*60*3);
			unset($cityList);
			unset($table_stats);
			unset($dateRange);
		}

        $wgOut->addHTML( $mainStats );
		wfProfileOut( __METHOD__ );
    }    

    private function mainStatsTrendsForm ()
    {
        global $wgUser, $wgOut, $wgRequest;
		wfProfileIn( __METHOD__ );

		#---
		$page = intval($wgRequest->getVal('page'));
		$select = $page * STATS_TREND_CITY_NBR;
		#---
		$cityList = $this->mStats->getWikiaAllCityList();
		#---

		$cityOrderList = array(); 
		$cities = $wgRequest->getVal("cities"); 
		$citiesList = array();
		if (!empty($cities)) {
			$citiesList = split(";", $cities, 30);
		}
		
		$cityOrderList = $this->mStats->getWikiaOrderStatsList('', $citiesList);
		#--- split table to get list of id of cities 
		$array_sli = array_slice($cityOrderList, $select, STATS_TREND_CITY_NBR);
		$splitCityList = array_merge(array(0 => 0) /* all stats */, (is_array($array_sli)) ? $array_sli : array());
		#---
		$nbrCities = count($cityOrderList) + 1;
		unset($cityOrderList);
		#---
		$cityKeys = array_values($splitCityList);
		#---
		$res = WikiaGenericStats::getWikiTrendStatistics($cityKeys, STATS_TREND_MONTH);
		$trend_stats = $res[0];
		$month_array = $res[1];
		#---
		unset($cityKeys);
		unset($res);

		$pager = $this->mStats->getStatisticsPager($nbrCities, $page, "/index.php?title=Special:WikiaStats&action=compare&table=1", "", STATS_TREND_CITY_NBR, 0);

        $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $oTmpl->set_vars( array(
            "title" 		=> $this->mTitle,
            "stats"			=> $this->mStats,
            "cityList"		=> $cityList,
            "cityOrderList"	=> $splitCityList,
            "nbrCities"		=> $nbrCities,
            "user"			=> $wgUser,
            "trend_stats" 	=> $trend_stats,
            "nbr_month"		=> STATS_TREND_MONTH,
            "month_array"	=> $month_array,
            "select_trend"	=> $select,
            "pager"			=> $pager,
            "page"			=> $page
        ));
        
        $wgOut->addHTML( $oTmpl->execute("trend-form") );
        
        unset($cityList);
        unset($trend_stats);
        unset($month_array);
        unset($splitCityList);
		wfProfileOut( __METHOD__ );
	}
	
	private function mainStatsCreationHistoryForm ()
	{
        global $wgUser, $wgOut, $wgRequest;
        global $wgMemc;

		wfProfileIn( __METHOD__ );
		$memkey = "wikiastatscreationhistory";
   		$creationHistory = "";
   		if (self::USE_MEMC) $creationHistory = $wgMemc->get($memkey);

		if (empty($creationHistory)) {
			#---
			$cityList = $this->mStats->getWikiaAllCityList();
			#---
			list ($arr_wikians, $dWikians, $arr_article, $dArticles) = $this->mStats->getWikiCreationHistory();
			#--- split table to get list of id of cities 
			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
			$oTmpl->set_vars( array(
				"title" 		=> $this->mTitle,
				"stats"			=> $this->mStats,
				"cityList"		=> $cityList,
				"user"			=> $wgUser,
				"wikians" 		=> (is_array($arr_wikians)) ? $arr_wikians[0] : array(),
				"article"		=> (is_array($arr_article)) ? $arr_article[0] : array(),
				"dWikians"		=> $dWikians,
				"max_wikians"	=> (is_array($arr_wikians)) ? $arr_wikians[1] : 1,
				"dArticles"		=> $dArticles,
				"max_articles"	=> (is_array($arr_article)) ? $arr_article[1] : 1,
			));
			#---
			$creationHistory = $oTmpl->execute("creation-form");
			unset($cityList);
			unset($creationWikians);
			unset($creationArticle);
			unset($dWikians);
			unset($dArticles);
			#---
			$wgMemc->set($memkey, $creationHistory, 60*60*3);
		}
		
		$wgOut->addHTML( $creationHistory );
		wfProfileOut( __METHOD__ );
	}
	
	private function mainStatsColumnHistoryForm($column, $cities = "")
	{
		global $wgUser, $wgOut, $wgRequest;

		wfProfileIn( __METHOD__ );
		#---
		$page = intval($wgRequest->getVal('page'));
		$select = STATS_COLUMN_CITY_NBR * $page;
		
		$citiesList = array();
		if (!empty($cities)) {
			$citiesList = split(";", $cities, 30);
		}

		$columnStats = $this->mStats->getWikiCompareColumnsStats($column, $citiesList, $select);
		if ($columnStats === false) {
			wfProfileOut( __METHOD__ );
			return '';
		}
		list ($cityList,$nbrCities,$splitCityList,$columnHistory,$columnRange) = $columnStats;
		unset($columnStats); $columnStats = false;
		
		$pager = $this->mStats->getStatisticsPager(count($cityList), $page, "/index.php?title=Special:WikiaStats&action=compare&table=$column", "", STATS_COLUMN_CITY_NBR, 0);
        $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $oTmpl->set_vars( array(
            "title" 		=> $this->mTitle,
            "stats"			=> $this->mStats,
            "cityList"		=> $cityList,
            "user"			=> $wgUser,
            "column"		=> $column,
            "nbrCities"		=> $nbrCities,
            "cityOrderList"	=> $splitCityList,
            "columnHistory"	=> $columnHistory,
            "rangeColumns"	=> $columnRange,
            "pager"			=> $pager,
            "cities"		=> $cities,
        ));
        $output = $oTmpl->execute("column-stats-form");
        
        unset($columnHistory);
        unset($splitCityList);
        unset($cityList);
        unset($nbrCities);
        unset($columnRange);
        
        $wgOut->addHTML( $output );
        #---
		wfProfileOut( __METHOD__ );
	}
	
	private function disableWidgetBarCss()
	{
	    global $wgOut; 
		$wgOut->addScript("<link rel=\"stylesheet\" type=\"text/css\" href=\"/extensions/wikia/WikiaStats/css/hideWidgets.css\">\n");
    }
}

?>
