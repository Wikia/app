<?php

use Swagger\Annotations as SWG;

/**
 * @SWG\Resource(
 *     apiVersion="0.2",
 *     swaggerVersion="1.1",
 *     resourcePath="ActivityApi",
 *     basePath="http://www.wikia.com/wikia.php"
 * )
 */

/**
 * 
 * @SWG\Model( id="ActivityResponseResult" )
 *     @SWG\Property(
 *         name="items",
 *         required="true",
 *         type="ActivityResponseItem",
 *         description="A list of each individual event, ordered by recency descending."
 *         )
 *      @SWG\Property(
 *          name="basepath",
 *          type="string",
 *          required="true",
 *          description="The base path of the request made. Used to confirm the origin of the response."
 *          )
 * 
 * @SWG\Model( id="ActivityResponseItem" )
 *     @SWG\Property( 
 *         name="article", 
 *         type="int", 
 *         required="true",
 *         description="The ID of the article acted upon" 
 *         )
 *     @SWG\Property( 
 *         name="user", 
 *         type="int", 
 *         required="true",
 *         description="The ID of the user performing the action" 
 *         )
 *     @SWG\Property( 
 *         name="revisionId", 
 *         type="int", 
 *         required="true",
 *         description="The ID of the revision created from this event" 
 *         )
 *     @SWG\Property( 
 *         name="timestamp", 
 *         type="int", 
 *         required="true",
 *         description="The Unix timestamp (in seconds) that the revision was made" 
 *         )
 *
 * @SWG\Api(
 *     path="/wikia.php?controller=ActivityApi&method=getLatestActivity",
 *     description="Acquire information about the latest user activity on the current wiki.",
 *     @SWG\Operations(
 *         @SWG\Operation( 
 *             httpMethod="GET", 
 *             summary="Fetches latest activity information", 
 *             nickname="getLatestActivity", 
 *             responseClass="ActivityResponseResult",
 *             @SWG\Parameters(
 *                 @SWG\Parameter( 
 *                                name="controller", 
 *                                description="Controller used", 
 *                                paramType="query", 
 *                                required="true", 
 *                                allowMultiple="false", 
 *                                dataType="string", 
 *                                defaultValue="ActivityApi" ),
 *                 @SWG\Parameter(
 *                                name="method", 
 *                                description="Method used", 
 *                                paramType="query", 
 *                                required="true", 
 *                                allowMultiple="false", 
 *                                dataType="string", 
 *                                defaultValue="getLatestActivity" 
 *                                ),
 *                 @SWG\Parameter(
 *                                name="limit", 
 *                                description="Maximum number of results", 
 *                                paramType="query", 
 *                                required="false", 
 *                                allowMultiple="false", 
 *                                dataType="int", 
 *                                defaultValue="10" 
 *                                ),
 *                 @SWG\Parameter(
 *                                name="namespaces", 
 *                                description="Namespaces results must match", 
 *                                paramType="query", 
 *                                required="false", 
 *                                allowMultiple="false", 
 *                                dataType="Array", 
 *                                defaultValue="0" 
 *                                ),
 *                 @SWG\Parameter( 
 *                                name="allowDuplicates", 
 *                                description="Set if duplicate values are allowed -- otherwise they are filtered", 
 *                                paramType="query", 
 *                                required="false", 
 *                                allowMultiple="false", 
 *                                dataType="boolean", 
 *                                defaultValue="true" 
 *                                )
 *                 )
 *             )
 *         )
 *     )
 */


class ActivityApiController extends WikiaApiController {
	private $revisionService;

	function __construct( $revisionService = null ) {
		if( $revisionService == null ) {
			$revisionService = new RevisionService();
		}
		$this->revisionService = $revisionService;
	}

	/**
	 * Fetches latest activity information
	 *
	 * @requestParam int  $limit [OPTIONAL] maximal result count
	 * @requestParam array $namespaces [OPTIONAL] [0] by default
	 * @requestParam bool $allowDuplicates [OPTIONAL] 1 by default
	 *
	 * @responseParam array latest revision information
	 *
	 * @example
	 * @example &allowDuplicates=1
	 * @example &allowDuplicates=0
	 * @example &namespaces=0,14&allowDuplicates=0&limit=20
	 */
	public function getLatestActivity() {
		$limit = $this->getRequest()->getInt("limit", 10);
		$namespaces = $this->getRequest()->getArray("namespaces", array("0"));
		$allowDuplicates = $this->getRequest()->getBool("allowDuplicates", true);

		$items = $this->revisionService->getLatestRevisions($limit, $namespaces, $allowDuplicates);

		$this->setVal( 'items', $items );
		$this->response->setVal( 'basepath', $this->wg->Server );
	}
}
