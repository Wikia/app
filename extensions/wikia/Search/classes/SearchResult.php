<?php


namespace Wikia\Search;


use ArrayIterator;
use F;
use Wikia\Search\UnifiedSearch\SearchResultWrapper;
use Wikia\Search\UnifiedSearch\UnifiedSearchResult;

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

	public static function fromUnifiedSearchResult( UnifiedSearchResult $result ): SearchResult {
		$searchResult = new SearchResult();
		$searchResult->correctedQuery = null;
		$searchResult->totalResults = $result->resultsFound;
		$searchResult->currentPage = $result->currentPage + 1;
		$searchResult->pageCount = $result->pagesCount;
		$searchResult->items = $result->getResults();

		return $searchResult;

	}

	public static function fromConfig( Config $config ): SearchResult {
		$searchResult = new SearchResult();
		$searchResult->correctedQuery = $config->getQuery()->getQueryForHtml();
		$searchResult->totalResults = $config->getResultsFound();
		$searchResult->currentPage = $config->getPage();
		$searchResult->pageCount = $config->getNumPages();
		$searchResult->items = $config->getResults();

		return $searchResult;
	}

	public static function empty() {
		$searchResult = new SearchResult();
		$searchResult->correctedQuery = null;
		$searchResult->totalResults = 0;
		$searchResult->currentPage = 1;
		$searchResult->pageCount = 0;
		$searchResult->items = new SearchResultWrapper( [] );

		return $searchResult;
	}

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

	/**
	 * Returns results number based on a truncated heuristic
	 * @param boolean $formatted whether we should also format the number
	 * @return integer
	 */
	public function getTruncatedResultsNum( bool $formatted = false ) {
		$resultsNum = $this->getResultsFound();

		$result = $resultsNum;

		$digits = strlen( $resultsNum );
		if ( $digits > 1 ) {
			$zeros = ( $digits > 3 ) ? ( $digits - 1 ) : $digits;
			$result = round( $resultsNum, ( 0 - ( $zeros - 1 ) ) );
		}

		if ( $formatted ) {
			return $this->formatNumber( $result );
		} else {
			return $result;
		}
	}

	protected function formatNumber( $number ) {
		return F::app()->wg->Lang->formatNum( $number );
	}

	public function isOneResultsPageOnly() {
		return $this->getNumPages() < 2;
	}

	public function getNumPages() {
		return $this->pageCount;
	}

	public function getCorrectedQuery() {
		return $this->correctedQuery;
	}
}
