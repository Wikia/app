<?php

class DiscussionsCategoryModel {
	const DISCUSSIONS_API_BASE = 'https://services.wikia.com/discussion/';
	const DISCUSSIONS_API_BASE_DEV = 'https://services.wikia-dev.com/discussion/';

	const MCACHE_VER = '1.0';

	private $cityId;

	public function __construct( $cityId ) {
		$this->cityId = $cityId;
	}


	private function getRequestUrl() {
		global $wgDevelEnvironment;

		if ( empty( $wgDevelEnvironment ) ) {
			return self::DISCUSSIONS_API_BASE . "$this->cityId/forums?responseGroup=small&viewableOnly=true";
		}

		return self::DISCUSSIONS_API_BASE_DEV . "$this->cityId/forums?responseGroup=small&viewableOnly=true";
	}


	private function apiRequest( $url ) {
		$data = Http::get( $url );
		$obj = json_decode( $data, true );
		return $obj;
	}

	private function categoryLookup( $category, $rawData ) {
		$categories = $rawData['_embedded']['doc:forum'];

		if ( is_array( $categories ) && count( $categories ) > 0 ) {
			foreach ( $categories as $key => $value ) {
				if ( $value['name'] === $category ) {
					return $value['id'];
				}
			}
		}
	}

	public function getCategoryId( $category ) {
		$memcKey = wfMemcKey( __METHOD__, self::MCACHE_VER );

		$rawData = WikiaDataAccess::cache(
			$memcKey,
			WikiaResponse::CACHE_VERY_SHORT,
			function() {
				return $this->apiRequest( $this->getRequestUrl() );
			}
		);

		return $this->categoryLookup( $category, $rawData );
	}
}
