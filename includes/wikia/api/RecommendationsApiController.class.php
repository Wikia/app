<?php

use Wikia\Api\Recommendations\Collector;

/**
 * Recommendations API
 * @author Maciej Brench <macbre@wikia-inc.com>
 * @author Damian Jozwiak <damian@wikia-inc.com>
 * @author Łukasz Konieczny <lukaszk@wikia-inc.com>
 *
 */
class RecommendationsApiController extends WikiaApiController {

	/**
	 * Get recommendations for article
	 *
	 * @requestParam int id article ID
	 * @requestParam int limit
	 * @responseParam array items list of content recommendations
	 * @throws NotFoundApiException
	 */
	public function getForArticle() {
		$articleId = $this->request->getInt( 'id' );
		$limit = $this->request->getInt( 'limit', 9 );
		// TODO limit validation

		$title = Title::newFromID( $articleId );

		// validate parameters
		if ( is_null($title) || !$title->exists() ) {
			throw new NotFoundApiException('Title not found');
		}

		$data = ( new Collector )->get( $articleId, $limit );
		$this->setResponseData( [ 'items' => $data ], null, WikiaResponse::CACHE_STANDARD );
	}
}
