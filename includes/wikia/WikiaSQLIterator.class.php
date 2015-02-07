<?php
/**
 * WikiaSQLIterator
 */

class WikiaSQLIterator {

	const DEFAULT_CHUNK_SIZE = 1000;

	private $limit = self::DEFAULT_CHUNK_SIZE;
	private $offset = 0;
	private $needsInit = true;
	private $queryDone = false;

	private $chunkSize = 0;
	private $chunkIndex = 0;
	private $recordNum = 0;

	/** @var DatabaseBase */
	private $dbh;

	/** @var WikiaSQL */
	private $sql;

	/** @var ResultWrapper|bool  */
	private $result;

	/**
	 * Create a new WikiaSQL iterator
	 *
	 * @param DatabaseBase $dbh
	 * @param WikiaSQL $sql
	 */
	public function __construct( DatabaseBase $dbh, WikiaSQL $sql ) {
		$this->sql = $sql;
		$this->dbh = $dbh;
		return $this;
	}

	/**
	 * Set the maximum number of rows to select at once
	 *
	 * @param $limit
	 *
	 * @return $this
	 */
	public function resultLimit( $limit ) {
		$this->limit = $limit;
		$this->sql->limit( $limit );
		return $this;
	}

	/**
	 * The record to start at.  Defaults to 0.
	 *
	 * @param $offset
	 *
	 * @return $this
	 */
	public function startAt( $offset ) {
		$this->offset = $offset;
		$this->sql->offset( $offset );
		return $this;
	}

	/**
	 * Return the next row in the query or null when finished
	 *
	 * @return null|stdClass
	 */
	public function next() {
		if ( $this->needsInit ) {
			$this->loadNextChunk();
			$this->needsInit = false;
		}

		if ( $this->chunkProcessed() ) {
			$this->loadNextChunk();
		}

		if ( $this->queryDone ) {
			return null;
		}

		return $this->getNextRecord();
	}

	protected function loadNextChunk() {
		$this->result = $this->sql->run( $this->dbh );
		$this->chunkSize = $this->result->numRows();
		$this->chunkIndex = 0;

		if ( $this->chunkSize > 0 ) {
			// Line up the offset for the next call
			$this->offset += $this->limit;
			$this->sql->offset( $this->offset );
		} else {
			// If no rows are returned after a fetch, we're done
			$this->queryDone = true;
		}
	}

	protected function chunkProcessed() {
		return $this->chunkIndex >= $this->chunkSize;
	}

	/**
	 * Returns the next row from the query.
	 *
	 * @return stdClass
	 */
	protected function getNextRecord() {
		$row = $this->result->fetchObject();
		$this->chunkIndex++;
		$this->recordNum++;

		return $row;
	}

	/**
	 * Returns the current record in the query
	 *
	 * @return int
	 */
	public function currentRecordNum() {
		return $this->recordNum;
	}

	/**
	 * Reports on the state of this iterator
	 *
	 * @return bool
	 */
	public function isDone() {
		return $this->queryDone;
	}
}

class WikiaSQLIteratorException extends Exception {}