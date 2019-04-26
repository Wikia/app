<?php


namespace Wikia\Search;


use ArrayIterator;
use F;
use Wikia\Search\UnifiedSearch\UnifiedSearchResult;

class SearchResultView {

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

	public static function fromUnifiedSearchResult(UnifiedSearchResult $result): SearchResultView {
		$view = new SearchResultView();

		$view->correctedQuery = null;
		$view->totalResults = $result->resultsFound;
		$view->currentPage = $result->currentPage;
		$view->items = $result->getResults();

		return $view;

	}

	public static function fromConfig( Config $config ): SearchResultView {
		$view = new SearchResultView();
		$view->correctedQuery = $config->getResults()->getQuery();
		$view->totalResults = $config->getResultsFound();
		$view->currentPage = $config->getPage();
		$view->items = $config->getResults();

		return $view;
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
	public function getTruncatedResultsNum( bool $formatted ) {
		$resultsNum = $this->getResultsFound();

		$result = $resultsNum;

		$digits = strlen( $resultsNum );
		if ( $digits > 1 ) {
			$zeros = ( $digits > 3 ) ? ( $digits - 1 ) : $digits;
			$result = round( $resultsNum, ( 0 - ( $zeros - 1 ) ) );
		}

		if ( $formatted ) {
			$result = F::app()->wg->Lang->formatNum( $result );
		}

		return $result;
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
