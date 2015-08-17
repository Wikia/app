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
	const MIN_LIMIT = 1;
	const MAX_LIMIT = 30;

	const PARAM_NAME_ID = 'id';
	const PARAM_NAME_LIMIT = 'limit';

	/**
	 * Get recommendations for article
	 *
	 * @requestParam int id article ID
	 * @requestParam int limit
	 * @responseParam array items list of content recommendations
	 * @throws NotFoundApiException
	 */
	public function getForArticle() {
		$articleId = $this->request->getVal( self::PARAM_NAME_ID );
		$limit = $this->request->getInt( self::PARAM_NAME_LIMIT, 9 );

		if ( $articleId === null ) {
			throw new MissingParameterApiException( self::PARAM_NAME_ID );
		} else {
			$articleId = intval( $articleId );
		}

		if ( $limit > self::MAX_LIMIT ) {
			throw new LimitExceededApiException( self::PARAM_NAME_LIMIT, self::MAX_LIMIT );
		} else if ($limit < self::MIN_LIMIT ) {
			throw new LimitExceededApiException( self::PARAM_NAME_LIMIT, self::MIN_LIMIT );
		}

		$title = Title::newFromID( $articleId );

		// validate parameters
		if ( is_null($title) || !$title->exists() ) {
			throw new NotFoundApiException('Title not found');
		}

		$data = ( new Collector )->get( $articleId, $limit );
		$this->setResponseData( [ 'items' => $data ], null, WikiaResponse::CACHE_STANDARD );
	}
}
