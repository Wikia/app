<?php

use Swagger\Annotations as SWG;

/**
 * @SWG\Resource(
 * 	apiVersion="0.2",
 * 	swaggerVersion="1.1",
 * 	resourcePath="WAMApi",
 * 	basePath="http://www.wikia.com"
 * )
 * 
 * @SWG\Model( id="MinMaxResultSet" )
 * 	@SWG\Property(
 * 		name="min_max_dates",
 * 		type="MinMaxDatesItem",
 * 		required=true,
 * 		description="Object containing minimal and maximal dates for wam index results"
 * 	)
 * 
 * @SWG\Model( id="MinMaxDatesItem" )
 * 	@SWG\Property(
 * 		name="max_date",
 * 		type="int",
 * 		required=true,
 * 		description="The Unix timestamp (in seconds) for maximal date of index"
 * 	)
 * 	@SWG\Property(
 * 		name="min_date",
 * 		type="int",
 * 		required=true,
 * 		description="The Unix timestamp (in seconds) for minimal date of index"
 * 	)
 * 
 * @SWG\Model( id="WAMResultSet" )
 * 	@SWG\Property(
 * 		name="wam_index",
 * 		type="Array",
 * 		items="$ref:WAMItem",
 * 		required=true,
 * 		description="Collection of wam index ordered by ranking"
 * 	)
 * 	@SWG\Property(
 * 		name="wam_results_total",
 * 		type="int",
 * 		required="true",
 * 		description="The total count of wikis available for provided params"
 * 	)
 * 	@SWG\Property(
 * 		name="wam_index_date",
 * 		type="int",
 * 		required="true",
 * 		description="date of received list"
 * 	)
 * 
 * @SWG\Model( id="WAMItem" )
 * 	@SWG\Property(
 * 		name="wiki_id",
 * 		type="int",
 * 		required="true",
 * 		description="An internal identification number for Wikia"
 * 	)
 * 	@SWG\Property(
 * 		name="wam",
 * 		type="float",
 * 		required="true",
 * 		description="WAM score"
 * 	)
 * 	@SWG\Property(
 * 		name="wam_rank",
 * 		type="int",
 * 		required="true",
 * 		description="WAM ranking"
 * 	)
 * 	@SWG\Property(
 * 		name="hub_wam_rank",
 * 		type="int",
 * 		required="true",
 * 		description="Wiki wam rank within its hub"
 * 	)
 * 	@SWG\Property(
 * 		name="peak_wam_rank",
 * 		type="int",
 * 		required="true",
 * 		description="the peak WAM Rank achieved by this Wiki"
 * 	)
 * 	@SWG\Property(
 * 		name="peak_hub_wam_rank",
 * 		type="int",
 * 		required="true",
 * 		description="peak WAM Rank within its Hub"
 * 	)
 * 	@SWG\Property(
 * 		name="top_1k_days",
 * 		type="int",
 * 		required="true",
 * 		description="the number of days that the Wiki has been in the top 1000 Wikis"
 * 	)
 * 	@SWG\Property(
 * 		name="top_1k_weeks",
 * 		type="int",
 * 		required="true",
 * 		description="the number of weeks that the Wiki has been in the top 1000 Wikis"
 * 	)
 * 	@SWG\Property(
 * 		name="first_peak",
 * 		type="string",
 * 		required="true",
 * 		description="the first date that the Wiki achieved its peak_wam_rank"
 * 	)
 * 	@SWG\Property(
 * 		name="last_peak",
 * 		type="string",
 * 		required="true",
 * 		description="the last time that the Wiki was at its peak_wam_rank"
 * 	)
 * 	@SWG\Property(
 * 		name="hub_name",
 * 		type="string",
 * 		required="true",
 * 		description="hub name"
 * 	)
 * 	@SWG\Property(
 * 		name="title",
 * 		type="string",
 * 		required="true",
 * 		description="Wiki title"
 * 	)
 * 	@SWG\Property(
 * 		name="url",
 * 		type="string",
 * 		required="true",
 * 		description="The absolute URL of the Wikia"
 * 	)
 * 	@SWG\Property(
 * 		name="hub_id",
 * 		type="int",
 * 		required="true",
 * 		description="An internal identification number for Hub"
 * 	)
 * 	@SWG\Property(
 * 		name="wam_change",
 * 		type="float",
 * 		required="true",
 * 		description="wam score change from wam_previous_day"
 * 	)
 * 	@SWG\Property(
 * 		name="wam_is_new",
 * 		type="int",
 * 		required="true",
 * 		description="1 if wiki wasn't classified on $wam_previous_day, 0 if this wiki was in index"
 * 	)
 * 	@SWG\Property(
 * 		name="wiki_image",
 * 		type="string",
 * 		required="false",
 * 		description="The absolute URL of the Wikia image"
 * 	)
 * 	@SWG\Property(
 * 		name="admins",
 * 		type="Array",
 * 		items="$ref:AdminItem",
 * 		required="false",
 * 		description="Wiki admins list"
 * 	)
 * 
 * @SWG\Model( id="AdminItem" )
 * 	@SWG\Property(
 * 		name="avatarUrl",
 * 		type="string",
 * 		required="true",
 * 		description="The absolute URL of the User avatar image"
 * 	)
 * 	@SWG\Property(
 * 		name="edits",
 * 		type="int",
 * 		required="true",
 * 		description="Number of edits"
 * 	)
 * 	@SWG\Property(
 * 		name="name",
 * 		type="string",
 * 		required="true",
 * 		description="Admin name"
 * 	)
 * 	@SWG\Property(
 * 		name="userPageUrl",
 * 		type="string",
 * 		required="true",
 * 		description="The absolute URL of the User page"
 * 	)
 * 	@SWG\Property(
 * 		name="userContributionsUrl",
 * 		type="string",
 * 		required="true",
 * 		description="The absolute URL of the User contributions page"
 * 	)
 * 	@SWG\Property(
 * 		name="userId",
 * 		type="string",
 * 		required="int",
 * 		description="An internal identification number for User"
 * 	)
 * 	@SWG\Property(
 * 		name="since",
 * 		type="string",
 * 		required="true",
 * 		description="Join date"
 * 	)
 * 
 * @SWG\Api(
 * 	path="/wikia.php?controller=WAMApi&method=getWAMIndex",
 * 	description="Get WAM index (list of wikis with their WAM ranks)",
 * 	@SWG\Operations(
 * 		@SWG\Operation(
 * 			httpMethod="GET",
 * 			summary="Get WAM index (list of wikis with their WAM ranks)",
 * 			nickname="getWAMIndex",
 * 			responseClass="WAMResultSet",
 * 			@SWG\ErrorResponses(
 *				@SWG\ErrorResponse( code="400", reason="Invalid parameters passed" )
 *			),
 * 			@SWG\Parameters(
 * 				@SWG\Parameter(
 * 					name="wam_day",
 * 					description="day for which the WAM scores are displayed",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="int"
 * 				),
 * 				@SWG\Parameter(
 * 					name="wam_previous_day",
 * 					description="day from which the difference in WAM scores is calculated",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="int"
 * 				),
 * 				@SWG\Parameter(
 * 					name="vertical_id",
 * 					description="vertical for which wiki list is to be pulled",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="true",
 * 					dataType="int",
 * 					defaultValue="2,3,9"
 * 				),
 * 				@SWG\Parameter(
 * 					name="wiki_lang",
 * 					description="Language code if narrowing the results to specific language",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="string"
 * 				),
 * 				@SWG\Parameter(
 * 					name="wiki_id",
 * 					description="Id of specific wiki to pull",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="int"
 * 				),
 * 				@SWG\Parameter(
 * 					name="wiki_word",
 * 					description="Fragment of url to search for amongst wikis",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="string"
 * 				),
 * 				@SWG\Parameter(
 * 					name="exclude_blacklist",
 * 					description="Determines if exclude blacklisted wikis (with Content Warning enabled)",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="boolean"
 * 				),
 * 				@SWG\Parameter(
 * 					name="sort_column",
 * 					description="Column by which to sort",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="string",
 * 					@SWG\AllowableValues(
 * 						valueType="LIST",
 * 						values="['wam_rank', 'wam_change', 'wam']"
 * 					),
 * 					defaultValue="wam"
 * 				),
 * 				@SWG\Parameter(
 * 					name="sort_direction",
 * 					description="Sort direction",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="string",
 * 					@SWG\AllowableValues(
 * 						valueType="LIST",
 * 						values="['ASC', 'DESC']"
 * 					),
 * 					defaultValue="ASC"
 * 				),
 * 				@SWG\Parameter(
 * 					name="offset",
 * 					description="offset from the beginning of data",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="int",
 * 					defaultValue="0"
 * 				),
 * 				@SWG\Parameter(
 * 					name="limit",
 * 					description="limit on fetched number of wikis",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="int",
 * 					@SWG\AllowableValues(
 * 						valueType="RANGE",
 * 						min="0",
 * 						max="20"
 * 					),
 * 					defaultValue="20"
 * 				),
 * 				@SWG\Parameter(
 * 					name="fetch_admins",
 * 					description="Determines if admins of each wiki are to be returned",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="boolean",
 * 					defaultValue="0"
 * 				),
 * 				@SWG\Parameter(
 * 					name="avatar_size",
 * 					description="Size of admin avatars in pixels if fetch_admins is enabled",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="int"
 * 				),
 * 				@SWG\Parameter(
 * 					name="fetch_wiki_images",
 * 					description="Determines if image of each wiki is to be returned",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="boolean",
 * 					defaultValue="false"
 * 				),
 * 				@SWG\Parameter(
 * 					name="wiki_image_width",
 * 					description="Width of wiki image in pixels if fetch_wiki_images is enabled",
 * 					paramType="query",
 * 					required="false",
 * 					allowMultiple="false",
 * 					dataType="int"
 * 				),
 * 				@SWG\Parameter(
 * 					name="wiki_image_height",
 * 					description="Height of wiki image in pixels if fetch_wiki_images is enabled. You can pass here -1 to keep aspect ratio",
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
 * 	path="/wikia.php?controller=WAMApi&method=getMinMaxWamIndexDate",
 * 	description="Get WAM score starting and last available dates",
 * 	@SWG\Operations(
 * 		@SWG\Operation(
 * 			httpMethod="GET",
 * 			summary="Get WAM score starting and last available dates",
 * 			nickname="getMinMaxWamIndexDate",
 * 			responseClass="MinMaxResultSet"
 * 		)
 * 	)
 * )
 */

die;