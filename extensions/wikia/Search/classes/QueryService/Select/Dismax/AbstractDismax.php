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
class AbstractDismax extends AbstractSelect
{

	/**
	 * Return a string of query fields based on configuration
	 * @return string
	 */
	protected function getQueryFieldsString() {
		$queryFieldsString = '';
		foreach ( $this->config->getQueryFieldsToBoosts()  as $field => $boost ) {
			$queryFieldsString .= sprintf( '%s^%s ', Utilities::field( $field ), $boost );
		}
		return trim( $queryFieldsString );
	}
	
	/**
	 * Registers our query as an extended dismax query.
	 * @return AbstractSelect
	 */
	protected function registerDismax( Solarium_Query_Select $select ) {
		
		$queryFieldsString = $this->getQueryFieldsString();
		$dismax = $select->getDismax()
		                 ->setQueryFields( $queryFieldsString )
		                 ->setQueryParser( 'edismax' )
		;
		
		if ( $this->service->isOnDbCluster() ) {
			$dismax
				->setPhraseFields		( $queryFieldsString )
				->setBoostQuery			( $this->getBoostQueryString() )
				->setMinimumMatch		( $this->config->getMinimumMatch() )
				->setPhraseSlop			( 3 )
				->setTie				( 0.01 )
			;
			if (! $this->config->getSkipBoostFunctions()  ) {
			    $dismax->setBoostFunctions( implode(' ', $this->boostFunctions ) );
			}
		}
		return $this;
	}
	

	/**
	 * As an edismax query, gives the required query in the first clause of the conjunction, and then the parseable query stuff in the second clause.
	 * @return string
	 */
	protected function getQuery() {
		$queryClauses = $this->getQueryClausesString();
		if ( substr_count( $queryClauses, " " ) > 0 ) {
			$queryClauses = "({$queryClauses})"; // hell yeah i need to do this wtf
		}
		return sprintf( '+%s AND (%s)', $queryClauses, $this->getConfig()->getQuery()->getSolrQuery( self::MAX_QUERY_WORDS ) );
	}
	
	/**
	 * Prepare boost queries based on the provided instance.
	 * @return string
	 */
	protected function getBoostQueryString() {
		return '';
	}
	
}