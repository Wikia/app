<?php

/**
 * This class is intended to provide additional functionality over a simple array
 * for an aggregation of WikiaSearchResult classes. They also accommodate same-class
 * nesting so that we can reuse this class for grouped interwiki search. 
 *  
 * @author Robert Elwell
 *
 */

class WikiaSearchResultSet extends WikiaObject implements Iterator,ArrayAccess {
	/**
	 * Used to keep track of index in array access
	 * @var int
	 */
	private $position = 0;
	
	/**
	 * Used to to access the documents for a given search result grouping
	 * @var int
	 */
	private $metaposition = 0;

	/**
	 * Number of results found by the search; NOT the number of results in the set
	 * @var int
	 */
	protected $resultsFound = 0;
	
	/**
	 * Offset of entire search result set we are starting from
	 * @var int
	 */
	protected $resultsStart = 0;
	
	/**
	 * Header values are used for search result grouping metadata
	 * @var array
	 */
	protected $header = array();
	
	/**
	 * This is the associative array handling results. 
	 * Keys are IDs, values are WikiaSearchResult instances.
	 * @var array
	 */
	protected $results = array();
	
	/**
	 * The query string provided by the user for the search 
	 * (not the complex query we create from it)
	 * @var string
	 */
	protected $query;
	
	/**
	 * Time it took for the query to complete on the Solr side.
	 * Mostly used for debugging.
	 * @var int
	 */
	protected $queryTime = 0;
	
	/**
	 * Used primarily for search groupings.
	 * This is the hostname of the wiki all the results belong to. 
	 * @var string
	 */
	protected $host;
	
	/**
	 * The object that Solarium builds after getting a Solr response
	 * @var Solarium_Result_Select
	 */
	protected $searchResultObject;
	
	/**
	 * The subcomponent handling snippeting
	 * @var Solarium_Result_Select_Highlighting
	 */
	protected $highlightingObject;
	
	/**
	 * The configuration used in handling searhes
	 * @var WikiaSearchConfig
	 */
	protected $searchConfig;
	
	/**
	 * Used in grouped search.
	 * @var WikiaSearchResultSet
	 */
	protected $parent;

	/**
	 * Accepts a Solarium select result and a search config.
	 * If not the root search result set, you should provide the parent and metaposition.
	 * @param Solarium_Result_Select $result
	 * @param WikiaSearchConfig $searchConfig
	 * @param WikiaSearchResultSet $parent
	 * @param int $metaposition
	 */
	public function __construct( Solarium_Result_Select $result, WikiaSearchConfig $searchConfig, $parent = null, $metaposition = null) {
		wfProfileIn(__METHOD__);
		parent::__construct();
		$this->searchResultObject = $result;
		$this->searchConfig = $searchConfig;
		$this->setQuery( $searchConfig->getQuery( WikiaSearchConfig::QUERY_ENCODED ) );
		
		if ( $result instanceof Solarium_Result_Select_Empty ) {
			return;
		}
		
		if ( ( $parent === null ) && $this->searchConfig->getGroupResults() ) {
			
			$this->setResultGroupings( $result, $searchConfig );
			$this->setResultsFound( $this->getHostGrouping()->getMatches() );
			
		} else {
			$this->parent				= $parent;
			$this->metaposition			= $metaposition;
			$this->highlightingObject	= $result->getHighlighting();
			
			$this	->setResultsStart	( $result->getStart() )
					->setQueryTime		( $result->getQueryTime() );
			
			if ( ( $this->parent !== null ) && ( $this->metaposition !==  null ) ) {
				$this->prepareChildResultSet();
			} else {
				// default behavior for an ungrouped search result set
				$this
					->prependArticleMatchIfExists	()
					->setResults					( $this->searchResultObject->getDocuments() )
					->setResultsFound				( $this->resultsFound + $this->searchResultObject->getNumFound() )
				;
			}
		}
		wfProfileOut(__METHOD__);
	}
	
