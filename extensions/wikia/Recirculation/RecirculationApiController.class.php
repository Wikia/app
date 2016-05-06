<?php

class RecirculationApiController extends WikiaApiController {
	const ALLOWED_TYPES = ['popular', 'shares', 'recent_popular', 'vertical', 'community'];

	public function getFandomPosts() {
		$type = $this->request->getVal( 'type' );
		if ( !$type || !in_array( $type, self::ALLOWED_TYPES ) ) {
			throw new InvalidParameterApiException( 'type' );
		}

		$fandomDataService = new FandomDataService();

		$posts = $fandomDataService->getPosts( $type );

		$this->response->setCacheValidity( WikiaResponse::CACHE_VERY_SHORT );
		$this->response->setData( [
			'title' => wfMessage( 'recirculation-fandom-title' )->plain(),
			'posts' => $posts,
		] );
	}
}
