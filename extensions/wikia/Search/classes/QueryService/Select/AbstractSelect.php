<?php
/**
 * Class definition for Wikia\Search\QueryService\Select\AbstractSelect
 */
namespace Wikia\Search\QueryService\Select;
use Wikia\Search\QueryService\DependencyContainer, Wikia\Search\Config, \Solarium_Client, Wikia\Search\ResultSet, Wikia\Search\Utilities;

abstract class AbstractSelect
{
	/**
	 * Snippets should be 150 characters long, by default.
	 * @var int
	 */
	const HL_FRAG_SIZE 						= 150;
	
	/**
	 * This should be prepended to matches in Solr snippets.
	 * @var string
	 */
	const HL_MATCH_PREFIX					= '<span class="searchmatch">';
	
	/**
	 * This should be appended to matches in Solr snippets.
	 * @var string
	 */
	const HL_MATCH_POSTFIX					= '</span>';
	
	/**
	 * Sets max collation tries when spellchecking
	 * @var int
	 */
	const SPELLING_MAX_COLLATION_TRIES		= 20;
	
	/**
	 * Sets max collations when spellchecking
	 * @var int
	 */
	const SPELLING_MAX_COLLATIONS			= 5;
	
	/**
	 * Sets the max number of results to return when spellchecking
	 * @var int
	 */
	const SPELLING_RESULT_COUNT				= 20;
	
	/**
	 * Used for tracking
	 * @var string
	 */
	protected $searchType;
	
	/**
	 * Boost functions, used by child classes to increase a document's score based on specific document values
	 * @var array
	 */
	protected $boostFunctions = array();
	
	/**
	 * Default time allowed for a query.
	 * @var int
	 */
	protected $timeAllowed = 5000;
	
	/**
	 * @var Wikia\Search\Config
	 */
	protected $config;
	
	/**
	 * @var \Solarium_Client
	 */
	protected $client;
	
	public function __construct( DependencyContainer $container ) {
		$this->client = $container->getClient();
		$this->config = $container->getConfig();
		$this->resultSetFactory = $container->getResultSetFactory();
	}
	
	/**
	 * @param  WikiaSearchConfig $searchConfig
	 * @return Wikia\Search\ResultSet\AbstractResultSet
	 */
	public function search() {
		$this->prepareRequest()
		     ->prepareResponse( $this->sendSearchRequestToClient() )
		;
		return $this->config->getResults();
	}
	
	/**
	 * Creates an instance of Solarium_Query_Select configured by searchconfig.
	 * @return \Solarium_Query_Select
	 */
	protected function getSelectQuery() {
		$query = $this->client->createSelect();
		$query->setDocumentClass( '\Wikia\Search\Result' );
		$this->registerComponents( $query );
		return $query->setQuery( $this->getFormulatedQuery() );
	}
	
	/**
	 * Introduced flexible in the actual query 
	 * @return string
	 */
	abstract protected function getFormulatedQuery();
	
	/**
	 * Prepare boost queries based on the provided instance.
	 * @return string
	 */
	public function getBoostQueryString() {
		return '';
	}
	
	/**
	 * Allows us to configure components in child instances.
	 * @param \Solarium_Query_Select $query
	 * @return \Wikia\Search\QueryService\Select\AbstractSelect
	 */
	protected function registerComponents( \Solarium_Query_Select $query ) {
		return $this;
	}
	
	/**
	 * Registers meta-parameters for the query
	 * @param Solarium_Query_Select $query
	 * @return Wikia\Search\QueryService\Select\AbstractSelect
	 */
	protected function registerQueryParams( Solarium_Query_Select $query ) {
		$sort = $this->config->getSort();
		$query->addFields      ( $this->searchConfig->getRequestedFields() )
		      ->removeField    ('*')
		      ->setStart       ( $this->config->getStart() )
		      ->setRows        ( $this->config->getLength() )
		      ->addSort        ( $sort[0], $sort[1] )
		      ->addParam       ( 'timeAllowed', $this->timeAllowed )
		;
		return $this;
	}
	
