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

############################## Ajax ##################################

function axWStatisticsGenerate($city_id, $year_from, $month_from, $year_to, $month_to, $charts = 0)
{
    global $wgRequest, $wgUser, $wgMessageCache, $wgWikiaStatsMessages;
    global $wgCityId, $wgDBname;

	if (empty($wgUser)) {
		return false;
	}

	if ( $wgUser->isBlocked() ) {
		return;
	}

	if ($wgDBname != CENTRAL_WIKIA_ID) { 
		// central version
		$city_id = $wgCityId;
	}

	wfLoadExtensionMessages("WikiaStats");

	$obj_stats = new WikiaGenericStats($wgUser->getID());
    $aResponse = $obj_stats->getWikiMainStatistics($city_id, $year_from, $month_from, $year_to, $month_to, $charts);
    
    $result = ($aResponse['code'] == 1) ? $aResponse['text'] : "";
    
    /*if (!function_exists('json_encode'))  {
        $oJson = new Services_JSON();
        return $oJson->encode($aResponse);
    }
    else {
        return json_encode($aResponse);
    }*/
    return $result;
}

function axWStatisticsDistribEditsGenerate($city_id)
{
    global $wgRequest, $wgUser, $wgMessageCache, $wgWikiaStatsMessages;
    global $wgCityId, $wgDBname;
    
	if (empty($wgUser)) {
		return false;
	}

	if ( $wgUser->isBlocked() ) {
		return;
	}
	
	if ($wgDBname != CENTRAL_WIKIA_ID) { 
		// central version
		$city_id = $wgCityId;
	}
    
	wfLoadExtensionMessages("WikiaStats");
    $aResponse = WikiaGenericStats::getWikiDistribStatistics($city_id, 0);
    
    if (!function_exists('json_encode'))  {
        $oJson = new Services_JSON();
        return $oJson->encode($aResponse);
    }
    else {
        return json_encode($aResponse);
    }
}

function axWStatisticsWikiansRank($city_id, $month = 1)
{
    global $wgRequest, $wgUser, $wgMessageCache, $wgWikiaStatsMessages;
    global $wgCityId, $wgDBname;
    
	if (empty($wgUser)) {
		return false;
	}

	if ( $wgUser->isBlocked() ) {
		return;
	}
	
	if ($wgDBname != CENTRAL_WIKIA_ID) { 
		// central version
		$city_id = $wgCityId;
	}
    
	wfLoadExtensionMessages("WikiaStats");
    $aResponse = WikiaGenericStats::getWikiWikiansRank($city_id, $month);
    
    if (!function_exists('json_encode'))  {
        $oJson = new Services_JSON();
        return $oJson->encode($aResponse);
    }
    else {
        return json_encode($aResponse);
    }
}

function axWStatisticsAnonUsers($city_id)
{
    global $wgRequest, $wgUser, $wgMessageCache, $wgWikiaStatsMessages;
    global $wgCityId, $wgDBname;
    
	if (empty($wgUser)) {
		return false;
	}

	if ( $wgUser->isBlocked() ) {
		return;
	}
	
	if ($wgDBname != CENTRAL_WIKIA_ID) { 
		// central version
		$city_id = $wgCityId;
	}
    
	wfLoadExtensionMessages("WikiaStats");
    $aResponse = WikiaGenericStats::getWikiAnonUsers($city_id);
    
    if (!function_exists('json_encode'))  {
        $oJson = new Services_JSON();
        return $oJson->encode($aResponse);
    }
    else {
        return json_encode($aResponse);
    }
}

function axWStatisticsArticleSize ($city_id, $sizeList = "")
{
    global $wgRequest, $wgUser, $wgMessageCache, $wgWikiaStatsMessages;
    global $wgCityId, $wgDBname;
    
	if (empty($wgUser)) {
		return false;
	}

	if ( $wgUser->isBlocked() ) {
		return;
	}
	
   
	if ($wgDBname != CENTRAL_WIKIA_ID) { 
		// central version
		$city_id = $wgCityId;
	}

	wfLoadExtensionMessages("WikiaStats");
    $aResponse = WikiaGenericStats::getWikiArticleSize($city_id, $sizeList);
    
    if (!function_exists('json_encode'))  {
        $oJson = new Services_JSON();
        return $oJson->encode($aResponse);
    }
    else {
        return json_encode($aResponse);
    }
}

