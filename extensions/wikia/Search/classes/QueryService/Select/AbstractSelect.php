<?php
/**
 * Class definition for Wikia\Search\QueryService\Select\AbstractSelect
 */
namespace Wikia\Search\QueryService\Select;
use Wikia\Search\QueryService\DependencyContainer, Wikia\Search\Config, \Solarium_Client, Wikia\Search\ResultSet, Wikia\Search\Utilities, \Solarium_Query_Select, \Solarium_Result_Select;
/**
 * Abstract class responsible for controlling the flow of logic of a search select query.
 * The workflow for a search includes preparation of the query, sending of the query, and preparation of results.
 * @author relwell
 * @package Search
 * @subpackage QueryService
 */
abstract class AbstractSelect
{
	/**
	 * Snippets should be 150 characters long, by default.
	 * @var int
	 */
	const HL_FRAG_SIZE = 150;
	
	/**
	 * This should be prepended to matches in Solr snippets.
	 * @var string
	 */
	const HL_MATCH_PREFIX = '<span class="searchmatch">';
	
	/**
	 * This should be appended to matches in Solr snippets.
	 * @var string
	 */
	const HL_MATCH_POSTFIX = '</span>';
	
	/**
	 * Sets max collation tries when spellchecking
	 * @var int
	 */
	const SPELLING_MAX_COLLATION_TRIES = 20;
	
	/**
	 * Sets max collations when spellchecking
	 * @var int
	 */
	const SPELLING_MAX_COLLATIONS = 5;
	
	/**
	 * Sets the max number of results to return when spellchecking
	 * @var int
	 */
	const SPELLING_RESULT_COUNT = 20;
	
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
	 * Responsible for storing configuration values for a search.
	 * @var Wikia\Search\Config
	 */
	protected $config;
	
	/**
	 * Responsible for encapsulating logic that interacts with MediaWiki classes.
	 * @var Wikia\Search\MediaWikiService
	 */
	protected $service;
	
	/**
	 * Responsible for sending search requests to Solr.
	 * @var \Solarium_Client
	 */
	protected $client;
	
	/**
	 * Handles dependency injection for all child classes.
	 * @param DependencyContainer $container
	 */
	public function __construct( DependencyContainer $container ) {
		$this->client = $container->getClient();
		$this->config = $container->getConfig();
		$this->resultSetFactory = $container->getResultSetFactory();
		$this->service = $container->getService();
	}
	
	/**
	 * Performs a select query on Solr.
	 * A match is instantiated if available, and then the search request 
	 * is prepared and sent. The response, upon receipt, is used to create a ResultSet.
	 * This is fault-tolerant, and will return an instance of Wikia\Search\ResultSet\EmptySet
	 * in the event of no results or an internal exception.
	 * @return Wikia\Search\ResultSet\AbstractResultSet
	 */
	public function search() {
		$this->getMatch();
		$this->prepareRequest()
		     ->prepareResponse( $this->sendSearchRequestToClient() )
		;
		return $this->config->getResults();
	}
	
	/**
	 * Allows us to get an array from search results rather than search result objects.
	 * @param array $fields allows us to apply a mapping
	 * @return array
	 */
	public function searchAsApi( $fields = null, $metadata = false ) {
		$resultSet = $this->search();
		if ( $metadata ) {
			$total = $this->getconfig()->getResultsFound();
			$numPages = $this->getConfig()->getNumPages();
			$limit = $this->getConfig()->getLimit();
			$response = [
					'total' => $total,
					'batches' => $total > 0 ? $numPages : 0,
					'currentBatch' => $total > 0 ? $this->getConfig()->getPage() : 0,
					'next' => $total > 0 ? min( [ $numPages * $limit, $this->getConfig()->getStart() + $limit ] ) : 0,
					'items' => $resultSet->toArray( $fields )
					];
		} else if ( $fields ) {
			$response = $resultSet->toArray( $fields );
		} else {
			$response = $resultSet->toArray();
		}
		return $response;
	}
	
	/**
	 * Retrieves an existing match, or forces the child class to retrieve a match. 
	 * @return Ambigous <\Wikia\Search\Match\Article, \Wikia\Search\Match\Wiki, \Wikia\Search\false, boolean>
	 */
	public function getMatch() {
		if ( $this->config->hasMatch() ) {
			return $this->config->getMatch();
		}
		return $this->extractMatch();
	}
	
