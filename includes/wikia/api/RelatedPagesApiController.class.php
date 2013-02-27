<?php
/**
 * Controller to fetch related pages for given article ids
 *
 * @author Jakub Olek <jakub.olek@wikia-inc.com>
 */

class RelatedPagesApiController extends WikiaApiController {
	const PARAMETER_ARTICLE_IDS = 'ids';
	const PARAMETER_LIMIT = 'limit';

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
		$this->wf->ProfileIn( __METHOD__ );

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
			$this->wf->ProfileOut( __METHOD__ );
			throw new MissingParameterApiException( 'ids' );
		}

		$this->response->setVal( 'related_pages', $related );
		$this->response->setVal( 'basepath', $this->wg->Server );

		$this->response->setCacheValidity(
			604800 /* 1 week */,
			604800 /* 1 week */,
			array(
				WikiaResponse::CACHE_TARGET_BROWSER,
				WikiaResponse::CACHE_TARGET_VARNISH
			)
		);
		$this->wf->ProfileOut( __METHOD__ );
	}
}