function axWStatisticsNamespaceCount($city_id)
{
    global $wgRequest, $wgUser, $wgMessageCache, $wgWikiaStatsMessages;
    global $wgCityId, $wgDBname;
    
	if (empty($wgUser)) {
		return false;
	}

	if ( $wgUser->isBlocked() ) {
		return;
	}
	
	if ($wgDBname != CENTRAL_WIKIA_ID) { 
		// central version
		$city_id = $wgCityId;
	}
    
	wfLoadExtensionMessages("WikiaStats");
    $aResponse = WikiaGenericStats::getWikiNamespaceCount($city_id);
    
    if (!function_exists('json_encode'))  {
        $oJson = new Services_JSON();
        return $oJson->encode($aResponse);
    }
    else {
        return json_encode($aResponse);
    }
}

function axWStatisticsPageEdits($city_id)
{
    global $wgRequest, $wgUser, $wgMessageCache, $wgWikiaStatsMessages;
    global $wgCityId, $wgDBname;
    
	if (empty($wgUser)) {
		return false;
	}

	if ( $wgUser->isBlocked() ) {
		return;
	}
	
	if ($wgDBname != CENTRAL_WIKIA_ID) { 
		// central version
		$city_id = $wgCityId;
	}

	wfLoadExtensionMessages("WikiaStats");
    $aResponse = WikiaGenericStats::getWikiPageEditsCount($city_id);
    
    if (!function_exists('json_encode'))  {
        $oJson = new Services_JSON();
        return $oJson->encode($aResponse);
    }
    else {
        return json_encode($aResponse);
    }
}

function axWStatisticsOtherNpacesPageEdits($city_id)
{
    global $wgRequest, $wgUser, $wgMessageCache, $wgWikiaStatsMessages;
    global $wgCityId, $wgDBname;
    
	if (empty($wgUser)) {
		return false;
	}

	if ( $wgUser->isBlocked() ) {
		return;
	}
	
	if ($wgDBname != CENTRAL_WIKIA_ID) { 
		// central version
		$city_id = $wgCityId;
	}

	wfLoadExtensionMessages("WikiaStats");
    $aResponse = WikiaGenericStats::getWikiPageEditsCount($city_id, 0, 1);
    
    if (!function_exists('json_encode'))  {
        $oJson = new Services_JSON();
        return $oJson->encode($aResponse);
    }
    else {
        return json_encode($aResponse);
    }
}


function axWStatisticsPageEditsDetails($city_id, $page_id)
{
    global $wgRequest, $wgUser, $wgMessageCache, $wgWikiaStatsMessages;
    global $wgCityId, $wgDBname;
    
	if (empty($wgUser)) {
		return false;
	}

	if ( $wgUser->isBlocked() ) {
		return;
	}
	
	if ($wgDBname != CENTRAL_WIKIA_ID) { 
		// central version
		$city_id = $wgCityId;
	}
    
	wfLoadExtensionMessages("WikiaStats");
    $aResponse = WikiaGenericStats::getWikiPageEditsDetailsCount($city_id, $page_id);
    
    if (!function_exists('json_encode'))  {
        $oJson = new Services_JSON();
        return $oJson->encode($aResponse);
    }
    else {
        return json_encode($aResponse);
    }
}

/*
 * function to generate XLS statistics
 */
