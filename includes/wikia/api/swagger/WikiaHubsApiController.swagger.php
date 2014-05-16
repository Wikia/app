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
 * @SWG\Model( id="WikiaHubsListResultSet" )
 * 	@SWG\Property(
 * 		name="list",
 * 		type="HubInfo",
 * 		items="$ref:HubInfo"
 * 		required="true",
 * 		description="Hubs collection"
 * 	)
 *
 * @SWG\Model( id="HubInfo" )
 * 	@SWG\Property(
 * 		name="id",
 * 		type="int",
 * 		required="true",
 * 		description="City ID"
 * 	),
 * 	@SWG\Property(
 * 		name="name",
 * 		type="string",
 * 		required="true",
 * 		description="City name"
 * 	),
 * 	@SWG\Property(
 * 		name="url",
 * 		type="string",
 * 		required="true",
 * 		description="The absolute URL of the hub"
 * 	),
 * 	@SWG\Property(
 * 		name="language",
 * 		type="string",
 * 		required="true",
 * 		description="Hub language code"
 * 	)
 *
 *
 * @SWG\Api(
 * 	path="/WikiaHubs/ModuleData",
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
 * 				)
 * 			)
 * 		)
 * 	)
 * )
 *
 * @SWG\Api(
 * 	path="/WikiaHubs/ModuleDataV3",
 * 	description="Get explore module data from given date and city",
 * 	@SWG\Operations(
 * 		@SWG\Operation(
 * 			httpMethod="GET",
 * 			summary="Get explore module data from given date and city",
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
 * 				)
 * 			)
 * 		)
 * 	)
 * )
 *
 * @SWG\Api(
 * 	path="/WikiaHubs/HubsV3List",
 * 	description="Get Hubs list",
 * 	@SWG\Operations(
 * 		@SWG\Operation(
 * 			httpMethod="GET",
 * 			summary="Get Hubs list",
 * 			nickname="getHubsV3List",
 * 			responseClass="WikiaHubsListResultSet",
 * 			@SWG\Parameters(
 * 				@SWG\Parameter(
 * 					name="lang",
 * 					description="Language",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="string"
 * 				)
 * 			)
 * 		)
 * 	)
 * )
 */

die;
