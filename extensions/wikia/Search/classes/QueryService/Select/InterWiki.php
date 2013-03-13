<?php
/**
 * Class definition for Wikia\Search\QueryService\Select\InterWiki
 */
namespace Wikia\Search\QueryService\Select;
use \Solarium_Query_Select, \Wikia\Search\Utilities;
/**
 * This class is responsible for performing interwiki search queries.
 * Presently, that not only means not restricting search by a single wiki,
 * but also grouping by hostname.
 * @author relwell
 * @package Search
 * @subpackage QueryService
 */
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
	 * Identifies a match by domain via interface. Registers with config and returns if found.
	 * @see \Wikia\Search\QueryService\Select\AbstractSelect::extractMatch()
	 * @return Wikia\Search\Match\Wiki
	 */
	public function extractMatch() {
		$domain = preg_replace(
				'/[^a-zA-Z]/',
				'',
				strtolower( $this->config->getQuery( \Wikia\Search\Config::QUERY_RAW ) ) 
				);
		$match =  $this->interface->getWikiMatchByHost( $domain );
		if (! empty( $match ) ) {
			$this->config->setWikiMatch( $match );
		}
		return $match;
	}
	
	/**
	 * Registers grouping, query parameters, and filters.
	 * @see \Wikia\Search\QueryService\Select\AbstractSelect::registerComponents()
	 * @param Solarium_Query_Select $query
	 * @return InterWiki
	 */
	protected function registerComponents( Solarium_Query_Select $query ) {
		return $this->configureQueryFields()
		            ->registerQueryParams   ( $query )
		            ->registerFilterQueries ( $query )
		            ->registerGrouping      ( $query )
		;
	}
	
	/**
	 * Sets grouping params given a configuration
	 * @param Solarium_Query_Select $query
	 * @return Wikia\Search\QueryService\Select\InterWiki
	 */
	protected function registerGrouping( Solarium_Query_Select $query ) {
		$grouping = $query->getGrouping();
		$grouping->setLimit( self::GROUP_RESULTS_GROUPING_ROW_LIMIT )
		         ->setOffset( $this->config->getStart() )
		         ->setFields( array( self::GROUP_RESULTS_GROUPING_FIELD ) )
		;
		return $this;
	}

	/**
	 * Registers a filter query for documents matching the wiki ID of a match, if available.
	 * @see \Wikia\Search\QueryService\Select\AbstractSelect::registerFilterQueryForMatch()
	 * @return Wikia\Search\QueryService\Select\InterWiki
	 */
	protected function registerFilterQueryForMatch() {
		if ( $this->config->hasWikiMatch() ) {
			$noPtt = Utilities::valueForField( 'wid', $this->config->getWikiMatch()->getId(), array( 'negate' => true ) );
			$this->config->setFilterQuery( $noPtt, 'wikiptt' );
		}
		return $this;
	}
	
	
	/**
	 * Handles initial configuration when invoking search.
	 * @return Wikia\Search\QueryService\Select\InterWiki
	 */
	protected function prepareRequest() {
		$this->config->setLength( self::GROUP_RESULTS_GROUPINGS_LIMIT )
		             ->setIsInterWiki( true );
		if ( $this->config->getPage() > 1 ) {
			$this->config->setStart( ( $this->config->getPage() - 1 ) * $this->config->getLength() );
		}
		return $this;
	}

	/**
	 * Adds wikititle to query fields before querying.
	 * @return \Wikia\Search\QueryService\Select\InterWiki
	 */
	protected function configureQueryFields() {
		$this->config->setQueryField( 'wikititle', 7 );
		return $this;
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
	 * Returns a nested query, preceded by lucene queries used to filter out bad wikis, and non-content documents.
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
	 * @todo since this gets repeated across OnWiki as well, this is an another indicator that we need additional class layers
	 * @return string
	 */
	protected function getQueryFieldsString() {
		$queryFieldsString = '';
		foreach ( $this->config->getQueryFieldsToBoosts()  as $field => $boost ) {
			$queryFieldsString .= sprintf( '%s^%s ', Utilities::field( $field ), $boost );
		}
		return trim( $queryFieldsString );
	}
	
}