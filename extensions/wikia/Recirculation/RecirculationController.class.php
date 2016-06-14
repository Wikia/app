<?php

class RecirculationController extends WikiaController {
	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;
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

	public function index() {
		$dataService = new ParselyDataService();

		$posts = $dataService->getPosts( $this->type );

		if ( count( $posts ) > 0 ) {
			$this->response->setCacheValidity( WikiaResponse::CACHE_VERY_SHORT );
			$this->response->setData( [
				'title'	=> wfMessage( 'recirculation-fandom-title' )->plain(),
				'posts' => $posts,
			] );
			return true;
		} else {
			return false;
		}
	}

	public function discussions() {
		global $wgCityId;

		if ( RecirculationHooks::canShowDiscussions() ) {
			$discussionsDataService = new DiscussionsDataService();
			$posts = $discussionsDataService->getPosts();

			if ( count( $posts ) > 0 ) {
				$discussionsUrl = "/d/f/$wgCityId/trending";

				$this->response->setCacheValidity( WikiaResponse::CACHE_VERY_SHORT );
				$this->response->setData( [
					'title' => wfMessage( 'recirculation-discussion-title' )->plain(),
					'linkText' => wfMessage( 'recirculation-discussion-link-text' )->plain(),
					'discussionsUrl' => $discussionsUrl,
					'posts' => $posts,
				] );
				return true;
			}
		}

		return false;
	}

	public function container( $params ) {
		$containerId = $this->request->getVal('containerId');
		$this->response->setVal('containerId', $containerId);
	}
}
