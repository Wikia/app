<?php

use Swagger\Annotations as SWG;

/**
 * @SWG\Resource(
 * 	apiVersion="0.2",
 * 	swaggerVersion="1.1",
 * 	resourcePath="NavigationApi",
 * 	basePath="http://www.wikia.com"
 * )
 * 
 * @SWG\Model( id="NavigationResultSet" )
 * 	@SWG\Property(
 * 		name="navigation",
 * 		type="NavigationItem",
 * 		required="true",
 * 		description="Wrapper for navigation objects"
 * 	)
 * 
 * @SWG\Model( id="NavigationItem" )
 * 	@SWG\Property(
 * 		name="wikia",
 * 		type="Array",
 * 		items="$ref:WikiaItem",
 * 		required="true",
 * 		description="On the wiki navigation bar data"
 * 	)
 * 	@SWG\Property(
 * 		name="wiki",
 * 		type="Array",
 * 		items="$ref:WikiaItem",
 * 		required="true",
 * 		description="User set navigation bars"
 * 	)
 * 
 * @SWG\Model( id="WikiaItem" )
 * 	@SWG\Property(
 * 		name="text",
 * 		type="string",
 * 		required="true",
 * 		description="On wiki navigation bar text"
 * 	)
 * 	@SWG\Property(
 * 		name="href",
 * 		type="string",
 * 		required="true",
 * 		description="The relative URL of the Page. Absolute URL: obtained from combining relative URL with basepath attribute from response."
 * 	)
 * 	@SWG\Property(
 * 		name="children",
 * 		type="Array",
 * 		items="$ref:ChildrenItem",
 * 		required="true",
 * 		description="Children collection containing article or special pages data"
 * 	)
 * 
 * @SWG\Model( id="ChildrenItem" )
 * 	@SWG\Property(
 * 		name="text",
 * 		type="string",
 * 		required="true",
 * 		description="Article or special page title"
 * 	)
 * 	@SWG\Property(
 * 		name="href",
 * 		type="string",
 * 		required="true",
 * 		description="The relative URL of the Page. Absolute URL: obtained from combining relative URL with basepath attribute from response."
 * 	)
 *
 * @SWG\Api(
 * 	path="/wikia.php?controller=NavigationApi&method=getData",
 * 	description="Fetches wiki navigation",
 * 	@SWG\Operations(
 * 		@SWG\Operation(
 * 			httpMethod="GET",
 * 			summary="Fetches wiki navigation",
 * 			nickname="getData",
 * 			responseClass="NavigationResultSet"
 * 		)
 * 	)
 * )
 *
 */

die;
