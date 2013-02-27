<?php
/**
 * Controller to fetch related pages for given article ids
 *
 * @author Jakub Olek <jakub.olek@wikia-inc.com>
 */

class RelatedPagesApiController extends WikiaApiController {
	const ITEMS_PER_BATCH = 25;
	const PARAMETER_WIKI_IDS = 'ids';

	/**
	 * Get RelatedPages for a givin article ID
	 *
	 * @requestParam string $id Id of an article to fetch related pages for
	 * @requestParam string $limit [OPTIONAL] Limit the number of related pages to return default: 3
	 *
	 * @responseParam array $items The list of top wikis by pageviews matching the optional filtering
	 * @responseParam integer $total The total number of results
	 *
	 * @example &id=2087
	 * @example &id=2087&limit=5
	 */

	function getList(){
		$articleid = $this->request->getInt( 'id', 0 );
		$limit = $this->request->getInt( 'limit', 3 );

		if ( $articleid != 0 ) {
			$relatedPages = RelatedPages::getInstance();



			$this->response->setVal( 'relatedPages', $relatedPages->get( $articleid, $limit ) );
		} else {
			throw new MissingParameterApiException( 'id' );
		}

//		$this->response->setCacheValidity(
//			1209600 /* 2 weeks */,
//			1209600 /* 1 week */,
//			array(
//				WikiaResponse::CACHE_TARGET_BROWSER,
//				WikiaResponse::CACHE_TARGET_VARNISH
//			)
//		);
	}
}