	/**
	 * This is the subroutine used to prepare a search result set instance with a parent.
	 * @return WikiaSearchResultSet provides for fluent interface
	 */
	private function prepareChildResultSet() {
		wfProfileIn(__METHOD__);
		$valueGroups	= $this->getHostGrouping()->getValueGroups();
		$valueGroup		= $valueGroups[$this->metaposition];
		$this->host		= $valueGroup->getValue();
		$documents		= $valueGroup->getDocuments();
		
		$this	->setResults		( $documents )
				->setResultsFound	( $valueGroup->getNumFound() );
		
		if ( count( $documents ) > 0 ) {
			$exampleDoc		= $documents[0];
			$cityId			= $exampleDoc->getCityId();
			
			$this->setHeader( 'cityId',				$cityId );
			$this->setHeader( 'cityTitle',			WikiFactory::getVarValueByName( 'wgSitename', $cityId ) );
			$this->setHeader( 'cityUrl',			WikiFactory::getVarValueByName( 'wgServer', $cityId ) );
			$this->setHeader( 'cityArticlesNum',	$exampleDoc['wikiarticles'] );
		}
		
		wfProfileOut(__METHOD__);
		return $this;
	}
	
	/**
	 * Reusable method for grabbing the resultset grouped by host.
	 * @throws Exception
	 * @return Solarium_Result_Select_Grouping_FieldGroup
	 */
	private function getHostGrouping() {
		wfProfileIn(__METHOD__);
		$grouping = $this->searchResultObject->getGrouping();
		if (! $grouping ) {
		    throw new Exception("Search config was grouped but result was not.");
		}
		$hostGrouping = $grouping->getGroup('host');
		if (! $hostGrouping ) {
		    throw new Exception("Search results were not grouped by host field.");
		}
		wfProfileOut(__METHOD__);
		return $hostGrouping;
	}

	/**
	 * We use this to iterate over groupings and created nested search result sets.
	 * @param  Solarium_Result_Select $result
	 * @param  WikiaSearchConfig $searchConfig
	 * @return WikiaSearchResultSet provides fluent interface
	 */
	private function setResultGroupings( Solarium_Result_Select $result, WikiaSearchConfig $searchConfig ) {
		wfProfileIn(__METHOD__);
		$fieldGroup = $result->getGrouping()->getGroup('host');
		$metaposition = 0;
		foreach ($fieldGroup->getValueGroups() as $valueGroup) {
			$resultSet = F::build('WikiaSearchResultSet', array($result, $searchConfig, $this, $metaposition++));
			$this->results[$resultSet->getHeader('cityUrl')] = $resultSet;
		}
		wfProfileOut(__METHOD__);
		return $this;
	}
	
	/**
	 * set result documents
	 * @param  array $results list of WikiaResult or WikiaResultSet (for result grouping) objects
	 * @return WikiaSearchResultSet provides fluent interface
	 */
	public function setResults(Array $results) {
		wfProfileIn(__METHOD__);

		foreach($results as $result) {
			$this->addResult($result);
		}
		
		wfProfileOut(__METHOD__);
		return $this;
	}

	/**
	 * Populates the resultsFound protected var
	 * @param int $value
	 * @return WikiaSearchResultSet provides fluent interface
	 */
	public function setResultsFound($value) {
		wfProfileIn(__METHOD__);
		$this->resultsFound = $value;
		wfProfileOut(__METHOD__);
		return $this;
	}

