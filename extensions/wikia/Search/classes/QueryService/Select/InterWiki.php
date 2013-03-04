<?php
/**
 * Class definition for Wikia\Search\QueryService\Select\InterWiki
 */
namespace Wikia\Search\QueryService\Select;
use \Solarium_Query_Select, \Wikia\Search\Utilities;

class InterWiki extends AbstractSelect
{
	/**
	 * Number of result groupings we want on a grouped search
	 * @var int
	 */
	const GROUP_RESULTS_GROUPINGS_LIMIT		= 20;
	
	/**
	 * Number of results per grouping we want in a grouped search
	 * @var int
	 */
	const GROUP_RESULTS_GROUPING_ROW_LIMIT = 1;
	
	/**
	 * The field to group over.
	 * @var string
	 */
	const GROUP_RESULTS_GROUPING_FIELD = 'host';
	
	/**
	 * Time to cache grouped results, in seconds -- 15 minutes.
	 * @var int
	 */
	const GROUP_RESULTS_CACHE_TTL = 900;
	
	/**
	 * Used for tracking
	 * @var string
	 */
	protected $searchType = 'inter';
	
	/** 
	 * Boost functions used in interwiki search
	 * @var array
	 */
	protected $boostFunctions = array(
		'log(wikipages)^4',
		'log(activeusers)^4',
		'log(revcount)^1',
		'log(views)^8',
		'log(words)^0.5',
	);
	
	/**
	 * Default time allowed for a query.
	 * @var int
	 */
	protected $timeAllowed = 7500;
	
	/**
	 * (non-PHPdoc)
	 * @see \Wikia\Search\QueryService\Select\AbstractSelect::extractMatch()
	 */
	public function extractMatch() {
		$domain = preg_replace(
				'/[^a-zA-Z]/',
				'',
				strtolower( $this->config->getQuery( \Wikia\Search\Config::QUERY_RAW ) ) 
				);
		if ( $match = $this->interface->getWikiMatchByHost( $domain ) ) {
			return $this->config->setWikiMatch( $match )->getWikiMatch();
		}
		return null;
	}
	
	protected function registerComponents( Solarium_Query_Select $query ) {
		return $this->registerQueryParams   ( $query )
		            ->registerHighlighting  ( $query )
		            ->registerFilterQueries ( $query )
		            ->registerGrouping      ( $query )
		            ->registerSpellcheck    ( $query )
		;
	}
	
	/**
	 * Sets grouping params given a configuration
	 * @param Solarium_Query_Select $query
	 * @return Wikia\Search\QueryService\Select\InterWiki
	 */
	protected function registerGrouping( Solarium_Query_Select $query ) {
		$grouping = $query->getGrouping();
		$grouping	->setLimit			( self::GROUP_RESULTS_GROUPING_ROW_LIMIT )
					->setOffset			( $this->config->getStart() )
					->setFields			( array( self::GROUP_RESULTS_GROUPING_FIELD ) )
		;
		return $this;
	}

	protected function registerFilterQueryForMatch() {
		if ( $this->config->hasWikiMatch() ) {
			$noPtt = Utilities::valueForField( 'wid', $this->config->getWikiMatch()->getId(), array( 'negate' => true ) );
			$this->config->setFilterQuery( $noPtt, 'wikiptt' );
		}
		
	}
	
	/**
	 * Configures spellcheck per our desired settings
	 * @param Solarium_Query_Select $query
	 * @return InterWiki
	 */
	protected function registerSpellcheck( Solarium_Query_Select $query ) {
		if ( $this->interface->getGlobal( 'WikiaSearchSpellcheckActivated' ) ) {
			$query->getSpellcheck()
			      ->setQuery( $this->config->getQueryNoQuotes( true ) )
			      ->setCollate( true )
			      ->setCount( self::SPELLING_RESULT_COUNT )
			      ->setMaxCollationTries( self::SPELLING_MAX_COLLATION_TRIES )
			      ->setMaxCollations( self::SPELLING_MAX_COLLATIONS )
			      ->setExtendedResults( true )
			      ->setCollateParam( 'fq', 'is_content:true' )
			      ->setOnlyMorePopular( true )
			      ->setDictionary( $this->interface->searchSupportsCurrentLanguage() ? $this->interface->getLanguageCode() : 'default'   )
			      ->setCollateExtendedResults( true )
			;
		}
		return $this;
	}
	
