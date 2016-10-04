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

	public function getCategoryName( $categoryId ) {
		$memcKey = wfMemcKey( __METHOD__, self::MCACHE_VER );
		$rawData = WikiaDataAccess::cache(
			$memcKey,
			WikiaResponse::CACHE_STANDARD,
			function() {
				return $this->apiRequest( $this->getCategoryRequestUrl() );
			}
		);

		return $this->categoryNameLookup( $categoryId, $rawData );
	}

	private function categoryNameLookup( $categoryId, $rawData ) {
		$categories = $rawData['_embedded']['doc:forum'];
		if ( is_array( $categories ) ) {
			foreach ( $categories as $value ) {
				if ( $value['id'] === $categoryId ) {
					return $value['name'];
				}
			}
		}

		return false;
	}

	private function getRequestUrl( $showLatest, $limit, $category ) {
		$sortKey = $showLatest ? self::SORT_LATEST : self::SORT_TRENDING;
		$categoryKey = $category ? '&forumId=' . $category : '';

		return "/$this->cityId/threads?sortKey=$sortKey&limit=$limit&viewableOnly=false" . $categoryKey;
	}

	private function getUpvoteRequestUrl() {
		return "/$this->cityId/votes/post/";
	}

	public function getData( $showLatest, $limit, $categoryId ) {
		$sortKey = $showLatest ? self::SORT_LATEST_LINK : self::SORT_TRENDING_LINK;
		$invalidCategory = false;
		$discussionsUrl = false;
		$categoryName = false;

		if ( !empty( $categoryId ) ) {
			$categoryName = $this->getCategoryName( $categoryId );

			if ( $categoryName ) {
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
			'requestUrl' => $this->getRequestUrl( $showLatest, $limit, $categoryId ),
			'upvoteRequestUrl' => $this->getUpvoteRequestUrl(),
			'invalidCategory' => $invalidCategory,
			'categoryName' => $categoryName,
			'categoryId' => $categoryId,
		];
	}
}
