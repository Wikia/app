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
		$metadata = $this->buildMetaData( $type );

		if ( ( $type === 'community' || $type === 'vertical' ) && count( $metadata ) === 0 ) {
			return [];
		}

		$memcKey = wfSharedMemcKey( __METHOD__, $type, $meta['key'], self::MCACHE_VER );

		$data = WikiaDataAccess::cache(
			$memcKey,
			self::MCACHE_TIME,
			function() use ( $type, $meta ) {
				return $this->apiRequest( $type, $meta );
			}
		);

		return $data;
	}

	/**
	 * Make an API request to parsely to gather posts
	 * @param string $type
	 * @return an array of posts
	 */
	private function apiRequest( $type, $meta ) {
		$options = [];
		switch ( $type ) {
			case 'vertical':
				$options['sort'] = self::PARSELY_API_SORT;
				$options['pub_days'] = 30;
				$endpoint = 'analytics/tag/' . rawurlencode( $meta['tag'] ) . '/detail';
				break;
			case 'community':
				$options['sort'] = self::PARSELY_API_SORT;
				$options['pub_days'] = 30;
				$endpoint = 'analytics/tag/' . rawurlencode( $meta['tag'] ) . '/detail';
				break;
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

		$posts = json_decode( $data )->data;

		if ( is_array( $posts ) ) {
			return $this->dedupePosts( $posts );
		} else {
			return [];
		}
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

	private function buildMetaData( $type ) {
		if ( $type === 'vertical' ) {
			$metadata = $this->buildVerticalData();
		} elseif ( $type === 'community' ) {
			$metadata = $this->buildCommunityData();
		} else {
			$metadata = [
				'key' => '',
				'tag' => ''
			];
		}

		return $metadata;
	}

	private function buildVerticalData() {
		global $wgCityId;
		$wikiFactoryHub = WikiFactoryHub::getInstance();
		$wgWikiVertical = $wikiFactoryHub->getWikiVertical( $wgCityId )['short'];

		$verticalMap = [
			'tv' => 'TV',
			'movies' => 'Movies',
			'games' => 'Games',
			'books' => 'Books',
			'comics' => 'Comics',
			'lifestyle' => 'Lifestyle',
			'music' => 'Music'
		];

		if ( array_key_exists( $wgWikiVertical, $verticalMap ) ) {
			return [
				'key' => $wgWikiVertical,
				'tag' => $verticalMap[$wgWikiVertical]
			];
		} else {
			return [];
		}
	}

	private function buildCommunityData() {
		global $wgCityId;

		$communityMap = [
			'147' => 'Star Wars',
			'3035' => 'Fallout',
			'2233' => 'Marvel',
			'130814' => 'Game of Thrones',
			'1706' => 'Elder Scrolls'
		];

		if ( array_key_exists( $wgCityId, $communityMap ) ) {
			return [
				'key' => $wgCityId,
				'tag' => $communityMap[$wgCityId]
			];
		} else {
			return [];
		}
	}
}
