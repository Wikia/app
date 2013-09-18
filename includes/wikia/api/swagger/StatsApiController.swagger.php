<?php

use Swagger\Annotations as SWG;

/**
 * @SWG\Resource(
 * 	apiVersion="1",
 * 	swaggerVersion="1.1",
 * 	resourcePath="Stats",
 * 	basePath="http://www.wikia.com"
 * )
 * 
 * @SWG\Model( id="Stats" )
 * 	@SWG\Property(
 * 		name="edits",
 * 		type="int",
 * 		required="true",
 * 		description="Number of edits on a wiki"
 * 	)
 * 	@SWG\Property(
 * 		name="articles",
 * 		type="int",
 * 		required="true",
 * 		description="Number of real articles on a wiki"
 * 	)
 * 	@SWG\Property(
 * 		name="pages",
 * 		type="int",
 * 		required="true",
 * 		description="Number of all pages on a wiki (eg. File pages, Articles, Category pages ...)"
 * 	)
 * 	@SWG\Property(
 * 		name="users",
 * 		type="int",
 * 		required="true",
 * 		description="Number of all users in a wiki"
 * 	)
 * 	@SWG\Property(
 * 		name="activeUsers",
 * 		type="int",
 * 		required="true",
 * 		description="Number of active users on a wiki"
 * 	)
 * 	@SWG\Property(
 * 		name="images",
 * 		type="int",
 * 		required="true",
 * 		description="Number of all images on a wiki"
 * 	)
 * 	@SWG\Property(
 * 		name="videos",
 * 		type="int",
 * 		required="true",
 * 		description="Number of all videos on a wiki"
 * 	)
 * 	@SWG\Property(
 * 		name="admins",
 * 		type="int",
 * 		required="true",
 * 		description="Number of all admins on a wiki"
 * 	)
 * 
 * @SWG\Api(
 * 	path="/api/v1/Stats/Data",
 * 	description="Controller to get statistical information about the current wiki",
 * 	@SWG\Operations(
 * 		@SWG\Operation(
 * 			httpMethod="GET",
 * 			summary="Get statistical information about the current wiki",
 * 			nickname="getData",
 * 			responseClass="Stats",
 * 			@SWG\ErrorResponses(
 * 				@SWG\ErrorResponse( code="404", reason="Stats extension not available" )
 * 			)
 * 		)
 * 	)
 * )
 */

die;
