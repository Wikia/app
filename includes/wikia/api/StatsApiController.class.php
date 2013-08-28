<?php

use Swagger\Annotations as SWG;

/**
 * @SWG\Resource(
 *     apiVersion="0.2",
 *     swaggerVersion="1.1",
 *     resourcePath="StatsApi",
 *     basePath="http://muppet.wikia.com"
 * )
 */

/**
 * @SWG\Model(id="Stats")
 *		@SWG\Property(
 *         name="edits",
 *         type="int",
 *         required="true",
 *         description="Number of edits on a wiki"
 *      )
 *      @SWG\Property(
 *         name="articles",
 *         type="int",
 *         required="true",
 *         description="Number of real articles on a wiki"
 *      )
 *		@SWG\Property(
 *         name="pages",
 *         type="int",
 *         required="true",
 *         description="Number of all pages on a wiki (eg. File pages, Articles, Category pages ...)"
 *      )
 *		@SWG\Property(
 *         name="users",
 *         type="int",
 *         required="true",
 *         description="Number of all users in a wiki"
 *      )
 *		@SWG\Property(
 *         name="activeUsers",
 *         type="int",
 *         required="true",
 *         description="Number of active users on a wiki"
 *		)
 *		@SWG\Property(
 *         name="images",
 *         type="int",
 *         required="true",
 *         description="Number of all images on a wiki"
 *      )
 *		@SWG\Property(
 *         name="videos",
 *         type="int",
 *         required="true",
 *         description="Number of all videos on a wiki"
 *      )
 *		@SWG\Property(
 *         name="admins",
 *         type="int",
 *         required="true",
 *         description="Number of all admins on a wiki"
 *      )
 * )
 */

/**
 *
 * @SWG\Api(
 *     path="/wikia.php?controller=StatsApi&method=getData",
 *     description="Controller to get statistical information about the current wiki",
 *     @SWG\Operations(
 *         @SWG\Operation(
 *             httpMethod="GET",
 *             summary="Gets statistical information about the current wiki",
 *             nickname="getData",
 *             responseClass="Stats",
 *             @SWG\ErrorResponses(
 *                 @SWG\ErrorResponse( code="404", reason="Stats extension not available" )
 *             )
 *         )
 *     )
 * )
 */

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