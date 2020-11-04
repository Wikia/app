<?php

use Wikia\Factory\ServiceFactory;

class DiscussionsDataService {
	const DISCUSSIONS_API_SORT_KEY_TRENDING = 'trending';
	const DISCUSSIONS_API_SORT_KEY_LATEST = 'creation_date';
	const DISCUSSIONS_API_SORT_DIRECTION = 'descending';
	const DISCUSSIONS_API_VIEWABLE_ONLY = true;

	const MCACHE_VER = '1.2';

	private $cityId, $limit;
	/** @var string $baseUrl */
	private $baseUrl;

	public function __construct( int $cityId, int $limit, string $baseUrl ) {
		$this->limit = $limit;
		$discussionsAlias = WikiFactory::getVarValueByName( 'wgRecirculationDiscussionsAlias', $cityId );

		if ( !empty( $discussionsAlias ) ) {
			$this->cityId = $discussionsAlias;
		} else {
			$this->cityId = $cityId;
		}

		$this->baseUrl = $baseUrl;
	}

	public function getPosts( string $sortKey = self::DISCUSSIONS_API_SORT_KEY_TRENDING ): array {
		$memcKey = wfMemcKey( __METHOD__, $this->cityId, 'posts', self::MCACHE_VER );

		$rawData =
			WikiaDataAccess::cache( $memcKey, WikiaResponse::CACHE_VERY_SHORT,
				function () use ( $sortKey ) {
					return $this->apiRequest( $sortKey );
				} );

		$posts = [];

		$rawPosts = $rawData['_embedded']['threads'];

		if ( is_array( $rawPosts ) && count( $rawPosts ) > 0 ) {
			foreach ( $rawPosts as $key => $value ) {
				$posts[] = $this->buildPost( $value, $key );
			}
		}

		return $posts;
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
		$endpoint = '/internal/' . $this->cityId . '/threads';

		$url = $this->buildUrl( $endpoint, $options );
		$data = Http::get( $url, 'default', [
			'noProxy' => true,
			'headers' => [ WebRequest::WIKIA_INTERNAL_REQUEST_HEADER => '1' ],
		] );

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

	private function getDiscussionsApiUrl(): string {
		return "http://" . ServiceFactory::instance()->providerFactory()->urlProvider()->getUrl( 'discussion' );
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
			'url' => $this->baseUrl . '/f/p/' . $rawPost['id'],
			'index' => $index,
			'title' => $postTitle,
			'publishDate' => wfTimestamp( TS_ISO_8601, $rawPost['creationDate']['epochSecond'] ),
			'author' => $rawPost['createdBy']['name'],
			'authorIsAnon' => $rawPost['createdBy']['id'] === '0',
			'source' => 'discussions',
			'isVideo' => false,
			'meta' => $meta,
		] );
	}
}
