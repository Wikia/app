<?php

class CachedFandomArticleService implements FandomArticleService {

	const CACHE_TTL_SECONDS = 900; // 15 minutes

	/** @var BagOStuff $cacheService */
	private $cacheService;
	/** @var FandomArticleService $articleService */
	private $articleService;

	public function __construct( BagOStuff $cacheService, FandomArticleService $articleService ) {
		$this->cacheService = $cacheService;
		$this->articleService = $articleService;
	}

	public function getTrendingFandomArticles( int $limit ): array {
		$key = wfSharedMemcKey( 'recirculation-trending-fandom-articles', $limit );
		$cachedValue = $this->cacheService->get( $key );

		if ( is_array( $cachedValue ) ) {
			return $cachedValue;
		}

		$freshValue = $this->articleService->getTrendingFandomArticles( $limit );

		$this->cacheService->set( $key, $freshValue, static::CACHE_TTL_SECONDS );

		return $freshValue;
	}
}
