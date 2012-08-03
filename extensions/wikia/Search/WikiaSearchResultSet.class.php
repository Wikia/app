<?php

class WikiaSearchResultSet implements Iterator {
	private $position = 0;

	protected $resultsFound = 0;
	protected $resultsStart = 0;
	protected $header = null;
	protected $results = array();
	protected $query;

	public $totalScore;
	public $score = 0;

	public function __construct(Array $results = array(), $resultsFound = 0, $resultsStart = 0, $query = null) {
		$this->setResults($results);
		$this->setResultsFound($resultsFound);
		$this->setResultsStart($resultsStart);
		$this->setQuery($query);
	}

	/**
	 * set result documents
	 * @param array $results list of WikiaResult or WikiaResultSet (for result grouping) objects
	 */
	public function setResults(Array $results) {
		wfProfileIn(__METHOD__);

		foreach($results as $result) {
			$this->addResult($result);
		}
		wfProfileOut(__METHOD__);
	}

	public function setResultsFound($value) {
		$this->resultsFound = $value;
	}

	public function addResult($result) {
		if($this->isValidResult($result)) {
			$this->results[] = $result;
		}
		else {
			throw new WikiaException( 'Invalid result in set' );
		}
	}

	public function getResultsFound() {
		return $this->resultsFound;
	}


	public function incrResultsFound($value = 1) {
		$this->resultsFound += $value;
	}

	public function getResultsStart() {
		return $this->resultsStart;
	}

	public function setResultsStart($value) {
		$this->resultsStart = $value;
	}

	public function getResultsNum() {
		return count($this->results);
	}

	public function hasResults() {
		return (bool) $this->getResultsNum();
	}

	public function next() {
		$result = $this->current();
		$this->position++;
		return $result;
	}

	public function rewind() {
		$this->resetPosition();
	}

	public function current() {
		if($this->valid()) {
			return $this->results[$this->position];
		}
		else {
			return false;
		}
	}

	public function key() {
		return $this->position;
	}

	public function valid() {
		return isset($this->results[$this->position]);
	}

	public function setHeader($key, $value) {
		if($this->header === null) {
			$this->header = array();
		}
		$this->header[$key] = $value;
	}

	public function getHeader($key = null) {
		return ( empty($key) ? $this->header : ( isset($this->header[$key]) ? $this->header[$key] : null ) );
	}

	private function isValidResult($result) {
		return (($result instanceof WikiaSearchResult) || ($result instanceof WikiaSearchResultSet)) ? true : false;
	}

	private function resetPosition() {
		$this->position = 0;
	}

	public function getQuery() {
		return $this->query;
	}

	public function setQuery($query) {
		$this->query = $query;
	}

	/**
	 * merge with another result set
	 * @param WikiaSearchResultSet $resultSet
	 */
	public function merge(WikiaSearchResultSet $resultSet) {
		wfProfileIn(__METHOD__);

		foreach($resultSet as $result) {
			$this->addResult($result);
		}

		$this->setResultsFound($resultSet->getResultsFound());
		$this->setResultsStart($resultSet->getResultsStart());

		wfProfileOut(__METHOD__);
	}

	public function __sleep() {
		return array( 'header', 'results', 'resultsFound', 'resultsStart');
	}

	public function __wakeup() {
		$this->position = 0;
		$this->resultsPerPage = 25;
		$this->currentPage = false;
	}

	public function isOnlyArticleMatchFound() {

		return $this->getResultsNum() == 1 && $this->getResultsFound() == 0 && $this->results[0]->getVar('isArticleMatch') == true;

	}

}