	/**
	 * Configures filter queries to, for instance, prevent duplicate results from PTT, or enable better caching.
	 * @param Solarium_Query_Select $query
	 * @return Wikia\Search\QueryService\Select\AbstractSelect
	 */
	protected function registerFilterQueries( Solarium_Query_Select $query ) {
		$this->config->setFilterQuery( $this->getFilterQueryString() );
		$this->registerFilterQueryForMatch();
		$query->addFilterQueries( $this->config->getFilterQueries() );
		return $this;
	}
	
	/**
	 * Children can override this method optionally.
	 */
	protected function registerFilterQueryForMatch() {}
	
	/**
	 * Configures result snippet highlighting
	 * @param Solarium_Query_Select $query
	 * @return AbstractSelect
	 */
	protected function registerHighlighting( Solarium_Query_Select $query ) {
		$highlighting = $query->getHighlighting();
		$highlighting->addField                     ( self::field( 'html' ) )
		             ->setSnippets                  ( 1 )
		             ->setRequireFieldMatch         ( true )
		             ->setFragSize                  ( self::HL_FRAG_SIZE )
		             ->setSimplePrefix              ( self::HL_MATCH_PREFIX )
		             ->setSimplePostfix             ( self::HL_MATCH_POSTFIX )
		             ->setAlternateField            ( 'nolang_txt' )
		             ->setMaxAlternateFieldLength   ( 100 )
		;
		return $this;
	}
	
	/**
	 * Responsible for the initial query to Solr, with some error handling built in
	 * @return Solarium_Result_Select
	 */
	protected function sendSearchRequestToClient() {
		try {
			return $this->client->select( $this->getSelectQuery() );
		} catch ( \Exception $e ) {
			if ( $this->config->getError() !== null ) {
				$this->config->setError( $e );
				\Wikia::log( __METHOD__, 'Querying Solr With No Boost Functions', $e );
				return new \Solarium_Result_Select_Empty();
			} else {
				\Wikia::log( __METHOD__, 'Querying Solr First Time', $e );
				
				$this->config->setSkipBoostFunctions( true )
				             ->setError( $e );

				return $this->sendSearchRequestToClient();
			}
		}
	}
	
	/**
	 * This is a hook for child classes to optionally extend
	 * @return AbstractSelect
	 */
	protected function prepareRequest() {
		if ( $this->config->getPage() > 1 ) {
			$this->config->setStart( ( $this->config->getPage() - 1 ) * $this->config->getLength() );
		}
		return $this;
	}
	
	/**
	 * This is a hook forchild classes to optionally extend
	 */
	protected function prepareResponse( Solarium_Result_Select $result ) {
		// re-search for spellchecked phrase in the absence of results
		if ( $this->interface->getGlobal( 'WikiaSearchSpellcheckActivated' ) 
				&& $result->getNumFound() == 0
				&& !$this->config->hasMatch() ) {
			if ( $collation = $result->getSpellcheck()->getCollation() ) {
				$this->config->setQuery( $collation->getQuery() );
				$result = $this->sendSearchRequestToClient();
			}
		}
		
		$container = new ResultSet\DependencyContainer( array( 'result' => $result, 'config' => $this->config ) );
		
		$results = $this->resultSetFactory->get( $container );
		$resultCount = $results->getResultsFound();
		
		$this->config->setResults( $results )
		             ->setResultsFound( $resultCount )
		;
		if( $this->config->getPage() == 1 ) {
			\Track::event(
					( !empty( $resultCount ) ? 'search_start' : 'search_start_nomatch' ),
					array(
							'sterm'	=> $this->config->getQuery(), 
							'stype'	=> $this->searchType 
							)
					);
		}
	}
	
	/**
	 * Creates a nested query using extended dismax.
	 * @return Solarium_Query_Select
	 */
	protected function getNestedQuery() {
		$nestedQuery = $this->client->createSelect();
		$nestedQuery->setQuery( $this->config->getQuery() );
		
		$queryFieldsString = $this->getQueryFieldsString();
		$dismax = $nestedQuery->getDismax()
		                      ->setQueryFields( $queryFieldsString )
		                      ->setQueryParser( 'edismax' )
		;
		
		if ( $this->interface->isOnDbCluster() ) {
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
		return $nestedQuery;
	}
	
	/**
	 * Builds the string used with filter queries based on search config
	 * @return string
	 */
	protected function getFilterQueryString()
	{
		return Utilities::valueForField( 'wid', $this->config->getCityId() );
	}
}