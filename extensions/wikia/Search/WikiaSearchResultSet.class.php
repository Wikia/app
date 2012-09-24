<?php

class WikiaSearchResultSet implements Iterator,ArrayAccess {
	private $position = 0;

	protected $resultsFound = 0;
	protected $resultsStart = 0;
	protected $header = null;
	protected $results = array();
	protected $query;
	protected $queryTime = 0;
	protected $host;
	
	/**
	 * @var Solarium_Result_Select
	 */
	protected $searchResultObject;
	
	/**
	 * @var Solarium_Result_Select_Highlighting
	 */
	protected $highlightingObject;
	
	/**
	 * @var WikiaSearchConfig
	 */
	protected $searchConfig;
	
	/**
	 * @var WikiaSearchResultSet
	 */
	protected $parent;

	public $totalScore;

	public function __construct( Solarium_Result_Select $result, WikiaSearchConfig $searchConfig, $parent = null, $metaposition = null) {
		$this->searchResultObject = $result;
		$this->searchConfig = $searchConfig;
		
		if ( $parent === null && $this->searchConfig->getGroupResults() ) {
			
			$this->setResultGroupings( $result, $searchConfig );
			$this->setResultsFound( $result->getGrouping()->getGroup('host')->getMatches() );
			
		} else {
			$this->parent = $parent;
			$this->metaposition = $metaposition;
			
			$this->highlightingObject = $result->getHighlighting();
			
			if ($this->parent !== null && $this->metaposition !==  null) {
				// this is a child grouping
				$valueGroups = $this->searchResultObject->getGrouping()->getGroup('host')->getValueGroups();
				$valueGroup = $valueGroups[$this->metaposition];
				$documents = $valueGroup->getDocuments();
				$this->setResults($documents);
				
				$exampleDoc = $documents[0];
				$cityId = $exampleDoc->getCityId();
				$this->setHeader( 'cityId', $cityId );
				$this->setHeader( 'cityTitle',  WikiFactory::getVarValueByName( 'wgSitename', $cityId ) );
				$this->setHeader( 'cityUrl', WikiFactory::getVarValueByName( 'wgServer', $cityId ) );
				$this->setHeader( 'cityArticlesNum', $exampleDoc['wikiarticles'] );
				$this->setResultsFound($valueGroup->getNumFound());
				
			} else {
				// default behavior
				if ( $this->searchConfig->hasArticleMatch() ) {
					$am = $this->searchConfig->getArticleMatch();
					$article = $am['article'];
					$redirect = $am['redirect'] ?: null;
					$this->prependArticleMatch( $article, $redirect );
				}
				$this->setResults( $result->getDocuments() );
				$this->setResultsFound( $result->getNumFound() );
			}
			
			
			$this->setResultsStart( $result->getStart() );
			$this->setQueryTime( $result->getQueryTime() );
			
		}
	}

	public function setResultGroupings( Solarium_Result_Select $result, WikiaSearchConfig $searchConfig ) {
		$fieldGroup = $result->getGrouping()->getGroup('host');
		$metaposition = 0;
		foreach ($fieldGroup->getValueGroups() as $valueGroup) {
			$resultSet = F::build('WikiaSearchResultSet', array($result, $searchConfig, $this, $metaposition++));
			$this->results[$resultSet->getHeader('cityUrl')] = $resultSet;
		}
	}
	
	/**
	 * set result documents
	 * @param array $results list of WikiaResult or WikiaResultSet (for result grouping) objects
	 */
	public function setResults(Array $results) {
		wfProfileIn(__METHOD__);

		foreach($results as $result) {
			$this->addResult($result);
		}
		wfProfileOut(__METHOD__);
	}

	public function setResultsFound($value) {
		$this->resultsFound = $value;
	}

