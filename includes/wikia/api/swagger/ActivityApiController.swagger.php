<?php

use Swagger\Annotations as SWG;

/**
 * @SWG\Resource(
 * 	apiVersion="0.2",
 * 	swaggerVersion="1.1",
 * 	resourcePath="ActivityApi",
 * 	basePath="http://www.wikia.com"
 * )
 * 
 * @SWG\Model( id="ActivityResponseResult" )
 * @SWG\Property(
 * 	name="items",
 * 	required="true",
 * 	type="Array",
 * 	items="$ref:ActivityResponseItem",
 * 	description="Standard container name for element collection (list)"
 * )
 * @SWG\Property(
 * 	name="basepath",
 * 	type="string",
 * 	required="true",
 * 	description="Common URL prefix for relative URLs"
 * )
 * 
 * @SWG\Model( id="ActivityResponseItem" )
 * @SWG\Property(
 * 	name="article",
 * 	type="int",
 * 	required="true",
 * 	description="The ID of the article acted upon"
 * )
 * @SWG\Property(
 * 	name="user",
 * 	type="int",
 * 	required="true",
 * 	description="The ID of the user performing the action"
 * )
 * @SWG\Property(
 * 	name="revisionId",
 * 	type="int",
 * 	required="true",
 * 	description="The ID of the revision created from this event"
 * )
 * @SWG\Property(
 * 	name="timestamp",
 * 	type="int",
 * 	required="true",
 * 	description="The Unix timestamp (in seconds) that the revision was made"
 * )
 * 
 * @SWG\Api(
 * 	path="/wikia.php?controller=ActivityApi&method=getLatestActivity",
 * 	description="Get information about the latest user activity on the current wiki",
 * 	@SWG\Operations(
 * 		@SWG\Operation(
 * 			httpMethod="GET",
 * 			summary="Get latest activity information",
 * 			nickname="getLatestActivity",
 * 			responseClass="ActivityResponseResult",
 * 			@SWG\Parameters(
 * 				@SWG\Parameter(
 * 					name="limit",
 * 					description="Maximum number of results",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="int",
 * 					defaultValue="10"
 * 				),
 * 				@SWG\Parameter(
 * 					name="namespaces",
 * 					description="Namespaces results must match",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="Array",
 * 					defaultValue="0"
 * 				),
 * 				@SWG\Parameter(
 * 					name="allowDuplicates",
 * 					description="Set if duplicate values are allowed -- otherwise they are filtered",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="boolean",
 * 					defaultValue="true"
 * 				)
 * 			)
 * 		)
 * 	)
 * )
 */

die;
