<?php

use Swagger\Annotations as SWG;

/**
 * @SWG\Resource(
 * 	apiVersion="1",
 * 	swaggerVersion="1.1",
 * 	resourcePath="SearchSuggestionsApi",
 * 	basePath="http://www.wikia.com"
 * )
 * 
 * @SWG\Model( id="SearchSuggestionsPhrases" )
 * 	@SWG\Property(
 * 		name="items",
 * 		type="Array",
 * 		description="Standard container name for element collection (list)",
 * 		items="$ref:SearchSuggestionsItems"
 * 	)
 * 
 * @SWG\Model( id="SearchSuggestionsItems" )
 * 	@SWG\Property(
 * 		name="title",
 * 		type="string",
 * 		required="true",
 * 		description="Searching article title"
 * 	)
 * 
 * @SWG\Api(
 * 	path="/api/v1/SearchSuggestions/List",
 * 	description="Controller to find suggested phrases for chosen query",
 * 	@SWG\Operations(
 * 		@SWG\Operation(
 * 			httpMethod="GET",
 * 			summary="Find suggested phrases for chosen query",
 * 			nickname="getList",
 * 			responseClass="SearchSuggestionsPhrases",
 * 			@SWG\ErrorResponses(
 * 				@SWG\ErrorResponse( code="404", reason="Search Suggestions extension not available or results not found" ),
 * 				@SWG\ErrorResponse( code="400", reason="Query parameter is missing" )
 * 			),
 * 			@SWG\Parameters(
 * 				@SWG\Parameter(
 * 					name="query",
 * 					description="Search term for suggestions",
 * 					paramType="query",
 * 					required="true",
 * 					allowMultiple="false",
 * 					dataType="string",
 * 					defaultValue=""
 * 				)
 * 			)
 * 		)
 * 	)
 * )
 */

die;
