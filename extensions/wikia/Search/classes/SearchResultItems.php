<?php


namespace Wikia\Search;


use ArrayIterator;

interface SearchResultItems {

	public function toArray( array $fields = null, $key = null ): array;

	/**
	 * @return ArrayIterator of Result
	 */
	public function getResults(): ArrayIterator;
}
