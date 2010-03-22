<?php

/*
 * Author: Tomek Odrobny
 * class for read all statistic information for home page
 */
class HomePageStatistic
{
	public static function getPagesAddedInLastHour(){
		wfProfileIn( __METHOD__ );
        $out = number_format(HomePageStatisticCollector::updatePagesAddedInLastHour());;
        wfProfileOut( __METHOD__ );          
        return $out;
	}
	
	public static function getWordsAddedLastWeek(){
		global $wgMemc;
        wfProfileIn( __METHOD__ );          

		$result = (int) (WikiaGlobalStats::countWordsInLastDays());

        wfProfileOut( __METHOD__ );          
		return number_format($result);
	}
/*	
	public static function getAddedThisMonth(){
		global $wgMemc;
		$key = wfMemcKey( "hp_stats", "added_month" );
		$result = $wgMemc->get( $key, null);

		if ($result != null){
			return number_format($result);
		}
		
		$month = date("Y-m");
		$time =  date("j") + date("H")/24;
		$result = (int) WikiaGlobalStats::getCountAverageDayCreatePages($month)*$time;
		$wgMemc->set( $key, $result, 60*60);
		return number_format($result);	
	}
*/
	public static function getEditsThisDay(){
        wfProfileIn( __METHOD__ );
        $out = number_format(WikiaGlobalStats::getCountEditedPages(1));
        wfProfileOut( __METHOD__ );          
        return $out;
	}
	
	public static function getMostEditArticles72(){
		global $wgUser;
        wfProfileIn( __METHOD__ );
		if ($wgUser->isAllowed( 'corporatepagemanager' )){
			// NOTE: If you update the values here, make sure they're still being purged
			// in extensions/wikia/WikiaStats/WikiaStatistic.php/WikiaGlobalStats::excludeArticle
			$out = WikiaGlobalStats::getPagesEditors(3, 10,true,true);
		} else {
			$out = WikiaGlobalStats::getPagesEditors(3);
		}
		$level = 1;
		$outLevel = 1;
		foreach ($out as $key => $value){
			$out[$key]['level'] = $outLevel;
			$out[$key]['real_pagename'] = $out[$key]['page_name'];
			$out[$key]['page_name'] = urldecode( str_replace('_' ,' ' , $out[$key]['page_name']) );
			if ( empty($out[$key]['out_of_limit'] )){
				$level ++;
				if ($out[$key]['count'] != $out[$key+1]['count']){
					$outLevel = $level;
				}
			} else {
				$out[$key]['level'] = 'x';
			}
		}         
        wfProfileOut( __METHOD__ );          
		return $out;      			
	}
	
	/*
	public static function getTopWikis($hub,$count = 20){
		WikiaHubStats::newFromHub('Humor')->getTopPVWikis() 
		return null;
	} */
}
