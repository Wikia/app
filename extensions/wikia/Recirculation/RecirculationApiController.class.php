<?php

class RecirculationApiController extends WikiaApiController {

	const MAX_MIXED_CONTENT_FOOTER_SLOTS = 13;

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

		$limit = min(
			$this->request->getInt( 'limit', static::MAX_MIXED_CONTENT_FOOTER_SLOTS ),
			static::MAX_MIXED_CONTENT_FOOTER_SLOTS
		);

		$popularPagesService = new PopularPagesService();
		$data = $popularPagesService->getPopularPagesWithVideoInfo( $limit, 386, 337 );

		$this->response->setData( $data );
	}

	public function getTrendingFandomArticles() {
		global $wgParselyApiUrl, $wgParselyApiKey, $wgParselyApiSecret, $wgMemc;
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );

		$limit = min(
			$this->request->getInt( 'limit', static::MAX_MIXED_CONTENT_FOOTER_SLOTS ),
			static::MAX_MIXED_CONTENT_FOOTER_SLOTS
		);

		$articleService = new ParselyService( $wgParselyApiUrl, $wgParselyApiKey, $wgParselyApiSecret );
		$cachedArticleService = new CachedFandomArticleService( $wgMemc, $articleService );

		$posts = $cachedArticleService->getTrendingFandomArticles( $limit );

		$this->response->setData( $posts );
	}
}
