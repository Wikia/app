<?php
use Swagger\Annotations as SWG;

/**
 *	@SWG\Resource(
 *		apiVersion="0.2",
 *		swaggerVersion="1.1",
 *		resourcePath="UserApi",
 *		basePath="http://www.wikia.com"
 *	)
 *
 *	@SWG\Model( id="UserElement" )
 *		@SWG\Property(
 *			name="user_id",
 *			type="int",
 *			required="true",
 *			description="An internal identification number for User"
 *		)
 *		@SWG\Property(
 *			name="title",
 *			type="string",
 *			required="true",
 *			description="Wikia user login"
 *		)
 *		@SWG\Property(
 *			name="name",
 *			type="string",
 *			required="true",
 *			description="Wikia user name (it can contain space characters)"
 *		)
 *		@SWG\Property(
 *			name="url",
 *			type="string",
 *			required="true",
 *			description="The relative URL of the User page. Absolute URL: obtained from combining relative URL with basepath attribute from response."
 *		)
 *		@SWG\Property(
 *			name="numberofedits",
 *			type="int",
 *			required="true",
 *			description="Total number of edits made by user on the current wiki"
 *		)
 *		@SWG\Property(
 *			name="avatar",
 *			type="string",
 *			required="true",
 *			description="The absolute URL of the user avatar image"
 *		)
 *
 *		@SWG\Model( id="UserResultSet" )
 *			@SWG\Property(
 *				name="items",
 *				required="true",
 *				type="Array",
 *				items="$ref:UserElement",
 *				description="Standard container name for element collection (list)"
 *			)
 *			@SWG\Property(
 *				name="basepath",
 *				type="string",
 *				required="true",
 *				description="Common URL prefix for relative URLs"
 *			)
 *
 *
 *	@SWG\Api(
 *		path="/wikia.php?controller=UserApi&method=getDetails",
 *		description="Get details about one or more user",
 *		@SWG\Operations(
 *			@SWG\Operation(
 *				httpMethod="GET",
 *				summary="Fetch details about selected users",
 *				nickname="getDetails",
 *				responseClass="UserResultSet",
 *				@SWG\ErrorResponses(
 *					@SWG\ErrorResponse( code="400", reason="Ids parameter is missing" ),
 *					@SWG\ErrorResponse( code="404", reason="Results not found" )
 *				),
 *				@SWG\Parameters(
 *					@SWG\Parameter(
 *						name="ids",
 *						description="The integer user ID values, comma-separated, max number of IDs is 100",
 *						paramType="query",
 *						required="true",
 *						allowMultiple="true",
 *						dataType="Array",
 *						defaultValue=""
 *					),
 *					@SWG\Parameter(
 *						name="size",
 *						description="The desired width (and height, because it is a square) for the thumbnail, defaults to 100, 0 for no thumbnail",
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
 */


die;