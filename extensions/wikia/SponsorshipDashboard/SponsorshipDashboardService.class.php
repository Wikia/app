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
		$wgStatsDBEnabled = F::app()->getGlobal('wgStatsDBEnabled');	
			
		return ( $isDevBox )
			? F::app()->getGlobal( 'wgExternalDatawareDB' )
			: ( ( empty( $wgStatsDBEnabled ) ) ? null : F::app()->getGlobal( 'wgStatsDB' ) ) ;
	}
}
