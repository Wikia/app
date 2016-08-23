<?php

use Swagger\Client\TemplateClassification\Storage\Api\TCSApi;
use Swagger\Client\TemplateClassification\Storage\Models\TemplateTypeHolder;
use Swagger\Client\TemplateClassification\Storage\Models\TemplateTypeProvider;
use Wikia\DependencyInjection\Injector;
use Wikia\Service\Swagger\ApiProvider;

class DiscussionsThreadModel {
	const SERVICE_NAME = 'discussions';

	const DISCUSSIONS_API_BASE = 'https://services.wikia.com/discussion';
	const DISCUSSIONS_API_BASE_DEV = 'https://services.wikia-dev.com/discussion';
	const DISCUSSIONS_API_SORT_KEY = 'trending';
	const DISCUSSIONS_API_SORT_DIRECTION = 'descending';
	const THREAD_CACHE_KEY = "embeddable_discussions_thread";
	const SORT_TRENDING = 'trending';
	const SORT_LATEST = 'creation_date';
	const SORT_TRENDING_LINK = 'trending';
	const SORT_LATEST_LINK = 'latest';
	const ACCESS_TOKEN_COOKIE_NAME = 'access_token';

	const MCACHE_VER = '1.0';

	private $apiClient = null;
	private $threadsApi = null;
	private $cityId;

	public function __construct( $cityId ) {
		global $wgDevelEnvironment;

		$this->cityId = $cityId;
		$this->apiClient = $this->createApiClient();

		if ( empty( $wgDevelEnvironment ) ) {
			$this->apiClient->getApiClient()->getConfig()->setHost( self::DISCUSSIONS_API_BASE );
		} else {
			$this->apiClient->getApiClient()->getConfig()->setHost( self::DISCUSSIONS_API_BASE_DEV );
		}

		$this->threadsApi = new Swagger\Client\Discussion\Api\ThreadsApi( $this->apiClient->getApiClient() );
	}

	// TODO: Delete this once Swagger integration is complete
	private function getRequestUrl( $showLatest, $limit ) {
		global $wgDevelEnvironment;

		$sortKey = $showLatest ? self::SORT_LATEST : self::SORT_TRENDING;

		if ( empty( $wgDevelEnvironment ) ) {
			return self::DISCUSSIONS_API_BASE . "/$this->cityId/threads?sortKey=$sortKey&limit=$limit&viewableOnly=false";
		}

		return self::DISCUSSIONS_API_BASE_DEV . "/$this->cityId/threads?sortKey=$sortKey&limit=$limit&viewableOnly=false";
	}

	private function getUpvoteRequestUrl( $id ) {
		global $wgDevelEnvironment;

		if ( empty( $wgDevelEnvironment ) ) {
			return self::DISCUSSIONS_API_BASE . "$this->cityId/votes/post/$id";
		}

		return self::DISCUSSIONS_API_BASE_DEV . "$this->cityId/votes/post/$id";
	}

	private function apiRequest( $url ) {
		$request = RequestContext::getMain()->getRequest();

		$options = [
			'returnInstance' => false,
			'headers' => [
				'cookie' => self::ACCESS_TOKEN_COOKIE_NAME . '=' .
					$request->getCookie( self::ACCESS_TOKEN_COOKIE_NAME, '' ) . ';'
			]
		];

		$data = Http::get( $url, 'default', $options );
		$obj = json_decode( $data, true );
		return $obj;
	}

