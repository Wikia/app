<?php

use Swagger\Annotations as SWG;

/**
 * @SWG\Resource(
 * 	apiVersion="1",
 * 	swaggerVersion="1.1",
 * 	resourcePath="Recommendations",
 * 	basePath="http://www.wikia.com"
 * )
 *
 * @SWG\Model( id="RecommendationsResultSet" )
 * 	@SWG\Property(
 * 		name="items",
 * 		type="Array",
 * 		description="Standard container name for element collection (list)",
 * 		required="true",
 * 		items="$ref:RecommendationItem"
 * 	)
 *
 * @SWG\Model( id="RecommendationItem" )
 * 	@SWG\Property(
 * 		name="type",
 * 		type="string",
 * 		required="true",
 * 		description="Recommendation item type - video/article"
 * 	)
 * 	@SWG\Property(
 * 		name="title",
 * 		type="string",
 * 		required="true",
 * 		description="Recommendation item title"
 * 	)
 * 	@SWG\Property(
 * 		name="url",
 * 		type="string",
 * 		required="true",
 * 		description="Recommendation item URL"
 * 	)
 * 	@SWG\Property(
 * 		name="description",
 * 		type="string",
 * 		required="true",
 * 		description="Recommendation item description"
 * 	)
 * 	@SWG\Property(
 * 		name="source",
 * 		type="string",
 * 		required="true",
 * 		description="Recommendation item data source - RelatedPages/VideoRecommendations/TopArticles"
 * 	)
 * 	@SWG\Property(
 * 		name="media",
 * 		type="Media",
 * 		required="true",
 * 		description="Object describing recommendation item media format"
 * 	)
 *
 * @SWG\Model( id="Media" )
 * 	@SWG\Property(
 * 		name="thumbUrl",
 * 		type="string",
 * 		required="true",
 * 		description="URL to thumbnail"
 * 	)
 * 	@SWG\Property(
 * 		name="duration",
 * 		type="int",
 * 		required="false",
 * 		description="Video duration (only for video type recommendations)"
 * 	)
 * 	@SWG\Property(
 * 		name="videoKey",
 * 		type="string",
 * 		required="false",
 * 		description="Video title"
 * 	)
 *
 * @SWG\Api(
 * 	path="/Recommendations/ForArticle",
 * 	description="Get recommendations for article from many sources",
 * 	@SWG\Operations(
 * 		@SWG\Operation(
 * 			httpMethod="GET",
 * 			summary="Get recommendations for article from many source",
 * 			nickname="getForArticle",
 * 			responseClass="RecommendationsResultSet",
 * 			@SWG\ErrorResponses(
 * 				@SWG\ErrorResponse( code="404", reason="Selected article not found" )
 * 			),
 * 			@SWG\Parameters(
 * 				@SWG\Parameter(
 * 					name="id",
 * 					description="Article ID",
 * 					paramType="query",
 * 					required="true",
 * 					allowMultiple="false",
 * 					dataType="int",
 * 					defaultValue=""
 * 				),
 * 				@SWG\Parameter(
 * 					name="limit",
 * 					description="Number of requested recommendations - default 9",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="int",
 * 					defaultValue="9"
 * 				)
 * 			)
 * 		)
 * 	)
 * )
 */

die;
