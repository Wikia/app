<?php
/**
 * Class definition for \Wikia\Search\ResultSet\AbstractResultSet
 * @author relwell
 */
namespace Wikia\Search\ResultSet;
use \Iterator, \ArrayAccess, \ArrayIterator;
/**
 * This allows us to do a lot of the utility stuff separated out from the core logic of each class.
 * @author relwell
 */
abstract class AbstractResultSet implements Iterator, ArrayAccess
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
	 * @var ArrayIterator
	 */
	protected $results = array();
	
	/**
	 * The configuration used in handling searhes
	 * @var WikiaSearchConfig
	 */
	protected $searchConfig;
	
	/**
	 * A resultset requires a dependency container, because that's how it knows how to configure itself.
	 * @param DependencyContainer $container
	 */
	abstract public function __construct( DependencyContainer $container );
	
	/**
	 * Provides the offset for the result set.
	 * @return int
	 */
	abstract public function getResultsStart();
	
	/**
	 * Returns the number of results found in the search
	 * @return int
	 */
	public function getResultsFound() {
		return $this->resultsFound;
	}
	
	/**
	 * Used to determine if we are currently wrapping any results
	 * @return boolean
	 */
	public function hasResults() {
		return !empty( $this->results );
	}
	
	/**
	 * Returns the actual number of result instances this class wraps
	 * @return int
	 */
	public function getResultsNum() {
		return count( $this->results );
	}
	

	/**
	 * Used for setting metadata over the result set, rather than a single result.
	 * Used particularly for grouped results.
	 * @param  string $key
	 * @param  mixed  $value
	 * @return Base provides fluent interface
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
	public function getHeader( $key = null ) {
		return ( empty( $key ) ? $this->header : ( isset( $this->header[$key] ) ? $this->header[$key] : null ) );
	}
	

	/**
	 * Returns the array of results
	 * @return array
	 */
	public function getResults() {
		$this->results = $this->results ?: new ArrayIterator(); 
		return $this->results;
	}
	
	/**
	 * Returns the query used to get these results
	 * @return string
	 */
	public function getQuery() {
		return $this->searchConfig->getQuery( \WikiaSearchConfig::QUERY_ENCODED );
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

	/**
	 * Done to return results in json format
	 * Can be removed after upgrade to 5.4 and specify serialized Json data on WikiaSearchResult
	 * http://php.net/manual/en/jsonserializable.jsonserialize.php
	 * @return array
	 */
	public function toNestedArray( array $expectedFields = array( 'title', 'url' ) ) {
		$tempResults = array();
		foreach( $this->results as $result ){
			$tempResults[] = $result->toArray( $expectedFields );
		}
		return $tempResults;
	}
	
	/**
	 * Here come a bunch of wrapper methods for ArrayIterator.
	 * These allow us to use array iterator methods on an existing property.
	 * @todo Turn everything below into a trait that includes a method that identifies which property is an ArrayIterator.
	 * This is a really nifty pattern for classes that encapsulate something iterable, but may require additional logic further down the road.
	 * This way, you can test once, and focus on the logic in the specific class implementations.
	 */
	
	/**
	 * Check if offset exists
	 * @link http://www.php.net/manual/en/arrayiterator.offsetexists.php
	 * @param index string <p>
	 * The offset being checked.
	 * </p>
	 * @return void true if the offset exists, otherwise false
	 */
	public function offsetExists( $index ) {
	    return $this->getResults()->offsetExists( $index );
	}

	/**
	 * Get value for an offset
	 * @link http://www.php.net/manual/en/arrayiterator.offsetget.php
	 * @param index string <p>
	 * The offset to get the value from.
	 * </p>
	 * @return mixed The value at offset index.
	 */
	public function offsetGet( $index ) {
	    return $this->getResults()->offsetGet( $index );
	}

	/**
	 * Set value for an offset
	 * @link http://www.php.net/manual/en/arrayiterator.offsetset.php
	 * @param index string <p>
	 * The index to set for.
	 * </p>
	 * @param newval string <p>
	 * The new value to store at the index.
	 * </p>
	 * @return void 
	 */
	public function offsetSet( $index, $newval ) {
	    return $this->getResults()->offsetSet( $index, $newval );
	}

	/**
	 * Unset value for an offset
	 * @link http://www.php.net/manual/en/arrayiterator.offsetunset.php
	 * @param index string <p>
	 * The offset to unset.
	 * </p>
	 * @return void 
	 */
	public function offsetUnset( $index ) {
	    return $this->getResults()->offsetUnset( $index );
	}

	/**
	 * Append an element
	 * @link http://www.php.net/manual/en/arrayiterator.append.php
	 * @param value mixed <p>
	 * The value to append.
	 * </p>
	 * @return void 
	 */
	public function append( $value ) {
	    return $this->getResults()->append( $value );
	}

	/**
	 * Rewind array back to the start
	 * @link http://www.php.net/manual/en/arrayiterator.rewind.php
	 * @return void 
	 */
	public function rewind (){
	    return $this->getResults()->rewind();
	}

	/**
	 * Return current array entry
	 * @link http://www.php.net/manual/en/arrayiterator.current.php
	 * @return mixed The current array entry.
	 */
	public function current() {
	    return $this->getResults()->current();
	}

	/**
	 * Return current array key
	 * @link http://www.php.net/manual/en/arrayiterator.key.php
	 * @return mixed The current array key.
	 */
	public function key() {
	    return $this->getResults()->key();
	}

	/**
	 * Move to next entry
	 * @link http://www.php.net/manual/en/arrayiterator.next.php
	 * @return void 
	 */
	public function next() {
	    return $this->getResults()->next();
	}

	/**
	 * Check whether array contains more entries
	 * @link http://www.php.net/manual/en/arrayiterator.valid.php
	 * @return bool 
	 */
	public function valid() {
	    return $this->getResults()->valid();
	}

	/**
	 * Seek to position
	 * @link http://www.php.net/manual/en/arrayiterator.seek.php
	 * @param position int <p>
	 * The position to seek to.
	 * </p>
	 * @return void 
	 */
	public function seek ($position){
	    return $this->getResults()->seek( $position );
	}
}