<?php

class RecirculationController extends WikiaController {
	const ALLOWED_TYPES = ['popular', 'shares', 'recent_popular'];
	const DEFAULT_TYPE = 'popular';

	public function init() {
		$type = $this->getVal( 'type' );
		if ( in_array( $type, self::ALLOWED_TYPES ) ) {
			$this->type = $type;
		} else {
			$this->type = self::DEFAULT_TYPE;
		}
	}

	public function discussions() {
		$cityId = $this->request->getVal( 'cityId', null );

		if ( !empty( $cityId ) && !is_numeric( $cityId ) ) {
			throw new InvalidParameterApiException( 'cityId' );
		}

		if ( RecirculationHooks::canShowDiscussions( $cityId ) ) {
			$discussionsDataService = new DiscussionsDataService( $cityId );
			$posts = $discussionsDataService->getData( 'posts' )['posts'];

			if ( count( $posts ) > 0 ) {
				$discussionsUrl = "$discussionsDataService->server/d/f";

				$postObjects = [];

				foreach ( $posts as $post ) {
					$postObjects[] = $post->jsonSerialize();
				}

				$this->response->setCacheValidity( WikiaResponse::CACHE_VERY_SHORT );
				$this->response->setData( [
					'title' => wfMessage( 'recirculation-discussion-title' )->plain(),
					'linkText' => wfMessage( 'recirculation-discussion-link-text' )->plain(),
					'discussionsUrl' => $discussionsUrl,
					'posts' => $postObjects,
				] );
				return true;
			}
		}

		return false;
	}

	public function container( $params ) {
		$containerId = $this->request->getVal( 'containerId' );
		$this->response->setVal( 'containerId', $containerId );
	}
}
