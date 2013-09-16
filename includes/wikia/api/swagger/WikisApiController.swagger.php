<?php

use Swagger\Annotations as SWG;

/**
 * @SWG\Resource(
 * 	apiVersion="1",
 * 	swaggerVersion="1.1",
 * 	resourcePath="WikisApi",
 * 	basePath="http://www.wikia.com"
 * )
 * 
 * @SWG\Model( id="WikiaDetailsResultSet" )
 * 	@SWG\Property(
 * 		name="items",
 * 		type="Array",
 * 		items="$ref:ExpandedWikiaItem",
 * 		required="true",
 * 		description="Standard container name for element collection (list)"
 * 	)
 * 
 * @SWG\Model( id="UnexpandedWikiaResultSet" )
 * 	@SWG\Property(
 * 		name="items",
 * 		type="Array",
 * 		items="$ref:UnexpandedWikiaItem",
 * 		required="true",
 * 		description="Standard container name for element collection (list)"
 * 	)
 * 	@SWG\Property(
 * 		name="next",
 * 		type="int",
 * 		required="true",
 * 		description="Number of elements in next batch"
 * 	)
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
 * 		description="Total number of batches"
 * 	)
 * 	@SWG\Property(
 * 		name="currentBatch",
 * 		type="int",
 * 		required="true",
 * 		description="Current batch number"
 * 	)
 *
 * @SWG\Model( id="UnexpandedWikiaItem" )
 * 	@SWG\Property(
 * 		name="id",
 * 		type="int",
 * 		required="true",
 * 		description="An internal identification number for Wikia"
 * 	)
 * 	@SWG\Property(
 * 		name="name",
 * 		type="string",
 * 		required="true",
 * 		description="Wikia name"
 * 	)
 * 	@SWG\Property(
 * 		name="hub",
 * 		type="string",
 * 		required="true",
 * 		description="Hub to which wikia belongs"
 * 	)
 * 	@SWG\Property(
 * 		name="language",
 * 		type="string",
 * 		required="true",
 * 		description="Wikia language"
 * 	)
 * 	@SWG\Property(
 * 		name="topic",
 * 		type="string",
 * 		required="true",
 * 		description="Topics describing Wikia content"
 * 	)
 * 	@SWG\Property(
 * 		name="domain",
 * 		type="string",
 * 		required="true",
 * 		description="The absolute URL of the Wikia domain"
 * 	)
 *
 * @SWG\Model( id="ExpandedWikiaResultSet" )
 * 	@SWG\Property(
 * 		name="items",
 * 		type="Array",
 * 		items="$ref:ExpandedWikiaItem",
 * 		required="true",
 * 		description="Standard container name for element collection (list)"
 * 	)
 * 	@SWG\Property(
 * 		name="next",
 * 		type="int",
 * 		required="true",
 * 		description="Number of elements in next batch"
 * 	)
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
 * 		description="Total number of batches"
 * 	)
 * 	@SWG\Property(
 * 		name="currentBatch",
 * 		type="int",
 * 		required="true",
 * 		description="Current batch number"
 * 	)
 *
 * @SWG\Model( id="ExpandedWikiaItem" )
 * 	@SWG\Property(
 * 		name="id",
 * 		type="int",
 * 		required="true",
 * 		description="An internal identification number for Wikia"
 * 	)
 * 	@SWG\Property(
 * 		name="name",
 * 		type="string",
 * 		required="true",
 * 		description="Wikia name"
 * 	)
 * 	@SWG\Property(
 * 		name="hub",
 * 		type="string",
 * 		required="true",
 * 		description="Hub to which wikia belongs"
 * 	)
 * 	@SWG\Property(
 * 		name="language",
 * 		type="string",
 * 		required="true",
 * 		description="Wikia language"
 * 	)
 * 	@SWG\Property(
 * 		name="topic",
 * 		type="string",
 * 		required="true",
 * 		description="Topics describing Wikia content"
 * 	)
 * 	@SWG\Property(
 * 		name="domain",
 * 		type="string",
 * 		required="true",
 * 		description="The absolute URL of the Wikia domain"
 * 	)
 * 	@SWG\Property(
 * 		name="title",
 * 		type="string",
 * 		required="true",
 * 		description="Wikia title"
 * 	)
 * 	@SWG\Property(
 * 		name="url",
 * 		type="string",
 * 		required="true",
 * 		description="The absolute URL of the Wikia"
 * 	)
 * 	@SWG\Property(
 * 		name="stats",
 * 		type="WikiaStats",
 * 		required="true",
 * 		description="Wikia title"
 * 	)
 * 	@SWG\Property(
 * 		name="topUsers",
 * 		type="Array",
 * 		required="true",
 * 		description="Array with ten top contributors"
 * 	)
 * 	@SWG\Property(
 * 		name="headline",
 * 		type="string",
 * 		required="true",
 * 		description="Wikia headline"
 * 	)
 * 	@SWG\Property(
 * 		name="flags",
 * 		type="Array",
 * 		required="true",
 * 		description="Array with flags"
 * 	)
 * 	@SWG\Property(
 * 		name="desc",
 * 		type="string",
 * 		required="true",
 * 		description="Description about Wikia content"
 * 	)
 * 	@SWG\Property(
 * 		name="image",
 * 		type="string",
 * 		required="true",
 * 		description="The absolute URL of the Wikia image"
 * 	)
 * 	@SWG\Property(
 * 		name="original_dimensions",
 * 		type="ImageDimensions",
 * 		required="true",
 * 		description="Object containing original image dimensions"
 * 	)
 * 
 * @SWG\Model( id="WikiaStats" )
 * 	@SWG\Property(
 * 		name="edits",
 * 		type="int",
 * 		required="true",
 * 		description="Number of total edits for Wikia"
 * 	)
 * 	@SWG\Property(
 * 		name="articles",
 * 		type="int",
 * 		required="true",
 * 		description="Number of total articles on Wikia"
 * 	)
 * 	@SWG\Property(
 * 		name="pages",
 * 		type="int",
 * 		required="true",
 * 		description="Number of total pages on Wikia"
 * 	)
 * 	@SWG\Property(
 * 		name="users",
 * 		type="int",
 * 		required="true",
 * 		description="Number of total users on Wikia"
 * 	)
 * 	@SWG\Property(
 * 		name="activeUsers",
 * 		type="int",
 * 		required="true",
 * 		description="Number of total active users on Wikia"
 * 	)
 * 	@SWG\Property(
 * 		name="images",
 * 		type="int",
 * 		required="true",
 * 		description="Number of total images on Wikia"
 * 	)
 * 	@SWG\Property(
 * 		name="videos",
 * 		type="int",
 * 		required="true",
 * 		description="Number of total videos on Wikia"
 * 	)
 * 	@SWG\Property(
 * 		name="admins",
 * 		type="int",
 * 		required="true",
 * 		description="Number of total admins on Wikia"
 * 	)
 * 
 * @SWG\Model( id="ImageDimensions" )
 * 	@SWG\Property(
 * 		name="width",
 * 		type="int",
 * 		required="true",
 * 		description="Original image width"
 * 	)
 * 	@SWG\Property(
 * 		name="height",
 * 		type="int",
 * 		required="true",
 * 		description="Original image height"
 * 	)
 * 
 * @SWG\Api(
 * 	path="/wikia.php?controller=WikisApi&method=getList",
 * 	description="Get the top wikis by pageviews",
 * 	@SWG\Operations(
 * 		@SWG\Operation(
 * 			httpMethod="GET",
 * 			summary="Get the top wikis by pageviews",
 * 			nickname="getList",
 * 			responseClass="UnexpandedWikiaResultSet",
 * 			@SWG\ErrorResponses(
 * 				@SWG\ErrorResponse( code="400", reason="Number of languages exceeded" )
 * 			),
 * 			@SWG\Parameters(
 * 				@SWG\Parameter(
 * 					name="hub",
 * 					description="The name of the vertical (e.g. Gaming, Entertainment, Lifestyle, etc.) to use as a filter",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="string"
 * 				),
 * 				@SWG\Parameter(
 * 					name="lang",
 * 					description="The comma-separated list of language codes (e.g. en,de,fr,es,it, etc.) to use as a filter",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="true",
 * 					dataType="Array"
 * 				),
 * 				@SWG\Parameter(
 * 					name="limit",
 * 					description="The maximum number of results to fetch",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="Array",
 * 					defaultValue="25"
 * 				),
 * 				@SWG\Parameter(
 * 					name="batch",
 * 					description="The batch/page index to retrieve",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="Array",
 * 					defaultValue="1"
 * 				)
 * 			)
 * 		)
 * 	)
 * )
 * 
 * @SWG\Api(
 * 	path="/wikia.php?controller=WikisApi&method=getList&expand=1",
 * 	description="Get the top wikis by pageviews (extended response)",
 * 	@SWG\Operations(
 * 		@SWG\Operation(
 * 			httpMethod="GET",
 * 			summary="Get the top wikis by pageviews (extended response)",
 * 			nickname="getList",
 * 			responseClass="ExpandedWikiaResultSet",
 * 			@SWG\ErrorResponses(
 * 				@SWG\ErrorResponse( code="400", reason="Number of languages exceeded" )
 * 			),
 * 			@SWG\Parameters(
 * 				@SWG\Parameter(
 * 					name="hub",
 * 					description="The name of the vertical (e.g. Gaming, Entertainment, Lifestyle, etc.) to use as a filter",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="string"
 * 				),
 * 				@SWG\Parameter(
 * 					name="lang",
 * 					description="The comma-separated list of language codes (e.g. en,de,fr,es,it, etc.) to use as a filter",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="true",
 * 					dataType="Array"
 * 				),
 * 				@SWG\Parameter(
 * 					name="limit",
 * 					description="The maximum number of results to fetch",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="Array",
 * 					defaultValue="25"
 * 				),
 * 				@SWG\Parameter(
 * 					name="batch",
 * 					description="The batch/page index to retrieve",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="Array",
 * 					defaultValue="1"
 * 				)
 * 			)
 * 		)
 * 	)
 * )
 * 
 * @SWG\Api(
 * 	path="/wikia.php?controller=WikisApi&method=getByString",
 * 	description="Get wikis which name or topic match a keyword",
 * 	@SWG\Operations(
 * 		@SWG\Operation(
 * 			httpMethod="GET",
 * 			summary="Get wikis which name or topic match a keyword",
 * 			nickname="getByString",
 * 			responseClass="UnexpandedWikiaResultSet",
 * 			@SWG\ErrorResponses(
 * 				@SWG\ErrorResponse( code="400", reason="Number of languages exceeded or keyword is missing" ),
 * 				@SWG\ErrorResponse( code="404", reason="Results not found" )
 * 			),
 * 			@SWG\Parameters(
 * 				@SWG\Parameter(
 * 					name="string",
 * 					description="Search term",
 * 					paramType="query",
 * 					required="true",
 * 					allowMultiple="false",
 * 					dataType="string"
 * 				),
 * 				@SWG\Parameter(
 * 					name="hub",
 * 					description="The name of the vertical (e.g. Gaming, Entertainment, Lifestyle, etc.) to use as a filter",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="string"
 * 				),
 * 				@SWG\Parameter(
 * 					name="lang",
 * 					description="The comma-separated list of language codes (e.g. en,de,fr,es,it, etc.) to use as a filter",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="true",
 * 					dataType="Array"
 * 				),
 * 				@SWG\Parameter(
 * 					name="limit",
 * 					description="The maximum number of results to fetch",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="Array",
 * 					defaultValue="25"
 * 				),
 * 				@SWG\Parameter(
 * 					name="batch",
 * 					description="The batch/page index to retrieve",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="Array",
 * 					defaultValue="1"
 * 				),
 * 				@SWG\Parameter(
 * 					name="includeDomain",
 * 					description="Whether to include wikis' domains as search targets or not",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="boolean",
 * 					defaultValue="false"
 * 				)
 * 			)
 * 		)
 * 	)
 * )
 * 
 * @SWG\Api(
 * 	path="/wikia.php?controller=WikisApi&method=getByString&expand=1",
 * 	description="Get wikis which name or topic match a keyword (extended version)",
 * 	@SWG\Operations(
 * 		@SWG\Operation(
 * 			httpMethod="GET",
 * 			summary="Get wikis which name or topic match a keyword (extended response)",
 * 			nickname="getByString",
 * 			responseClass="ExpandedWikiaResultSet",
 * 			@SWG\ErrorResponses(
 * 				@SWG\ErrorResponse( code="400", reason="Number of languages exceeded or keyword is missing" ),
 * 				@SWG\ErrorResponse( code="404", reason="Results not found" )
 * 			),
 * 			@SWG\Parameters(
 * 				@SWG\Parameter(
 * 					name="string",
 * 					description="Search term",
 * 					paramType="query",
 * 					required="true",
 * 					allowMultiple="false",
 * 					dataType="string"
 * 				),
 * 				@SWG\Parameter(
 * 					name="hub",
 * 					description="The name of the vertical (e.g. Gaming, Entertainment, Lifestyle, etc.) to use as a filter",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="string"
 * 				),
 * 				@SWG\Parameter(
 * 					name="lang",
 * 					description="The comma-separated list of language codes (e.g. en,de,fr,es,it, etc.) to use as a filter",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="true",
 * 					dataType="Array"
 * 				),
 * 				@SWG\Parameter(
 * 					name="limit",
 * 					description="The maximum number of results to fetch",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="Array",
 * 					defaultValue="25"
 * 				),
 * 				@SWG\Parameter(
 * 					name="batch",
 * 					description="The batch/page index to retrieve",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="Array",
 * 					defaultValue="1"
 * 				),
 * 				@SWG\Parameter(
 * 					name="includeDomain",
 * 					description="Whether to include wikis' domains as search targets or not",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="boolean",
 * 					defaultValue="false"
 * 				)
 * 			)
 * 		)
 * 	)
 * )
 * 
 * @SWG\Api(
 * 	path="/wikia.php?controller=WikisApi&method=getDetails",
 * 	description="Get information about wikis",
 * 	@SWG\Operations(
 * 		@SWG\Operation(
 * 			httpMethod="GET",
 * 			summary="Get information about wikis",
 * 			nickname="getDetails",
 * 			responseClass="WikiaDetailsResultSet",
 * 			@SWG\ErrorResponses(
 * 				@SWG\ErrorResponse( code="400", reason="Ids parameter is missing" )
 * 			),
 * 			@SWG\Parameters(
 * 				@SWG\Parameter(
 * 					name="ids",
 * 					description="The list of wiki ids that will be fetched",
 * 					paramType="query",
 * 					required="true",
 * 					allowMultiple="true",
 * 					dataType="Array"
 * 				),
 * 				@SWG\Parameter(
 * 					name="height",
 * 					description="Thumbnail height in pixels",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="int"
 * 				),
 * 				@SWG\Parameter(
 * 					name="width",
 * 					description="Thumbnail width in pixels",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="int"
 * 				),
 * 				@SWG\Parameter(
 * 					name="snippet",
 * 					description="Maximum number of words returned in description",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="int"
 * 				)
 * 			)
 * 		)
 * 	)
 * )
 */

die;
