<?php

class RecirculationApiController extends WikiaApiController {
	const ALLOWED_TYPES = ['popular', 'shares', 'recent_popular', 'vertical', 'community', 'curated'];

	public function getFandomPosts() {
		$type = $this->request->getVal( 'type' );
		if ( !$type || !in_array( $type, self::ALLOWED_TYPES ) ) {
			throw new InvalidParameterApiException( 'type' );
		}

		if ($type === 'curated') {
			$fandomDataService = new CuratedContentService();
		} else {
			$fandomDataService = new FandomDataService();
		}

		$posts = $fandomDataService->getPosts( $type );

		$this->response->setCacheValidity( WikiaResponse::CACHE_VERY_SHORT );
		$this->response->setData( [
			'title' => wfMessage( 'recirculation-fandom-title' )->plain(),
			'posts' => $posts,
		] );
	}

	public function getCakeRelatedContent() {
		$target = trim($this->request->getVal('relatedTo'));
		if (empty($target)) {
			throw new InvalidParameterApiException('relatedTo');
		}

		$limit = trim($this->request->getVal('limit'));
		$ignore = trim($this->request->getVal('ignore'));

		$this->response->setCacheValidity(WikiaResponse::CACHE_VERY_SHORT);
		$this->response->setData([
				'title' => wfMessage( 'recirculation-fandom-subtitle' )->plain(),
				'items' => (new CakeRelatedContentService())->getContentRelatedTo($target, $limit, $ignore),
		]);
	}

	public function getAllPosts() {
		$fandomDataService = new FandomDataService();
		$fandom = [
			'title' => wfMessage( 'recirculation-fandom-title' )->plain(),
			'items' => $fandomDataService->getPosts( 'recent_popular', 12 )
		];

		$discussionsData = [];
		if ( RecirculationHooks::canShowDiscussions() ) {
			$discussionsDataService = new DiscussionsDataService();
			$discussionsData = $discussionsDataService->getData();
			$discussionsData['title'] = wfMessage( 'recirculation-discussion-title' )->plain();
			$discussionsData['linkText'] = wfMessage( 'recirculation-discussion-link-text' )->plain();
		}

		$articleId = $this->request->getVal( 'articleId' );
		$articles = $this->app->sendRequest( 'ArticlesApi', 'getTop', [
			'abstract' => 0,
			'expand' => 1,
			'height' => 220,
			'limit' => 8,
			'namespaces' => 0,
			'width' => 385,
		] )->getVal( 'items' );

		$this->response->setCacheValidity( WikiaResponse::CACHE_VERY_SHORT );
		$this->response->setData( [
			'title' => wfMessage( 'recirculation-impact-footer-title' )->plain(),
			'fandom' => $fandom,
			'discussions' => $discussionsData,
			'articles' => $articles
		] );
	}
}