function axWStatisticsXLS($city_id, $param, $others = "", $date_from = "", $date_to = "")
{
    global $wgRequest, $wgUser, $wgMessageCache, $wgWikiaStatsMessages;
    global $wgCityId, $wgDBname;

	error_log ("axWStatisticsXLS($city_id, $param, $others, $date_from, $date_to)");

	if ( $wgUser->isBlocked() ) {
		return;
	}
	
	if ($wgDBname != CENTRAL_WIKIA_ID) { 
		// central version
		$city_id = $wgCityId;
	}

	wfLoadExtensionMessages("WikiaStats");
	$xls = 1;
	switch ($param) {
		case "1": { // generate main statistics for Wikia
			// parse parameters
			list($year_from, $month_from) = array(MIN_STATS_YEAR, MIN_STATS_MONTH);
			if ($date_from != "") {
				list($year_from, $month_from) = explode("-", $date_from);
				$month_from = sprintf("%02d", $month_from);
			}
			
			list($year_to, $month_to) = array(date("Y"), date("m"));
			if ($date_to != "") {
				list($year_to, $month_to) = explode("-", $date_to);
				$month_to = sprintf("%02d", $month_to);
			}
			$obj_stats = new WikiaGenericStats($wgUser->getID());
			$obj_stats->getWikiMainStatistics($city_id, $year_from, $month_from, $year_to, $month_to, 0, $xls);
			break;
		}
		case "2": { // generate "Distribution of article edits over wikians"
			WikiaGenericStats::getWikiDistribStatistics($city_id, $xls);
			break;
		}
		case "3": { // Active/Absent wikians, ordered by number of contributions
		    WikiaGenericStats::getWikiWikiansRank($city_id, 1, $xls);
		    break;
		}
		case "4": { // Active/Absent wikians, ordered by number of contributions
		    WikiaGenericStats::getWikiAnonUsers($city_id, $xls);
		    break;
		}
		case "5": { // Articles that contain at least one internal link and .. characters readable text, 
			$sizeList = "";
			for ($i = 0 ; $i <= 13 ; $i++) {
				$s = pow(2, 5 + $i);
				$sizeList .= $s . "," ;
			}
		    WikiaGenericStats::getWikiArticleSize($city_id, $sizeList, $xls);
		    break;
		}
		case "6": { // Database records per namespace
			WikiaGenericStats::getWikiNamespaceCount($city_id, $xls);
			break;			
		}
		case "7": { // Most edited articles (> 25 edits)
			WikiaGenericStats::getWikiPageEditsCount($city_id, $xls);
			break;
		}
		case "8": { // Most edited articles (> 25 edits)
			WikiaGenericStats::getWikiPageEditsCount($city_id, $xls, 1);
			break;
		}
		case "9": { // page views
			WikiaGenericStats::getWikiPageViewsCount($city_id, $xls, 0);
			break;
		}
		// comparisions
		case "10": { // overview
			$obj_stats = new WikiaGenericStats($wgUser->getID());
			$cities = array(0 => 0); //initial and default value
			if (!empty($others)) {
				$_ = explode(";", $others);
				foreach ($_ as $id => $key) {
					if (is_numeric($key)) $cities[] = intval($key);
				}
			}
			#---
			$obj_stats->getWikiTrendStatisticsXLS($city_id, $cities);
			//WikiaGenericStats::getWikiPageEditsCount($city_id, $xls);
			break;
		}
		case "11": { // creation history
			$obj_stats = new WikiaGenericStats($wgUser->getID());
			$obj_stats->getWikiCreationHistoryXLS($city_id);
			//WikiaGenericStats::getWikiPageEditsCount($city_id, $xls);
			break;
		}
		default : { // comparisions 
			if ( ($param > 11) && ($param < 27) ) {
				$obj_stats = new WikiaGenericStats($wgUser->getID());
				$cities = array(0 => 0); //initial and default value
				if (!empty($others)) {
					$_ = explode(";", $others);
					foreach ($_ as $id => $key) {
						if (is_numeric($key)) {
							$cities[] = intval($key);
						}
					}
				}
				#---
				$param = $param - 9;
				$obj_stats->getWikiCompareColumnsStatsXLS($param, $cities);
			}
			break;
		}
	}
	
	return;
}

