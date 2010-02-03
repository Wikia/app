<?php

/*
 * Author: Tomek Odrobny
 * class for read all statistic information for home page
 */
class HomePageStatistic
{
	public static function getPagesAddedInLastHour(){
		return number_format(HomePageStatisticCollector::updatePagesAddedInLastHour());
	}
	
	public static function getWordsAddedLastWeek(){
		global $wgMemc;
		$key = wfMemcKey( "hp_stats", "words_added_week" );
		$result = $wgMemc->get( $key, null);

		if ($result != null){
			return number_format($result);
		}
		
		$months = array(); 
		$thisMonth =  date('Y-m',strtotime($i.'-1 day'));
		for ($i = -1; $i >= -6; $i-- ){
			$time = strtotime($i.' day');
			$month = date('Y-m', $time);
			$months[$month]['count'] ++;
			if (empty($months[$month]['number_of_day'])){
				if ( $thisMonth == $month ){
					$months[$month]['number_of_day'] = date('j', $time);	
				} else {
					$months[$month]['number_of_day'] = date('t', $time);	
				}
			}
			if ( $i == -1 ){
				$months[$month]['count'] += date('G')/24;
			}
		}
		$result = 0;
		foreach ( $months as $key => $value ){
			$factor = $value['count']/$value['number_of_day'];
			$result += (int) (WikiaGlobalStats::getCountWordsInMonth($key)*$factor);
		}
		$wgMemc->set( $key, $result, 60*60);
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
		return number_format(WikiaGlobalStats::getCountEditedPages(1));
	}
	
	public static function getMostEditArticles72(){
		global $wgUser;
		if ($wgUser->isAllowed( 'corporatepagemanager' )){
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
		return $out;      			
	}
	
	/*
	public static function getTopWikis($hub,$count = 20){
		WikiaHubStats::newFromHub('Humor')->getTopPVWikis() 
		return null;
	} */
}
