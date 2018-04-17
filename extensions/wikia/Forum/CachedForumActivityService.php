<?php

class CachedForumActivityService implements ForumActivityService {
	const CACHE_TTL = 86400; // 1 day

	/** @var ForumActivityService $forumActivityService */
	private $forumActivityService;
	/** @var BagOStuff $cacheService */
	private $cacheService;

	public function __construct( ForumActivityService $forumActivityService, BagOStuff $cacheService ) {
		$this->forumActivityService = $forumActivityService;
		$this->cacheService = $cacheService;
	}

	public function getRecentlyUpdatedThreads(): array {
		$key = static::getCacheKey();
		$cachedValue = $this->cacheService->get( $key );

		if ( $cachedValue !== false ) {
			return $cachedValue;
		}

		$freshValue = $this->forumActivityService->getRecentlyUpdatedThreads();
		$this->cacheService->set( $key, $freshValue, static::CACHE_TTL );

		return $freshValue;
	}

	public static function purgeCache() {
		WikiaDataAccess::cachePurge( static::getCacheKey() );
	}

	private static function getCacheKey(): string {
		return wfMemcKey( 'ForumActivityService', 'getRecentlyUpdatedThreads' );
	}
}
