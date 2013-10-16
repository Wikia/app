<?php

	/**
	 * Controller to fetch various stats info about the current wiki
	 *
	 * @author Jakub Olek <jolek@wikia-inc.com>
	 */

class StatsApiController extends WikiaApiController {

	const CACHE_VALIDITY = 10800; //3 hours

	/**
	 * Get statistical information about the current wiki [DEPRECATED]
	 *
	 * @responseParam Integer $edits Number of edits on a wiki
	 * @responseParam Integer $articles Number of real articles on a wiki
	 * @responseParam Integer $pages Number of all pages on a wiki (eg. File pages, Articles, Category pages ...)
	 * @responseParam Integer $users Stats Number of all users in a wiki
	 * @responseParam Integer $activeUsers Number of active users on a wiki
	 * @responseParam Integer $images Number of all images on a wiki
	 * @responseParam Integer $videos Number of all videos on a wiki
	 * @responseParam Integer $admins Number of all admins on a wiki
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

		$this->response->setValues( $siteStats );
	}
}