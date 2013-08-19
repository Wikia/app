<?php

use Swagger\Annotations as SWG;

/**
 * @SWG\Resource(
 *     apiVersion="0.2",
 *     swaggerVersion="1.1",
 *     resourcePath="RelatedPagesApi",
 *     basePath="http://www.wikia.com/wikia.php"
 * )
 */

/**
 *
 * @SWG\Api(
 *   path="",
 *   description="Controller to fetch related pages for given article ids",
 *	@SWG\Operations(
 *		@SWG\Operation( httpMethod="GET", summary="Get RelatedPages for a given article ID", nickname="getList", responseClass="RelatedPages",
 * 			@SWG\ErrorResponses(
 * 				@SWG\ErrorResponse( code="404", reason="Related Pages extension not available" )
 * 			),
 * 			@SWG\Parameters(
 * 				@SWG\Parameter( name="controller", description="Controller used", paramType="query", required="true", allowMultiple="false", dataType="string", defaultValue="RelatedPagesApi" ),
 * 				@SWG\Parameter( name="method", description="Method used", paramType="query", required="true", allowMultiple="false", dataType="string", defaultValue="getList" ),
 * 				@SWG\Parameter( name="ids", description="Id of an article to fetch related pages for", paramType="query", required="true", allowMultiple="false", dataType="Array", defaultValue="2087" ),
 * 				@SWG\Parameter( name="limit", description="Limit the number of related pages to return", paramType="query", required="false", allowMultiple="false", dataType="int", defaultValue="3" )
 * 			)
 *		)
 *	)
 * )
 */

/**
 * @SWG\Model(
 * 	id="RelatedPages",
 * 	@SWG\Property(
 * 		name="items",
 * 		type="Array",
 * 		description="Result items",
 * 		items="$ref:RelatedPage"
 * 	),
 * @SWG\Property(
 * 		name="basepath",
 * 		type="string",
 * 		description="Base URL for current domain"
 * 	)
 * )
 * @SWG\Model(
 * 	id="RelatedPage",
 * 	@SWG\Property(
 * 		name="url",
 * 		type="string",
 * 		description="URL to article without domain part"
 * 	),
 * 	@SWG\Property(
 * 		name="title",
 * 		type="string",
 * 		description="Formatted article title"
 * 	),
 * 	@SWG\Property(
 * 		name="id",
 * 		type="int",
 * 		description="Article ID"
 * 	),
 * 	@SWG\Property(
 * 		name="imgUrl",
 * 		type="string",
 * 		description="URL for article image"
 * 	)
 * )
 */

class RelatedPagesApiController extends WikiaApiController {
	const PARAMETER_ARTICLE_IDS = 'ids';
	const PARAMETER_LIMIT = 'limit';

	/**
	 * Get RelatedPages for a given article ID
	 *
	 * @requestParam array $id Id of an article to fetch related pages for
	 * @requestParam integer $limit [OPTIONAL] Limit the number of related pages to return default: 3
	 *
	 * @responseParam object $items List of articles with related pages
	 * @responseParam array $basepath domain of a wiki to create a url for an article
	 *
	 * @example &ids=2087
	 * @example &ids=2087,3090
	 * @example &ids=2087&limit=5
	 */

	function getList(){
		wfProfileIn( __METHOD__ );

		if ( !empty( $this->wg->EnableRelatedPagesExt ) && empty( $this->wg->EnableAnswers ) ) {
			$ids = $this->request->getArray( self::PARAMETER_ARTICLE_IDS, null );
			$limit = $this->request->getInt( self::PARAMETER_LIMIT, 3 );

			$related = [];

			if ( is_array( $ids ) ) {
				$relatedPages = RelatedPages::getInstance();

				foreach( $ids as $id ) {
					if ( is_numeric( $id ) ) {
						$related[$id] = $relatedPages->get( $id, $limit );
					} else {
						throw new InvalidParameterApiException( self::PARAMETER_ARTICLE_IDS );
					}

					$relatedPages->reset();
				}
			} else {
				wfProfileOut( __METHOD__ );
				throw new MissingParameterApiException( 'ids' );
			}

			$this->response->setVal( 'items', $related );
			$this->response->setVal( 'basepath', $this->wg->Server );

			$this->response->setCacheValidity(
				10800 /* 3 hours */,
				10800 /* 3 hours */,
				array(
					WikiaResponse::CACHE_TARGET_BROWSER,
					WikiaResponse::CACHE_TARGET_VARNISH
				)
			);

			wfProfileOut( __METHOD__ );
		} else {
			wfProfileOut( __METHOD__ );
			throw new NotFoundApiException( 'Related Pages extension not available' );
		}
	}
}