	/**
	 * Subroutine for optionally prepending article match to result array. 
	 * @return WikiaSearchResultSet provides fluent interface
	 */
	public function prependArticleMatchIfExists() {
		wfProfileIn(__METHOD__);
		
		if (! ( $this->searchConfig->hasArticleMatch() && $this->resultsStart == 0 ) ) {
			return $this;
		}

		$articleMatch	= $this->searchConfig->getArticleMatch();
		$article		= $articleMatch->getCanonicalArticle();
		$title			= $article->getTitle();
		$articleId		= $article->getID();
		
		if (! in_array( $title->getNamespace(), $this->searchConfig->getNamespaces() ) ) { 
			// we had an article match by name, but not in our desired namespaces
			return $this;
		}
		
		$articleMatchId	= sprintf( '%s_%s', $this->wg->CityId, $articleId );
		$articleService	= F::build('ArticleService', array( $articleId ) );
		$firstRev		= $title->getFirstRevision();
		$created		= $firstRev ? wfTimestamp(TS_ISO_8601, $firstRev->getTimestamp()) : '';
		$lastRev		= Revision::newFromId($title->getLatestRevID());
		$touched		= $lastRev ? wfTimeStamp(TS_ISO_8601, $lastRev->getTimestamp()) : '';

		$fieldsArray = array(
				'wid'			=>	$this->wg->CityId,
				'title'			=>	$article->mTitle,
				'url'			=>	urldecode( $title->getFullUrl() ),
				'score'			=>	'PTT',
				'isArticleMatch'=>	true,
				'ns'			=>	$title->getNamespace(),
				'pageId'		=>	$article->getID(),
				'created'		=>	$created,
				'touched'		=>	$touched,
				);
		//@TODO: we could put categories ^^ here but we aren't really using them yet
		
		$result		= F::build( 'WikiaSearchResult', array($fieldsArray) );
		$snippet	= $articleService->getTextSnippet(250);
		
		$result->setText( $snippet );
		if ( $articleMatch->hasRedirect() ) {
			$result->setVar( 'redirectTitle', $articleMatch->getArticle()->getTitle() );
		}
		
		$result->setVar( 'id', $articleMatchId );
		
		$this->addResult( $result );
		
		$this->resultsFound++;
		
		wfProfileOut(__METHOD__);
		return $this;
	}
	
	/**
	 * Does a little prep on a result oject, applies highlighting if exists, and adds to result array.
	 * @param  WikiaSearchResult $result
	 * @throws WikiaException
	 * @return WikiaSearchResultSet provides fluent interface
	 */
	private function addResult( WikiaSearchResult $result ) {
		if( $this->isValidResult( $result ) ) {
			$id = $result['id'];
			if ( 		( $this->highlightingObject !==	null ) 
					&&  ( $hlResult 				=	$this->highlightingObject->getResult( $id ) )
					&&  ( $field					=	$hlResult->getField( WikiaSearch::field( 'html' ) ) ) ) {
				$result->setText( $field[0] );
			}
			
			if ( ( $result['created'] !== null ) && $this->wg->Lang ) {
				$result	->setVar( 'created',		$result['created'] )
						->setVar( 'fmt_timestamp',	$this->wg->Lang->date( wfTimestamp( TS_MW, $result['created'] ) ) );
				
				if ( $result->getVar( 'fmt_timestamp' ) ) {
				    $result->setVar( 'created_30daysago', time() - strtotime( $result['created'] ) > 2592000 );
				}
			}

			$result	->setVar('categories',		$result[WikiaSearch::field( 'categories' )] ?: 'NONE' )
					->setVar('cityArticlesNum',	$result['wikiarticles'] )
					->setVar('wikititle',		$result[WikiaSearch::field( 'wikititle' )] );
			
			$this->results[$id] = $result;
		}
		else {
			throw new WikiaException( 'Invalid result in set' );
		}
		return $this;
	}

	/**
	 * Returns the number of results found in the search
	 * @return int
	 */
	public function getResultsFound() {
		return $this->resultsFound;
	}

	/**
	 * Returns originating offset of the search results
	 * @return int
	 */
	public function getResultsStart() {
		return $this->resultsStart;
	}

	/**
	 * Sets the protected $resultsStart value
	 * @param int $value
	 * @return WikiaSearchResultSet provides fluent interface
	 */
	public function setResultsStart( $value ) {
		$this->resultsStart = $value;
		return $this;
	}

	/**
	 * Returns the actual number of result instances this class wraps
	 * @return int
	 */
	public function getResultsNum() {
		return count( $this->results );
	}

	/**
	 * Used to determine if we are currently wrapping any results
	 * @return boolean
	 */
	public function hasResults() {
		return empty( $this->results );
	}

	/**
	 * (non-PHPdoc)
	 * @see Iterator::next()
	 */
	public function next() {
		$result = $this->current();
		$this->position++;
		return $result;
	}

