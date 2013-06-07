<?php
/**
 * User: artur
 * Date: 06.06.13
 * Time: 15:42
 */

class WikiPageCountService {
	/**
	 * @var Solarium_Client
	 */
	private $solariumClient;

	function __construct($solariumClient) {
		$this->solariumClient = $solariumClient;
	}

	/**
	 * @param integer $start
	 * @param integer $count
	 * @return array
	 */
	public function listPageCounts( $start, $count ) {
		$query = $this->solariumClient->createSelect();

		$query->setQuery("(ns:0)");
		$query->getGrouping()->addField("wid");
		$query->setStart( $start );
		$query->setRows( $count );
		$query->addSort( 'wid', Solarium_Query_Select::SORT_ASC );

		$resultSet = $this->solariumClient->select( $query );

		$results = [];
		foreach( $resultSet->getGrouping()->getGroups() as $group ) {
			/** @var Solarium_Result_Select_Grouping_FieldGroup $group */
			foreach( $group as $groupElement ) {
				/** @var Solarium_Result_Select_Grouping_ValueGroup $groupElement */
				$results[] = new WikiPageCountModel( $groupElement->getValue(),  $groupElement->getNumFound() );
			}
		}
		return $results;
	}

	public function listPageCountsIterator() {
		return new PageCountsIterator( $this );
	}
}

class PageCountsIterator implements  Iterator {
	/**
	 * @var WikiPageCountService
	 */
	private $wikiPageCountService;
	private $position = 0;
	private $chunk = null;
	private $chunkStart = null;
	private $chunkSize = 1000;

	function __construct( WikiPageCountService $wikiPageCountService ) {
		$this->wikiPageCountService = $wikiPageCountService;
	}

	protected function fetchPageForCurrentChunk ( ) {
		$pos = $this->position;
		if( $this->chunk == null
			|| ($pos - $this->chunkStart) < 0
			|| ($pos - $this->chunkStart) >= $this->chunkSize ) {
			$this->chunkStart = floor( $pos / $this->chunkSize ) * $this->chunkSize;
			$this->chunk = $this->wikiPageCountService->listPageCounts( $this->chunkStart, $this->chunkSize );
		}
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Return the current element
	 * @link http://php.net/manual/en/iterator.current.php
	 * @return mixed Can return any type.
	 */
	public function current() {
		if ( $this->valid() ) {
			return $this->chunk[$this->position - $this->chunkStart];
		}
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Move forward to next element
	 * @link http://php.net/manual/en/iterator.next.php
	 * @return void Any returned value is ignored.
	 */
	public function next() {
		$this->position++;
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Return the key of the current element
	 * @link http://php.net/manual/en/iterator.key.php
	 * @return mixed scalar on success, or null on failure.
	 */
	public function key() {
		return $this->position;
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Checks if current position is valid
	 * @link http://php.net/manual/en/iterator.valid.php
	 * @return boolean The return value will be casted to boolean and then evaluated.
	 * Returns true on success or false on failure.
	 */
	public function valid() {
		$this->fetchPageForCurrentChunk();
		return isset( $this->chunk[$this->position - $this->chunkStart] );
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Rewind the Iterator to the first element
	 * @link http://php.net/manual/en/iterator.rewind.php
	 * @return void Any returned value is ignored.
	 */
	public function rewind() {
		$this->position = 0;
	}
}
