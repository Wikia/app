<?php

namespace Wikia\Search\UnifiedSearch;

class UnifiedSearchResult {

	/** @var SearchResultWrapper */
	public $results;
	public $resultsFound = 1;
	public $resultsFoundTruncatedtrue = 1;
	public $isOneResultsPageOnly = true;
	public $pagesCount = 1;
	public $currentPage = 0;

	public function __construct( $results ) {
		$this->results = $results;
	}
}
