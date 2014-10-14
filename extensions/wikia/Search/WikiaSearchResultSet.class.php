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
	protected $position = 0;

	/**
	 * Used to to access the documents for a given search result grouping
	 * @var int
	 */
	protected $metaposition = 0;

	/**
	 * Number of results found by the search; NOT the number of results in the set
	 * @var int
	 */
	protected $resultsFound = 0;

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
		$this->searchResultObject	= $result;
		$this->searchConfig			= $searchConfig;
		$this->parent				= $parent;
		$this->metaposition			= $metaposition;
		$this->configure( $parent, $metaposition );
		wfProfileOut(__METHOD__);
	}
	
	/**
	 * Called by the constructor to handle constructing nested and non-nested result sets and pass values
	 * from search result object to result set. Sort of a take on the strategy pattern. 
	 * @return bool
	 */
	protected function configure() {
		return ( $this->searchResultObject instanceof Solarium_Result_Select_Empty )
			|| $this->configureGroupedSetAsRootNode() 
			|| $this->configureGroupedSetAsLeafNode() 
			|| $this->configureUngroupedSet()
		;  
	}
	
	/**
	 * Performs configuration actions required just for grouped results
	 * @return boolean
	 */
	protected function configureGroupedSetAsRootNode() {
		wfProfileIn(__METHOD__);
		$satisfies = ( $this->parent === null ) && $this->searchConfig->getGroupResults();
		if ( $satisfies ) {
			$this->prependWikiMatchIfExists();
			$this->setResultGroupings();
			$countMatch = ( $this->searchConfig->hasWikiMatch() ? 1 : 0 );
			$this->setResultsFound( $this->getHostGrouping()->getMatches() + $countMatch );
		}
		wfProfileOut(__METHOD__);
		return $satisfies;
	}

	/**
	 * This is the subroutine used to prepare a search result set instance with a parent.
	 * @return WikiaSearchResultSet provides for fluent interface
	 */
	protected function configureGroupedSetAsLeafNode() {
		wfProfileIn(__METHOD__);
		$satisfies = ( $this->parent !== null ) && ( $this->metaposition !==  null );
		if ( $satisfies ) {
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
		}

		wfProfileOut(__METHOD__);
		return $satisfies;
	}
	
	/**
	 * This is the default behavior of a search result set
	 * @return bool
	 */
	protected function configureUngroupedSet() {
		wfProfileIn(__METHOD__);
		$this
			->prependArticleMatchIfExists	()
			->setResults					( $this->searchResultObject->getDocuments() )
			->setResultsFound				( $this->resultsFound + $this->searchResultObject->getNumFound() )
		;
		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Reusable method for grabbing the resultset grouped by host.
	 * @throws Exception
	 * @return Solarium_Result_Select_Grouping_FieldGroup
	 */
	protected function getHostGrouping() {
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
	 * @return WikiaSearchResultSet provides fluent interface
	 */
	protected function setResultGroupings() {
		wfProfileIn(__METHOD__);
		$fieldGroup = $this->getHostGrouping();
		$metaposition = 0;
		foreach ($fieldGroup->getValueGroups() as $valueGroup) {
			$resultSet = F::build('WikiaSearchResultSet', array($this->searchResultObject, $this->searchConfig, $this, $metaposition++));
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
	protected function prependArticleMatchIfExists() {
		wfProfileIn(__METHOD__);

		if (! ( $this->searchConfig->hasArticleMatch() && $this->getResultsStart() == 0 ) ) {
			wfProfileOut(__METHOD__);
			return $this;
		}

		$articleMatch	= $this->searchConfig->getArticleMatch();
		$article		= $articleMatch->getCanonicalArticle();
		$title			= $article->getTitle();
		$articleId		= $article->getID();
		$titleNs		= $title->getNamespace();

		if (! in_array( $titleNs, $this->searchConfig->getNamespaces() ) ) {
			// we had an article match by name, but not in our desired namespaces
			wfProfileOut(__METHOD__);
			return $this;
		}

		$articleMatchId	= sprintf( '%s_%s', $this->wg->CityId, $articleId );
		$articleService	= F::build('ArticleService', array( $articleId ) );
		$firstRev		= $title->getFirstRevision();
		$created		= $firstRev ? $this->wf->Timestamp(TS_ISO_8601, $firstRev->getTimestamp()) : '';
		$lastRev		= Revision::newFromId($title->getLatestRevID());
		$touched		= $lastRev ? $this->wf->Timestamp(TS_ISO_8601, $lastRev->getTimestamp()) : '';
		
		$fieldsArray = array(
				'wid'			=>	$this->wg->CityId,
				'title'			=>	(string) $title,
				'url'			=>	urldecode( $title->getFullUrl() ),
				'score'			=>	'PTT',
				'isArticleMatch'=>	true,
				'ns'			=>	$titleNs,
				'pageId'		=>	$articleId,
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
	 * Prepends a wiki match if one is stored in the config.
	 * @return WikiaSearchResultSet
	 */
	protected function prependWikiMatchIfExists() {
		if ( $this->searchConfig->hasWikiMatch() ) {
    		$this->resultsFound++;
    		return $this->addResult( $this->searchConfig->getWikiMatch()->getResult() );
		}
		return $this;
	}

	/**
	 * Does a little prep on a result oject, applies highlighting if exists, and adds to result array.
	 * @param  WikiaSearchResult $result
	 * @throws WikiaException
	 * @return WikiaSearchResultSet provides fluent interface
	 */
	protected function addResult( WikiaSearchResult $result ) {
		if( $this->isValidResult( $result ) ) {
			$id = $result['id'];
			$highlighting = $this->searchResultObject->getHighlighting();
			if ( 		( $highlighting				!==	null )
					&&  ( $hlResult 				=	$highlighting->getResult( $id ) )
					&&  ( $field					=	$hlResult->getField( WikiaSearch::field( 'html' ) ) ) ) {
				$result->setText( $field[0] );
			}

			$created = $result['created'];
			if ( ( $created !== null ) && $this->wg->Lang ) {
				$result	->setVar( 'created',		$created )
						->setVar( 'fmt_timestamp',	$this->wg->Lang->date( $this->wf->Timestamp( TS_MW, $created ) ) );

				if ( $result->getVar( 'fmt_timestamp' ) ) {
				    $result->setVar( 'created_30daysago', time() - strtotime( $created ) > 2592000 );
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
		return $this->searchResultObject->getStart();
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
		return !empty( $this->results );
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
	protected function isValidResult( $result ) {
		return ( ( $result instanceof WikiaSearchResult ) || ( $result instanceof WikiaSearchResultSet ) );
	}

	/**
	 * Returns the query used to get these results
	 * @return string
	 */
	public function getQuery() {
		return $this->searchConfig->getQuery( WikiaSearchConfig::QUERY_ENCODED );
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

	/**
	 * Returns the array of results
	 * @return array
	 */
	public function getResults() {
		return $this->results;
	}
	
	/**
	 * Allows us to serialize some core values from an expected wiki for json requests
	 * @param array $expectedFields
	 * @return array
	 */
	public function toArray( $expectedFields = array( 'title', 'url' ) ) {
		$result = array();
		foreach ( $expectedFields as $field ) {
			switch ( $field ) {
				case 'title':
					$result['title'] = $this->getHeader( 'cityTitle' );
					break;
				case 'url':
					$result['url'] = $this->getHeader( 'cityUrl' );
					break;
			}
		}
		return $result;
	}

	/*
	 * Done to return results in json format
	 * Can be removed after upgrade to 5.4 and specify serialized Json data on WikiaSearchResult
	 * http://php.net/manual/en/jsonserializable.jsonserialize.php
	 * @todo if we break the different kind of result sets out into different classes, we should make this just be the "toarray" for root node 
	 * @return array
	 */
	public function toNestedArray( array $expectedFields = array( 'title', 'url' ) ) {
		$tempResults = array();
		foreach( $this->results as $result ){
	        $tempResults[] = $result->toArray( $expectedFields );
		}
		return $tempResults;
	}
}