/* get list of wikia */
function axWStatisticsWikiaList() {
    global $wgRequest, $wgUser, $wgMessageCache, $wgWikiaStatsMessages, $wgMemc;

	if ( $wgUser->isBlocked() ) {
		return;
	}

	wfLoadExtensionMessages("WikiaStats");
	$usLang = $wgUser->getOption( 'language' );
	$usLang = (!empty($usLang)) ? $usLang : "en";
	
	$memckey = wfMemcKey("wikiastatslist_" . $usLang);
	$main_select = $wgMemc->get($memckey);
	
	if (empty($main_select)) {
        $mStats = new WikiaGenericStats($wgUser->getID());
        
        $cityStatsList = $mStats->getWikiaOrderStatsList();
        if (is_array($cityStatsList) && (empty($cityStatsList[0]))) {
            $cityStatsList = array_merge(array(0=>0) /*All stats*/, $cityStatsList);
        }
        $cityList = $mStats->getWikiaAllCityList();

/*
        $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $oTmpl->set_vars( array(
            "cityStats"	=> $cityStatsList,
            "cityList"	=> $cityList,
            "user"		=> $wgUser,
        ));
        
        $main_select = $oTmpl->execute("wikia-main-list"); 
*/
		$main_select = array();
		$loop = 0;
		foreach ($cityStatsList as $id => $cityId) {
			if (!empty($cityList[$cityId])) {
				$loop++;
				$title = ($cityList[$cityId]['title'] == "&Sigma;") ? wfMsg("wikiastats_trend_all_wikia_text") . " " . wfMsg("wikiastats_always_selected") : $cityList[$cityId]['title'];
				$urlshort = ($cityList[$cityId]['title'] == "&Sigma;") ? $title : ucfirst($cityList[$cityId]['urlshort']) . " (".$title.")";
				#(!empty($cityList[$cityId]['urlshort'])) ? " (".ucfirst($cityList[$cityId]['urlshort']).")" : "";
				$main_select[] = array("city" => $cityId, "name" => ucfirst($urlshort));
			}
		}
		if (!function_exists('json_encode'))  {
			$oJson = new Services_JSON();
			$main_select = $oJson->encode($main_select);
		}
		else {
			$main_select = json_encode($main_select);
		}

        $wgMemc->set($memckey, $main_select, 60*60*10);        
    }
	
	return $main_select;
}

/* get list of wikia */
function axWStatisticsWikiaListJson($limit=25, $offset=0) {
    global $wgRequest, $wgUser, $wgMessageCache, $wgWikiaStatsMessages, $wgMemc;

	if ( $wgUser->isBlocked() ) {
		return;
	}

	wfLoadExtensionMessages("WikiaStats");
	$cities_list = array();
	$memckey = wfMemcKey("wikiastatslistjson_".$limit."_".$offset);
	$cities_list = $wgMemc->get($memckey);
	if (empty($cities_list)) {
        $mStats = new WikiaGenericStats($wgUser->getID());
        
        $cityStatsList = $mStats->getWikiaOrderStatsList();
        if (is_array($cityStatsList) && (empty($cityStatsList[0])))
        {
            $cityStatsList = array_merge(array(0=>0) /*All stats*/, $cityStatsList);
        }
        $cityList = $mStats->getWikiaAllCityList();

		#---
		$loop = 0;
		$result = array();
		foreach ($cityStatsList as $id => $cityId)
		{
			if (!empty($cityList[$cityId]))
			{
				$loop++;
				$result[] = array('Id' => $cityId, 'Title' => ucfirst($cityList[$cityId]['title']), 'Name' => ucfirst($cityList[$cityId]['dbname']), 'Option' => '');
			}
		}
		$cities_list = array();
		$cities_list["total"] = $loop;
		$cities_list["totalReturned"] = count(array_splice($result, $offset, $limit));
		$cities_list["index"] = $offset;
		#$cities_list["Result"] = array_splice($result, 0, $limit);
		
		$_ = array_splice($cityStatsList, $offset, $limit);
		if (empty($_)) { 
			$cities_list["Result"] = "";
		} else {
			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
			$oTmpl->set_vars( array(
				"cityStats"	=> array_splice($cityStatsList, $offset, $limit),
				"cityList"	=> $cityList,
				"user"		=> $wgUser,
			));
			$cities_list["Result"] = $oTmpl->execute("wikia-main-cities");
		}
		
        $wgMemc->set($memckey, $cities_list, 60*60*10);
    }

	if (!function_exists('json_encode'))  {
		$oJson = new Services_JSON();
		return $oJson->encode($cities_list);
	}
	else {
		return json_encode($cities_list);
	}
}

