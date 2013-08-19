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
 * @SWG\Api(
 *   path="",
 *   description="Controller for acquiring information about latest user activity on current wiki",
 *	@SWG\Operations(
 *		@SWG\Operation( httpMethod="GET", summary="Fetches latest activity information", nickname="getLatestActivity",
 * 			@SWG\Parameters(
 * 				@SWG\Parameter( name="controller", description="Controller used", paramType="query", required="true", allowMultiple="false", dataType="string", defaultValue="ActivityApi" ),
 * 				@SWG\Parameter( name="method", description="Method used", paramType="query", required="true", allowMultiple="false", dataType="string", defaultValue="getLatestActivity" ),
 * 				@SWG\Parameter( name="limit", description="Maximal result count", paramType="query", required="false", allowMultiple="false", dataType="int", defaultValue="10" ),
 * 				@SWG\Parameter( name="namespaces", description="Namespaces filtering", paramType="query", required="false", allowMultiple="false", dataType="Array", defaultValue="0" ),
 * 				@SWG\Parameter( name="allowDuplicates", description="Set if duplicate values are allowed", paramType="query", required="false", allowMultiple="false", dataType="boolean", defaultValue="true" )
 * 			)
 *		)
 *	)
 * )
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
