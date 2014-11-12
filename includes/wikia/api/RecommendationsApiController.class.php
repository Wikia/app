<?php

use Wikia\Api\Recommendations\Api;

class RecommendationsApiController extends WikiaApiController {

	public function getArticle() {
		$articleId = $this->request->getInt( 'id' );
		$limit = $this->request->getInt( 'limit', 9 );

		$title = Title::newFromID( $articleId );

		// validate parameters
		if ( is_null($title) || !$title->exists() ) {
			// TODO: message
			throw new BadRequestApiException();
		}

		$data = ( new Api )->get( $articleId, $limit );
		$this->setResponseData( [ 'items' => $data ], null, WikiaResponse::CACHE_STANDARD );
	}
}
