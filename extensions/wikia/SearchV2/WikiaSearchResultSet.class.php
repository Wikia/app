<?php

class WikiaSearchResultSet implements Iterator {
	private $position = 0;

	protected $resultsFound = 0;
	protected $header = array();
	protected $results = array();

	public function __construct(Array $results, $resultsFound = 0) {
		$this->setResults($results);
		$this->setResultsFound($resultsFound);
	}

	/**
	 * set result documents
	 * @param array $results list of WikiaResult or WikiaResultSet (for result grouping) objects
	 */
	public function setResults(Array $results) {
		foreach($results as $result) {
			$this->addResult($result);
		}
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

	public function next() {
		$result = $this->current();
		$this->position++;
		return $result;
	}

	function rewind() {
		$this->position = 0;
	}

	function current() {
		if($this->valid()) {
			return $this->results[$this->position];
		}
		else {
			return false;
		}
	}

	function key() {
		return $this->position;
	}

	function valid() {
		if(isset($this->results[$this->position])) {
			return true;
		}
		else {
			return false;
		}
	}

	private function isValidResult($result) {
		return (($result instanceof WikiaSerachResult) || ($result instanceof WikiaSearchResultSet)) ? true : false;
	}

}
