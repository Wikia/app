<?php
/**
 * Class definition for \Wikia\Search\ResultSet\Base
 */
namespace Wikia\Search\ResultSet;
use \Wikia\Search\Result, \ArrayIterator, \Wikia\Search\MediaWikiService, \Wikia\Search\Utilities;
use \WikiaException, \Solarium_Result_Select, \WikiaSearchConfig;
/**
 * This is the default class definition -- represents a flat grouping of results, e.g. on-wiki search.
 * @author relwell
 * @package Search
 * @subpackage ResultSet
 */
class Base extends EmptySet
{
	/**
	 * The object that Solarium builds after getting a Solr response
	 * @var Solarium_Result_Select
	 */
	protected $searchResultObject;
	
	/**
	 * MW service.
	 * @var MediaWikiService
	 */
	protected $service;

	/**
	 * Dependencies are injected here by factory for result, config, and interface, via container.
	 * @param DependencyContainer $container
	 */
	protected function configure( DependencyContainer $container ) {
		$this->searchResultObject  = $container->getResult();
		$this->searchConfig        = $container->getConfig();
		$this->service           = $container->getService();
		$this->results             = new ArrayIterator( array() );
		$this->resultsFound        = $this->searchResultObject->getNumFound();
		$this->prependMatchIfExists()
		     ->setResults( $this->searchResultObject->getDocuments() )
		;
	}
	
	/**
	 * set result documents
	 * @param  array $results list of Wikia\Search\Result or Wikia\Search\ResultSet objects
	 * @return Base provides fluent interface
	 */
	public function setResults( array $results ) {
		foreach( $results as $result ) {
			$this->addResult( $result );
		}
		return $this;
	}
	
	/**
	 * Does a little prep on a result object, applies highlighting if exists, and adds to result array.
	 * @param  Result $result
	 * @throws WikiaException
	 * @return Base provides fluent interface
	 */
	protected function addResult( Result $result ) {
		$id = $result['id'];
		$highlighting = $this->searchResultObject->getHighlighting();
		if (        ( $highlighting !== null )
				&&  ( $hlResult      =  $highlighting->getResult( $id ) )
				&&  ( $field         =  $hlResult->getField( Utilities::field( 'html' ) ) ) ) {
			$result->setText( $field[0] );
		}
		if ( $result['created'] ) {
			$result->setVar( 'fmt_timestamp', $this->service->getMediaWikiFormattedTimestamp( $result['created'] ) );
			$result->setVar( 'created_30daysago', ( time() - strtotime( $result['created'] ) ) > 2592000 );
		}

		$result->setVar('cityArticlesNum', $result['wikiarticles'] )
		       ->setVar('wikititle',       $result[Utilities::field( 'wikititle' )] );

		$this->results[$id] = $result;
		return $this;
	}
	
	/**
	 * Subroutine for optionally prepending article match to result array.
	 * @return Base provides fluent interface
	 */
	protected function prependMatchIfExists() {
		if ( $this->searchConfig->hasMatch() ) {
			if ( $this->getResultsStart() == 0 ) {
				$this->addResult( $this->searchConfig->getMatch()->getResult() );
			}
			$this->resultsFound++;
		}
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