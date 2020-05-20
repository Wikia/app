<?php

declare( strict_types=1 );

/**
 * This class organises generators for all cache keys which need to be cleared when user data
 * changes, for example when it's anonymized or renamed.
 */
class UserIdCacheKeys {

	/** @var int */
	private $userId;

	public function __construct( int $userId ) {
		$this->userId = $userId;
	}

	public function getAllKeys(): array {
		return [
			$this->forUser(),
			$this->forFavoriteWikis(),
			$this->forUserIdentityBox(),
			$this->forLookupContribs(),
			$this->forHiddenWikis(),
			$this->forMastheadEdits()
		];
	}

	public function forUser(): string {
		return wfMemcKey( 'user', 'id', $this->userId );
	}

	public function forUserIdentityBox(): string {
		return wfSharedMemcKey( 'user-identity-box-data0', $this->userId, /* version */ 3 );
	}

	public function forLookupContribs(): string {
		return wfSharedMemcKey( 'LookupContribsCore', $this->userId );
	}

	public function forFavoriteWikis(): string {
		return wfSharedMemcKey( 'user-identity-box-data-top-wikis', $this->userId, /* version */ 3 );
	}

	public function forMastheadEdits(): string {
		return wfSharedMemcKey( 'user-identity-box-data-masthead-edits0', $this->userId, /* version */ 3 );
	}

	public function forHiddenWikis() {
		return wfSharedMemcKey( 'user-identity-box-data-top-hidden-wikis', $this->userId, /* version */ 3 );
	}
}
