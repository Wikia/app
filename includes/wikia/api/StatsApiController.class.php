<?php
	/**
	 * Controller to fetch various stats info about the current wiki
	 *
	 * @author Jakub Olek <jolek@wikia-inc.com>
	 */

class StatsApiController extends WikiaApiController {

	const CACHE_VALIDITY = 10800; //3 hours

	/**
	 * Get statistical information about the current wiki
	 *
	 * @responseParam object stats Stats about wiki edits | articles | pages | users | activeUsers | images | videos | admins
	 *
	 * @example
	 */
	function getData() {
		$this->response->setCacheValidity(
			self::CACHE_VALIDITY,
			self::CACHE_VALIDITY,
			array(
				WikiaResponse::CACHE_TARGET_BROWSER,
				WikiaResponse::CACHE_TARGET_VARNISH
			)
		);

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

		$this->response->setVal( 'items',  $siteStats );
	}
}