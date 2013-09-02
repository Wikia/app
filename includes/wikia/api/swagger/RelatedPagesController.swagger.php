<?php

use Swagger\Annotations as SWG;

/**
 * @SWG\Resource(
 *     apiVersion="0.2",
 *     swaggerVersion="1.1",
 *     resourcePath="RelatedPagesApi",
 *     basePath="http://muppet.wikia.com"
 * )
 */

/**
 *
 * @SWG\Api(
 *     path="/wikia.php?controller=RelatedPagesApi&method=getList",
 *     description="Controller to fetch related pages for given article ID",
 *     @SWG\Operations(
 *         @SWG\Operation(
 *             httpMethod="GET",
 *             summary="Get pages related to a given article ID",
 *             nickname="getList",
 *             responseClass="RelatedPages",
 *             @SWG\ErrorResponses(
 *                 @SWG\ErrorResponse( code="404", reason="Related Pages extension not available" )
 *             ),
 *             @SWG\Parameters(
 *                 @SWG\Parameter(
 *                     name="ids",
 *                     description="Id of an article to fetch related pages for",
 *                     paramType="query",
 *                     required="true",
 *                     allowMultiple="false",
 *                     dataType="Array",
 *                     defaultValue="50"
 *                 ),
 *                 @SWG\Parameter(
 *                     name="limit",
 *                     description="Limit the number of related pages to return",
 *                     paramType="query",
 *                     required="false",
 *                     allowMultiple="false",
 *                     dataType="int",
 *                     defaultValue="3"
 *                 )
 *             )
 *         )
 *     )
 * )
 */

/**
 * @SWG\Model(
 *     id="RelatedPages",
 *     @SWG\Property(
 *         name="items",
 *         type="Array",
 *         description="Standard container name for element collection (list)",
 *         items="$ref:RelatedPage"
 *     ),
 *     @SWG\Property(
 *         name="basepath",
 *         type="string",
 *         description="Common URL prefix for relative URLs"
 *     )
 * )
 * @SWG\Model(
 *     id="RelatedPage",
 *     @SWG\Property(
 *         name="url",
 *         type="string",
 *         required="true",
 *         description="The relative URL of the Article. Absolute URL: obtained from combining relative URL with basepath attribute from response."
 *  ),
 *      @SWG\Property(
 *         name="title",
 *         type="string",
 *         required="true",
 *         description="Formatted article title"
 *     ),
 *     @SWG\Property(
 *         name="id",
 *         type="int",
 *         required="true",
 *         description="An internal identification number for Article"
 * ),
 *     @SWG\Property(
 *         name="imgUrl",
 *         type="string",
 *         required="true",
 *         description="The absolute URL of the image"
 *     )
 * )
 */

die;
