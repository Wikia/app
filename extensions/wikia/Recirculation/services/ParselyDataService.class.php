<?php

class ParselyDataService {
	static protected $instance = null;

	const PARSELY_API_BASE = 'https://api.parsely.com/v2/';
	const PARSELY_API_EXTRA = 3; // We request more posts than we actually need incase we receive duplicates
	const PARSELY_API_PAGE = 1;
	const PARSELY_API_PUB_DAYS = 10;
	const PARSELY_API_SORT = '_hits';
	const PARSELY_API_TIMEOUT = 5;

	const PARSELY_POSTS_LIMIT = 5;

	const MCACHE_VER = '1.1';
	const MCACHE_TIME = 900; // 15 minutes

	private $cityId;

	public function __construct( $cityId ) {
		$this->cityId = $cityId;
	}

	/**
	 * Get posts for a specific type. Uses cache if available
	 * @param string $type
	 * @return an array of posts
	 */
	public function getPosts( $type, $count = self::PARSELY_POSTS_LIMIT ) {
		$metadata = $this->buildMetaData( $type );

		if ( ( $type === 'community' || $type === 'vertical' ) && count( $metadata ) === 0 ) {
			return [];
		}

		$memcKey = wfSharedMemcKey( __METHOD__, $type, $metadata['key'], $count, static::MCACHE_VER );

		$data = WikiaDataAccess::cache(
			$memcKey,
			static::MCACHE_TIME,
			function() use ( $type, $metadata, $count ) {
				return $this->apiRequest( $type, $metadata, $count );
			}
		);

		return $data;
	}

	/**
	 * Make an API request to parsely to gather posts
	 * @param string $type
	 * @return an array of posts
	 */
	private function apiRequest( $type, $meta, $count ) {
		$options = [];
		$options['limit'] = $count + static::PARSELY_API_EXTRA;

		switch ( $type ) {
			case 'vertical':
				$options['sort'] = static::PARSELY_API_SORT;
				$options['pub_days'] = 30;
				$endpoint = 'analytics/tag/' . rawurlencode( $meta['tag'] ) . '/detail';
				break;
			case 'community':
				$options['sort'] = static::PARSELY_API_SORT;
				$options['pub_days'] = 30;
				$endpoint = 'analytics/tag/' . rawurlencode( $meta['tag'] ) . '/detail';
				break;
			case 'shares':
				$options['days'] = 5;
				$endpoint = 'shares/posts';
				break;
			case 'recent_popular':
				$options['sort'] = static::PARSELY_API_SORT;
				$options['pub_days'] = static::PARSELY_API_PUB_DAYS;
				$endpoint = 'analytics/posts';
				break;
			case 'popular':
			default:
				$options['sort'] = static::PARSELY_API_SORT;
				$endpoint = 'analytics/posts';
				break;
		}

		$url = $this->buildUrl( $endpoint, $options );
		$data = ExternalHttp::get( $url, static::PARSELY_API_TIMEOUT );

		$posts = json_decode( $data, true );

		if ( isset( $posts['data'] ) && is_array( $posts['data'] ) ) {
			return $this->dedupePosts( $posts['data'], $count, $type );
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
			'page' => static::PARSELY_API_PAGE
		];

		$params = array_merge( $defaultParams, $options );

		$url = static::PARSELY_API_BASE . $endpoint . '?' . http_build_query( $params );

		return $url;
	}

	/**
	 * Remove duplicates from Parsely's API result
	 * @param array $rawPosts
	 * @return array
	 */
	private function dedupePosts( $rawPosts, $count, $type ) {
		$posts = [];
		$postIds = [];

		foreach ( $rawPosts as $post ) {
			if ( count( $posts ) >= $count ) {
				break;
			}

			$metadata = json_decode( $post['metadata'], true );
			if ( !empty( $metadata['postID'] ) && !in_array( $metadata['postID'], $postIds ) ) {
				$postIds[] = $metadata['postID'];
				$post['source'] = 'fandom';
				$post['isVideo'] = $metadata['isVideo'] ?? null;
				$post['type'] = $type;
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
		$wikiFactoryHub = WikiFactoryHub::getInstance();
		$wgWikiVertical = $wikiFactoryHub->getWikiVertical( $this->cityId )['short'];

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
		$tag = WikiFactory::getVarValueByName( 'wgRecirculationParselyCommunityTag', $this->cityId );

		if ( !empty( $tag ) ) {
			return [
				'key' => $this->cityId,
				'tag' => $tag
			];
		} else {
			return [];
		}
	}
}
