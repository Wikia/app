<?php

class DiscussionsDataService {
	const DISCUSSIONS_API_BASE = 'https://services.wikia.com/discussion/';
	const DISCUSSIONS_API_LIMIT = 5;
	const DISCUSSIONS_API_SORT_KEY = 'trending';
	const DISCUSSIONS_API_SORT_DIRECTION = 'descending';

	const MCACHE_VER = '1.0';

	/**
	 * Get posts for a specific type. Uses cache if available
	 * @param string $type
	 * @return an array of posts
	 */
	public function getPosts() {
		$memcKey = wfMemcKey( __METHOD__, $type, self::MCACHE_VER );

		$rawPosts = WikiaDataAccess::cache(
			$memcKey,
			WikiaResponse::CACHE_VERY_SHORT,
			function() {
				return $this->apiRequest();
			}
		);

		$posts = [];

		if ( is_array( $rawPosts ) && count( $rawPosts ) > 0 ) {
			foreach ( $rawPosts as $key => $value ) {
				$posts[] = $this->buildPost( $value );
			}
		}

		return $posts;
	}

	/**
	 * Make an API request to parsely to gather posts
	 * @param string $type
	 * @return an array of posts
	 */
	private function apiRequest() {
		global $wgCityId;
		$options = [];
		$endpoint = $wgCityId . '/forums/' . $wgCityId;

		$url = $this->buildUrl( $endpoint, $options );

		try {
			$data = Http::get( $url );

			$obj = json_decode( $data, true );
			$posts = $obj['_embedded']['doc:threads'];
		} catch (Exception $e) {
			$posts = [];
		}

		return $posts;
	}

	/**
	 * Build a complete url to the parsely API
	 * @param string $endpoint
	 * @param array $options
	 * @return string
	 */
	private function buildUrl( $endpoint, $options ) {
		$defaultParams = [
			'limit' => self::DISCUSSIONS_API_LIMIT,
			'sortKey' => self::DISCUSSIONS_API_SORT_KEY,
			'sortDirection' => self::DISCUSSIONS_API_SORT_DIRECTION,
		];

		$params = array_merge($defaultParams, $options);

		$url = self::DISCUSSIONS_API_BASE . $endpoint . '?' . http_build_query( $params );

		return $url;
	}

	private function buildPost( $rawPost ) {
		global $wgContLang;
		$post = [];
		$post['author'] = $rawPost['createdBy']['name'];
		$post['authorAvatar'] = $rawPost['createdBy']['avatarUrl'];
		$post['content'] = $wgContLang->truncate($rawPost['_embedded']['firstPost'][0]['rawContent'], 120);
		$post['upvoteCount'] = $rawPost['upvoteCount'];
		$post['commentCount'] = $rawPost['postCount'];
		$post['createdAt'] = wfTimestamp( TS_ISO_8601, $rawPost['creationDate']['epochSecond'] );
		$post['link'] = '/d/p/' . $rawPost['id'];

		return $post;
	}
}
