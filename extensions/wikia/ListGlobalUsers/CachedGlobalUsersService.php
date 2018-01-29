<?php

class CachedGlobalUsersService implements GlobalUsersService {
	const CACHE_TTL = 1500; // 15 mins

	/** @var BagOStuff $cacheService */
	private $cacheService;
	/** @var GlobalUsersService $globalUsersService */
	private $globalUsersService;

	public function __construct( BagOStuff $cacheService, GlobalUsersService $globalUsersService ) {
		$this->cacheService = $cacheService;
		$this->globalUsersService = $globalUsersService;
	}

	public function getGroupMembers( array $groupSet ): array {
		if ( empty( $groupSet ) ) {
			return [];
		}

		$cacheKey = static::makeCacheKey( $groupSet );
		$cachedResult = $this->cacheService->get( $cacheKey );

		if ( is_array( $cachedResult ) ) {
			return $cachedResult;
		}

		$groupMembers = $this->globalUsersService->getGroupMembers( $groupSet );
		$this->cacheService->set( $cacheKey, $groupMembers, static::CACHE_TTL );

		return $groupMembers;
	}

	private static function makeCacheKey( array $groupSet ): string {
		asort( $groupSet );
		return call_user_func_array( 'wfSharedMemcKey', array_merge( [ 'global-users' ], $groupSet ) );
	}
}
