<?php

class FandomDataService {
	static protected $instance = null;

	const PARSELY_API_BASE = 'https://api.parsely.com/v2/';
	const PARSELY_API_LIMIT = 8; // We request more posts than we actually need incase we receive duplicates
	const PARSELY_API_PAGE = 1;
	const PARSELY_API_PUB_DAYS = 10;
	const PARSELY_API_SORT = '_hits';

	const PARSELY_POSTS_LIMIT = 5;

	const MCACHE_VER = '1.0';
	const MCACHE_TIME = 900; // 15 minutes

	/**
	 * Get posts for a specific type. Uses cache if available
	 * @param string $type
	 * @return an array of posts
	 */
	public function getPosts( $type ) {
		$memcKey = wfSharedMemcKey( __METHOD__, $type, self::MCACHE_VER );

		$data = WikiaDataAccess::cache(
			$memcKey,
			self::MCACHE_TIME,
			function() use ( $type ) {
				return $this->apiRequest( $type );
			}
		);

		return $data;
	}

	/**
	 * Make an API request to parsely to gather posts
	 * @param string $type
	 * @return an array of posts
	 */
	private function apiRequest( $type ) {
		$options = [];
		switch ( $type ) {
			case 'shares':
				$options['days'] = 5;
				$endpoint = 'shares/posts';
				break;
			case 'recent_popular':
				$options['sort'] = self::PARSELY_API_SORT;
				$options['pub_days'] = self::PARSELY_API_PUB_DAYS;
				$endpoint = 'analytics/posts';
				break;
			case 'popular':
			default:
				$options['sort'] = self::PARSELY_API_SORT;
				$endpoint = 'analytics/posts';
				break;
		}

		$url = $this->buildUrl( $endpoint, $options );
		$data = ExternalHttp::get( $url );

		$obj = json_decode( $data );
		$posts = $this->dedupePosts( $obj->data );
		return $posts;
	}

	/**
	 * Build a complete url to the parsely API
	 * @param string $endpoint
	 * @param array $options
	 * @return string
	 */
	private function buildUrl( $endpoint, $options ) {
		global $wgParselyApiKey, $wgParselyApiSecret;

		$defaultParams = [
			'apikey' => $wgParselyApiKey,
			'secret' => $wgParselyApiSecret,
			'page' => self::PARSELY_API_PAGE,
			'limit' => self::PARSELY_API_LIMIT
		];

		$params = array_merge( $defaultParams, $options );

		$url = self::PARSELY_API_BASE . $endpoint . '?' . http_build_query( $params );

		return $url;
	}

	/**
	 * Remove duplicates from Parsely's API result
	 * @param array $rawPosts
	 * @return array
	 */
	private function dedupePosts( $rawPosts ) {
		$posts = [];
		$postIds = [];

		foreach ( $rawPosts as $post ) {
			if ( count( $posts ) >= self::PARSELY_POSTS_LIMIT ) {
				break;
			}

			$metadata = json_decode( $post->metadata );
			if ( !empty( $metadata->postID ) && !in_array( $metadata->postID, $postIds ) ) {
				$postIds[] = $metadata->postID;
				$posts[] = $post;
			}
		}

		return $posts;
	}
}