	public function prependArticleMatch( Article $article, $redirect = null )
	{
		global $wgCityId;
		$title = $article->getTitle();
		$articleId = $article->getID();
		if ( in_array($title->getNamespace(), $this->searchConfig->getNamespaces()) ) {
			$articleMatchId = sprintf('%s_%s', $wgCityId, $articleId);
			$articleService = F::build('ArticleService', array($articleId));
			$firstRev = $title->getFirstRevision();
			$created = wfTimestamp(TS_ISO_8601, $firstRev->getTimestamp());
			$lastRev = Revision::newFromId($title->getLatestRevID());
			$touched = wfTimeStamp(TS_ISO_8601, $lastRev->getTimestamp());

			$fieldsArray = array(
					'wid'			=>	$wgCityId,
					'title'			=>	$article->mTitle,
					'url'			=>	urldecode($title->getFullUrl()),
					'score'			=>	'PTT',
					'isArticleMatch'=>	true,
					'ns'			=>	$title->getNamespace(),
					'pageId'		=>	$article->getID(),
					'created'		=>	$created,
					'touched'		=>	$touched,
					);
			//@TODO: we could put categories ^^ here but we aren't really using them yet
			
			
			$result = F::build( 'WikiaSearchResult', array($fieldsArray) );
			$snippet = $articleService->getTextSnippet(250);
			$result->setText($snippet);
			if ( $redirect !== null ) {
				$result->setVar('redirectTitle', $redirect->getTitle());
			}
			
			$result->setVar('id', $articleMatchId);
			$this->addResult($result);
		}
	}
	
	public function addResult( WikiaSearchResult $result) {
		if($this->isValidResult($result)) {
			$id = $result['id'];
			if ( 		( $this->highlightingObject !== null ) 
					&&  ( $hlResult = $this->highlightingObject->getResult($id) )
					&&  ( $field = $hlResult->getField( WikiaSearch::field('html') ) ) ) {
				$result->setText( $field[0] );
			}
			global $wgLang;
			if ($result['created'] !== null && $wgLang) {
				$result->setVar('created', $result['created']);
				$result->setVar('fmt_timestamp', $wgLang->date(wfTimestamp(TS_MW, $result['created'])));
				if ($result->getVar('fmt_timestamp')) {
				    $result->setVar('created_30daysago', time() - strtotime($result['created']) > 2592000 );
				}
			}

			$result->setVar('categories', $result[WikiaSearch::field('categories')] ?: 'NONE');
			$result->setVar('cityArticlesNum', $result['wikiarticles']);
			$result->setVar('wikititle', $result[WikiaSearch::field('wikititle')]);
			
			$this->results[$id] = $result;
		}
		else {
			throw new WikiaException( 'Invalid result in set' );
		}
	}

	public function getResultsFound() {
		return $this->resultsFound;
	}


	public function incrResultsFound($value = 1) {
		$this->resultsFound += $value;
	}

	public function getResultsStart() {
		return $this->resultsStart;
	}

	public function setResultsStart($value) {
		$this->resultsStart = $value;
	}

	public function getResultsNum() {
		return count($this->results);
	}

	public function hasResults() {
		return (bool) $this->getResultsNum();
	}

	public function next() {
		$result = $this->current();
		$this->position++;
		return $result;
	}

	public function rewind() {
		$this->resetPosition();
	}

	public function current() {
		if($this->valid()) {
			$keys = array_keys($this->results);
			return $this->results[$keys[$this->position]];
		}
		else {
			return false;
		}
	}

	public function key() {
		return $this->position;
	}

	public function valid() {
		$keys = array_keys($this->results);
		return isset($keys[$this->position]);
	}

	public function setHeader($key, $value) {
		if($this->header === null) {
			$this->header = array();
		}
		$this->header[$key] = $value;
	}

	public function getHeader($key = null) {
		return ( empty($key) ? $this->header : ( isset($this->header[$key]) ? $this->header[$key] : null ) );
	}

	private function isValidResult($result) {
		return (($result instanceof WikiaSearchResult) || ($result instanceof WikiaSearchResultSet)) ? true : false;
	}

	private function resetPosition() {
		$this->position = 0;
	}

	public function getQuery() {
		return $this->query;
	}

	public function setQuery($query) {
		$this->query = $query;
	}
	
	public function getQueryTime() {
		return $this->queryTime;
	}
	
	public function setQueryTime($val) {
		$this->queryTime = $val;
	}

	/**
	 * merge with another result set
	 * @param WikiaSearchResultSet $resultSet
	 */
	public function merge(WikiaSearchResultSet $resultSet) {
		wfProfileIn(__METHOD__);

		foreach($resultSet as $result) {
			$this->addResult($result);
		}
		$this->setResultsFound($resultSet->getResultsFound());
		$this->setResultsStart($resultSet->getResultsStart());

		wfProfileOut(__METHOD__);
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

		return $this->getResultsNum() == 1 && $this->getResultsFound() == 0 && $this->results[0]->getVar('isArticleMatch') == true;

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
	
	public function getParent() {
		return $this->parent;
	}
	
	public function getId() {
		return $this->host;
	}
}
