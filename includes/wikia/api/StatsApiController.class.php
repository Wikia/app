<?php
	/**
	 * Controller to fetch various stats info
	 *
	 * @author Jakub Olek <jolek@wikia-inc.com>
	 */

class StatsApiController extends WikiaApiController {

	const CACHE_VERSION = 0;

	/**
	 * Get stats about wiki
	 *
	 * @responseParam $stats Stats
	 *
	 * @example
	 */
	function getData() {
		$wikiService = new WikiService();

		$siteStats = $wikiService->getSiteStats();
		$siteStats['videos'] = $wikiService->getTotalVideos();

		//lets return always integer for consistency
		foreach( $siteStats as &$stat ) {
			$stat = (int) $stat;
		}

		$siteStats['views'] = [
			'monthly' => DataMartService::getPageviewsMonthly( date( 'Y-m-d', strtotime('-1 month') ) ),
			'weekly' => DataMartService::getPageviewsWeekly( date( 'Y-m-d', strtotime('-1 week') ) ),
			'daily' => DataMartService::getPageviewsDaily( date( 'Y-m-d', strtotime('-1 day') ) )
		];

		$siteStats['admins'] = count( $wikiService->getWikiAdminIds() );

		$this->response->setVal( 'stats',  $siteStats );
	}
}