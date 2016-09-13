<?php

class DiscussionsThreadModel {
	const DISCUSSIONS_API_BASE = 'https://services.wikia.com/discussion/';
	const DISCUSSIONS_API_BASE_DEV = 'https://services.wikia-dev.com/discussion/';
	const SORT_TRENDING = 'trending';
	const SORT_LATEST = 'creation_date';
	const SORT_TRENDING_LINK = 'trending';
	const SORT_LATEST_LINK = 'latest';

	const MCACHE_VER = '1.0';

	private $cityId;

	public function __construct( $cityId ) {
		$this->cityId = $cityId;
	}

	// TODO: Consider changing this request to use Swagger when unblocked. See JPN-631
	private function apiRequest( $url ) {
		return json_decode( Http::get( $url ), true );
	}

	private function getCategoryRequestUrl() {
		global $wgDevelEnvironment;
		if ( empty( $wgDevelEnvironment ) ) {
			return self::DISCUSSIONS_API_BASE . "$this->cityId/forums?responseGroup=small&viewableOnly=true";
		}
		return self::DISCUSSIONS_API_BASE_DEV . "$this->cityId/forums?responseGroup=small&viewableOnly=true";
	}

	public function getCategoryId( $category ) {
		$memcKey = wfMemcKey( __METHOD__, self::MCACHE_VER );
		$rawData = WikiaDataAccess::cache(
			$memcKey,
			WikiaResponse::CACHE_STANDARD,
			function() {
				return $this->apiRequest( $this->getCategoryRequestUrl() );
			}
		);

		return $this->categoryLookup( $category, $rawData );
	}

	private function categoryLookup( $category, $rawData ) {
		$categories = $rawData['_embedded']['doc:forum'];
		if ( is_array( $categories ) ) {
			foreach ( $categories as $value ) {
				if ( $value['name'] === $category ) {
					return $value['id'];
				}
			}
		}

		return false;
	}

	private function getRequestUrl( $showLatest, $limit, $category ) {
		$sortKey = $showLatest ? self::SORT_LATEST : self::SORT_TRENDING;
		$categoryId = $this->getCategoryId( $category );
		$categoryKey = $categoryId ? '&forumId=' . $categoryId : '';

		return "/$this->cityId/threads?sortKey=$sortKey&limit=$limit&viewableOnly=false" . $categoryKey;
	}

	private function getUpvoteRequestUrl() {
		return "/$this->cityId/votes/post/";
	}

	public function getData( $showLatest, $limit, $category ) {
		$sortKey = $showLatest ? self::SORT_LATEST_LINK : self::SORT_TRENDING_LINK;
		$categoryId = false;
		$invalidCategory = false;
		$discussionsUrl = false;

		if ( !empty($category) ) {
			$categoryId = $this->getCategoryId( $category );

			if ( $categoryId ) {
				$discussionsUrl = "/d/f?catId=$categoryId&sort=$sortKey";
			} else {
				$invalidCategory = true;
			}
		} else {
			$discussionsUrl = "/d/f?sort=$sortKey";
		}

		return [
			'siteId' => $this->cityId,
			'discussionsUrl' => $discussionsUrl,
			'requestUrl' => $this->getRequestUrl( $showLatest, $limit, $category ),
			'upvoteRequestUrl' => $this->getUpvoteRequestUrl(),
			'invalidCategory' => $invalidCategory,
			'categoryId' => $categoryId,
		];
	}
}
