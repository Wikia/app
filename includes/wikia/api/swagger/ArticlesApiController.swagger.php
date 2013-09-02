<?php
use Swagger\Annotations as SWG;

/**
 * @SWG\Resource(
 * 	apiVersion="0.2",
 * 	swaggerVersion="1.1",
 * 	resourcePath="ArticlesApi",
 * 	basePath="http://www.wikia.com"
 * )
 *
 * @SWG\Model( id="HubArticleResult" )
 * 	@SWG\Property(
 * 		name="wiki",
 * 		type="Wikia",
 * 		required="true",
 * 		description="Wikia info object"
 * 	)
 * 	@SWG\Property(
 * 		name="articles",
 * 		type="Array",
 * 		items="$ref:HubArticle",
 * 		required="true",
 * 		description="Article list"
 * 	)
 *
 * @SWG\Model( id="Wikia" )
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
 * 		name="language",
 * 		type="string",
 * 		required="true",
 * 		description="Wikia language"
 * 	)
 * 	@SWG\Property(
 * 		name="domain",
 * 		type="string",
 * 		required="true",
 * 		description="Wikia base URL"
 * 	)
 *
 * @SWG\Model( id="HubArticle" )
 * 	@SWG\Property(
 * 		name="id",
 * 		type="int",
 * 		required="true",
 * 		description="An internal identification number for Article"
 * 	)
 * 	@SWG\Property(
 * 		name="ns",
 * 		type="int",
 * 		required="true",
 * 		description="The namespace value of the given article"
 * 	)
 *
 * 	@SWG\Model( id="UnexpandedArticle" )
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
 * 		description="The title of the article"
 * 	)
 * 	@SWG\Property(
 * 		name="url",
 * 		type="string",
 * 		required="true",
 * 		description="The relative URL of the Article. Absolute URL: obtained from combining relative URL with basepath attribute from response."
 * 	)
 * 	@SWG\Property(
 * 		name="ns",
 * 		type="int",
 * 		required="true",
 * 		description="The namespace value of the given article"
 * 	)
 * 
 * @SWG\Model( id="ExpandedArticle" )
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
 * 		description="The title of the article"
 * 	)
 * 	@SWG\Property(
 * 		name="url",
 * 		type="string",
 * 		required="true",
 * 		description="The relative URL of the Article. Absolute URL: obtained from combining relative URL with basepath attribute from response."
 * 	)
 * 	@SWG\Property(
 * 		name="ns",
 * 		type="int",
 * 		required="true",
 * 		description="The namespace value of the given article"
 * 	)
 * 	@SWG\Property(
 * 		name="revision",
 * 		type="Revision",
 * 		required="true",
 * 		description="The latest revision for this article"
 * 	)
 * 	@SWG\Property(
 * 		name="comments",
 * 		type="int",
 * 		required="true",
 * 		description="Number of comments on this article"
 * 	)
 * 	@SWG\Property(
 * 		name="type",
 * 		type="string",
 * 		required="true",
 * 		description="The functional type of the document (e.g. article, file, category)"
 * 	)
 * 	@SWG\Property(
 * 		name="abstract",
 * 		type="string",
 * 		required="true",
 * 		description="A snippet of text from the beginning of the article"
 * 	)
 * 	@SWG\Property(
 * 		name="thumbnail",
 * 		type="string",
 * 		description="The absolute URL of the thumbnail"
 * 	)
 * 	@SWG\Property(
 * 		name="original_dimensions",
 * 		type="OriginalDimension",
 * 		description="The original dimensions of the thumbnail for the article, if available"
 * 	)
 * 
 * @SWG\Model( id="Revision" )
 * 	@SWG\Property(
 * 		name="id",
 * 		type="int",
 * 		required="true",
 * 		description="An internal identification number for Revision"
 * 	)
 * 	@SWG\Property(
 * 		name="user",
 * 		type="string",
 * 		required="true",
 * 		description="The name of the user who made the revision"
 * 	)
 * 	@SWG\Property(
 * 		name="user_id",
 * 		type="int",
 * 		required="true",
 * 		description="An internal identification number for User"
 * 	)
 * 	@SWG\Property(
 * 		name="timestamp",
 * 		type="int",
 * 		required="true",
 * 		description="The Unix timestamp (in seconds) that the revision was made"
 * 	)
 * 
 * @SWG\Model( id="OriginalDimension" )
 * 	@SWG\Property(
 * 		name="width",
 * 		type="int",
 * 		required="true",
 * 		description="Original width of the thumbnail, in pixels"
 * 	)
 * 	@SWG\Property(
 * 		name="height",
 * 		type="int",
 * 		required="true",
 * 		description="Original height of the thumbnail, in pixels"
 * 	)
 * 
 * @SWG\Model( id="HubArticleResultSet" )
 * 	@SWG\Property(
 * 		name="items",
 * 		required="true",
 * 		type="Array",
 * 		items="$ref:HubArticleResult",
 * 		description="Standard container name for element collection (list)"
 * 	)
 * 
 * @SWG\Model( id="UnexpandedListArticleResultSet" )
 * 	@SWG\Property(
 * 		name="items",
 * 		required="true",
 * 		type="Array",
 * 		items="$ref:UnexpandedArticle",
 * 		description="Standard container name for element collection (list)"
 * 	)
 * 	@SWG\Property(
 * 		name="offset",
 * 		type="string",
 * 		required="true",
 * 		description="Offset to start next batch of data"
 * 	)
 * 	@SWG\Property(
 * 		name="basepath",
 * 		type="string",
 * 		required="true",
 * 		description="Common URL prefix for relative URLs"
 * 	)
 * @SWG\Model( id="ExpandedListArticleResultSet" )
 * 	@SWG\Property(
 * 		name="items",
 * 		required="true",
 * 		type="Array",
 * 		items="$ref:ExpandedArticle",
 * 		description="Standard container name for element collection (list)"
 * 	)
 * 	@SWG\Property(
 * 		name="offset",
 * 		type="string",
 * 		required="true",
 * 		description="Offset value of next datum (used for pagination in subsequent requests)"
 * 	)
 * 	@SWG\Property(
 * 		name="basepath",
 * 		type="string",
 * 		required="true",
 * 		description="Common URL prefix for relative URLs"
 * 	)
 * 
 * @SWG\Model( id="UnexpandedArticleResultSet" )
 * 	@SWG\Property(
 * 		name="items",
 * 		required="true",
 * 		type="Array",
 * 		items="$ref:UnexpandedArticle",
 * 		description="Standard container name for element collection (list)"
 * 	)
 * 	@SWG\Property(
 * 		name="basepath",
 * 		type="string",
 * 		required="true",
 * 		description="Common URL prefix for relative URLs"
 * 	)
 * 	@SWG\Model( id="ExpandedArticleResultSet" )
 * 	@SWG\Property(
 * 		name="items",
 * 		required="true",
 * 		type="Array",
 * 		items="$ref:ExpandedArticle",
 * 		description="Standard container name for element collection (list)"
 * 	)
 * 	@SWG\Property(
 * 		name="basepath",
 * 		type="string",
 * 		required="true",
 * 		description="Common URL prefix for relative URLs"
 * 	)
 * 
 * @SWG\Api(
 * 	path="/wikia.php?controller=ArticlesApi&method=getTop",
 * 	description="Fetch the most viewed articles on this wiki",
 * 	@SWG\Operations(
 * 		@SWG\Operation(
 * 			httpMethod="GET",
 * 			summary="Fetch the most viewed articles on this wiki",
 * 			nickname="getTop",
 * 			responseClass="UnexpandedArticleResultSet",
 * 			@SWG\ErrorResponses(
 * 				@SWG\ErrorResponse( code="400", reason="Invalid parameter or category" ),
 * 				@SWG\ErrorResponse( code="404", reason="Results not found" )
 * 			),
 * 			@SWG\Parameters(
 * 				@SWG\Parameter(
 * 					name="namespaces",
 * 					description="Page namespace number, see more: http://www.mediawiki.org/wiki/help:namespaces",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="true",
 * 					dataType="Array",
 * 					defaultValue=""
 * 				),
 * 				@SWG\Parameter(
 * 					name="category",
 * 					description="Specifying a title corresponding to an existing for this value will display only articles that pertain to this category",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="string",
 * 					defaultValue=""
 * 				)
 * 			)
 * 		)
 * 	)
 * )
 * @SWG\Api(
 * 	path="/wikia.php?controller=ArticlesApi&method=getTop&expand=1",
 * 	description="Fetch the most viewed articles for this wiki, with additional information provided for each article",
 * 	@SWG\Operations(
 * 		@SWG\Operation(
 * 			httpMethod="GET",
 * 			summary="Fetch the most viewed articles for this wiki, with additional information for each article",
 * 			nickname="getTop",
 * 			responseClass="ExpandedArticleResultSet",
 * 			@SWG\ErrorResponses(
 * 				@SWG\ErrorResponse( code="400", reason="Invalid parameter or category" ),
 * 				@SWG\ErrorResponse( code="404", reason="Results not found" )
 * 			),
 * 			@SWG\Parameters(
 * 				@SWG\Parameter(
 * 					name="namespaces",
 * 					description="Page namespace number, see more: http://www.mediawiki.org/wiki/help:namespaces",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="true",
 * 					dataType="Array",
 * 					defaultValue=""
 * 				),
 * 				@SWG\Parameter(
 * 					name="category",
 * 					description="Specifying a title corresponding to an existing for this value will display only articles that pertain to this category",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="string",
 * 					defaultValue=""
 * 				)
 * 			)
 * 		)
 * 	)
 * )
 * 
 * 
 * @SWG\Api(
 * 	path="/wikia.php?controller=ArticlesApi&method=getTopByHub",
 * 	description="View the most popular wikis in a given hub. Available only on the www.wikia.com main domain.",
 * 	@SWG\Operations(
 * 		@SWG\Operation(
 * 			httpMethod="GET",
 * 			summary="Get the top articles by pageviews for a hub optionally filtering by namespace and/or language",
 * 			nickname="getTopByHub",
 * 			responseClass="HubArticleResultSet",
 * 			@SWG\ErrorResponses(
 * 				@SWG\ErrorResponse( code="400", reason="Missing 'hub' parameter, number of languages exceeded or not on www.wikia.com domain" ),
 * 				@SWG\ErrorResponse( code="404", reason="Results not found" )
 * 			),
 * 			@SWG\Parameters(
 * 				@SWG\Parameter(
 * 					name="hub",
 * 					description="The name of the vertical (e.g. Gaming, Entertainment, Lifestyle, etc.) to use as a filter",
 * 					paramType="query",
 * 					required="true",
 * 					allowMultiple="false",
 * 					dataType="Array",
 * 					defaultValue="gaming"
 * 				),
 * 				@SWG\Parameter(
 * 					name="lang",
 * 					description="Specifies the desired language of the resulting wikis, by language code",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="true",
 * 					dataType="string",
 * 					defaultValue=""
 * 				),
 * 				@SWG\Parameter(
 * 					name="namespaces",
 * 					description="Page namespace number, see more: http://www.mediawiki.org/wiki/help:namespaces",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="true",
 * 					dataType="Array",
 * 					defaultValue=""
 * 				)
 * 			)
 * 		)
 * 	)
 * )
 * 
 * 
 * @SWG\Api(
 * 	path="/wikia.php?controller=ArticlesApi&method=getList",
 * 	description="Get the most viewed articles for the current wiki",
 * 	@SWG\Operations(
 * 		@SWG\Operation(
 * 			httpMethod="GET",
 * 			summary="Get the most viewed articles for the current wiki ",
 * 			nickname="getList",
 * 			responseClass="UnexpandedListArticleResultSet",
 * 			@SWG\ErrorResponses(
 * 				@SWG\ErrorResponse( code="400", reason="Namespaces or category parameter is invalid" ),
 * 				@SWG\ErrorResponse( code="404", reason="Results not found" )
 * 			),
 * 			@SWG\Parameters(
 * 				@SWG\Parameter(
 * 					name="category",
 * 					description="Return only articles belonging to the provided valid category",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="string",
 * 					defaultValue=""
 * 				),
 * 				@SWG\Parameter(
 * 					name="namespaces",
 * 					description="Page namespace number, see more: http://www.mediawiki.org/wiki/help:namespaces",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="true",
 * 					dataType="Array",
 * 					defaultValue=""
 * 				),
 * 				@SWG\Parameter(
 * 					name="limit",
 * 					description="The maximum number of results to fetch",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="int",
 * 					defaultValue="25"
 * 				),
 * 				@SWG\Parameter(
 * 					name="offset",
 * 					description="If provided, lists results starting with the provided offset position",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="string",
 * 					defaultValue=""
 * 				)
 * 			)
 * 		)
 * 	)
 * )
 * @SWG\Api(
 * 	path="/wikia.php?controller=ArticlesApi&method=getList&expand=1",
 * 	description="Fetch a list of pages on the current wiki",
 * 	@SWG\Operations(
 * 		@SWG\Operation(
 * 			httpMethod="GET",
 * 			summary="Fetch a list of pages on the current wiki",
 * 			nickname="getList",
 * 			responseClass="ExpandedListArticleResultSet",
 * 			@SWG\ErrorResponses(
 * 				@SWG\ErrorResponse( code="400", reason="Namespaces or category parameter is invalid" ),
 * 				@SWG\ErrorResponse( code="404", reason="Results not found" )
 * 			),
 * 			@SWG\Parameters(
 * 				@SWG\Parameter(
 * 					name="category",
 * 					description="Return only articles belonging to the provided valid category",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="string",
 * 					defaultValue=""
 * 				),
 * 				@SWG\Parameter(
 * 					name="namespaces",
 * 					description="Page namespace number, see more: http://www.mediawiki.org/wiki/help:namespaces",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="true",
 * 					dataType="Array",
 * 					defaultValue=""
 * 				),
 * 				@SWG\Parameter(
 * 					name="limit",
 * 					description="The maximum number of results to fetch",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="int",
 * 					defaultValue="25"
 * 				),
 * 				@SWG\Parameter(
 * 					name="offset",
 * 					description="Offset to start fetching data from",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="string",
 * 					defaultValue=""
 * 				)
 * 			)
 * 		)
 * 	)
 * )
 * 
 * @SWG\Api(
 * 		path="/wikia.php?controller=ArticlesApi&method=getDetails",
 * 		description="Fetch top articles for the current wiki",
 * 		@SWG\Operations(
 * 			@SWG\Operation(
 * 				httpMethod="GET",
 * 				summary="Get details about one or more articles",
 * 				nickname="getDetails",
 * 				responseClass="ExpandedArticleResultSet",
 * 				@SWG\ErrorResponses(
 * 					@SWG\ErrorResponse( code="400", reason="Missing ids parameter or abstract out of range" )
 * 				),
 * 				@SWG\Parameters(
 * 					@SWG\Parameter(
 * 						name="ids",
 * 						description="A string with a comma-separated list of article IDs",
 * 						paramType="query",
 * 						required="true",
 * 						allowMultiple="true",
 * 						dataType="Array",
 * 						defaultValue="50"
 * 					),
 * 					@SWG\Parameter(
 * 						name="titles",
 * 						description="Titles with underscores instead of spaces, comma-separated",
 * 						paramType="query",
 * 						required="false",
 * 						allowMultiple="false",
 * 						dataType="string",
 * 						defaultValue=""
 * 					),
 * 					@SWG\Parameter(
 * 						name="abstract",
 * 						description="The desired length for the article's abstract",
 * 						paramType="query",
 * 						required="false",
 * 						allowMultiple="false",
 * 						dataType="int",
 * 						defaultValue="100",
 * 						@SWG\AllowableValues(valueType="RANGE",min="0", max="500")
 * 					),
 * 					@SWG\Parameter(
 * 						name="width",
 * 						description="The desired width for the thumbnail",
 * 						paramType="query",
 * 						required="false",
 * 						allowMultiple="false",
 * 						dataType="int",
 * 						defaultValue="200"
 * 					),
 * 					@SWG\Parameter(
 * 						name="height",
 * 						description="The desired height for the thumbnail",
 * 						paramType="query",
 * 						required="false",
 * 						allowMultiple="false",
 * 						dataType="int",
 * 						defaultValue="200"
 * 					)
 * 				)
 * 			)
 * 		)
 * 	)
 */

die;
