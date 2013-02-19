<?php
/**
 * Class definition for \Wikia\Search\ResultSet\Base
 */
namespace Wikia\Search\ResultSet;
use \WikiaSearchResult;
use \Wikia\Search\MediaWikiInterface;
use \WikiaSearch;
use \WikiaException;
/**
 * This is the default class definition -- represents a flat grouping of results, e.g. on-wiki search.
 * @author relwell
 */
class Base
{
	/**
	 * Used to keep track of index in array access
	 * @var int
	 */
	protected $position = 0;

	/**
	 * Used to to access the documents for a given search result grouping
	 * @var int
	 */
	protected $metaposition = 0;

	/**
	 * Number of results found by the search; NOT the number of results in the set
	 * @var int
	 */
	protected $resultsFound = 0;

	/**
	 * Header values are used for search result grouping metadata
	 * @var array
	 */
	protected $header = array();

	/**
	 * This is the associative array handling results.
	 * Keys are IDs, values are WikiaSearchResult instances.
	 * @var array
	 */
	protected $results = array();
	
	/**
	 * The object that Solarium builds after getting a Solr response
	 * @var Solarium_Result_Select
	 */
	protected $searchResultObject;

	/**
	 * The configuration used in handling searhes
	 * @var WikiaSearchConfig
	 */
	protected $searchConfig;
	
	/**
	 * MW interface.
	 * @var MediaWikiInterface
	 */
	protected $interface;

	/**
	 * Constructor method. Accepts a Solarium select result and a search config.
	 * @param Solarium_Result_Select $result
	 * @param WikiaSearchConfig $searchConfig
	 */
	public function __construct( Solarium_Result_Select $result, WikiaSearchConfig $searchConfig ) {
		$this->searchResultObject  = $result;
		$this->searchConfig        = $searchConfig;
		$this->interface           = MediaWikiInterface::getInstance();
		$this
			->prependArticleMatchIfExists	()
			->setResults					( $this->searchResultObject->getDocuments() )
			->setResultsFound				( $this->resultsFound + $this->searchResultObject->getNumFound() )
		;
	}
	
	/**
	 * Does a little prep on a result object, applies highlighting if exists, and adds to result array.
	 * @param  WikiaSearchResult $result
	 * @throws WikiaException
	 * @return WikiaSearchResultSet provides fluent interface
	 */
	protected function addResult( WikiaSearchResult $result ) {
		if( $this->isValidResult( $result ) ) {
			$id = $result['id'];
			$highlighting = $this->searchResultObject->getHighlighting();
			if (        ( $highlighting == null )
					&&  ( $hlResult      = $highlighting->getResult( $id ) )
					&&  ( $field         = $hlResult->getField( WikiaSearch::field( 'html' ) ) ) ) {
				$result->setText( $field[0] );
			}

			
			if ( $result['created'] ) {
				$result->setVar( 'fmt_timestamp', $this->interface->getMediaWikiFormattedTimestamp( $result['created'] ) );
				$result->setVar( 'created_30daysago', time() - strtotime( $result['created'] ) > 2592000 );
			}

			$result->setVar('cityArticlesNum', $result['wikiarticles'] )
			       ->setVar('wikititle',       $result[WikiaSearch::field( 'wikititle' )] );

			$this->results[$id] = $result;
		}
		else {
			throw new WikiaException( 'Invalid result in set' );
		}
		return $this;
	}
	
	/**
	 * Subroutine for optionally prepending article match to result array.
	 * @return WikiaSearchResultSet provides fluent interface
	 */
	protected function prependArticleMatchIfExists() {
		if (! ( $this->searchConfig->hasArticleMatch() && $this->getResultsStart() == 0 ) ) {
			return $this;
		}
		$this->addResult( $this->searchConfig->getArticleMatch()->getResult() );
		$this->resultsFound++;
		return $this;
	}
	
	/**
	 * Returns the number of results found in the search
	 * @return int
	 */
	public function getResultsFound() {
		return $this->resultsFound;
	}

	/**
	 * Returns originating offset of the search results
	 * @return int
	 */
	public function getResultsStart() {
		return $this->searchResultObject->getStart();
	}

	/**
	 * Returns the actual number of result instances this class wraps
	 * @return int
	 */
	public function getResultsNum() {
		return count( $this->results );
	}

	/**
	 * Used to determine if we are currently wrapping any results
	 * @return boolean
	 */
	public function hasResults() {
		return !empty( $this->results );
	}

