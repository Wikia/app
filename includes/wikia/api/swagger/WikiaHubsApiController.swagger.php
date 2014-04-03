<?php

use Swagger\Annotations as SWG;

/**
 * @SWG\Resource(
 * 	apiVersion="1",
 * 	swaggerVersion="1.1",
 * 	resourcePath="WikiaHubs",
 * 	basePath="http://www.wikia.com"
 * )
 * 
 * @SWG\Model( id="WikiaHubsResultSet" )
 * 	@SWG\Property(
 * 		name="data",
 * 		type="HubsData",
 * 		required="true",
 * 		description="Wrapping object"
 * 	)
 * 
 * @SWG\Model( id="HubsData" )
 * 	@SWG\Property(
 * 		name="slides",
 * 		type="Array",
 * 		items="$ref:SlideItem",
 * 		required="true",
 * 		description="Slides collection"
 * 	)
 * 
 * @SWG\Model( id="SlideItem" )
 * 	@SWG\Property(
 * 		name="photoUrl",
 * 		type="string",
 * 		required="true",
 * 		description="The absolute URL of the image"
 * 	)
 * 	@SWG\Property(
 * 		name="strapline",
 * 		type="string",
 * 		required="true",
 * 		description="Headline text"
 * 	)
 * 	@SWG\Property(
 * 		name="shortDesc",
 * 		type="string",
 * 		required="true",
 * 		description="Short description"
 * 	)
 * 	@SWG\Property(
 * 		name="longDesc",
 * 		type="string",
 * 		required="true",
 * 		description="Long description"
 * 	)
 * 	@SWG\Property(
 * 		name="url",
 * 		type="string",
 * 		required="true",
 * 		description="The absolute URL of the page"
 * 	)
 * 	@SWG\Property(
 * 		name="photoName",
 * 		type="string",
 * 		required="true",
 * 		description="Image name"
 * 	)
 *
 * @SWG\Api(
 * 	path="/api/v1/WikiaHubs/ModuleData",
 * 	description="Get explore module data from given date and city/vertical",
 * 	@SWG\Operations(
 * 		@SWG\Operation(
 * 			httpMethod="GET",
 * 			summary="Get explore module data from given date and city/vertical",
 * 			nickname="getModuleData",
 * 			responseClass="WikiaHubsResultSet",
 * 			@SWG\ErrorResponses(
 * 				@SWG\ErrorResponse( code="400", reason="Module, city, vertical or timestamp not valid" )
 * 			),
 * 			@SWG\Parameters(
 * 				@SWG\Parameter(
 * 					name="module",
 * 					description="Module id",
 * 					paramType="query",
 * 					required="true",
 * 					allowMultiple="false",
 * 					dataType="int"
 * 				),
 * 				@SWG\Parameter(
 * 					name="city",
 * 					description="City id (required if data should be puled from HubsV3)",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="int"
 * 				),
 * 				@SWG\Parameter(
 * 					name="vertical",
 * 					description="Vertical id (required if data should be puled from HubsV2)",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="int"
 * 				),
 * 				@SWG\Parameter(
 * 					name="lang",
 * 					description="Language",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="string",
 * 					defaultValue="en"
 * 				),
 * 				@SWG\Parameter(
 * 					name="ts",
 * 					description="The Unix timestamp (in seconds)",
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
 * @SWG\Api(
 * 	path="/api/v1/WikiaHubs/ModuleDataV2",
 * 	description="Get explore module data from given date and vertical (from HubsV2)",
 * 	@SWG\Operations(
 * 		@SWG\Operation(
 * 			httpMethod="GET",
 * 			summary="Get explore module data from given date and vertical (from HubsV2)",
 * 			nickname="getModuleDataV2",
 * 			responseClass="WikiaHubsResultSet",
 * 			@SWG\ErrorResponses(
 * 				@SWG\ErrorResponse( code="400", reason="Module, vertical or timestamp not valid" )
 * 			),
 * 			@SWG\Parameters(
 * 				@SWG\Parameter(
 * 					name="module",
 * 					description="Module id",
 * 					paramType="query",
 * 					required="true",
 * 					allowMultiple="false",
 * 					dataType="int"
 * 				),
 * 				@SWG\Parameter(
 * 					name="vertical",
 * 					description="Vertical id",
 * 					paramType="query",
 * 					required="true",
 * 					allowMultiple="false",
 * 					dataType="int"
 * 				),
 * 				@SWG\Parameter(
 * 					name="ts",
 * 					description="The Unix timestamp (in seconds)",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="int"
 * 				),
 * 				@SWG\Parameter(
 * 					name="lang",
 * 					description="Language",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="string",
 * 					defaultValue="en"
 * 				)
 * 			)
 * 		)
 * 	)
 * )
 *
 * @SWG\Api(
 * 	path="/api/v1/WikiaHubs/ModuleDataV3",
 * 	description="Get explore module data from given date and city (from HubsV3)",
 * 	@SWG\Operations(
 * 		@SWG\Operation(
 * 			httpMethod="GET",
 * 			summary="Get explore module data from given date and city (from HubsV3)",
 * 			nickname="getModuleDataV3",
 * 			responseClass="WikiaHubsResultSet",
 * 			@SWG\ErrorResponses(
 * 				@SWG\ErrorResponse( code="400", reason="Module, city or timestamp not valid" )
 * 			),
 * 			@SWG\Parameters(
 * 				@SWG\Parameter(
 * 					name="module",
 * 					description="Module id",
 * 					paramType="query",
 * 					required="true",
 * 					allowMultiple="false",
 * 					dataType="int"
 * 				),
 * 				@SWG\Parameter(
 * 					name="city",
 * 					description="City id",
 * 					paramType="query",
 * 					required="true",
 * 					allowMultiple="false",
 * 					dataType="int"
 * 				),
 * 				@SWG\Parameter(
 * 					name="ts",
 * 					description="The Unix timestamp (in seconds)",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="int"
 * 				),
 * 				@SWG\Parameter(
 * 					name="lang",
 * 					description="Language",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="string",
 * 					defaultValue="en"
 * 				)
 * 			)
 * 		)
 * 	)
 * )
 */

die;
