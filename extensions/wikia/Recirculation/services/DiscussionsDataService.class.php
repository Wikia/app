<?php

class DiscussionsDataService {
	const DISCUSSIONS_API_BASE = 'https://services.wikia.com/discussion/';
	const DISCUSSIONS_API_LIMIT = 5;
	const DISCUSSIONS_API_SORT_KEY = 'trending';
	const DISCUSSIONS_API_SORT_DIRECTION = 'descending';

	const MCACHE_VER = '1.2';

	private $cityId;

	public function __construct( $cityId ) {
		$discussionsAlias = WikiFactory::getVarValueByName( 'wgRecirculationDiscussionsAlias', $cityId );

		if ( !empty( $discussionsAlias ) ) {
			$this->cityId = $discussionsAlias;
		} else {
			$this->cityId = $cityId;
		}

		$this->server = WikiFactory::getVarValueByName( 'wgServer', $this->cityId );
	}

	public function getData( $type ) {
		$memcKey = wfMemcKey( __METHOD__, $this->cityId, $type, self::MCACHE_VER );

		$rawData = WikiaDataAccess::cache(
			$memcKey,
			WikiaResponse::CACHE_VERY_SHORT,
			function() {
				return $this->apiRequest();
			}
		);

		if ($type === 'posts') {
			$data = $this->getPosts( $rawData );
		} elseif ( $type === 'meta' ) {
			$data = $this->getMeta( $rawData );
		} else {
			$data = $this->formatData( $rawData );
		}

		return $data;
	}

	/**
	 * Get posts for discussions
	 * @return an array of posts
	 */
	private function getPosts( $rawData ) {
		$data = [
			'posts' => []
		];

		$rawPosts = $rawData['_embedded']['doc:threads'];

		if ( is_array( $rawPosts ) && count( $rawPosts ) > 0 ) {
			foreach ( $rawPosts as $key => $value ) {
				$data['posts'][] = $this->buildPost( $value, $key );
			}
		}

		return $data;
	}

	private function getMeta( $rawData ) {
		$data = [];
		$siteId = $rawData['siteId'];

		$data['discussionsUrl'] = $this->server . '/d/f';
		$data['postCount'] = $rawData['threadCount'];

		return $data;
	}

	private function formatData( $rawData ) {
		$data = [];
		$siteId = $rawData['siteId'];

		$rawPosts = $rawData['_embedded']['doc:threads'];
		$data['discussionsUrl'] = $this->server . '/d/f';
		$data['postCount'] = $rawData['threadCount'];
		$data['posts'] = [];

		if ( is_array( $rawPosts ) && count( $rawPosts ) > 0 ) {
			foreach ( $rawPosts as $key => $value ) {
				$data['posts'][] = $this->buildPost( $value, $key );
			}
		}

		return $data;
	}

	/**
	 * Make an API request to parsely to gather posts
	 * @param string $type
	 * @return an array of posts
	 */
	private function apiRequest() {
		$options = [];
		$endpoint = $this->cityId . '/forums/' . $this->cityId;

		$url = $this->buildUrl( $endpoint, $options );
		$data = Http::get( $url );

		$obj = json_decode( $data, true );
		return $obj;
	}

	/**
	 * Build a complete url to the discussions API
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

	private function buildPost( $rawPost, $index ) {
		$meta = [];
		$meta['authorAvatarUrl'] = $rawPost['createdBy']['avatarUrl'];
		$meta['upvoteCount'] = $rawPost['upvoteCount'];
		$meta['postCount'] = $rawPost['postCount'];

		return new RecirculationContent([
			'url' => $this->server . '/d/p/' . $rawPost['id'],
			'index' => $index,
			'title' =>  wfShortenText($rawPost['_embedded']['firstPost'][0]['rawContent'], 120),
			'publishDate' => wfTimestamp( TS_ISO_8601, $rawPost['creationDate']['epochSecond'] ),
			'author' => $rawPost['createdBy']['name'],
			'source' => 'discussions',
			'isVideo' => false,
			'meta' => $meta,
		]);
	}
}
