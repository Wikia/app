<?php

use Swagger\Annotations as SWG;

/**
 * @SWG\Resource(
 *     apiVersion="0.2",
 *     swaggerVersion="1.1",
 *     resourcePath="SearchSuggestionsApi",
 *     basePath="http://muppet.wikia.com"
 * )
 */

/**
 * @SWG\Model(id="SearchSuggestionsPhrases")
 *     @SWG\Property(
 *         name="items",
 *         type="Array",
 *         description="The list of phrases matching the query",
 *         items="$ref:SearchSuggestionsItems"
 *     )
 * )
 * @SWG\Model(id="SearchSuggestionsItems")
 *      @SWG\Property(
 *         name="title",
 *         type="string",
 *         required="true",
 *         description="Searching article title"
 *     )
 * )
 */

/**
 *
 * @SWG\Api(
 *     path="/wikia.php?controller=SearchSuggestionsApi&method=getList",
 *     description="Controller to find suggested phrases for chosen query",
 *     @SWG\Operations(
 *         @SWG\Operation(
 *             httpMethod="GET",
 *             summary="Finds suggested phrases for chosen query",
 *             nickname="getList",
 *             responseClass="SearchSuggestionsPhrases",
 *             @SWG\ErrorResponses(
 *                 @SWG\ErrorResponse( code="404", reason="Search Suggestions extension not available" )
 *             ),
 *             @SWG\Parameters(
 *                 @SWG\Parameter(
 *                     name="query",
 *                     description="Search term for suggestions",
 *                     paramType="query",
 *                     required="true",
 *                     allowMultiple="false",
 *                     dataType="String",
 *                     defaultValue=""
 *                 )
 *             )
 *         )
 *     )
 * )
 */

/**
* Controller to suggest searched phrases
*
* @author Artur Klajnerok <arturk@wikia-inc.com>
*/

class SearchSuggestionsApiController extends WikiaApiController {
	const PARAMETER_QUERY = 'query';

	/**
	 * Finds search suggestions phrases for chosen query
	 *
	 * @requestParam string $query search term for suggestions
	 *
	 * @responseParam array $items The list of phrases matching the query
	 *
	 * @example &query=los
	 */
	public function getList() {
		wfProfileIn(__METHOD__);

		if ( !empty( $this->wg->EnableLinkSuggestExt ) ) {

			$query = trim( $this->request->getVal( self::PARAMETER_QUERY, null ) );

			if ( empty( $query ) ) {
				throw new MissingParameterApiException( self::PARAMETER_QUERY );
			}

			$request = new WebRequest();
			$request->setVal('format', 'array');

			$linkSuggestions = LinkSuggest::getLinkSuggest( $request );

			if ( !empty( $linkSuggestions ) ) {

				foreach( $linkSuggestions as $suggestion ){
					$searchSuggestions[]['title'] = $suggestion;
				}

				$this->response->setVal( 'items', $searchSuggestions );

			} else {
				throw new NotFoundApiException();
			}

			$this->response->setCacheValidity(
				86400 /* 24h */,
				86400 /* 24h */,
				array(
					WikiaResponse::CACHE_TARGET_BROWSER,
					WikiaResponse::CACHE_TARGET_VARNISH
				)
			);
		} else {
			throw new NotFoundApiException( 'Link Suggest extension not available' );
		}

		wfProfileOut( __METHOD__ );
	}

}