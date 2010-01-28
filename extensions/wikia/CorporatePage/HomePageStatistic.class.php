<?php

/*
 * Author: Tomek Odrobny
 * class for read all statistic information for home page
 */
class HomePageStatistic
{
	public static function getWordsInLastHour(){
		return number_format(HomePageStatisticCollector::updateWordsInLastHour());
	}
	
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

	public static function getEditsThisWeek(){
		return number_format(WikiaGlobalStats::getCountEditedPages(60*60));
	}
	
	public static function getMostEditArticles72(){
		global $wgUser;
		if ($wgUser->isAllowed( 'corporatepagemanager' )){
			$out = WikiaGlobalStats::getPagesEditors(7, 10);
		} else {
			$out = WikiaGlobalStats::getPagesEditors();
		}
		$level = 1;
		foreach ($out as $key => $value){
			$out[$key]['level'] = $level;
			$out[$key]['page_name'] = str_replace('_' ,' ' , $out[$key]['page_name']);
			if ($out[$key]['count'] != $out[$key+1]['count']){
				$level ++;
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
?>