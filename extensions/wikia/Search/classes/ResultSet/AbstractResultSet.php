<?php
/**
 * Class definition for \Wikia\Search\ResultSet\AbstractResultSet
 * @author relwell
 */
namespace Wikia\Search\ResultSet;
use Wikia\Search\Traits\AttributeIterableTrait;
use \Iterator, \ArrayAccess, \ArrayIterator, \Wikia\Search\Config;
/**
 * This allows us to do a lot of the utility stuff separated out from the core logic of each class.
 * @author relwell
 * @abstract
 * @package Search
 * @subpackage ResultSet
 */
abstract class AbstractResultSet implements Iterator, ArrayAccess
{
	use AttributeIterableTrait;
	
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
	 * Keys are IDs, values are Wikia\Search\Result instances.
	 * @var ArrayIterator
	 */
	protected $results = array();
	
	/**
	 * The configuration used in handling searhes
	 * @var Config
	 */
	protected $searchConfig;
	
	/**
	 * A resultset requires a dependency container, because that's how it knows how to configure itself.
	 * @final
	 * @param DependencyContainer $container
	 */
	final public function __construct( DependencyContainer $container ) {
		$this->configure( $container );
	}
	
	/**
	 * We need this one because you can't unit test an abstract class with an abstract constructor
	 * @param DependencyContainer $container
	 */
	abstract protected function configure( DependencyContainer $container );
	
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
	 * Allows us to set multiple headers at once.
	 * @param array $headers
	 * @return \Wikia\Search\ResultSet\AbstractResultSet
	 */
	public function addHeaders( array $headers ) {
		foreach ( $headers as $key => $value ) {
			$this->setHeader( $key, $value );
		}
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
		$this->results = $this->results instanceof ArrayIterator ? $this->results : new ArrayIterator( $this->results ); 
		return $this->results; 
	}
	
	/**
	 * Returns the query used to get these results
	 * @return string
	 */
	public function getQuery() {
		return $this->searchConfig->getQuery()->getQueryForHtml();
	}
	
	/**
	 * Done to return results in json format
	 * Can be removed after upgrade to 5.4 and specify serialized Json data on Wikia\Search\Result
	 * http://php.net/manual/en/jsonserializable.jsonserialize.php
	 * @param array $expectedFields the fields we should surface
	 * @return array
	 */
	public function toArray( array $expectedFields = array( 'title', 'url', 'pageid' ) ) {
		$tempResults = array();
		foreach( $this->getResults() as $result ){
			$tempResults[] = $result->toArray( $expectedFields );
		}
		return $tempResults;
	}
	
	/**
	 * Allows us to implement the AttributeIterable trait.
	 * @return \ArrayIterator
	 */
	public function getIterable() {
		return $this->getResults();
	}
}