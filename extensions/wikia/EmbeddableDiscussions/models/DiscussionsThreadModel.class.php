<?php

use Wikia\Factory\ServiceFactory;

class DiscussionsThreadModel {
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
		return json_decode( Http::get( $url, 'default', [
			'noProxy' => true,
			'headers' => [ WebRequest::WIKIA_INTERNAL_REQUEST_HEADER => '1' ],
		] ), true );
	}

	private function getDiscussionsApiUrl(): string {
		return 'http://' . ServiceFactory::instance()->providerFactory()->urlProvider()->getUrl( 'discussion' );
	}

	private function getCategoryRequestUrl() {
		return $this->getDiscussionsApiUrl() .
			"/internal/$this->cityId/forums?responseGroup=small&viewableOnly=true";
	}

	/**
	 * Get category names for all requested categoryIds
	 * @param $categoryIds requested category ids
	 * @return array with name and id pairs for all valid requested categories
	 */
	public function getCategoryNames( $categoryIds ) {
		$memcKey = wfMemcKey( __METHOD__, self::MCACHE_VER, $categoryIds );
		$rawData = WikiaDataAccess::cache(
			$memcKey,
			WikiaResponse::CACHE_VERY_SHORT,
			function () {
				return $this->apiRequest( $this->getCategoryRequestUrl() );
			}
		);

		return $this->categoryNameLookup( $categoryIds, $rawData );
	}

	/**
	 * Helper function for matching category data from API with requested Ids
	 * @param $categoryIds requested category ids
	 * @param $rawData response from API
	 * @return array
	 */
	private function categoryNameLookup( $categoryIds, $rawData ) {
		$explodedIds = explode( ',', $categoryIds );
		$ret = [];

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
			$categoryKey = array_reduce( $allCategoryIds, function ( $carry, $item ) {
				return $carry . '&forumId=' . $item;
			} );
		}

		return "/$this->cityId/threads?sortKey=$sortKey&limit=$limit&viewableOnly=true" . $categoryKey;
	}

	private function getUpvoteRequestUrl() {
		return "/$this->cityId/votes/post/";
	}

	public function getData( $showLatest, $limit, $categoryIds ) {
		global $wgScriptPath;

		$sortKey = $showLatest ? self::SORT_LATEST_LINK : self::SORT_TRENDING_LINK;
		$invalidCategory = false;
		$discussionsUrl = false;
		$categoryName = false;
		// This will be populated to only include verified valid category ids
		$filteredCategoryIds = [];

		if ( !empty( $categoryIds ) ) {
			$categoryData = $this->getCategoryNames( $categoryIds );

			if ( count( $categoryData ) === 0 ) {
				// No valid categories specified, show error message
				$invalidCategory = true;
			} elseif ( count( $categoryData ) === 1 ) {
				// A single category specified, use its name
				$categoryName = $categoryData[0]['name'];
				$discussionsUrl = "/f?sort=$sortKey&catId=$categoryIds";
				$filteredCategoryIds[] = $categoryData[0]['id'];
			} else {
				// Multiple categories specified, don't use name
				$categoryName = false;
				$catIdUrl = '&catId=';
				$separator = '';

				foreach ( $categoryData as $category ) {
					$catIdUrl .= $separator . $category['id'];
					$separator = urlencode( ',' );

					$filteredCategoryIds[] = $category['id'];
				}

				$discussionsUrl = "/f?sort=$sortKey$catIdUrl";
			}
		} else {
			$discussionsUrl = "/f?sort=$sortKey";
		}

		return [
			'siteId' => $this->cityId,
			'discussionsUrl' => $wgScriptPath . $discussionsUrl,
			'requestUrl' => $this->getRequestUrl( $showLatest, $limit, $categoryIds ),
			'upvoteRequestUrl' => $this->getUpvoteRequestUrl(),
			'invalidCategory' => $invalidCategory,
			'categoryName' => $categoryName,
			'categoryIds' => $filteredCategoryIds,
		];
	}
}
