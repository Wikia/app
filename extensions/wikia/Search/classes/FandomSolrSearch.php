<?php

namespace Wikia\Search;

use Wikia\Search\Services\FandomSearchService;

class FandomSolrSearch {

	public static function getStoriesWithCache( $query ) {
		//TODO: add caching
		$service = new FandomSearchService();

		return $service->query( $query );
	}

}
