<?php
	/**
	 * Controller to fetch various stats info
	 *
	 * @author Jakub Olek <jolek@wikia-inc.com>
	 */

class StatsApiController extends WikiaApiController {

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

		//views are empty anyway...
		unset( $siteStats['views'] );

		//lets return always integers for consistency
		foreach( $siteStats as &$stat ) {
			$stat = (int) $stat;
		}

		$siteStats['admins'] = count( $wikiService->getWikiAdminIds() );

		$this->response->setVal( 'stats',  $siteStats );
	}
}