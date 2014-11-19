<?php

use Wikia\Api\Recommendations\Collector;

class RecommendationsApiController extends WikiaApiController {

	public function getForArticle() {
		$articleId = $this->request->getInt( 'id' );
		$limit = $this->request->getInt( 'limit', 9 );

		$title = Title::newFromID( $articleId );

		// validate parameters
		if ( is_null($title) || !$title->exists() ) {
			throw new NotFoundApiException('Title not found');
		}

		$data = ( new Collector )->get( $articleId, $limit );
		$this->setResponseData( [ 'items' => $data ], null, WikiaResponse::CACHE_STANDARD );
	}
}
