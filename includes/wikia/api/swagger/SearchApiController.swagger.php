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
 * 	@SWG\Property(
 * 		name="quality",
 * 		type="int",
 * 		required="true",
 * 		description="Quality score of the article, ranges from 0 (low quality) to 99 (high quality)"
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
 *
 * @SWG\Model ( id="CombinedSearchArticlesResultSet" )
 *  @SWG\Property(
 * 		name="wikiId",
 * 		required="true",
 * 		type="int",
 * 		description="ID of Wikia site"
 *  )
 *  @SWG\Property(
 * 		name="articleId",
 * 		required="true",
 * 		type="int",
 * 		description="ID of the article on the Wikia site"
 *  )
 *  @SWG\Property(
 * 		name="title",
 * 		required="true",
 * 		type="string",
 * 		description="The title of the article"
 *  )
 *  @SWG\Property(
 * 		name="url",
 * 		required="true",
 * 		type="string",
 * 		description="URL to the article"
 *  )
 * @SWG\Property(
 * 		name="lang",
 * 		required="true",
 * 		type="string",
 * 		description="Language of the article"
 *  )
 * 	@SWG\Property(
 * 		name="quality",
 * 		type="int",
 * 		required="true",
 * 		description="Quality score of the article, ranges from 0 (low quality) to 99 (high quality)"
 * 	)
 * 	@SWG\Property(
 * 		name="type",
 * 		type="string|null",
 * 		required="true",
 * 		description="Type of article ( book | character | comic_book | location | movie | person | tv_episode | tv_season | tv_series | other | video_game )"
 * 	)
 * @SWG\Property(
 * 		name="snippet",
 * 		required="true",
 * 		type="string",
 * 		description="Text snippet for the article"
 *  )
 *  @SWG\Property(
 * 		name="image",
 * 		required="true",
 * 		type="string",
 * 		description="The URL of the image"
 *  )
 *
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
 * @SWG\Model( id="ExpandedCrossWikiaResultSet" )
 * 	@SWG\Property(
 * 		name="items",
 * 		type="Array",
 * 		items="$ref:ExpandedCrossWikiaItem",
 * 		required="true",
 * 		description="Standard container name for element collection (list)"
 * 	)
 *
 * @SWG\Model( id="ExpandedCrossWikiaItem" )
 * 	@SWG\Property(
 * 		name="id",
 * 		type="int",
 * 		required="true",
 * 		description="An internal identification number for Wikia"
 * 	)
 * 	@SWG\Property(
 * 		name="lang",
 * 		type="string",
 * 		required="true",
 * 		description="Wikia language"
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
 * 	@SWG\Property(
 * 		name="wordmark",
 * 		type="string",
 * 		required="true",
 * 		description="Wiki wordmark image URL, might be empty"
 * 	)
 * 	@SWG\Property(
 * 		name="wam_score",
 * 		type="float",
 * 		required="true",
 * 		description="Wiki WAM score"
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
 *
 * @SWG\Model( id="CombinedSearchResultSet" )
 * 	@SWG\Property(
 * 		name="wikias",
 * 		required="true",
 * 		type="Array",
 * 		items="$ref:WikiasResultSet",
 * 		description="Container for wikias collection (list)"
 * 	)
 *  @SWG\Property(
 * 		name="articles",
 * 		required="true",
 * 		type="Array",
 * 		items="$ref:CombinedSearchArticlesResultSet",
 * 		description="Container for articles collection (list)"
 * 	)
 *
 * @SWG\Model( id="WikiasResultSet" )
 * 	@SWG\Property(
 * 		name="wikiId",
 * 		required="true",
 * 		type="int",
 * 		description="ID of Wikia site"
 *  )
 *  @SWG\Property(
 * 		name="name",
 * 		required="true",
 * 		type="string",
 * 		description="Name of Wikia site"
 *  )
 * 	@SWG\Property(
 * 		name="url",
 * 		required="true",
 * 		type="string",
 * 		description="URL to the main page"
 *  )
 *  @SWG\Property(
 * 		name="lang",
 * 		required="true",
 * 		type="string",
 * 		description="Language of the Wikia site"
 *  )
 * 	@SWG\Property(
 * 		name="snippet",
 * 		required="true",
 * 		type="string",
 * 		description="Description of the Wikia site"
 *  )
 * 	@SWG\Property(
 * 		name="wordmark",
 * 		required="true",
 * 		type="string",
 * 		description="URL for Wikia site logo"
 *  )
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
 * 					name="minArticleQuality",
 * 					description="Minimal value of article quality. Ranges from 0 to 99",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="int",
 * 					defaultValue="10",
 * 					@SWG\AllowableValues(valueType="RANGE",min="0", max="99")
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
 * 					name="hub",
 * 					paramType="query",
 * 					description="The name of the hub (Gaming, Entertainment, Lifestyle). Separate by comma if more than one provided",
 * 					required="false",
 * 					allowMultiple="true",
 * 					dataType="string",
 * 					defaultValue=""
 * 				),
 * 				@SWG\Parameter(
 * 					name="lang",
 * 					description="The two chars wiki language code, (eg.: en, de, fr, all (for any language)). Can handles multiple values, on default will use current wikia content language.",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="true",
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
 *
 * @SWG\Api(
 * 	path="/api/v1/Search/CrossWiki?expand=1",
 * 	description="Get results for cross-wiki search for submitted query. As a result you get a list of Wikis expanded with detailed data",
 * 	@SWG\Operations(
 * 		@SWG\Operation(
 * 			httpMethod="get",
 * 			summary="Get results for cross-wiki search (extended response)",
 * 			nickname="getCrossWiki",
 * 			responseClass="ExpandedCrossWikiaResultSet",
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
 * 					name="hub",
 * 					paramType="query",
 * 					description="The name of the hub (Gaming, Entertainment, Lifestyle). Separate by comma if more than one provided",
 * 					required="false",
 * 					allowMultiple="true",
 * 					dataType="string",
 * 					defaultValue=""
 * 				),
 * 				@SWG\Parameter(
 * 					name="lang",
 * 					description="The two chars wiki language code, (eg.: en, de, fr, all (for any language)). Can handles multiple values, on default will use current wikia content language.",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="true",
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
 *
 *  @SWG\Api(
 * 	path="/api/v1/Search/Combined",
 * 	description="Get results for combined wiki and cross-wiki search ",
 * 	@SWG\Operations(
 * 		@SWG\Operation(
 * 			httpMethod="get",
 * 			summary="Get results for combined (wiki and cross-wiki) search",
 * 			nickname="getCombined",
 * 			responseClass="CombinedSearchResultSet",
 * 			@SWG\ErrorResponses(
 * 				@SWG\ErrorResponse( code="400", reason="Query parameter is missing" )
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
 * 					name="langs",
 * 					description="The two chars wiki language code set, coma-separated, (eg.: en,de,fr or en,pl)",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="true",
 * 					dataType="string",
 * 					defaultValue="en"
 * 				),
 * 				@SWG\Parameter(
 * 					name="hubs",
 * 					description="Filter by the verticals, coma-separated, (eg.: Gaming,Entertainment,Lifestyle)",
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
 * 				),
 * 				@SWG\Parameter(
 * 					name="limit",
 * 					description="Will limit number of articles returned to given number",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="int",
 * 					defaultValue="6",
 * 					@SWG\AllowableValues(valueType="RANGE",min="0", max="15")
 * 				),
 * 				@SWG\Parameter(
 * 					name="minArticleQuality",
 * 					description="Minimal value of article quality. Ranges from 0 to 99",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="int",
 * 					defaultValue="10",
 * 					@SWG\AllowableValues(valueType="RANGE",min="0", max="99")
 * 				)
 * 			)
 * 		)
 * 	)
 * )
 */

die;
