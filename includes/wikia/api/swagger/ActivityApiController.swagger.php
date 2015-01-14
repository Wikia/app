<?php

use Swagger\Annotations as SWG;

/**
 * @SWG\Resource(
 * 	apiVersion="1",
 * 	swaggerVersion="1.1",
 * 	resourcePath="Activity",
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
 * 	path="/Activity/LatestActivity",
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
 * 					description="Limit the number of results",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="int",
 * 					defaultValue="10"
 * 				),
 * 				@SWG\Parameter(
 * 					name="namespaces",
 * 					description="Comma-separated namespace ids, see more: http://community.wikia.com/wiki/Help:Namespaces",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="Array",
 * 					defaultValue="0"
 * 				),
 * 				@SWG\Parameter(
 * 					name="allowDuplicates",
 * 					description="Set if duplicate values of an article's revisions made by the same user are not allowed",
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
 * @SWG\Api(
 * 	path="/Activity/RecentlyChangedArticles",
 * 	description="Get information about recently changed articles on the current wiki",
 * 	@SWG\Operations(
 * 		@SWG\Operation(
 * 			httpMethod="GET",
 * 			summary="Get recently changed articles",
 * 			nickname="getRecentlyChangedArticles",
 * 			responseClass="ActivityResponseResult",
 * 			@SWG\Parameters(
 * 				@SWG\Parameter(
 * 					name="limit",
 * 					description="Limit the number of results",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="int",
 * 					defaultValue="10"
 * 				),
 * 				@SWG\Parameter(
 * 					name="namespaces",
 * 					description="Comma-separated namespace ids, see more: http://community.wikia.com/wiki/Help:Namespaces",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="Array",
 * 					defaultValue="0"
 * 				),
 * 				@SWG\Parameter(
 * 					name="allowDuplicates",
 * 					description="Set if duplicates of articles are not allowed",
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