	/**
	 * (non-PHPdoc)
	 * @see Iterator::rewind()
	 */
	public function rewind() {
		$this->position = 0;
	}

	/**
	 * (non-PHPdoc)
	 * @see Iterator::current()
	 */
	public function current() {
		if($this->valid()) {
			$keys = array_keys( $this->results );
			return $this->results[ $keys[$this->position] ];
		}
		else {
			return false;
		}
	}

	/**
	 * (non-PHPdoc)
	 * @see Iterator::key()
	 */
	public function key() {
		return $this->position;
	}

	/**
	 * (non-PHPdoc)
	 * @see Iterator::valid()
	 */
	public function valid() {
		$keys = array_keys( $this->results );
		return isset( $keys[$this->position] );
	}

	/**
	 * Used for setting metadata over the result set, rather than a single result.
	 * Used particularly for grouped results.
	 * @param  string $key
	 * @param  mixed  $value
	 * @return WikiaSearchResultSet provides fluent interface
	 */
	public function setHeader( $key, $value ) {
		$this->header[$key] = $value;
		return $this;
	}

	/**
	 * If you don't provide a key, this returns the entire header array.
	 * If you do provide a key, it provides the value for the header array key.
	 * @param  string $key
	 * @return array|mixed
	 */
	public function getHeader($key = null) {
		return ( empty( $key ) ? $this->header : ( isset( $this->header[$key] ) ? $this->header[$key] : null ) );
	}

	/**
	 * Determines if a result is valid to be added to the $results array.
	 * @param  mixed $result
	 * @return boolean
	 */
	private function isValidResult( $result ) {
		return ( ( $result instanceof WikiaSearchResult ) || ( $result instanceof WikiaSearchResultSet ) );
	}

	public function getQuery() {
		return $this->query;
	}

	public function setQuery($query) {
		$this->query = $query;
		return $this;
	}
	
	public function getQueryTime() {
		return $this->queryTime;
	}
	
	public function setQueryTime($val) {
		$this->queryTime = $val;
		return $this;
	}

	public function __sleep() {
		return array( 'header', 'results', 'resultsFound', 'resultsStart');
	}

	public function __wakeup() {
		$this->position = 0;
		$this->resultsPerPage = 25;
		$this->currentPage = false;
	}

	public function isOnlyArticleMatchFound() {
		return $this->getResultsNum() == 1 && $this->results[0]->getVar( 'isArticleMatch' ) == true;
	}
	
	/* (non-PHPdoc)
	 * @see ArrayAccess::offsetExists()
	 */
	public function offsetExists ($offset) {
		return isset($this->results[$offset]);
	}

	/* (non-PHPdoc)
	 * @see ArrayAccess::offsetGet()
	 */
	public function offsetGet ($offset)	{
		return (isset($this->results[$offset])) ? $this->results[$offset] : false;
	}

	/* (non-PHPdoc)
	 * @see ArrayAccess::offsetSet()
	 */
	public function offsetSet ($offset, $value)	{
		$this->results[$offset] = $value;
	}

	/* (non-PHPdoc)
	 * @see ArrayAccess::offsetUnset()
	 */
	public function offsetUnset ($offset) {
		unset($this->results[$offset]);
	}
	
	/**
	 * Returns the parent value set during instantiation
	 * @return WikiaSearchResultSet|null
	 */
	public function getParent() {
		return $this->parent;
	}
	
	/**
	 * For a search result set with a parent, returns the host value of the grouping.
	 * @return string|null
	 */
	public function getId() {
		return $this->host;
	}
	
	/*
	 * Done to return results in json format
	 * Can be removed after upgrade to 5.4 and specify serialized Json data on WikiaSearchResult
	 * http://php.net/manual/en/jsonserializable.jsonserialize.php
	 * 
	 * @return array
	 */
	public function toNestedArray() {
		$tempResults = array();
		foreach( $this as $result ){
		    if($result instanceof WikiaSearchResult){
		        $tempResults[] = $result->toArray(array('title', 'url'));
		    }
		}
		return $tempResults;
	}
}
