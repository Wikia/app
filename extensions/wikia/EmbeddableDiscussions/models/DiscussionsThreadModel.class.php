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

	public function getCategoryNames( $categoryIds ) {
		$memcKey = wfMemcKey( __METHOD__, self::MCACHE_VER );
		$rawData = WikiaDataAccess::cache(
			$memcKey,
			WikiaResponse::CACHE_STANDARD,
			function() {
				return $this->apiRequest( $this->getCategoryRequestUrl() );
			}
		);

		return $this->categoryNameLookup( $categoryIds, $rawData );
	}

	private function categoryNameLookup( $categoryIds, $rawData ) {
		$explodedIds = explode( ',', $categoryIds );
		$ret = array();

		$categories = $rawData['_embedded']['doc:forum'];
		if ( is_array( $categories ) ) {
			foreach ( $categories as $value ) {
				if ( in_array( $value['id'], $explodedIds ) ) {
					$ret[] = [
						'id' => $value['id'],
						'name' => $value['name'],
					];
				}
			}
		}

		return $ret;
	}

	private function getRequestUrl( $showLatest, $limit, $categoryIds ) {
		$sortKey = $showLatest ? self::SORT_LATEST : self::SORT_TRENDING;
		$categoryKey = null;

		if ( !empty( $categoryIds ) ) {
			$allCategoryIds = explode( ',', $categoryIds );
			$categoryKey = array_reduce( $allCategoryIds, function( $carry, $item ) {
				return $carry . '&forumId=' . $item;
			} );
		}

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
			$categoryNames = $this->getCategoryNames( $categoryId );

			if ( count ( $categoryNames ) === 0 ) {
				// No valid categories specified, show error message
				$invalidCategory = true;
			} elseif ( count ( $categoryNames ) === 1 ) {
				// A single category specified, use its name
				$categoryName = $categoryNames[0]['name'];
				$discussionsUrl = "/d/f?sort=$sortKey&catId=$categoryId";
			} else {
				// Multiple categories specified, don't use name
				$categoryName = false;
				$catIdUrl = '&catId=';
				$separator = '';

				foreach ( $categoryNames as $category ) {
					$catIdUrl .= $separator . $category['id'];
					$separator = urlencode( ',' );
				}

				$discussionsUrl = "/d/f?sort=$sortKey$catIdUrl";
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