	/**
	 * Handles initial configuration when invoking doSearch
	 */
	protected function prepareRequest() {
		$this->config->setLength( self::GROUP_RESULTS_GROUPINGS_LIMIT )
		             ->setIsInterWiki( true )
		;
		return parent::prepareRequest();
	}
	
	protected function configureQueryFields() {
		$this->config->setQueryField( 'wikititle', 7 );
	}
	
	/**
	 * Builds the string used with filter queries based on search config
	 * @return string
	 */
	protected function getFilterQueryString() {
		$filterQueries = array( Utilities::valueForField( 'iscontent', 'true') );
		$hub = $this->config->getHub();
		if (! empty( $hub ) ) {
			$filterQueries[] = Utilities::valueForField( 'hub', $hub );
		}
		return implode( ' AND ', $filterQueries );
	}
	
	/**
	 * Builds the necessary query clauses based on values set in the searchconfig object
	 * @return string
	 */
	protected function getQueryClausesString()
	{
		$widQueries = array();
		foreach ( $this->interface->getGlobal( 'CrossWikiaSearchExcludedWikis' ) as $excludedWikiId ) {
			$widQueries[] = Utilities::valueForField( 'wid',  $excludedWikiId, array( 'negate' => true ) );
		}
		
		$queryClauses= array(
				implode( ' AND ', $widQueries ),
				Utilities::valueForField( 'lang', $this->interface->getLanguageCode() ),
				Utilities::valueForField( 'iscontent', 'true' )
		);
		
		$hub = $this->config->getHub();
		if (! empty( $hub ) ) {
		    $queryClauses[] = Utilities::valueForField( 'hub', $hub );
		}
		return sprintf( '(%s)', implode( ' AND ', $queryClauses ) );
	}
	
	/**
	 * @see \Wikia\Search\QueryService\Select\AbstractSelect::getFormulatedQuery()
	 */
	protected function getFormulatedQuery() {
		return sprintf( '%s AND (%s)', $this->getQueryClausesString(), $this->getNestedQuery() );
	}
	
	/**
	 * Returns the string used to build out a boost query with Solarium
	 * @return string
	 */
	protected function getBoostQueryString()
	{
		$queryNoQuotes = preg_replace( '/ wiki\b/i', '', $this->config->getQueryNoQuotes( true ) );
		$boostQueries = array(
				Utilities::valueForField( 'html', $queryNoQuotes, array( 'boost'=>5, 'quote'=>'\"' ) ),
				Utilities::valueForField( 'title', $queryNoQuotes, array( 'boost'=>10, 'quote'=>'\"' ) ),
				Utilities::valueForField( 'wikititle', $queryNoQuotes, array( 'boost' => 15, 'quote' => '\"' ) ),
				Utilities::valueForField( 'host', 'answers', array( 'boost' => 10, 'negate' => true ) ),
				Utilities::valueForField( 'host', 'respuestas', array( 'boost' => 10, 'negate' => true ) )
		);
		return implode( ' ', $boostQueries );
	}
	
	/**
	 * Return a string of query fields based on configuration
	 * @return string
	 */
	protected function getQueryFieldsString() {
		$queryFieldsString = '';
		$this->config->setQueryField( 'wikititle', 7 );
		foreach ( $this->config->getQueryFieldsToBoosts()  as $field => $boost ) {
			$queryFieldsString .= sprintf( '%s^%s ', Utilities::field( $field ), $boost );
		}
		return trim( $queryFieldsString );
	}
	
}