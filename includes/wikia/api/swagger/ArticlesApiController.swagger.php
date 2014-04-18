<?php
use Swagger\Annotations as SWG;

/**
 * @SWG\Resource(
 * 	apiVersion="1",
 * 	swaggerVersion="1.1",
 * 	resourcePath="Articles",
 * 	basePath="http://www.wikia.com"
 * )
 *
 * @SWG\Model( id="ContentResult" )
 * 	@SWG\Property(
 * 		name="sections",
 * 		type="Section",
 * 		required="true",
 * 		description="Article section data container"
 * 	)
 *
 * @SWG\Model( id="Section" )
 * 	@SWG\Property(
 * 		name="title",
 * 		type="string",
 * 		required="true",
 * 		description="Article section title"
 * 	)
 * 	@SWG\Property(
 * 		name="level",
 * 		type="int",
 * 		required="true",
 * 		description="Section nesting level"
 * 	)
 * 	@SWG\Property(
 * 		name="content",
 * 		type="Array",
 * 		items="$ref:SectionContent",
 * 		required="true",
 * 		description="Section content"
 * 	)
 * 	@SWG\Property(
 * 		name="images",
 * 		type="Array",
 * 		items="$ref:SectionImages",
 * 		required="true",
 * 		description="Images list in section"
 * 	)
 *
 * @SWG\Model( id="SectionContent" )
 *	@SWG\Property(
 * 		name="type",
 * 		type="string",
 * 		required="true",
 * 		description="Content element type can be paragraph or list"
 * 	)
 * 	@SWG\Property(
 * 		name="text",
 * 		type="string",
 * 		required="false",
 * 		description="Cleaned up paragraph text"
 * 	)
 * 	@SWG\Property(
 * 		name="elements",
 * 		type="Array",
 * 		items="$ref:ListElement",
 * 		required="false",
 * 		description="Array containing list elements"
 * 	)
 * @SWG\Model( id="ListElement" )
 * 	@SWG\Property(
 * 		name="text",
 * 		type="string",
 * 		required="true",
 * 		description="Cleaned up list element text"
 * 	)
 * 	@SWG\Property(
 * 		name="elements",
 * 		type="Array",
 * 		required="true",
 * 		description="Array containing nested list elements"
 * 	)
 * @SWG\Model( id="SectionImages" )
 * 	@SWG\Property(
 * 		name="src",
 * 		type="string",
 * 		required="true",
 * 		description="Full image URL"
 * 	)
 * 	@SWG\Property(
 * 		name="caption",
 * 		type="string",
 * 		required="true",
 * 		description="Image description"
 * 	)
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
 * @SWG\Model( id="PopularArticle" )
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
 * 		name="ns",
 * 		type="int",
 * 		required="true",
 * 		description="The namespace value of the given article"
 * 	)
 * 	@SWG\Property(
 * 		name="url",
 * 		type="string",
 * 		required="true",
 * 		description="The relative URL of the Article. Absolute URL: obtained from combining relative URL with basepath attribute from response."
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
 * @SWG\Model( id="Creator" )
 * 	@SWG\Property(
 * 		name="avatar",
 * 		type="string",
 * 		required="true",
 * 		description="Url for user avatar"
 * 	)
 * 	@SWG\Property(
 * 		name="name",
 * 		type="string",
 * 		required="true",
 * 		description="User name"
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
 * @SWG\Model( id="NewArticleResultSet" )
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
 * 	@SWG\Property(
 * 		name="title",
 * 		type="string",
 * 		required="true",
 * 		description="The title of the article"
 * 	)
 * 	@SWG\Property(
 * 		name="abstract",
 * 		type="string",
 * 		required="true",
 * 		description="A snippet of text from the beginning of the article"
 * 	)
 * 	@SWG\Property(
 * 		name="quality",
 * 		type="int",
 * 		required="true",
 * 		description="Quality score of the article, ranges from 0 (low quality) to 99 (high quality)"
 * 	)
 * 	@SWG\Property(
 * 		name="url",
 * 		type="string",
 * 		required="true",
 * 		description="The relative URL of the Article. Absolute URL: obtained from combining relative URL with basepath attribute from response."
 * 	)
 * 	@SWG\Property(
 * 		name="creator",
 * 		type="Creator",
 * 		description="Data about the author of the article (creator of the first revision)"
 * 	)
 * 	@SWG\Property(
 * 		name="creation_date",
 * 		type="string",
 * 		required="true",
 * 		description="Date of the first revision of the article"
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
 *
 *
 * @SWG\Model( id="PopularListArticleResultSet" )
 * 	@SWG\Property(
 * 		name="items",
 * 		required="true",
 * 		type="Array",
 * 		items="$ref:PopularArticle",
 * 		description="Standard container name for element collection (list)"
 * 	)
 * 	@SWG\Property(
 * 		name="basepath",
 * 		type="string",
 * 		required="true",
 * 		description="Common URL prefix for relative URLs"
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
 *
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
 * @SWG\Model( id="ExpandedArticleResultSet" )
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
 *
 * @SWG\Model( id="UnexpandedMostLinkedResultSet" )
 * 	@SWG\Property(
 * 		name="items",
 * 		required="true",
 * 		type="Array",
 * 		items="$ref:UnexpandedMostLinked",
 * 		description="Standard container name for element collection (list)"
 * 	)
 * 	@SWG\Property(
 * 		name="basepath",
 * 		type="string",
 * 		required="true",
 * 		description="Common URL prefix for relative URLs"
 * 	)
 *
 * 	@SWG\Model( id="ExpandedMostLinkedResultSet" )
 * 	@SWG\Property(
 * 		name="items",
 * 		required="true",
 * 		type="Array",
 * 		items="$ref:ExpandedMostLinked",
 * 		description="Standard container name for element collection (list)"
 * 	)
 * 	@SWG\Property(
 * 		name="basepath",
 * 		type="string",
 * 		required="true",
 * 		description="Common URL prefix for relative URLs"
 * 	)
 *
 *
 *   @SWG\Model( id="UnexpandedMostLinked" )
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
 * 		name="backlink_cnt",
 * 		type="int",
 * 		required="true",
 * 		description="Number of backlinks for the article"
 * 	)
 *
 * @SWG\Model( id="ExpandedMostLinked" )
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
 * 		name="backlink_cnt",
 * 		type="int",
 * 		required="true",
 * 		description="Number of backlinks for the article"
 * 	)
 *
 *
 * @SWG\Api(
 * 	path="/api/v1/Articles/Top",
 * 	description="Get the most viewed articles on this wiki",
 * 	@SWG\Operations(
 * 		@SWG\Operation(
 * 			httpMethod="GET",
 * 			summary="Get the most viewed articles on this wiki",
 * 			nickname="getTop",
 * 			responseClass="UnexpandedArticleResultSet",
 * 			@SWG\ErrorResponses(
 * 				@SWG\ErrorResponse( code="400", reason="Invalid parameter or category" ),
 * 				@SWG\ErrorResponse( code="404", reason="Results not found" )
 * 			),
 * 			@SWG\Parameters(
 * 				@SWG\Parameter(
 * 					name="namespaces",
 * 					description="Comma-separated namespace ids, see more: http://community.wikia.com/wiki/Help:Namespaces",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="true",
 * 					dataType="Array",
 * 					defaultValue=""
 * 				),
 * 				@SWG\Parameter(
 * 					name="category",
 * 					description="Return only articles belonging to the provided valid category title",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="string",
 * 					defaultValue=""
 * 				),
 * 				@SWG\Parameter(
 * 					name="limit",
 * 					description="Limit the number of result - maximum limit is 250",
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
 * 	path="/api/v1/Articles/New",
 * 	description="Get list of new articles on this wiki",
 * 	@SWG\Operations(
 * 		@SWG\Operation(
 * 			httpMethod="GET",
 * 			summary="Get list of new articles on this wiki",
 * 			nickname="getNew",
 * 			responseClass="NewArticleResultSet",
 * 			@SWG\ErrorResponses(
 * 				@SWG\ErrorResponse( code="400", reason="Invalid parameter or category" ),
 * 				@SWG\ErrorResponse( code="404", reason="Results not found" )
 * 			),
 * 			@SWG\Parameters(
 * 				@SWG\Parameter(
 * 					name="namespaces",
 * 					description="Comma-separated namespace ids, see more: http://community.wikia.com/wiki/Help:Namespaces",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="true",
 * 					dataType="Array",
 * 					defaultValue=""
 * 				),
 * 				@SWG\Parameter(
 * 					name="limit",
 * 					description="Limit the number of result - maximum limit is 100",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="string",
 * 					defaultValue="20"
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
 * @SWG\Api(
 * 	path="/api/v1/Articles/Top?expand=1",
 * 	description="Get the most viewed articles for this wiki (expanded results)",
 * 	@SWG\Operations(
 * 		@SWG\Operation(
 * 			httpMethod="GET",
 * 			summary="Get the most viewed articles for this wiki (expanded results)",
 * 			nickname="getTop",
 * 			responseClass="ExpandedArticleResultSet",
 * 			@SWG\ErrorResponses(
 * 				@SWG\ErrorResponse( code="400", reason="Invalid parameter or category" ),
 * 				@SWG\ErrorResponse( code="404", reason="Results not found" )
 * 			),
 * 			@SWG\Parameters(
 * 				@SWG\Parameter(
 * 					name="namespaces",
 * 					description="Comma-separated namespace ids, see more: http://community.wikia.com/wiki/Help:Namespaces",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="true",
 * 					dataType="Array",
 * 					defaultValue=""
 * 				),
 * 				@SWG\Parameter(
 * 					name="category",
 * 					description="Return only articles belonging to the provided valid category title",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="string",
 * 					defaultValue=""
 * 				),
 * 				@SWG\Parameter(
 * 					name="limit",
 * 					description="Limit the number of result - maximum limit is 250",
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
 * 	path="/api/v1/Articles/MostLinked",
 * 	description="Get the most linked articles on this wiki",
 * 	@SWG\Operations(
 * 		@SWG\Operation(
 * 			httpMethod="GET",
 * 			summary="Get the most linked articles on this wiki",
 * 			nickname="getTop",
 * 			responseClass="UnexpandedMostLinkedResultSet",
 * 			@SWG\ErrorResponses(
 * 				@SWG\ErrorResponse( code="400", reason="Invalid parameter or category" ),
 * 				@SWG\ErrorResponse( code="404", reason="Results not found" )
 * 			)
 * 		)
 * 	)
 * )
 *
 *  @SWG\Api(
 * 	path="/api/v1/Articles/MostLinked?expand=1",
 * 	description="Get the most linked articles on this wiki (expanded results)",
 * 	@SWG\Operations(
 * 		@SWG\Operation(
 * 			httpMethod="GET",
 * 			summary="Get the most linked articles on this wiki (expanded results)",
 * 			nickname="getTop",
 * 			responseClass="ExpandedMostLinkedResultSet",
 * 			@SWG\ErrorResponses(
 * 				@SWG\ErrorResponse( code="400", reason="Invalid parameter or category" ),
 * 				@SWG\ErrorResponse( code="404", reason="Results not found" )
 * 			)
 * 		)
 * 	)
 * )
 *
 * @SWG\Api(
 * 	path="/api/v1/Articles/TopByHub",
 * 	description="View the most popular wikis in a given hub. Available only on the www.wikia.com main domain.",
 * 	@SWG\Operations(
 * 		@SWG\Operation(
 * 			httpMethod="GET",
 * 			summary="Get the top articles by pageviews for a hub",
 * 			nickname="getTopByHub",
 * 			responseClass="HubArticleResultSet",
 * 			@SWG\ErrorResponses(
 * 				@SWG\ErrorResponse( code="400", reason="Missing 'hub' parameter, number of languages exceeded or not on www.wikia.com domain" ),
 * 				@SWG\ErrorResponse( code="404", reason="Results not found" )
 * 			),
 * 			@SWG\Parameters(
 * 				@SWG\Parameter(
 * 					name="hub",
 * 					description="The name of the vertical (e.g. Gaming)",
 * 					paramType="query",
 * 					required="true",
 * 					allowMultiple="false",
 * 					dataType="Array",
 * 					defaultValue="gaming"
 * 				),
 * 				@SWG\Parameter(
 * 					name="lang",
 * 					description="Comma separated language codes (e.g. en,de,fr)",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="true",
 * 					dataType="string",
 * 					defaultValue=""
 * 				),
 * 				@SWG\Parameter(
 * 					name="namespaces",
 * 					description="Comma-separated namespace ids, see more: http://community.wikia.com/wiki/Help:Namespaces",
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
 * @SWG\Api(
 * 	path="/api/v1/Articles/Popular?expand=1",
 * 	description="Get popular articles for the current wiki (from the beginning of time)",
 * 	@SWG\Operations(
 * 		@SWG\Operation(
 * 			httpMethod="GET",
 * 			summary="Get popular articles for the current wiki (from the beginning of time)",
 * 			nickname="getPopular",
 * 			responseClass="ExpandedArticleResultSet",
 * 			@SWG\ErrorResponses(
 * 				@SWG\ErrorResponse( code="400", reason="Limit parameter is invalid" ),
 * 				@SWG\ErrorResponse( code="404", reason="Results not found" )
 * 			),
 * 			@SWG\Parameters(
 * 				@SWG\Parameter(
 * 					name="limit",
 * 					description="Limit the number of result - maximum limit is 10",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="int",
 * 					defaultValue="10"
 * 				)
 * 			)
 * 		)
 * 	)
 * )
 *
 * @SWG\Api(
 * 	path="/api/v1/Articles/Popular",
 * 	description="Get popular articles for the current wiki (from the beginning of time)",
 * 	@SWG\Operations(
 * 		@SWG\Operation(
 * 			httpMethod="GET",
 * 			summary="Get popular articles for the current wiki (from the beginning of time)",
 * 			nickname="getPopular",
 * 			responseClass="PopularListArticleResultSet",
 * 			@SWG\ErrorResponses(
 * 				@SWG\ErrorResponse( code="400", reason="Limit parameter is invalid" ),
 * 				@SWG\ErrorResponse( code="404", reason="Results not found" )
 * 			),
 * 			@SWG\Parameters(
 * 				@SWG\Parameter(
 * 					name="limit",
 * 					description="Limit the number of result - maximum limit is 10",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="int",
 * 					defaultValue="10"
 * 				)
 * 			)
 * 		)
 * 	)
 * )
 *
 * @SWG\Api(
 * 	path="/api/v1/Articles/List",
 * 	description="Get articles list in alphabetical order",
 * 	@SWG\Operations(
 * 		@SWG\Operation(
 * 			httpMethod="GET",
 * 			summary="Get articles list in alphabetical order",
 * 			nickname="getList",
 * 			responseClass="UnexpandedListArticleResultSet",
 * 			@SWG\ErrorResponses(
 * 				@SWG\ErrorResponse( code="400", reason="Namespaces or category parameter is invalid" ),
 * 				@SWG\ErrorResponse( code="404", reason="Results not found" )
 * 			),
 * 			@SWG\Parameters(
 * 				@SWG\Parameter(
 * 					name="category",
 * 					description="Return only articles belonging to the provided valid category title",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="string",
 * 					defaultValue=""
 * 				),
 * 				@SWG\Parameter(
 * 					name="namespaces",
 * 					description="Comma-separated namespace ids, see more: http://community.wikia.com/wiki/Help:Namespaces",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="true",
 * 					dataType="Array",
 * 					defaultValue=""
 * 				),
 * 				@SWG\Parameter(
 * 					name="limit",
 * 					description="Limit the number of results",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="int",
 * 					defaultValue="25"
 * 				),
 * 				@SWG\Parameter(
 * 					name="offset",
 * 					description="Lexicographically minimal article title.",
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
 * 	path="/api/v1/Articles/List?expand=1",
 * 	description="Get a list of pages on the current wiki",
 * 	@SWG\Operations(
 * 		@SWG\Operation(
 * 			httpMethod="GET",
 * 			summary="Get a list of pages on the current wiki",
 * 			nickname="getList",
 * 			responseClass="ExpandedListArticleResultSet",
 * 			@SWG\ErrorResponses(
 * 				@SWG\ErrorResponse( code="400", reason="Namespaces or category parameter is invalid" ),
 * 				@SWG\ErrorResponse( code="404", reason="Results not found" )
 * 			),
 * 			@SWG\Parameters(
 * 				@SWG\Parameter(
 * 					name="category",
 * 					description="Return only articles belonging to the provided valid category title",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="string",
 * 					defaultValue=""
 * 				),
 * 				@SWG\Parameter(
 * 					name="namespaces",
 * 					description="Comma-separated namespace ids, see more: http://community.wikia.com/wiki/Help:Namespaces",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="true",
 * 					dataType="Array",
 * 					defaultValue=""
 * 				),
 * 				@SWG\Parameter(
 * 					name="limit",
 * 					description="Limit the number of results",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="int",
 * 					defaultValue="25"
 * 				),
 * 				@SWG\Parameter(
 * 					name="offset",
 * 					description="Lexicographically minimal article title.",
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
 * 		path="/api/v1/Articles/Details",
 * 		description="Get top articles for the current wiki",
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
 * 						description="Comma-separated list of article ids",
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
 * @SWG\Api(
 * 		path="/api/v1/Articles/AsSimpleJson",
 * 		description="Get simplified article contents in JSON format",
 * 		@SWG\Operations(
 * 			@SWG\Operation(
 * 				httpMethod="GET",
 * 				summary="Get simplified article contents",
 * 				nickname="getAsSimpleJson",
 * 				responseClass="ContentResult",
 * 				@SWG\ErrorResponses(
 * 					@SWG\ErrorResponse( code="400", reason="Invalid ID parameter" ),
 * 					@SWG\ErrorResponse( code="404", reason="Article not found" )
 * 				),
 * 				@SWG\Parameters(
 * 					@SWG\Parameter(
 * 						name="id",
 * 						description="A single article ID",
 * 						paramType="query",
 * 						required="true",
 * 						allowMultiple="false",
 * 						dataType="int",
 * 						defaultValue="50"
 * 					)
 * 				)
 * 			)
 * 		)
 * 	)
 */

die;
