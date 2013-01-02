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
		$siteStats['totalImages'] = $wikiService->getTotalImages();

		foreach($siteStats as &$stat) {
			$stat = (int) $stat;
		}

		$siteStats['topEditors'] = $wikiService->getTopEditors();

		$this->response->setVal( 'stats',  $siteStats );
	}
}