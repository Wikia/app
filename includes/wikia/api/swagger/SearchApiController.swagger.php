<?php

use Swagger\Annotations as SWG;

/**
 *	@swg\Resource(
 *		apiVersion="0.2",
 *		swaggerVersion="1.1",
 *		resourcePath="SearchApi",
 *		basePath="http://www.wikia.com"
 *	)
 *
 *	@swg\Model( id="localWikiSearchResult" )
 *		@swg\Property(
 *			name="id",
 *			type="int",
 *			required="true",
 *			description="An internal identification number for Article"
 *		)
 *		@swg\Property(
 *			name="title",
 *			type="string",
 *			required="true",
 *			description="Article title"
 *		)
 *		@swg\Property(
 *			name="url",
 *			type="string",
 *			required="true",
 *			description="Absolute url for given article"
 *		)
 *		@swg\Property(
 *			name="ns",
 *			type="int",
 *			required="true",
 *			description="Article namespace number. example namespaces: 0 - main ns (regular articles), 1 - main ns user talk pages, user page - 2, user talk - 3, files (images,movies) - 6, help - 12, category - 14. see more: http://www.mediawiki.org/wiki/help:namespaces "
 *		)
 *
 *		@swg\Model( id="localWikiSearchResultSet" )
 *			@swg\Property(
 *				name="total",
 *				type="int",
 *				required="true",
 *				description="Total number of results"
 *			)
 *			@swg\Property(
 *				name="batches",
 *				type="int",
 *				required="true",
 *				description="Number of batches (pages) of results"
 *			)
 *  		@swg\Property(
 *				name="currentBatch",
 *				type="int",
 *				required="true",
 *				description="The index of the current batch (page)"
 *			)
 *			@swg\Property(
 *				name="next",
 *				type="int",
 *				required="true",
 *				description="The amount of items in the next batch (page)"
 *			)
 *			@swg\Property(
 *				name="items",
 *				required="true",
 *				type="Array",
 *				items="$ref:localWikiSearchResult",
 *				description="Standard container name for element collection (list)"
 *			)
 *
 *	@swg\Api(
 *		path="/wikia.php?controller=SearchApi&method=getList",
 *		description="search local wikia for given phrase. should not be used directly on www.wikia.com. use on specific wikia instead. for example muppets.wikia.com",
 *		@swg\Operations(
 *			@swg\Operation(
 *				httpMethod="get",
 *				summary="Do search for given phrase",
 *				nickname="getList",
 *				responseClass="localWikiSearchResultSet",
 *				@swg\ErrorResponses(
 *					@swg\ErrorResponse( code="400", reason="invalid parameters" ),
 *					@swg\ErrorResponse( code="404", reason="results not found" )
 *				),
 *				@swg\Parameters(
 *					@swg\Parameter(
 *						name="query",
 *						description="The query to use for the search",
 *						paramType="query",
 *						required="true",
 *						allowMultiple="false",
 *						dataType="string",
 *						defaultValue=""
 *					),
 *					@swg\Parameter(
 *						@SWG\AllowableValues(valueType="LIST",values="['videos']"),
 *						name="type",
 *						description="The search type, either articles (default) or videos. For 'videos' value, this parameter should be used with namespaces parameter (namespaces needs to be set to 6)",
 *						paramType="query",
 *						required="false",
 *						allowMultiple="false",
 *						dataType="string"
 *					),
 *					@swg\Parameter(
 * 						@SWG\AllowableValues(valueType="LIST",values="['newest', 'oldest', 'recently-modified', 'stable', 'most-viewed', 'freshest', 'stalest']"),
 *						name="rank",
 *						description="The ranking to use in fetching the list of results, one of default, newest, oldest, recently-modified, stable, most-viewed, freshest, stalest",
 *						paramType="query",
 *						required="false",
 *						allowMultiple="false",
 *						dataType="string",
 *						defaultValue=""
 *					),
 *					@swg\Parameter(
 *						name="limit",
 *						description="The number of items per batch",
 *						paramType="query",
 *						required="false",
 *						allowMultiple="false",
 *						dataType="int",
 *						defaultValue="25"
 *					),
 *					@swg\Parameter(
 *						name="batch",
 *						description="The batch (page) of results to fetch",
 *						paramType="query",
 *						required="false",
 *						allowMultiple="false",
 *						dataType="int",
 *						defaultValue=""
 *					),
 *					@swg\Parameter(
 *						name="namespaces",
 *						description="A comma-separated list of namespaces to restrict the results (e.g. 0, 6, 14)",
 *						paramType="query",
 *						required="false",
 *						allowMultiple="false",
 *						dataType="string",
 *						defaultValue="0,14"
 *					)
 *				)
 *			)
 *		)
 * )
 *
 *
 *
 *
 *	@swg\Model( id="CrossWikiSearchResult" )
 *		@swg\Property(
 *			name="id",
 *			type="int",
 *			required="true",
 *			description="An internal identification number for Wikia"
 *		)
 *		@swg\Property(
 *			name="language",
 *			type="string",
 *			required="true",
 *			description="Language of the site"
 *		)
 *
 *	@swg\Model( id="CrossWikiSearchResultSet" )
 *		@swg\Property(
 *			name="items",
 *			required="true",
 *			type="Array",
 *			items="$ref:CrossWikiSearchResult",
 *			description="Standard container name for element collection (list)"
 *		)
 *
 *
 *	@swg\Api(
 *		path="/wikia.php?controller=SearchApi&method=getCrossWiki",
 *		description="Fetches results for cross-wiki search for submitted query. As a result you get a list of Wikis.",
 *		@swg\Operations(
 *			@swg\Operation(
 *				httpMethod="get",
 *				summary="Fetches results for cross-wiki search.",
 *				nickname="getCrossWiki",
 *				responseClass="CrossWikiSearchResultSet",
 *				@swg\ErrorResponses(
 *					@swg\ErrorResponse( code="400", reason="invalid parameters" ),
 *					@swg\ErrorResponse( code="404", reason="results not found" )
 *				),
 *				@swg\Parameters(
 *					@swg\Parameter(
 *						name="query",
 *						description="The query to use for the search",
 *						paramType="query",
 *						required="true",
 *						allowMultiple="false",
 *						dataType="string",
 *						defaultValue=""
 *					),
 *					@swg\Parameter(
 *						name="lang",
 *						description="The two chars wiki language code, (eg.: en, de, fr)",
 *						paramType="query",
 *						required="true",
 *						allowMultiple="false",
 *						dataType="string",
 * 						defaultValue="en"
 *					),
 *					@swg\Parameter(
 * 						@SWG\AllowableValues(valueType="LIST",values="['newest', 'oldest', 'recently-modified', 'stable', 'most-viewed', 'freshest', 'stalest']"),
 *						name="rank",
 *						description="The ranking to use in fetching the list of results, one of default, newest, oldest, recently-modified, stable, most-viewed, freshest, stalest",
 *						paramType="query",
 *						required="false",
 *						allowMultiple="false",
 *						dataType="string",
 *						defaultValue=""
 *					),
 *					@swg\Parameter(
 *						name="limit",
 *						description="The number of items per batch (page)",
 *						paramType="query",
 *						required="false",
 *						allowMultiple="false",
 *						dataType="int",
 *						defaultValue="25"
 *					),
 *					@swg\Parameter(
 *						name="batch",
 *						description="The batch (page) of results to fetch",
 *						paramType="query",
 *						required="false",
 *						allowMultiple="false",
 *						dataType="int",
 *						defaultValue=""
 *					)
 *				)
 *			)
 *		)
 * )
 *
 *
 *
 */


die;
