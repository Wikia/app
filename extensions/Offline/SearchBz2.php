<?php
/**
 * Interface to search backup dump data using its index.
 * @file
 * @ingroup Search
 */

/**
 * Search engine hook
 * @ingroup Search
 */
class SearchBz2 extends SearchEngine {
	var $strictMatching = true;
	static $mMinSearchLength;

	function __construct( $db ) {
		$this->db = $db;
	}

	/** 
	 * Parse the user's query and transform it into an SQL fragment which will 
	 * become part of a WHERE clause
	 */
	function parseQuery( $filteredText, $fulltext ) {
		return $filteredText;
	}
	
	/**
	 * Perform a full text search query and return a result set.
	 *
	 * @param $term String: raw search term
	 * @return MySQLSearchResultSet
	 */
	function searchText( $term ) {
		return $this->searchInternal( $term, true );
	}

	/**
	 * Perform a title-only search query and return a result set.
	 *
	 * @param $term String: raw search term
	 * @return Bz2SearchResultSet
	 */
	function searchTitle( $term ) {
		return $this->searchInternal( $term, false );
	}
	
	protected function searchInternal( $term, $fulltext ) {
		global $wgCountTotalSearchHits;
		
		$results = DumpReader::index_search($term);

		return new Bz2SearchResultSet( $results, $term);
	}
// TODO
//	function queryNamespaces() {
}

/**
 * @ingroup Search
 */
class Bz2SearchResultSet extends SearchResultSet {
	function Bz2SearchResultSet($results, $terms) {
		$this->mTotalHits = count($results);
		$this->mResultSet = $results;
		$this->mTerms = $terms;
	}

	function termMatches() {
		return $this->mTerms;
	}

	function numRows() {
		return $this->getTotalHits();
	}

	function getTotalHits() {
		return $this->mTotalHits;
	}

	function next() {
		if ($this->mResultSet === false || count($this->mResultSet) < 1)
			return false;

		$result = array_pop($this->mResultSet);
		if ($result === false)
			return false;

		list ($bzfile, $offset, $title) = $result;

		$matches = array();
		$row = new stdClass();
		if (preg_match('/([^:]*):([^:]+)$/', $title, $matches)) {
//TODO lookup index
			$row->page_namespace = $matches[1];
			$row->page_title = $matches[2];
		} else {
			$row->page_namespace = NS_MAIN;
			$row->page_title = $title;
		}

//wfDebug('GOT'.$row->page_namespace .' : '. $row->page_title .'('.$bzfile.')');
		return new SearchResult($row);
	}
}
