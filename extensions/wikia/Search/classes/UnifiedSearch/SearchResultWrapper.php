<?php

namespace Wikia\Search\UnifiedSearch;

use ArrayIterator;
use Wikia\Search\Result;
use Wikia\Search\SearchResultItems as SearchResultItemsAlias;

class SearchResultWrapper implements SearchResultItemsAlias {

	private $results = [];

	public function __construct( $results ) {
		foreach ( $results as $r ) {
			$this->results[] = new Result( $r );
		}
	}

	public function getResults(): ArrayIterator {
		return new ArrayIterator( $this->results );
	}

	function toArray( array $expectedFields = null, $key = null ): array {
		if ( $expectedFields === null ) {
			$expectedFields = [ 'title', 'url', 'pageid' ];
		}
		$tempResults = [];
		foreach ( $this->results as $result ) {
			if ( $key !== null && isset( $result[$key] ) ) {
				$tempResults[$result[$key]] = $result->toArray( $expectedFields );
			} else {
				$tempResults[] = $result->toArray( $expectedFields );
			}
		}

		return $tempResults;
	}
}
