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
	 * Maximum number of words to use when querying solr
	 * @var int
	 */
	const MAX_QUERY_WORDS = 10;
	
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
	 * This is the core path for articles as documents
	 * @var string
	 */
	const SOLR_CORE_MAIN = 'main';
	
	/**
	 * This is the core path for cross-wiki, or wikis as documents
	 * @var string
	 */
	const SOLR_CORE_CROSSWIKI = 'xwiki';
	
	/**
	 * Used for tracking
	 * @var string
	 */
	protected $searchType;
	
	/**
	 * Which "core" we're using in Solr -- xwiki or main
	 * @var string
	 */
	protected $core = 'main';
	
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
	 * The field used for highlighting
	 * @var unknown_type
	 */
	protected $highlightingField = 'html';
	
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
	 * A little pre-processing since the client needs to know the core before it's properly configured.
	 * @var bool
	 */
	protected $coreSetInClient = false;
	
	/**
	 * Default requested fields for a main-core search service. 
	 * @var array
	 */
	protected $requestedFields = [
				'id',
				'pageid',
				'wikiarticles',
				'wikititle',
				'url',
				'wid',
				'canonical',
				'host',
				'ns',
				'indexed',
				'backlinks',
				'title',
				'score',
				'created',
				'views',
				'categories',
				'hub',
				'lang',
			];
	
	/**
	 * Handles dependency injection for all child classes.
	 * @param DependencyContainer $container
	 */
	public function __construct( DependencyContainer $container ) {
		$this->client = $container->getClient();
		// this initializes the core assigned to the queryservice by default
		$this->config = $container->getConfig();
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
		return $this->getConfig()->getResults();
	}
	
	/**
	 * Allows us to get an array from search results rather than search result objects.
	 * @param array $fields allows us to apply a mapping
	 * @return array
	 */
	public function searchAsApi( $fields = null, $metadata = false ) {
		$resultSet = $this->search();
		$config = $this->getConfig();
		if ( $metadata ) {
			$total = $config->getResultsFound();
			$numPages = $config->getNumPages();
			$limit = $config->getLimit();
			$response = [
					'total' => $total,
					'batches' => $total > 0 ? $numPages : 0,
					'currentBatch' => $total > 0 ? $config->getPage() : 0,
					'next' => $total > 0 ? min( [ $numPages * $limit, $config->getStart() + $limit ] ) : 0,
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
		$config = $this->getConfig();
		if ( $config->hasMatch() ) {
			return $config->getMatch();
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
		$query = $this->getClient()->createSelect();
		$query->setDocumentClass( '\Wikia\Search\Result' );
		$this->registerQueryParams( $query )
		     ->registerComponents( $query );
		return $query->setQuery( $this->getQuery() );
	}
	
	/**
	 * This is abstract because the dismax and lucene query services behave differently here.
	 * @return string
	 */
	abstract protected function getQuery();
	
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
		$config = $this->getConfig();
		$sort = $config->getSort();
		$query->addFields      ( $this->getRequestedFields() )
		      ->removeField    ('*')
		      ->setStart       ( $config->getStart() )
		      ->setRows        ( $config->getLength() )
		      ->addSort        ( $sort[0], $sort[1] )
		      ->addParam       ( 'timeAllowed', $this->timeAllowed )
		;
		return $this;
	}
	
	/**
	 * For now, this is the union of the default requested fields (usually required for minimum functionality),
	 * and any fields specifically added by the client code.
	 * @todo Add support for _removing_ requested fields?
	 * @return array
	 */
	protected function getRequestedFields() {
		$fields = [];
		foreach ( array_merge( $this->requestedFields, $this->getConfig()->getRequestedFields() ) as $field ) {
			$fields[] = Utilities::field( $field );
		}
		return $fields;
	}
	
	/**
	 * Configures filter queries to, for instance, prevent duplicate results from PTT, or enable better caching.
	 * @param Solarium_Query_Select $query
	 * @return Wikia\Search\QueryService\Select\AbstractSelect
	 */
	protected function registerFilterQueries( Solarium_Query_Select $query ) {
		$config = $this->getConfig();
		$config->setFilterQuery( $this->getFilterQueryString() );
		$this->registerFilterQueryForMatch();
		$query->addFilterQueries( $config->getFilterQueries() );
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
		$highlighting->addField                     ( Utilities::field( $this->highlightingField ) )
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
			return $this->getClient()->select( $this->getSelectQuery() );
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
		$config = $this->getConfig();
		if ( $config->getPage() > 1 ) {
			$config->setStart( ( $config->getPage() - 1 ) * $config->getLength() );
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
		$service = $this->getService();
		$config = $this->getConfig();
		if ( $service->getGlobal( 'WikiaSearchSpellcheckActivated' ) 
				&& $result->getNumFound() == 0
				&& !$config->hasMatch() ) {
			if ( $collation = $result->getSpellcheck()->getCollation() ) {
				$config->setQuery( $collation->getQuery() );
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
		$config = $this->getConfig();
		$container = new ResultSet\DependencyContainer( array( 'result' => $result, 'config' => $config ) );
		$results = (new ResultSet\Factory)->get( $container );
		$config->setResults( $results );
	}
	
	/**
	 * Builds the string used with filter queries based on search config
	 * @return string
	 */
	protected function getFilterQueryString()
	{
		return '';
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
			$result = $wikiMatch->getResult();
			if ( $result['articles_i'] >= 50 ) {
				$config->setWikiMatch( $wikiMatch );
			}
		}
		return $config->getWikiMatch();
	}
	
	/**
	 * This allows internal manipulation of the specific core being queried by this service.
	 * There is probably a better way to do this, but this is the least disruptive way to handle this somewhat circular dependency.
	 * @return \Wikia\Search\QueryService\Select\AbstractSelect
	 */
	protected function setCoreInClient() {
		$options = $this->client->getOptions();
		$options['adapteroptions']['path'] = '/solr/'.$this->core;
		$this->client->setOptions( $options, true );
		$this->coreSetInClient = true;
		return $this;
	}
	
	/**
	 * Allows lazy loading of internal configuration through accessor method
	 * @return Solarium_Client
	 */
	protected function getClient() {
		if (! $this->coreSetInClient ) {
			$this->setCoreInClient();
		}
		return $this->client;
	}
}