	/**
	 * This hook should be overidden by children to access the appropriate kind of match.
	 * @return NULL
	 */
	protected function extractMatch() {
		return null;
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
	 * As an edismax query, gives the required query in the first clause of the conjunction, and then the parseable query stuff in the second clause.
	 * @return string
	 */
	protected function getFormulatedQuery() {
		$queryClauses = $this->getQueryClausesString();
		if ( substr_count( $queryClauses, " " ) > 0 ) {
			$queryClauses = "({$queryClauses})"; // hell yeah i need to do this wtf
		}
		return sprintf( '+%s AND (%s)', $queryClauses, $this->config->getQuery()->getSolrQuery( 10 ) );
	}
	
	/**
	 * Prepare boost queries based on the provided instance.
	 * @return string
	 */
	protected function getBoostQueryString() {
		return '';
	}
	
	/**
	 * Allows us to configure components in child instances.
	 * @param \Solarium_Query_Select $query
	 * @return \Wikia\Search\QueryService\Select\AbstractSelect
	 */
	protected function registerComponents( Solarium_Query_Select $query ) {
		return $this;
	}
	
	/**
	 * Registers meta-parameters for the query
	 * @param Solarium_Query_Select $query
	 * @return Wikia\Search\QueryService\Select\AbstractSelect
	 */
	protected function registerQueryParams( Solarium_Query_Select $query ) {
		$sort = $this->config->getSort();
		$query->addFields      ( $this->config->getRequestedFields() )
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
	 * Used to register a filter query based on settings in the config.
	 * Children can override this method optionally.
	 * @return Wikia\Search\QueryService\Select\AbstractSelect
	 */
	protected function registerFilterQueryForMatch() {
		return $this;
	}
	
	/**
	 * Configures result snippet highlighting
	 * @param Solarium_Query_Select $query
	 * @return AbstractSelect
	 */
	protected function registerHighlighting( Solarium_Query_Select $query ) {
		$highlighting = $query->getHighlighting();
		$highlighting->addField                     ( Utilities::field( 'html' ) )
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
				return new \Solarium_Result_Select_Empty();
			} else {
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
	 * Allows us to re-search for a collated spellcheck
	 * @param Solarium_Result_Select $result
	 * @return Ambigous <Solarium_Result_Select, \Solarium_Result_Select_Empty>
	 */
	protected function spellcheckResult( Solarium_Result_Select $result ) {
		// re-search for spellchecked phrase in the absence of results
		if ( $this->service->getGlobal( 'WikiaSearchSpellcheckActivated' ) 
				&& $result->getNumFound() == 0
				&& !$this->config->hasMatch() ) {
			if ( $collation = $result->getSpellcheck()->getCollation() ) {
				$this->config->setQuery( $collation->getQuery() );
				$result = $this->sendSearchRequestToClient();
			}
		}
		return $result;
	}
	
	/**
	 * This is a hook for child classes to optionally extend.
	 * It creates result sets based on the response from Solr, encapsulated in 
	 * an instance of Solarium_Result_Select.
	 * @param Solarium_Result_Select $result
	 */
	protected function prepareResponse( Solarium_Result_Select $result ) {
		$this->spellcheckResult( $result );
		$container = new ResultSet\DependencyContainer( array( 'result' => $result, 'config' => $this->config ) );
		$results = $this->resultSetFactory->get( $container );
		
		$this->config->setResults( $results );
		
		if( $this->config->getPage() == 1 ) {
			\Track::event(
					( $results->getResultsFound() > 0 ? 'search_start' : 'search_start_nomatch' ),
					array(
							'sterm'	=> $this->config->getQuery()->getSanitizedQuery(), 
							'stype'	=> $this->searchType 
							)
					);
		}
	}
	
	/**
	 * Returns the fields that should be queried
	 * @return string 
	 */
	abstract protected function getQueryFieldsString();
	
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
	 * Builds the string used with filter queries based on search config
	 * @return string
	 */
	protected function getFilterQueryString()
	{
		$namespaces = [];
		foreach ( $this->config->getNamespaces() as $ns ) {
			$namespaces[] = Utilities::valueForField( 'ns', $ns );
		}
		return [];//implode( ' AND ', [ sprintf( '(%s)', implode( ' OR ', $namespaces ) ), Utilities::valueForField( 'wid', $this->config->getCityId() ) ] );
	}
	
	/**
	 * @return Wikia\Search\Config
	 */
	protected function getConfig() {
		return $this->config;
	}
	
	/**
	 * @return Wikia\Search\MediaWikiService
	 */
	protected function getService() {
		return $this->service;
	}
	
	/**
	 * Reusable logic for storing matches on a wiki basis. Used in InterWiki and OnWiki Query Services.
	 * @return Wikia\Search\Match\Wiki|null
	 */
	protected function extractWikiMatch() {
		$config = $this->getConfig();
		$query = $config->getQuery()->getSanitizedQuery();
		$domain = preg_replace(
			'/[^a-zA-Z0-9]/',
			'',
			strtolower( $query ) 
		);
		$service = $this->getService();
		$wikiMatch = $service->getWikiMatchByHost( $domain );
		if (! empty( $wikiMatch ) && ( $wikiMatch->getId() !== $service->getWikiId() ) ) {
			$config->setWikiMatch( $wikiMatch );
		}
		return $config->getWikiMatch();
	}
}