	/**
	 * (non-PHPdoc)
	 * @see Iterator::next()
	 */
	public function next() {
		$result = $this->current();
		$this->position++;
		return $result;
	}

	/**
	 * (non-PHPdoc)
	 * @see Iterator::rewind()
	 */
	public function rewind() {
		$this->position = 0;
	}

	/**
	 * (non-PHPdoc)
	 * @see Iterator::current()
	 */
	public function current() {
		if($this->valid()) {
			$keys = array_keys( $this->results );
			return $this->results[ $keys[$this->position] ];
		}
		else {
			return false;
		}
	}

	/**
	 * (non-PHPdoc)
	 * @see Iterator::key()
	 */
	public function key() {
		return $this->position;
	}

	/**
	 * (non-PHPdoc)
	 * @see Iterator::valid()
	 */
	public function valid() {
		$keys = array_keys( $this->results );
		return isset( $keys[$this->position] );
	}

	/**
	 * Used for setting metadata over the result set, rather than a single result.
	 * Used particularly for grouped results.
	 * @param  string $key
	 * @param  mixed  $value
	 * @return WikiaSearchResultSet provides fluent interface
	 */
	public function setHeader( $key, $value ) {
		$this->header[$key] = $value;
		return $this;
	}

	/**
	 * If you don't provide a key, this returns the entire header array.
	 * If you do provide a key, it provides the value for the header array key.
	 * @param  string $key
	 * @return array|mixed
	 */
	public function getHeader($key = null) {
		return ( empty( $key ) ? $this->header : ( isset( $this->header[$key] ) ? $this->header[$key] : null ) );
	}

	/**
	 * Determines if a result is valid to be added to the $results array.
	 * @param  mixed $result
	 * @return boolean
	 */
	protected function isValidResult( $result ) {
		return ( ( $result instanceof WikiaSearchResult ) || ( $result instanceof Base ) );
	}

	/**
	 * Returns the query used to get these results
	 * @return string
	 */
	public function getQuery() {
		return $this->searchConfig->getQuery( \WikiaSearchConfig::QUERY_ENCODED );
	}

	/**
	 * Returns query time
	 * @return number
	 */
	public function getQueryTime() {
		return $this->searchResultObject->getQueryTime();
	}

	/**
	 * Determines whether the result set is empty except for an article match
	 * @return boolean
	 */
	public function isOnlyArticleMatchFound() {
		return $this->getResultsNum() == 1 && $this->results[0]->getVar( 'isArticleMatch' );
	}

	/* (non-PHPdoc)
	 * @see ArrayAccess::offsetExists()
	 */
	public function offsetExists ($offset) {
		return isset($this->results[$offset]);
	}

	/* (non-PHPdoc)
	 * @see ArrayAccess::offsetGet()
	 */
	public function offsetGet ($offset)	{
		return (isset($this->results[$offset])) ? $this->results[$offset] : false;
	}

	/* (non-PHPdoc)
	 * @see ArrayAccess::offsetSet()
	 */
	public function offsetSet ($offset, $value)	{
		$this->results[$offset] = $value;
	}

	/* (non-PHPdoc)
	 * @see ArrayAccess::offsetUnset()
	 */
	public function offsetUnset ($offset) {
		unset($this->results[$offset]);
	}

	/**
	 * Returns the array of results
	 * @return array
	 */
	public function getResults() {
		return $this->results;
	}
	
	/**
	 * Allows us to serialize some core values from an expected wiki for json requests
	 * @param array $expectedFields
	 * @return array
	 */
	public function toArray( $expectedFields = array( 'title', 'url' ) ) {
		$result = array();
		foreach ( $expectedFields as $field ) {
			switch ( $field ) {
				case 'title':
					$result['title'] = $this->getHeader( 'cityTitle' );
					break;
				case 'url':
					$result['url'] = $this->getHeader( 'cityUrl' );
					break;
			}
		}
		return $result;
	}

	/*
	 * Done to return results in json format
	 * Can be removed after upgrade to 5.4 and specify serialized Json data on WikiaSearchResult
	 * http://php.net/manual/en/jsonserializable.jsonserialize.php
	 * @todo if we break the different kind of result sets out into different classes, we should make this just be the "toarray" for root node 
	 * @return array
	 */
	public function toNestedArray( array $expectedFields = array( 'title', 'url' ) ) {
		$tempResults = array();
		foreach( $this->results as $result ){
			$tempResults[] = $result->toArray( $expectedFields );
		}
		return $tempResults;
	}
}