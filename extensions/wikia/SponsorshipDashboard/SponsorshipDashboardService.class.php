<?php

/**
 * Category service
 * @author Jakub Kurcek
 */
class SponsorshipDashboardService extends Service {

	const SD_RETURNPARAM_TICKS = 'ticks';
	const SD_RETURNPARAM_FULL_TICKS = 'fullTicks';
	const SD_RETURNPARAM_SERIE = 'serie';
	const SD_GAPI_RETRIES = 4;

	static function getDatabase(){

		$isDevBox = F::app()->getGlobal( 'wgDevEnvironment' );
		return ( $isDevBox )
			? F::app()->getGlobal( 'wgExternalDatawareDB' )
			: F::app()->getGlobal( 'wgStatsDB' );
	}

//	public function getPopularHubs(){
//
//		global $wgHubsPages;
//
//		$wgCityId = WF::build( 'App' )->getGlobal( 'wgCityId' );
//
//		if ( !empty( $this->aCityHubs ) ){
//			return $this->aCityHubs;
//		}
//
//		$wikiFactoryTags = new WikiFactoryTags( $wgCityId );
//		$cityTags = $wikiFactoryTags->getTags();
//
//		if ( empty( $cityTags ) ){
//			Wikia::log( __METHOD__ , false, "City [{$wgCityId}] has no tags" );
//			return array();
//		}
//
//		$popularCityHubs = array();
//		foreach( $wgHubsPages['en'] as $hubs_key=>$hubsPages ){
//			foreach( $cityTags as $key => $val ){
//				$hubName = is_array($hubsPages) ? $hubsPages['name'] : $hubsPages;
//				if ( $hubName == $val ){
//					$popularCityHubs[$val] = $key;
//				}
//			}
//		}
//		$this->aCityHubs = $popularCityHubs;
//		return $popularCityHubs;
//	}

}
