<?php

use Swagger\Annotations as SWG;

/**
 * @SWG\Resource(
 * 	apiVersion="1",
 * 	swaggerVersion="1.1",
 * 	resourcePath="Search",
 * 	basePath="http://www.wikia.com"
 * )
 * 
 * @SWG\Model( id="localWikiSearchResult" )
 * 	@SWG\Property(
 * 		name="id",
 * 		type="int",
 * 		required="true",
 * 		description="An internal identification number for Article"
 * 	)
 * 	@SWG\Property(
 * 		name="title",
 * 		type="string",
 * 		required="true",
 * 		description="Article title"
 * 	)
 * 	@SWG\Property(
 * 		name="url",
 * 		type="string",
 * 		required="true",
 * 		description="The absolute URL of the Article"
 * 	)
 * 	@SWG\Property(
 * 		name="ns",
 * 		type="int",
 * 		required="true",
 * 		description="Page namespace number, see more: http://www.mediawiki.org/wiki/help:namespaces"
 * 	)
 * 
 * @SWG\Model( id="localWikiSearchResultSet" )
 * 	@SWG\Property(
 * 		name="total",
 * 		type="int",
 * 		required="true",
 * 		description="Total number of results"
 * 	)
 * 	@SWG\Property(
 * 		name="batches",
 * 		type="int",
 * 		required="true",
 * 		description="Number of batches (pages) of results"
 * 	)
 * 	@SWG\Property(
 * 		name="currentBatch",
 * 		type="int",
 * 		required="true",
 * 		description="The index of the current batch (page)"
 * 	)
 * 	@SWG\Property(
 * 		name="next",
 * 		type="int",
 * 		required="true",
 * 		description="The amount of items in the next batch (page)"
 * 	)
 * 	@SWG\Property(
 * 		name="items",
 * 		required="true",
 * 		type="Array",
 * 		items="$ref:localWikiSearchResult",
 * 		description="Standard container name for element collection (list)"
 * 	)
 * 
 * @SWG\Model( id="CrossWikiSearchResult" )
 * 	@SWG\Property(
 * 		name="id",
 * 		type="int",
 * 		required="true",
 * 		description="An internal identification number for Wikia"
 * 	)
 * 	@SWG\Property(
 * 		name="language",
 * 		type="string",
 * 		required="true",
 * 		description="Language of the site"
 * 	)
 * 
 * @SWG\Model( id="CrossWikiSearchResultSet" )
 * 	@SWG\Property(
 * 		name="items",
 * 		required="true",
 * 		type="Array",
 * 		items="$ref:CrossWikiSearchResult",
 * 		description="Standard container name for element collection (list)"
 * 	)
 * 
 * @SWG\Api(
 * 	path="/api/v1/Search/List",
 * 	description="Search local Wikia for given phrase. Should not be used directly on www.wikia.com.",
 * 	@SWG\Operations(
 * 		@SWG\Operation(
 * 			httpMethod="get",
 * 			summary="Do search for given phrase",
 * 			nickname="getList",
 * 			responseClass="localWikiSearchResultSet",
 * 			@SWG\ErrorResponses(
 * 				@SWG\ErrorResponse( code="400", reason="Query parameter is missing or namespaces parameter is not numeric" ),
 * 				@SWG\ErrorResponse( code="404", reason="Results not found" )
 * 			),
 * 			@SWG\Parameters(
 * 				@SWG\Parameter(
 * 					name="query",
 * 					description="The query to use for the search",
 * 					paramType="query",
 * 					required="true",
 * 					allowMultiple="false",
 * 					dataType="string",
 * 					defaultValue=""
 * 				),
 * 				@SWG\Parameter(
 * 					@SWG\AllowableValues(valueType="LIST",values="['videos']"),
 * 					name="type",
 * 					description="The search type, either articles (default) or videos. For 'videos' value, this parameter should be used with namespaces parameter (namespaces needs to be set to 6)",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="string"
 * 				),
 * 				@SWG\Parameter(
 * 					@SWG\AllowableValues(valueType="LIST",values="['newest', 'oldest', 'recently-modified', 'stable', 'most-viewed', 'freshest', 'stalest']"),
 * 					name="rank",
 * 					description="The ranking to use in fetching the list of results, one of default, newest, oldest, recently-modified, stable, most-viewed, freshest, stalest",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="string",
 * 					defaultValue=""
 * 				),
 * 				@SWG\Parameter(
 * 					name="limit",
 * 					description="The number of items per batch",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="int",
 * 					defaultValue="25"
 * 				),
 * 				@SWG\Parameter(
 * 					name="batch",
 * 					description="The batch (page) of results to fetch",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="int",
 * 					defaultValue=""
 * 				),
 * 				@SWG\Parameter(
 * 					name="namespaces",
 * 					description="Page namespace number, see more: http://www.mediawiki.org/wiki/help:namespaces",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="string",
 * 					defaultValue="0,14"
 * 				)
 * 			)
 * 		)
 * 	)
 * )
 * 
 * @SWG\Api(
 * 	path="/api/v1/Search/CrossWiki",
 * 	description="Get results for cross-wiki search for submitted query. As a result you get a list of Wikis",
 * 	@SWG\Operations(
 * 		@SWG\Operation(
 * 			httpMethod="get",
 * 			summary="Get results for cross-wiki search",
 * 			nickname="getCrossWiki",
 * 			responseClass="CrossWikiSearchResultSet",
 * 			@SWG\ErrorResponses(
 * 				@SWG\ErrorResponse( code="400", reason="Query or lang parameters missing" )
 * 			),
 * 			@SWG\Parameters(
 * 				@SWG\Parameter(
 * 					name="query",
 * 					description="The query to use for the search",
 * 					paramType="query",
 * 					required="true",
 * 					allowMultiple="false",
 * 					dataType="string",
 * 					defaultValue=""
 * 				),
 * 				@SWG\Parameter(
 * 					name="lang",
 * 					description="The two chars wiki language code, (eg.: en, de, fr)",
 * 					paramType="query",
 * 					required="true",
 * 					allowMultiple="false",
 * 					dataType="string",
 * 					defaultValue="en"
 * 				),
 * 				@SWG\Parameter(
 * 					@SWG\AllowableValues(valueType="LIST",values="['newest', 'oldest', 'recently-modified', 'stable', 'most-viewed', 'freshest', 'stalest']"),
 * 					name="rank",
 * 					description="The ranking to use in fetching the list of results, one of default, newest, oldest, recently-modified, stable, most-viewed, freshest, stalest",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="string",
 * 					defaultValue=""
 * 				),
 * 				@SWG\Parameter(
 * 					name="limit",
 * 					description="The number of items per batch (page)",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="int",
 * 					defaultValue="25"
 * 				),
 * 				@SWG\Parameter(
 * 					name="batch",
 * 					description="The batch (page) of results to fetch",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="int",
 * 					defaultValue=""
 * 				)
 * 			)
 * 		)
 * 	)
 * )
 */

die;
