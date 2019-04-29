<?php

namespace Wikia\Search\UnifiedSearch;

class UnifiedSearchResult {

	/** @var array */
	private $results;
	public $resultsFound;
	public $pagesCount;
	public $currentPage;

	public function __construct(
		$resultsFound, $pagesCount, $currentPage, $results

	) {
		$this->results = $results;
		$this->resultsFound = $resultsFound;
		$this->pagesCount = $pagesCount;
		$this->currentPage = $currentPage;
	}

	public function getResults(): SearchResultWrapper {
		return new SearchResultWrapper( $this->results );
	}
}
