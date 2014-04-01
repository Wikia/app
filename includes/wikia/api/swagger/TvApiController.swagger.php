<?php

use Swagger\Annotations as SWG;

/**
 * @SWG\Resource(
 * 	apiVersion="1",
 * 	swaggerVersion="1.1",
 * 	resourcePath="Tv",
 * 	basePath="http://www.wikia.com"
 * )
 *

 * @SWG\Model( id="TvResultSet" )
 * 	@SWG\Property(
 * 		name="wikiId",
 * 		type="int",
 * 		required="true",
 * 		description="An internal identification number for wiki"
 * 	)
 * 		@SWG\Property(
 * 		name="articleId",
 * 		type="int",
 * 		required="true",
 * 		description="An internal identification number for article"
 * 	)
 * 	@SWG\Property(
 * 		name="title",
 * 		type="string",
 *		required="true",
 * 		description="The title of the article"
 * 	)
 * 	@SWG\Property(
 * 		name="url",
 * 		type="string",
 * 		required="true",
 * 		description="The relative URL of the article"
 * 	)
 * 	@SWG\Property(
 * 		name="quality",
 * 		type="int",
 * 		required="true",
 * 		description="Quality score of the article, ranges from 0 (low quality) to 99 (high quality)"
 * 	)
 * 	@SWG\Property(
 * 		name="contentUrl",
 * 		type="string",
 * 		required="true",
 * 		description="The URL of plain content of the article"
 * 	)
 *
 * @SWG\Api(
 * 	path="/api/v1/Tv/Episode",
 * 	description="Get article against series name and episode name",
 * 	@SWG\Operations(
 * 		@SWG\Operation(
 * 			httpMethod="GET",
 * 			summary="Get article against series name and episode name",
 * 			nickname="getEpisode",
 * 			responseClass="TvResultSet",
 *			@SWG\ErrorResponses(
 *				@SWG\ErrorResponse( code="400", reason="seriesName or episodeName not provided" ),
 *				@SWG\ErrorResponse( code="404", reason="Results not found" )
 *				),
 *			@SWG\Parameters(
 *				@SWG\Parameter(
 *					name="seriesName",
 *					description="The name of series",
 *					paramType="query",
 *					required="true",
 *					allowMultiple="false",
 *					dataType="string",
 *					defaultValue=""
 *				),
 *				@SWG\Parameter(
 *					name="episodeName",
 *					description="The name of episode",
 *					paramType="query",
 *					required="true",
 *					allowMultiple="false",
 *					dataType="string",
 *					defaultValue=""
 *				),
 * 				@SWG\Parameter(
 * 					name="minArticleQuality",
 * 					description="Minimal value of article quality. Ranges from 0 to 99",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="int",
 * 					defaultValue="10",
 * 					@SWG\AllowableValues(valueType="RANGE",min="0", max="99")
 *				),
 * 				@SWG\Parameter(
 *					name="lang",
 *					description="Comma separated language codes (e.g. en,de,fr)",
 *					paramType="query",
 *					required="false",
 *					allowMultiple="false",
 *					dataType="string",
 *					defaultValue="en"
 *				)
 *			)
 *		)
 * 	)
 *)
 *
 */
die;