	private function buildPost( $rawPost, $index ) {
		global $wgContLang;

		$timeAgo = wfTimeFormatAgo( wfTimestamp( TS_ISO_8601, $rawPost['creationDate']['epochSecond'] ) );
		$userData = $rawPost['_embedded']['userData'][0];

		return [
			'author' => $rawPost['createdBy']['name'],
			'authorAvatar' => $rawPost['createdBy']['avatarUrl'],
			'commentCount' => $rawPost['postCount'],
			'content' => $wgContLang->truncate( $rawPost['rawContent'], 120 ),
			'createdAt' => $timeAgo,
			'forumName' => wfMessage( 'embeddable-discussions-forum-name', $rawPost['forumName'] )->plain(),
			'id' => $rawPost['id'],
			'firstPostId' => $rawPost['firstPostId'],
			'index' => $index,
			'link' => '/d/p/' . $rawPost['id'],
			'upvoteUrl' => $this->getUpvoteRequestUrl( $rawPost['firstPostId'] ),
			'title' => $rawPost['title'],
			'upvoteCount' => $rawPost['upvoteCount'],
			'hasUpvoted' => $userData['hasUpvoted'],
		];

		return $post;
	}

	private function formatData( $rawData, $showLatest ) {
		$rawThreads = $rawData['_embedded']['threads'];
		$sortKey = $showLatest ? self::SORT_LATEST_LINK : self::SORT_TRENDING_LINK;

		$data = [
			'siteId' => $this->cityId,
			'discussionsUrl' => "/d/f?sort=$sortKey",
		];

		if ( is_array( $rawThreads ) && count( $rawThreads ) > 0 ) {
			foreach ( $rawThreads as $key => $value ) {
				$data['threads'][] = $this->buildPost( $value, $key );
			}
		}

		return $data;
	}

	// TODO: This should replace the current formatData once it is returning proper data. Rename to formatData
	private function formatDataSwagger( $response, $showLatest ) {
		$rawThreads = $response->getEmbedded();
		$sortKey = $showLatest ? self::SORT_LATEST_LINK : self::SORT_TRENDING_LINK;

		$data = [
			'siteId' => $this->cityId,
			'discussionsUrl' => "/d/f?sort=$sortKey",
		];

		if ( is_array( $rawThreads ) && count( $rawThreads ) > 0 ) {
			foreach ( $rawThreads as $key => $value ) {
				// TODO: Data inside $value is serialized into objects.
				// Extract the needed data with accessor methods from HalForumThreadEmbedded object
			}
		}

		return $data;
	}

	// TODO: This should replace the current getData, once formatDataSwagger returns proper data. Rename to getData
	public function getDataSwagger( $showLatest, $limit ) {
		$memcKey = wfMemcKey( __METHOD__, self::MCACHE_VER );

		$rawData = WikiaDataAccess::cache(
			$memcKey,
			WikiaResponse::CACHE_VERY_SHORT,
			function() use ( $showLatest, $limit ) {
				try {
					return $this->threadsApi->getThreads( $this->cityId );
				} catch ( ApiException $e ) {
					return [];
				}
			}
		);

		return $this->formatDataSwagger( $rawData, $showLatest );
	}

	// TODO: Once Swagger implementation is complete, remove this
	public function getData( $showLatest, $limit ) {
		// TODO: for testing only: call getDataSwagger
		$this->getDataSwagger( $showLatest, $limit );

		$memcKey = wfMemcKey( __METHOD__, self::MCACHE_VER );

		$rawData = WikiaDataAccess::cache(
			$memcKey,
			WikiaResponse::CACHE_VERY_SHORT,
			function() use ( $showLatest, $limit ) {
				return $this->apiRequest( $this->getRequestUrl( $showLatest, $limit ) );
			}
		);

		return $this->formatData( $rawData, $showLatest );
	}

	/**
	 * Create Swagger-generated API client
	 *
	 * @return TCSApi
	 */
	private function createApiClient() {
		/** @var ApiProvider $apiProvider */
		$apiProvider = Injector::getInjector()->get( ApiProvider::class );
		$api = $apiProvider->getApi( self::SERVICE_NAME, TCSApi::class );

		// default CURLOPT_TIMEOUT for API client is set to 0 which means no timeout.
		// Overwriting to minimal value which is 1.
		// cURL function is allowed to execute not longer than 1 second
		$api->getApiClient()
			->getConfig()
			->setCurlTimeout( 1 );

		return $api;
	}

}
