<?php

namespace Wikia\Search\UnifiedSearch;

use ArrayAccess;
use ArrayIterator;
use Iterator;
use Wikia\Search\Result;
use Wikia\Search\Traits\AttributeIterableTrait;

class SearchResultWrapper implements Iterator, ArrayAccess {
	use AttributeIterableTrait;

	private $results = [];

	public function __construct( $results ) {
		foreach ( $results as $r ) {
			$this->results[] = new Result( $r );
		}
	}

	/**
	 * @return ArrayIterator
	 */
	function getIterable() {
		return new ArrayIterator($this->results);
	}


	function toArray( $expectedFields, $key = null ) {
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
