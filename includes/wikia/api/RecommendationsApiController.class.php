<?php

use Wikia\Api\Recommendations\Api;

class RecommendationsApiController extends WikiaApiController {

	public function getArticle() {
		$articleId = $this->request->getInt( 'articleId' );
		$limit = $this->request->getInt( 'limit', 9 );

		$data = ( new Api )->get( $articleId, $limit );
		$this->setResponseData( $data, null, WikiaResponse::CACHE_STANDARD );
	}
}