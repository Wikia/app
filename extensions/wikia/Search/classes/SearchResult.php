<?php

namespace Wikia\Search;

use ArrayIterator;

class SearchResult {

	/** @var string */
	private $correctedQuery;
	/** @var int */
	private $pageCount;
	/** @var int */
	private $totalResults;
	/** @var int */
	private $currentPage;
	/** @var SearchResultItems */
	private $items;

	public function hasResults(): bool {
		return $this->getResults() ? true : false;
	}

	public function toArray( array $fields = null ): array {
		return $this->items->toArray( $fields );
	}

	public function getResults(): ArrayIterator {
		return $this->items->getResults();
	}

	public function getResultsFound() {
		return $this->totalResults;
	}

	public function getPage() {
		return $this->currentPage;
	}

	public function getNumPages() {
		return $this->pageCount;
	}
}
