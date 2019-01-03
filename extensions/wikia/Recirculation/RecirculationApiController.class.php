<?php

class RecirculationApiController extends WikiaApiController {
	const ALLOWED_TYPES = ['recent_popular', 'vertical', 'community', 'curated', 'hero', 'category', 'latest', 'posts', 'all', 'stories'];

	/**
	 * @var CrossOriginResourceSharingHeaderHelper
	 */
	protected $cors;

	public function __construct() {
		parent::__construct();
		$this->cors = new CrossOriginResourceSharingHeaderHelper();
		$this->cors->setAllowAllOrigins();
	}

	public function getPopularWikiArticles() {
		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );
		$this->response->setData( WikiRecommendations::getPopularArticles() );
	}

	public function getPopularPages() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );

		$limit = max( $this->request->getInt( 'limit', 13 ), 13 );

		$popularPagesService = new PopularPagesService();
		$data = $popularPagesService->getPopularPagesWithVideoInfo( $limit, 386, 337 );

		$this->response->setData( $data );
	}
}
