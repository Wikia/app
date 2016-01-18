<?php

class FandomDataService {
	static protected $instance = null;

	const PARSELY_API_BASE = 'https://api.parsely.com/v2/';
	const PARSELY_API_LIMIT = 5;
	const PARSELY_API_PAGE = 1;
	const PARSELY_API_SORT = '_hits';

	const MCACHE_VER = '1.0';

	/**
	 * Get posts for a specific type. Uses cache if available
	 * @param string $type
	 * @return an array of posts
	 */
	public function getPosts( $type ) {
		$memcKey = wfMemcKey( __METHOD__, $type, self::MCACHE_VER );

		$data = WikiaDataAccess::cache(
			$memcKey,
			WikiaResponse::CACHE_STANDARD, // 24 hours
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
		switch ( $type ) {
			case 'shares':
				$endpoint = 'shares/posts';
				break;
			case 'popular':
			default:
				$endpoint = 'analytics/posts';
				break;
		}

		$url = $this->buildUrl( $endpoint );
		$data = Http::get( $url );

		$obj = json_decode( $data );
		return $obj->data;
	}

	/**
	 * Build a complete url to the parsely API
	 * @param string $endpoint
	 * @return string
	 */
	private function buildUrl( $endpoint ) {
		global $wgParselyApiKey, $wgParselyApiSecret;

		$params = [
			'apikey' => $wgParselyApiKey,
			'secret' => $wgParselyApiSecret,
			'page' => self::PARSELY_API_PAGE,
			'limit' => self::PARSELY_API_LIMIT,
			'sort' => self::PARSELY_API_SORT
		];

		$url = self::PARSELY_API_BASE . $endpoint . '?' . http_build_query( $params );

		return $url;
	}
}
