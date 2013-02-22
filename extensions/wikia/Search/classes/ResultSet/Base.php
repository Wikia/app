<?php
/**
 * Class definition for \Wikia\Search\ResultSet\Base
 */
namespace Wikia\Search\ResultSet;
use \Wikia\Search\Result, \ArrayIterator, \Wikia\Search\MediaWikiInterface, \WikiaSearch;
use \WikiaException, \Solarium_Result_Select, \WikiaSearchConfig;
/**
 * This is the default class definition -- represents a flat grouping of results, e.g. on-wiki search.
 * @author relwell
 */
class Base extends EmptySet
{
	/**
	 * The object that Solarium builds after getting a Solr response
	 * @var Solarium_Result_Select
	 */
	protected $searchResultObject;
	
	/**
	 * MW interface.
	 * @var MediaWikiInterface
	 */
	protected $interface;

	/**
	 * Constructor method. Dependencies are injected here by factory for result, config, and interface, via container.
	 * @param DependencyContainer $container
	 */
	public function __construct( DependencyContainer $container ) {
		$this->searchResultObject  = $container->getResult();
		$this->searchConfig        = $container->getConfig();
		$this->interface           = $container->getInterface();
		$this->resultsFound        = $this->searchResultObject->getNumFound();
		$this->prependArticleMatchIfExists()
		     ->setResults( $this->searchResultObject->getDocuments() )
		     ->setResultsFound( $this->resultsFound )
		;
	}
	
	/**
	 * set result documents
	 * @param  array $results list of WikiaResult or WikiaResultSet (for result grouping) objects
	 * @return Base provides fluent interface
	 */
	public function setResults( array $results ) {
		$this->results = new ArrayIterator( array() );
		foreach( $results as $result ) {
			$this->addResult( $result );
		}
		return $this;
	}
	
	/**
	 * Populates the resultsFound protected var
	 * @param int $value
	 * @return Base provides fluent interface
	 */
	public function setResultsFound( $value ) {
		$this->resultsFound = $value;
		return $this;
	}
	
	
	/**
	 * Does a little prep on a result object, applies highlighting if exists, and adds to result array.
	 * @param  Result $result
	 * @throws WikiaException
	 * @return Base provides fluent interface
	 */
	protected function addResult( Result $result ) {
		if( $this->isValidResult( $result ) ) {
			$id = $result['id'];
			$highlighting = $this->searchResultObject->getHighlighting();
			if (        ( $highlighting !== null )
					&&  ( $hlResult      =  $highlighting->getResult( $id ) )
					&&  ( $field         =  $hlResult->getField( WikiaSearch::field( 'html' ) ) ) ) {
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
	 * @return Base provides fluent interface
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
	 * Returns originating offset of the search results
	 * @return int
	 */
	public function getResultsStart() {
		return $this->searchResultObject->getStart();
	}

	/**
	 * Determines if a result is valid to be added to the $results array.
	 * @param  mixed $result
	 * @return boolean
	 */
	protected function isValidResult( $result ) {
		return ( ( $result instanceof Result ) || ( $result instanceof Base ) );
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

}