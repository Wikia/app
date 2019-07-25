<?php

namespace Wikia\Search\UnifiedSearch;

use F;

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

	public function getResults(): UnifiedSearchResultItems {
		return new UnifiedSearchResultItems( $this->results );
	}

	public function getTruncatedResultsNum( bool $formatted = false ) {
		$resultsNum = $this->resultsFound;

		$result = $resultsNum;

		$digits = strlen( $resultsNum );
		if ( $digits > 1 ) {
			$zeros = ( $digits > 3 ) ? ( $digits - 1 ) : $digits;
			$result = round( $resultsNum, ( 0 - ( $zeros - 1 ) ) );
		}

		if ( $formatted ) {
			return $this->formatNumber( $result );
		}

		return $result;
	}

	protected function formatNumber( $number ) {
		return F::app()->wg->Lang->formatNum( $number );
	}
}
