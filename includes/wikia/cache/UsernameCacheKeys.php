<?php

declare( strict_types=1 );

/**
 * This class organises generators for all cache keys which need to be cleared when user data
 * changes, for example when it's anonymized or renamed.
 */
class UsernameCacheKeys {

	/** @var string */
	private $username;

	public function __construct( string $username ) {
		$this->username = $username;
	}

	public function getAllKeys(int $wikiId): array {
		$keys = [
			$this->forUser(),
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
	public function forUser(): string {
		return wfSharedMemcKey( 'user', 'name', $this->username );
	}

	public function forLookupUser( int $wikiId ):string {
		return 'lookupUser' . 'user' . $this->username . 'on' . $wikiId;
	}

	public function forBlogArticleFeed( int $offset ): string {
		return wfMemcKey( 'blog', 'feed', 'v' . /* version */ 4, $this->username, $offset );
	}
	public function forBlogArticleListing( int $offset ): string {
		return wfMemcKey( 'blog', 'listing', 'v' . /* version */ 4, $this->username, $offset );
	}
}
