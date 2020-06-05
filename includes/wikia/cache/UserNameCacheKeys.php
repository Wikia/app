<?php

declare( strict_types=1 );

/**
 * This class organises generators for all cache keys which need to be cleared when user data
 * changes, for example when it's anonymized or renamed.
 */
class UserNameCacheKeys {

	/** @var string */
	private $username;
	/** @var string */
	private $encodedUsername;

	public function __construct( string $username ) {
		$this->username = $username;
		$this->encodedUsername = urlencode( $username );
	}

	public function getAllKeys( int $wikiId ): array {
		$keys = [
			$this->forUserId(),
			$this->forUserIdLegacy(),
			$this->forLookupUser( $wikiId ),
			$this->forLookupUserLegacy( $wikiId ),
		];

		// clear up to 10 pages of blog listings
		for ( $i = 0; $i < 10; ++ $i ) {
			$keys[] = $this->forBlogArticleFeed( $i );
			$keys[] = $this->forBlogArticleListing( $i );
		}
		return $keys;
	}

	/**
	 *  SUS-2945
	 * @return string
	 */
	public function forUserId(): string {
		return wfSharedMemcKey( 'username-to-id',  $this->encodedUsername );
	}

	/**
	 *  SUS-2945
	 * @return string
	 * @deprecated
	 */
	public function forUserIdLegacy(): string {
		$newCacheKey = WikiFactory::getVarValueByName( 'wgNewCacheKey', 177, false, false );
		if ( $newCacheKey ) {
			return $this->forUserId();
		} else {
			return wfSharedMemcKey( 'user', 'name', $this->username );
		}
	}

	public function forLookupUser( int $wikiId ): string {
		return wfSharedMemcKey( 'LookupUser', 'name', $this->encodedUsername, $wikiId );
	}

	/**
	 * @param int $wikiId
	 * @return string
	 * @deprecated
	 */
	public function forLookupUserLegacy( int $wikiId ): string {
		$newCacheKey = WikiFactory::getVarValueByName( 'wgNewCacheKey', 177, false, false );
		if ( $newCacheKey ) {
			return $this->forLookupUser( $wikiId );
		} else {
			return 'lookupUser' . 'user' . $this->username . 'on' . $wikiId;
		}
	}

	public function forBlogArticleFeed( int $offset ): string {
		return wfMemcKey( 'blog', 'feed', 'v' . /* version */ 5, $this->encodedUsername, $offset );
	}

	public function forBlogArticleListing( int $offset ): string {
		return wfMemcKey( 'blog', 'listing', 'v' . /* version */ 5, $this->encodedUsername, $offset );
	}
}
