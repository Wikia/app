<?php
use Swagger\Annotations as SWG;

/**
 * @SWG\Resource(
 * 	apiVersion="1",
 * 	swaggerVersion="1.1",
 * 	resourcePath="Palantir",
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
 * @SWG\Model( id="ExpandedPalantirArticle" )
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
 * 		name="categories",
 * 		type="array",
 * 		required="true",
 * 		description="Array of strings - category names"
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
 * @SWG\Property(
 * 		name="metadata",
 * 		type="array",
 * 		items="$ref:Metadata"
 * )
 *
 * @SWG\Model( id="MapLocation" )
 * 	@SWG\Property(
 * 		name="latitude",
 * 		type="float",
 * 		required="false",
 * 		description="Latitude of the POI"
 * 	)
 *  @SWG\Property(
 * 		name="longitude",
 * 		type="float",
 * 		required="false",
 * 		description="Longitude of the POI"
 * 	)
 * 	@SWG\Property(
 * 		name="region",
 * 		type="string",
 * 		required="false",
 * 		description="Region ID"
 * 	)
 *
 * @SWG\Model( id="Metadata" )
 * 	@SWG\Property(
 * 		name="ability_id",
 * 		type="string",
 * 		required="false",
 * 		description="The ID of the ability"
 * 	)
 *  @SWG\Property(
 * 		name="fingerprints",
 * 		type="array",
 * 		required="false",
 * 		description="An array of fingerprint IDs"
 * 	)
 *  @SWG\Property(
 * 		name="quest_id",
 * 		type="string",
 * 		required="false",
 * 		description="The ID of the quest"
 * 	)
 * 	@SWG\Property(
 *  	name="map_location",
 * 		required="false",
 * 		type="array",
 * 		items="$ref:MapLocation"
 *  )
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
 *
 * @SWG\Model( id="ExpandedPalantirListArticleResultSet" )
 * 	@SWG\Property(
 * 		name="items",
 * 		required="true",
 * 		type="Array",
 * 		items="$ref:ExpandedPalantirArticle",
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
 *
 * @SWG\Api(
 * 	path="/Palantir/NearbyQuests",
 * 	description="Get a list of nearby quests (pages) on the current wiki",
 * 	@SWG\Operations(
 * 		@SWG\Operation(
 * 			httpMethod="GET",
 * 			summary="Get a list of nearby quests (pages) on the current wiki",
 * 			nickname="getNearbyQuests",
 * 			responseClass="ExpandedPalantirListArticleResultSet",
 * 			@SWG\ErrorResponses(
 * 				@SWG\ErrorResponse( code="400", reason="Latitude/longitude parameter is invalid" ),
 * 				@SWG\ErrorResponse( code="404", reason="Results not found" )
 * 			),
 * 			@SWG\Parameters(
 *   				@SWG\Parameter(
 * 					name="latitude",
 * 					description="The latitude of the point of interest",
 * 					paramType="query",
 * 					required="true",
 * 					allowMultiple="false",
 * 					dataType="string",
 * 					defaultValue="1"
 * 				),
 *   			@SWG\Parameter(
 * 					name="longitude",
 * 					description="The longitude of the point of interest",
 * 					paramType="query",
 * 					required="true",
 * 					allowMultiple="false",
 * 					dataType="string",
 * 					defaultValue="1"
 * 				),
 *   			@SWG\Parameter(
 * 					name="radius",
 * 					description="How far the point can be from the point of interest (in kilometers)",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="int",
 * 					defaultValue=""
 * 				),
 *   			@SWG\Parameter(
 * 					name="region",
 * 					description="Region ID",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="string",
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
 * 				)
 * 			)
 * 		)
 * 	)
 * )
 *
 * @SWG\Api(
 * 	path="/Palantir/QuestDetails",
 * 	description="Get quest details",
 * 	@SWG\Operations(
 * 		@SWG\Operation(
 * 			httpMethod="GET",
 * 			summary="Get quest details",
 * 			nickname="getQuestDetails",
 * 			responseClass="ExpandedPalantirListArticleResultSet",
 * 			@SWG\ErrorResponses(
 * 				@SWG\ErrorResponse( code="400", reason="Latitude/longitude parameter is invalid" ),
 * 				@SWG\ErrorResponse( code="404", reason="Results not found" )
 * 			),
 * 			@SWG\Parameters(
 *    			@SWG\Parameter(
 * 					name="fingerprint_id",
 * 					description="Fingerprint ID",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="string",
 * 					defaultValue=""
 * 				),
 *      		@SWG\Parameter(
 * 					name="quest_id",
 * 					description="Quest ID",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="string",
 * 					defaultValue=""
 * 				),
 *   			@SWG\Parameter(
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
 * 					description="Limit the number of results",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="int",
 * 					defaultValue="25"
 * 				)
 * 			)
 * 		)
 * 	)
 * )
 *
 *
 */

die;
