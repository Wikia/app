<?php

use Wikia\Service\Gateway\KubernetesUrlProvider;

class DiscussionsDataService {
	const DISCUSSIONS_API_SORT_KEY_TRENDING = 'trending';
	const DISCUSSIONS_API_SORT_KEY_LATEST = 'creation_date';
	const DISCUSSIONS_API_SORT_DIRECTION = 'descending';
	const DISCUSSIONS_API_VIEWABLE_ONLY = true;

	const MCACHE_VER = '1.2';

	private $cityId, $limit;

	public function __construct( $cityId, $limit ) {
		$this->limit = $limit;
		$discussionsAlias = WikiFactory::getVarValueByName( 'wgRecirculationDiscussionsAlias', $cityId );

		if ( !empty( $discussionsAlias ) ) {
			$this->cityId = $discussionsAlias;
		} else {
			$this->cityId = $cityId;
		}

		$this->server = WikiFactory::getVarValueByName( 'wgServer', $this->cityId );
	}

	public function getData( $type, $sortKey = self::DISCUSSIONS_API_SORT_KEY_TRENDING ) {
		$memcKey = wfMemcKey( __METHOD__, $this->cityId, $type, self::MCACHE_VER );

		$rawData =
			WikiaDataAccess::cache( $memcKey, WikiaResponse::CACHE_VERY_SHORT,
				function () use ( $sortKey ) {
					return $this->apiRequest( $sortKey );
				} );

		if ( $type === 'posts' ) {
			$data = $this->getPosts( $rawData );
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

		$rawPosts = $rawData['_embedded']['threads'];

		if ( is_array( $rawPosts ) && count( $rawPosts ) > 0 ) {
			foreach ( $rawPosts as $key => $value ) {
				$data['posts'][] = $this->buildPost( $value, $key );
			}
		}

		return $data;
	}

	private function formatData( $rawData ) {
		$data = [];

		$data['discussionsUrl'] = $this->server . '/d/f';
		$data['postCount'] = $rawData['threadCount'];
		$data['posts'] = $this->getPosts( $rawData )['posts'];

		return $data;
	}

	/**
	 * Make an API request to parsely to gather posts
	 * @param string $type
	 * @param string $sortKey
	 * @return an array of posts
	 */
	private function apiRequest( $sortKey ) {
		$options = [
			'sortKey' => $sortKey,
		];
		$endpoint = $this->cityId . '/threads';

		$url = $this->buildUrl( $endpoint, $options );
		$data = Http::get( $url, 'default', [ 'noProxy' => true ] );

		return json_decode( $data, true );
	}

	/**
	 * Build a complete url to the discussions API
	 * @param string $endpoint
	 * @param array $options
	 * @return string
	 */
	private function buildUrl( $endpoint, $options ) {
		$defaultParams = [
			'limit' => $this->limit,
			'sortKey' => self::DISCUSSIONS_API_SORT_KEY_TRENDING,
			'sortDirection' => self::DISCUSSIONS_API_SORT_DIRECTION,
			'viewableOnly' => self::DISCUSSIONS_API_VIEWABLE_ONLY,
		];

		$params = array_merge( $defaultParams, $options );
		return $this->getDiscussionsApiUrl() . '/' . $endpoint . '?' . http_build_query( $params );
	}

	private function getDiscussionsApiUrl() {
		global $wgWikiaEnvironment, $wgWikiaDatacenter;

		return "http://" . ( new KubernetesUrlProvider( $wgWikiaEnvironment, $wgWikiaDatacenter ) )
				->getUrl( 'discussion' );
	}

	private function buildPost( $rawPost, $index ) {
		$meta = [];
		$meta['upvoteCount'] = $rawPost['upvoteCount'];
		$meta['postCount'] = $rawPost['postCount'];
		$meta['forumName'] = $rawPost['forumName'];

		$postTitle = $rawPost['title'];

		if ( empty( $rawPost['title'] ) ) {
			$postTitle = wfShortenText( $rawPost['rawContent'], 70 );
		}

		return new RecirculationContent( [
			'url' => $this->server . '/d/p/' . $rawPost['id'],
			'index' => $index,
			'title' => $postTitle,
			'publishDate' => wfTimestamp( TS_ISO_8601, $rawPost['creationDate']['epochSecond'] ),
			'author' => $rawPost['createdBy']['name'],
			'source' => 'discussions',
			'isVideo' => false,
			'meta' => $meta,
		] );
	}
}
