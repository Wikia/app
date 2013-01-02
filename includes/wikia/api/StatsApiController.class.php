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


		$this->response->setVal( 'stats', (new WikiService())->getSiteStats() );
	}
}