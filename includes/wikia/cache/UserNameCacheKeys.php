<?php

declare( strict_types=1 );

/**
 * This class organises generators for all cache keys which need to be cleared when user data
 * changes, for example when it's anonymized or renamed.
 */
class UserNameCacheKeys {
	/** @var string */
	private $encodedUsername;

	public function __construct( string $username ) {
		$this->encodedUsername = urlencode( $username );
	}

	public function getAllKeys( int $wikiId ): array {
		$keys = [
			$this->forUserId(),
			$this->forLookupUser( $wikiId ),
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

	public function forLookupUser( int $wikiId ): string {
		return wfSharedMemcKey( 'LookupUser', 'name', $this->encodedUsername, $wikiId );
	}

	public function forBlogArticleFeed( int $offset ): string {
		return wfMemcKey( 'blog', 'feed', 'v' . /* version */ 5, $this->encodedUsername, $offset );
	}

	public function forBlogArticleListing( int $offset ): string {
		return wfMemcKey( 'blog', 'listing', 'v' . /* version */ 5, $this->encodedUsername, $offset );
	}
}