/* get list of wikia */
function axWStatisticsWikiaInfo($city) {
    global $wgRequest, $wgUser, $wgMessageCache, $wgWikiaStatsMessages, $wgMemc, $wgContLang;
    global $wgCityId, $wgDBname, $wgLang;

	if ( $wgUser->isBlocked() ) {
		return;
	}
	
	if ($wgDBname != CENTRAL_WIKIA_ID) { 
		// central version
		$city = $wgCityId;
	}

	$usLang = $wgUser->getOption( 'language' );
	$usLang = (!empty($usLang)) ? $usLang : "en";

	$memckey = wfMemcKey("wikiastatscityinfo_".$city."_".$usLang);
	$cityinfo = $wgMemc->get($memckey);
	if (empty($cityinfo)) {
		#---
		wfLoadExtensionMessages("WikiaStats");
		$city_row = "";
		if (class_exists('WikiFactory')) {
			$city_row = WikiFactory::getWikiByID($city);
		} 
		
		$cats = array();
		if (!empty($city)) {
			$cats = WikiaGenericStats::getCategoryForCityFromDB($city);
		}
        
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"city_row"	 => $city_row,
			"user"		 => $wgUser,
			"wgContLang" => $wgContLang,
			"cats"		 => $cats,
			"city"		 => $city,
			"wgLang"	 => $wgLang,
		));
		$cityinfo = $oTmpl->execute("wikia-info");

        $wgMemc->set($memckey, $cityinfo, 60*60*3);
    }
    
    return $cityinfo;    
}

function axWStatisticsSearchWikis($search_text) {
    global $wgRequest, $wgUser, $wgMessageCache, $wgWikiaStatsMessages, $wgContLang;

	if ( $wgUser->isBlocked() ) {
		return;
	}

	wfLoadExtensionMessages("WikiaStats");
	$cities = WikiaGenericStats::getWikisListByValue($search_text);

	if (!function_exists('json_encode'))  {
		$oJson = new Services_JSON();
		return $oJson->encode($cities);
	}
	else {
		return json_encode($cities);
	}
}

function axWStatisticsPageViews($city_id = 0)
{
    global $wgRequest, $wgUser, $wgMessageCache, $wgWikiaStatsMessages;
    global $wgCityId, $wgDBname;
    
	if (empty($wgUser)) { 
		return false;
	}

	if ( $wgUser->isBlocked() ) {
		return;
	}
	
	if ($wgDBname != CENTRAL_WIKIA_ID) { 
		// central version
		$city_id = $wgCityId;
	}

	wfLoadExtensionMessages("WikiaStats");
    $aResponse = WikiaGenericStats::getWikiPageViewsCount($city_id);
    
    if (!function_exists('json_encode'))  {
        $oJson = new Services_JSON();
        return $oJson->encode($aResponse);
    }
    else {
        return json_encode($aResponse);
    }
}

global $wgAjaxExportList;
$wgAjaxExportList[] = "axWStatisticsGenerate";
$wgAjaxExportList[] = "axWStatisticsDistribEditsGenerate";
$wgAjaxExportList[] = "axWStatisticsWikiansRank";
$wgAjaxExportList[] = "axWStatisticsAnonUsers";
$wgAjaxExportList[] = "axWStatisticsArticleSize";
$wgAjaxExportList[] = "axWStatisticsNamespaceCount";
$wgAjaxExportList[] = "axWStatisticsPageEdits";
$wgAjaxExportList[] = "axWStatisticsPageEditsDetails";
$wgAjaxExportList[] = "axWStatisticsOtherNpacesPageEdits";
$wgAjaxExportList[] = "axWStatisticsWikiaList";
$wgAjaxExportList[] = "axWStatisticsWikiaListJson";
$wgAjaxExportList[] = "axWStatisticsWikiaInfo";
$wgAjaxExportList[] = "axWStatisticsSearchWikis";
$wgAjaxExportList[] = "axWStatisticsPageViews";
//xls-functions
$wgAjaxExportList[] = "axWStatisticsXLS";

