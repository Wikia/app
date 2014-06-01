<?php
/**
 * Class definition for Wikia\Search\QueryService\Select\Dismax\AbstractDismax
 */
namespace Wikia\Search\QueryService\Select\Dismax;
use Wikia\Search\QueryService\Select\AbstractSelect, Solarium_Query_Select, Wikia\Search\Utilities;
/**
 * Specifies behavior applicable only to query services that use the DisMax Query Parser
 * @author relwell
 */
abstract class AbstractDismax extends AbstractSelect
{
	
	/**
	 * Boost functions, used by child classes to increase a document's score based on specific document values
	 * @var array
	 */
	protected $boostFunctions = array();

	abstract protected function getQueryClausesString();
	
	/**
	 * Return a string of query fields based on configuration
	 * @return string
	 */
	protected function getQueryFieldsString() {
		$queryFieldsString = '';
		foreach ( $this->getConfig()->getQueryFieldsToBoosts()  as $field => $boost ) {
			$queryFieldsString .= sprintf( '%s^%s ', Utilities::field( $field ), $boost );
		}
		return trim( $queryFieldsString );
	}
	
	/**
	 * Registers our query as an extended dismax query.
	 * @return AbstractSelect
	 */
	protected function registerDismax( Solarium_Query_Select $select ) {
		
		$config = $this->getConfig();
		$queryFieldsString = $this->getQueryFieldsString();
		$dismax = $select->getDismax()
		                 ->setQueryFields( $queryFieldsString )
		                 ->setQueryParser( 'edismax' )
		;
		
		if ( $this->service->isOnDbCluster() ) {
			$dismax->setPhraseFields ( $queryFieldsString )
			       ->setBoostQuery   ( $this->getBoostQueryString() )
			       ->setMinimumMatch ( $config->getMinimumMatch() )
			       ->setPhraseSlop   ( 3 )
				   ->setTie          ( $config->getTie() )
			;
			if ( (! $config->getSkipBoostFunctions() ) && (! empty( $this->boostFunctions ) ) ) {
				$dismax->setBoostFunctions( implode(' ', $this->boostFunctions ) );
			}
		}
		return $this;
	}
	
	/**
	 * Dismax-specific implementation -- registers the dismax component for child components.
	 * @param Solarium_Query_Select $query
	 * @return Wikia\Search\QueryService\Select\Dismax\AbstractDismax
	 */
	protected function registerComponents( Solarium_Query_Select $select ) {
		return $this->registerDismax( $select )
		            ->registerNonDismaxComponents( $select );
	}
	
	/**
	 * This is a hook for child components to provide their own specific component registry.
	 * @param Solarium_Query_Select $query
	 * @return Wikia\Search\QueryService\Select\Dismax\AbstractDismax
	 */
	protected function registerNonDismaxComponents( Solarium_Query_Select $select ) {
		return $this;
	}
	

	/**
	 * As an edismax query, gives the required query in the first clause of the conjunction, and then the parseable query stuff in the second clause.
	 * @return string
	 */
	protected function getQuery() {
		$queryClauses = $this->getQueryClausesString();
		if ( substr_count( $queryClauses, " " ) > 0 ) {
			$queryClauses = "({$queryClauses})"; // this is just a lucene query syntax nuance
		}
		return sprintf( '+%s AND +(%s)', $queryClauses, $this->getConfig()->getQuery()->getSolrQuery( self::MAX_QUERY_WORDS ) );
	}
	
	/**
	 * Returns boost functions
	 * @return array
	 */
	protected function getBoostFunctions() {
		return $this->boostFunctions;
	}
	
	/**
	 * Prepare boost queries based on the provided instance.
	 * @return string
	 */
	protected function getBoostQueryString() {
		return '';
	}
}