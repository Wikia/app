<?php

class DiscussionsThreadModel {
	const DISCUSSIONS_API_BASE = 'https://services.wikia.com/discussion/';
	const DISCUSSIONS_API_BASE_DEV = 'https://services.wikia-dev.com/discussion/';
	const DISCUSSIONS_API_SORT_KEY = 'trending';
	const DISCUSSIONS_API_SORT_DIRECTION = 'descending';
	const THREAD_CACHE_KEY = "embeddable_discussions_thread";
	const SORT_TRENDING = 'trending';
	const SORT_LATEST = 'creation_date';
	const SORT_TRENDING_LINK = 'trending';
	const SORT_LATEST_LINK = 'latest';
	const ACCESS_TOKEN_COOKIE_NAME = 'access_token';

	const MCACHE_VER = '1.0';

	private $cityId;

	public function __construct( $cityId ) {
		$this->cityId = $cityId;
	}

	// TODO: Refactor this to use Swagger, see JPN-631.
	private function getRequestUrl( $showLatest, $limit ) {
		global $wgDevelEnvironment;

		$sortKey = $showLatest ? self::SORT_LATEST : self::SORT_TRENDING;

		if ( empty( $wgDevelEnvironment ) ) {
			return self::DISCUSSIONS_API_BASE . "$this->cityId/threads?sortKey=$sortKey&limit=$limit&viewableOnly=false";
		}

		return self::DISCUSSIONS_API_BASE_DEV . "$this->cityId/threads?sortKey=$sortKey&limit=$limit&viewableOnly=false";
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

	public function getData( $showLatest, $limit ) {
		$memcKey = wfMemcKey( __METHOD__, self::MCACHE_VER );

		$rawData = WikiaDataAccess::cache(
			$memcKey,
			WikiaResponse::CACHE_VERY_SHORT,
			function() use ( $showLatest, $limit ) {
				return $this->apiRequest( $this->getRequestUrl( $showLatest, $limit ) );
			}
		);

		$data = $this->formatData( $rawData, $showLatest );

		return $data;
	}
}
