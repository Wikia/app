<?php
interface SearchErrorReporting {
	public function getError();
	public function getErrorTracker();
}

class SolrSearch extends SearchEngine implements SearchErrorReporting {

	private $errorCode = null;
	private $crossWikiSearch = false;

	public function __construct() {
		global $wgRequest, $wgEnableCrossWikiaSearch;

		$thisWikiOnly = $wgRequest->getVal('thisWikiOnly');
		$this->crossWikiSearch = empty($thisWikiOnly) ? $wgEnableCrossWikiaSearch : false;

		// allow cross-wikia search on selected wikis (eg. community) (BugId: #9412)
		$this->crossWikiSearch = $wgRequest->getCheck( 'crossWikiaSearch' ) ? true : $this->crossWikiSearch;

		wfLoadExtensionMessages( 'WikiaSearch' );
	}

	public function getError() {
		if($this->errorCode != null) {
			// don't bother with error codes, just display standard error message for now
			return wfMsg( 'wikiasearch-system-error-msg' );
		}
	}

	public function getErrorTracker()
	{
		$code = '<script type="text/javascript">
					WET.byStr("search/searchResults/error");
				</script> ';
		return $code;
	}

	/**
	 * Perform a full text search query and return a result set.
	 *
	 * @param string $term - Raw search term
	 * @return SolrSearchSet
	 * @access public
	 */
	public function searchText( $term ) {
		global $wgRequest;

		if(empty($term)) {
			return null;
		}

		$titlesOnly = $this->crossWikiSearch ? false : $wgRequest->getCheck('titlesOnly');

		if(!$titlesOnly) {
			if($this->crossWikiSearch) {
				$queryFields = 'title^5 host^2 html';
			}
			else {
				$queryFields = 'title^5 html';
			}

			$searchSet = SolrSearchSet::newFromQuery( $term, $queryFields, $this->namespaces, $this->limit, $this->offset, $this->crossWikiSearch );
			if($searchSet instanceof SolrSearchSet) {
				return $searchSet;
			}
			else {
				$this->errorCode = $searchSet;
				return null;
			}
		}
		else {
			return null;
		}
	}

	public function searchTitle( $term ) {
		global $wgRequest;

		if(empty($term)) {
			return null;
		}

		$titlesOnly = $this->crossWikiSearch ? false : $wgRequest->getCheck('titlesOnly');

		if($titlesOnly) {
			$searchSet = SolrSearchSet::newFromQuery( $term, 'title', $this->namespaces, $this->limit, $this->offset, $this->crossWikiSearch );
			if($searchSet instanceof SolrSearchSet) {
				return $searchSet;
			}
			else {
				$this->errorCode = $searchSet;
				return null;
			}
		}
		else {
			return null;
		}
	}

	public static function addPagerParams( $ops ) {
		global $wgRequest;
		$titlesOnly = $wgRequest->getCheck('titlesOnly');
		if ($titlesOnly) {
			$ops['titlesOnly'] = 1;
		}
		return true;
	}

	public static function renderExtraRefinements( $refinements ) {
		global $wgRequest;
		$titles = Xml::check( 'titlesOnly', $wgRequest->getCheck('titlesOnly'), array( 'value' => '1', 'id' => 'titlesOnly' ) );
		$titlesLabel = Xml::label( wfMsg( 'wikiasearch-titles-only' ), 'titlesOnly' );
		$refinements = "<p>" . $titles . " " . $titlesLabel . "</p>\n";
		return true;
	}

	public static function onSpecialSearchShortDialog( $term, &$out ) {
		global $wgRequest, $wgEnableCrossWikiaSearchOption;

		if( !empty( $wgEnableCrossWikiaSearchOption ) ) {
			$out .= "<p>";
			$out .= Xml::check( 'crossWikiaSearch', $wgRequest->getCheck('crossWikiaSearch'), array( 'value' => '1', 'id' => 'crossWikiaSearch' ) );
			$out .= Xml::label( 'crossWikiaSearch',  wfMsg( 'wikiasearch-search-all-wikia' ) );
			$out .= "</p>";
		}

		return true;
	}

	public static function onSpecialSearchIsgomatch( $title, $term ) {
		Track::event( 'search_start_gomatch', array( 'sterm' => $term, 'rver' => 0 ) );
		return true;
	}

}

class SolrSearchSet extends SearchResultSet {

	private $mCanonicals = array();
	private $crossWikiaSearch = false;
	private $mOffset = 0;
	private $suggestions = null;
	private $mRelevancyFunctionId = 1;
	private $mArticleMatch = null;

	/**
	 * any query string transformation before sending to backend should be placed here
	 */
	private static function sanitizeQuery($query) {
		// non-indexed number-string phrases issue workaround (RT #24790)
		$query = preg_replace('/(\d+)([a-zA-Z]+)/i', '$1 $2', $query);

		// escape all lucene special characters: + - && || ! ( ) { } [ ] ^ " ~ * ? : \ (RT #25482)
		$query = Apache_Solr_Service::escape($query);

		return $query;
	}

	public static function getABTestMode( Array $modes, $percent = 10 ) {
		$diceRoll = mt_rand(1, 100);
		$abRange = count($modes) * $percent;

		if( $diceRoll > $abRange ) {
			return false;
		}
		else {
			return $modes[ ( $diceRoll % count($modes) ) ];
		}
	}

	public static function createArticleMatch( $term , $namespaces = array() ) {
		// Try to go to page as entered.
		$title = Title::newFromText( $term );
		# If the string cannot be used to create a title
		if( is_null( $title ) ) {
			return null;
		}

		$searchWithNamespace = $title->getNamespace() != 0 ? true : false;
		// If there's an exact or very near match, jump right there.
		$title = SearchEngine::getNearMatch( $term );
		if( !is_null( $title ) && 
		    ( $searchWithNamespace || $title->getNamespace() == NS_MAIN || $title->getNamespace() == NS_CATEGORY) &&
		    (empty($namespaces) || in_array($title->getNamespace(), $namespaces))) {
			$article = new Article( $title );
			if($article->isRedirect()) {
			  return array('article'=>new Article($article->getRedirectTarget()), 'redirect'=>$article);
			}
			else {
			        return array('article'=>$article);
			}
		}

		return null;
	}

	/**
	 * Contact the solr search server and return a wrapper
	 * object with the set of results. Results may be cached.
	 *
	 * @param string $query
	 * @param int $limit
	 * @param int $offset
	 * @return array
	 * @access public
	 */
	public static function newFromQuery( $query, $queryFields, $namespaces = array(), $limit = 20, $offset = 0, $crossWikiaSearch = false ) {
		global $wgSolrHost, $wgSolrPort, $wgCityId, $wgErrorLog, $wgSolrDebugWikiId, $wgWikiaSearchABTestModes, $wgWikiaSearchABTestEnabled;
		$fname = 'SolrSearchSet::newFromQuery';
		wfProfileIn( $fname );

		$solr = new Apache_Solr_Service($wgSolrHost, $wgSolrPort, '/solr');

		$sanitizedQuery = self::sanitizeQuery($query);

		$ABTestMode = false;
		$relevancyFunctionId = 5;
		$params = array(
			'fl' => '*,score', // fields we want to fetch back
			'qf' => $queryFields,
			'hl' => 'true',
			'hl.fl' => 'html,title', // highlight field
			'hl.snippets' => '2', // number of snippets per field
			'hl.fragsize' => '150', // snippet size in characters
			'hl.simple.pre' => '<span class="searchmatch">',
			'hl.simple.post' => '</span>',
			'f.html.hl.alternateField' => 'html',
			'f.html.hl.maxAlternateFieldLength' => 300,
			'indent' => 1,
			'timeAllowed' => 5000
		);

		$queryClauses = array();

		$onWikiId = (!empty($wgSolrDebugWikiId)) ? $wgSolrDebugWikiId : $wgCityId;

		if( $crossWikiaSearch ) {

			$widQuery = '';

			foreach (self::getCrossWikiaSearchExcludedWikis() as $wikiId)
			{
				if ($onWikiId == $wikiId) {
					continue;
				}

				$widQuery .= ( !empty($widQuery) ? ' AND ' : '' ) . '!wid:' . $wikiId;
			}

			$queryClauses[] = $widQuery;

			$queryClauses[] = "lang:en";

			$queryClauses[] = "iscontent:true";

		} else {

			if(count($namespaces)) {
				$nsQuery = '';
				foreach($namespaces as $namespace) {
					$nsQuery .= ( !empty($nsQuery) ? ' OR ' : '' ) . 'ns:' . $namespace;
				}

				$queryClauses[] = "({$nsQuery})";


			}

			array_unshift($queryClauses, "wid: {$onWikiId}");
		}

		$queryNoQuotes = self::sanitizeQuery(preg_replace("/['\"]/", '', $query));

		$boostQueries = array('html:\"'.$queryNoQuotes.'\"^5', 
				      'title:\"'.$queryNoQuotes.'\"^10');

		$boostFunctions = array();

		if ($crossWikiaSearch) {
		  // this is still pretty important!
		  $boostQueries[] = 'wikititle:\"'.$queryNoQuotes.'\"^15';		  

		  # we can do this because the host is a text field
		  $boostQueries[] = '-host:\"answers\"^10';

		  $boostFunctions[] = 'log(wikipages)^4';

		  $boostFunctions[] = 'log(activeusers)^4';

		  $boostFunctions[] = 'log(revcount)';

		  $boostFunctions[] = 'log(views)^8';

		  $boostFunctions[] = 'log(words)^0.5';

		}

		$dismaxParams = array('qf'	=>	"'html^0.8 title^5'",
			      	      'pf'	=>	"'html^0.8 title^5'",
				      'ps'	=>	'3',
				      'tie'	=>	'0.01',
				      'bq'	=>	"\'".implode(' ', $boostQueries)."\'",
				      'mm'      =>      '66%'
				     );

		if (!empty($boostFunctions)) {
		  $dismaxParams['bf'] = sprintf("'%s'", implode(' ', $boostFunctions));
		}

		array_walk($dismaxParams, function($val,$key) use (&$paramString) {$paramString .= "{$key}={$val} "; });

		$queryClauses[] = sprintf('_query_:"{!dismax %s}%s"', 
					  $paramString, 
					  $sanitizedQuery);

		$sanitizedQuery = implode(' AND ', $queryClauses);

		try {
			wfRunHooks( 'Search-beforeBackendCall', array( &$sanitizedQuery, &$offset, &$limit, &$params ) );
			$response = $solr->search($sanitizedQuery, $offset, $limit, $params);
		}
		catch (Exception $exception) {
			$wgErrorLogTmp = $wgErrorLog;
			$wgErrorLog = true;
			Wikia::log( __METHOD__, "ERROR", $exception->getMessage() . " PARAMS: ".$sanitizedQuery );
			$wgErrorLog = $wgErrorLogTmp;

			wfProfileOut( $fname );
			return 100;
		}

		$resultDocs = $response->response->docs;
		$resultSnippets = is_object($response->highlighting) ? get_object_vars($response->highlighting) : array();
		$resultSuggestions = is_object($response->spellcheck) ? $response->spellcheck->suggestions : null;
		$resultCount = count($resultDocs);
		$totalHits = $response->response->numFound;

		$articleMatch = null;
		if( !$crossWikiaSearch ) {
			// check if exact match is available (similar to MW "go-result" feature)
		        $articleMatch = self::createArticleMatch($query, $namespaces);
		}

		$resultSet = new SolrSearchSet( $query, $resultDocs, $resultSnippets, $resultSuggestions, $resultCount, $offset, $relevancyFunctionId, $totalHits, $crossWikiaSearch, $articleMatch);

		if( empty( $offset ) ) {
			Track::event( ( !empty( $resultCount ) ? 'search_start' : 'search_start_nomatch' ), array( 'sterm' => $query, 'rver' => $relevancyFunctionId, 'stype' => ( $crossWikiaSearch ? 'inter' : 'intra' ) ) );
		}

		wfProfileOut( $fname );
		return $resultSet;
	}

	public static function onSpecialSearchResults( $term, &$titleMatches, &$textMatches ) {
		global $wgOut, $wgUser, $wgCityId;

		$matches = is_object($textMatches) ? $textMatches : ( is_object($titleMatches) ? $titleMatches : null );
		if( ( $matches instanceof SolrSearchSet )  && $matches->hasArticleMatch() ) {
			$skin = $wgUser->getSkin();
			$articleMatch = $matches->getArticleMatch();
			extract($articleMatch);

			$title = $article->getTitle();
			$link = $skin->linkKnown( $title, null,
				array(
					'class' => 'mw-search-result-title',
					'data-wid' => $wgCityId,
					'data-pageid' => $article->getID(),
					'data-pagens' => $title->getNamespace(),
					'data-title' => $title->getText(),
					'data-pos' => 0,
					'data-sterm' => urlencode($term),
					'data-stype' => 'intra',
					'data-rver' => 0,
					'data-event' => 'search_click_match'
				));

			$wgOut->addHTML( "<div><strong>{$link}</strong>\n" );
			if (isset($redirect)) {
			        $redirTitle = $redirect->getTitle();
			        $wgOut->addHTML(sprintf("<div class='mw-search-result-redirect'>&mdash; redirected from %s</div>\n",
							$skin->linkKnown( $redirTitle, null,
									  array(
										'class' => 'mw-search-result-title',
										'data-wid' => $wgCityId,
										'data-pageid' => $article->getID(),
										'data-pagens' => $redirTitle->getNamespace(),
										'data-title' => $redirTitle->getText(),
										'data-pos' => 0,
										'data-sterm' => urlencode($term),
										'data-stype' => 'intra',
										'data-rver' => 0,
										'data-event' => 'search_click_match'
										)
									  )
							)
						);
			}
			if( $title->userCanRead() ) {
				$articleService = new ArticleService($article->getID());

				$wgOut->addHTML( "<div class='searchresult'>" . $articleService->getTextSnippet( 250 ) . "</div>\n" );
			}
			$wgOut->addHTML( "</div><br />" );
		}
		return true;
	}

	/**
	 * get list of wikis excluded from cross-wikia search
	 * @return array
	 */
	private static function getCrossWikiaSearchExcludedWikis() {
		global $wgCrossWikiaSearchExcludedWikis, $wgCityId, $wgMemc;

		$cacheKey = wfSharedMemcKey( 'crossWikiaSearchExcludedWikis' );
		$privateWikis = $wgMemc->get( $cacheKey );

		if(!is_array($privateWikis)) {
			// get private wikis from db
			$wgIsPrivateWiki = WikiFactory::getVarByName( 'wgIsPrivateWiki', $wgCityId );
			$privateWikis = WikiFactory::getCityIDsFromVarValue( $wgIsPrivateWiki->cv_id, true, '=' );
			$wgMemc->set( $cacheKey, $privateWikis, 3600 ); // cache for 1 hour
		}

		return count( $privateWikis ) ? array_merge( $privateWikis, $wgCrossWikiaSearchExcludedWikis ) : $wgCrossWikiaSearchExcludedWikis;
	}

	/**
	 * Private constructor. Use SolrSearchSet::newFromQuery().
	 *
	 * @param string $query
	 * @param array $results
	 * @param array $snippets
	 * @param object $suggestions
	 * @param int $resultCount
	 * @param int $offset
	 * @param int $relevancyFunctionId
	 * @param int $totalHits
	 * @param bool $crossWikiaSearch
	 * @access private
	 */
	private function __construct( $query, $results, $snippets, $suggestions, $resultCount, $offset, $relevancyFunctionId, $totalHits = null, $crossWikiaSearch = false, $exactMatch = null) {
		$this->mQuery               = $query;
		$this->mTotalHits           = $totalHits;
		$this->mArticleMatch          = $exactMatch;
		if(is_array($results)) {
			$this->mResults            = $this->deDupe($results);
		}
		else {
			$this->mResults            = array();
		}
		$this->mSnippets            = $snippets;
		$this->suggestions          = $suggestions;
		$this->mResultCount         = $resultCount;
		$this->mOffset              = $offset;
		$this->mRelevancyFunctionId = $relevancyFunctionId;
		$this->mPos                 = 0;
		$this->crossWikiaSearch     = $crossWikiaSearch;
	}

	/**
	 * Remove duplicates (like redirects) from the result set
	 */
	private function deDupe(Array $results) {
		$deDupedResults = array();
		$article = $this->hasArticleMatch() ? $this->getArticleMatch() : false;
		foreach($results as $result) {
		        if($article && ($result->pageid == $article['article']->getID() ) ) {
				// remove exact match from set
				continue;
			}
			if($article && ($result->canonical == $article['article']->getTitle()->getText() ) ) {
				// remove redirect to exact match from set
				continue;
			}
			if(!isset($this->mCanonicals[$result->wid])) {
				$this->mCanonicals[$result->wid] = array();
			}
			$result->canonical = str_replace('_', ' ', $result->canonical);
			$result->title = str_replace('_', ' ', $result->title);
			if(isset($result->canonical) && !empty($result->canonical)) {
				if(!in_array($result->canonical, $this->mCanonicals[$result->wid])) {
					$this->mCanonicals[$result->wid][] = $result->canonical;
					$deDupedResults[] = $result;
				}
				else {
					continue;
				}
			}
			else if(!in_array($result->title, $this->mCanonicals[$result->wid])) {
				$this->mCanonicals[$result->wid][] = $result->title;
				$deDupedResults[] = $result;
			}
		}
		return $deDupedResults;
	}
	/**
	 * Some search modes return a total hit count for the query
	 * in the entire article database. This may include pages
	 * in namespaces that would not be matched on the given
	 * settings.
	 *
	 * @return int
	 * @access public
	 */
	function getTotalHits() {
		return $this->mTotalHits;
	}

	function hasResults() {
		return count( $this->mResults ) > 0;
	}

	function hasSuggestion() {
		return empty($this->suggestions->collation) ? false : true;
	}

	function getSuggestionQuery() {
		return $this->suggestions->collation;
	}

	function getSuggestionSnippet() {
		return $this->suggestions->collation;
	}

	function numRows() {
		return $this->mResultCount;
	}

	/**
	 * get article match
	 * @return Title
	 */
	function getArticleMatch() {
		return $this->mArticleMatch;
	}

	function setArticleMatch($article) {
		$this->mArticleMatch = $article;
	}

	function hasArticleMatch() {
		return !is_null($this->mArticleMatch);
	}

	/**
	 * Fetches next search result, or false.
	 * @return LuceneResult
	 * @access public
	 * @abstract
	 */
	function next() {
		if(isset($this->mResults[$this->mPos])) {
			$solrResult = new SolrResult($this->mResults[$this->mPos], $this->crossWikiaSearch);
			$url = $this->mResults[$this->mPos]->url;
			if(isset($this->mSnippets[$url]->html)) {
				$solrResult->setSnippets($this->mSnippets[$url]->html);
			}

			if(isset($this->mSnippets[$url]->title[0])) {
				$solrResult->setHighlightTitle($this->mSnippets[$url]->title[0]);
			}
			$this->mPos++;
			$solrResult->setRelevancyFunctionId($this->mRelevancyFunctionId);
			$solrResult->setPosition($this->mOffset + $this->mPos);
			$solrResult->setSearchTerm($this->mQuery);
		}
		else {
			$solrResult = false;
		}

		return $solrResult;
	}

	/**
	 * Rewinds the result set back one or
	 * @return Current index
	 * @access public
	 * @abstract
	 */
	function rewind ( $full = false ) {
		if ($full || $this->mPos == 1) {
			$this->mPos = 0;
		} else {
			$this->mPos--;
		}

		return $this->mPos;
	}
}

class SolrResult extends SearchResult {
	private $mSnippets = array();
	private $mCreated = null;
	private $mIndexed = null;
	private $mHighlightTitle = null;
	private $mRedirectTitle = null;
	private $mWikiId = null;
	private $mPageId = null;
	private $mUrl = null;
	private $mNamespace = null;
	private $crossWikiaResult = false;
	private $mRelevancyFunctionId = 0;
	private $mDebug = '';
	private $mWikiTitle = '';
	private $mPosition = 0;
	private $mSearchTerm = '';

	/**
	 * Construct a result object from single Apache_Solr_Document object
	 *
	 * @param Apache_Solr_Document $document
	 * @param bool $crossWikiaResult
	 */
	public function __construct( Apache_Solr_Document $document, $crossWikiaResult = false ) {
		$this->crossWikiaResult = $crossWikiaResult;
		$this->mWikiId = $document->wid;
		$this->mPageId = $document->pageid;
		$this->mNamespace = $document->ns;
		$this->mDebug = "<br>views:" . $document->views . " revcount:" . $document->revcount . " backlinks:" . $document->backlinks . " articles:" . $document->wikiarticles . " pages:" . $document->wikipages . " ativeusers:" . $document->activeusers;
		$this->mWikiTitle = $document->wikititle;

		$url = $document->url; //utf8_decode( htmlspecialchars_decode( $document->url ) );
		$title = htmlspecialchars_decode( $document->title );
		if(isset($document->canonical) && !empty($document->canonical)) {
			$canonical = htmlspecialchars_decode($document->canonical);
			$this->mTitle = new SolrResultTitle($document->ns, $canonical, $url);
			$this->mRedirectTitle = new SolrResultTitle($document->ns, $title, $url);
			$this->setHighlightTitle( $canonical );
		}
		else {
			$this->mTitle = new SolrResultTitle($document->ns, $title, $url);
		}

		$this->mWordCount = $document->words;
		$this->mSize = $document->bytes;
		$this->mCreated = isset($document->created) ? $document->created : 0;
		$this->mIndexed = isset($document->indexed) ? $document->indexed : 0;
		$this->mHighlightText = null;
		$this->mUrl = $this->mTitle->getLinkUrl();
	}

	protected function initText() {
		return true;
	}

	public function setSnippets(Array $snippets) {
		$this->mSnippets = $snippets;
	}

	private function getWikiHeading() {
		global $wgCityId, $wgSitename;

		if($this->crossWikiaResult) {
			if ($this->mWikiId != $wgCityId) {
				$sitename = WikiFactory::getVarValueByName( 'wgSitename', $this->mWikiId );
			}
			else {
				$sitename = $wgSitename;
			}
			$wikititle = trim($this->getWikiTitle());
			if(strlen($wikititle) > 90) {
				$wikititle = substr($wikititle, 0 ,90) . '...';
			}

			$wikiname = !empty($wikititle) ? ' - ' . $wikititle : ( !empty($sitename) ? ' - ' . $sitename : '' );
		}
		else {
			$wikiname = '';
		}
		return $wikiname;
	}

	public function setHighlightTitle($title) {
		if($this->mHighlightTitle == null) {
			$this->mHighlightTitle = str_replace('_', ' ', htmlspecialchars_decode($title)) . $this->getWikiHeading();
		}
	}

	public function getTextSnippet($terms = null) {
		if( is_null($this->mHighlightText) ) {
			$this->mHighlightText = '';
			foreach($this->mSnippets as $snippet) {
				$this->mHighlightText .= $snippet . '... ';
			}
		}
		return preg_replace("/^\W+ /", '', 
				    preg_replace("/(<\/span>)('s)/i", '$2$1' , 
						 strip_tags($this->mHighlightText, '<span>')));
	}

	public function getWikiId() {
		return $this->mWikiId;
	}

	public function getPageId() {
		return $this->mPageId;
	}

	public function getPageNS() {
		return $this->mNamespace;
	}

	public function getTitle() {
		return $this->mTitle;
	}

	public function getRedirectTitle() {
		return $this->mRedirectTitle;
	}

	public function getTitleSnippet($terms = null) {
		return ( !is_null($this->mHighlightTitle) ? $this->mHighlightTitle : ( $this->mTitle->getText() . $this->getWikiHeading() ) );
	}

	public function isMissingRevision() {
		return false;
	}

	public function getByteSize() {
		return $this->mSize;
	}

	public function getWordCount() {
		return $this->mWordCount;
	}

	public function getTimestamp() {
		return $this->mCreated;
	}

	public function isCrossWikiaResult() {
		return $this->crossWikiaResult;
	}

	public function getUrl() {
		return $this->mUrl;
	}

	public function getDebug() {
		return $this->mDebug;
	}

	public function getWikiTitle() {
		return strtr( $this->mWikiTitle, array( '$1 - ' => '', '$1' => '' ) );
	}

	public function getPosition() {
		return $this->mPosition;
	}

	public function setPosition($position) {
		$this->mPosition = $position;
	}

	public function getSearchTerm() {
		return $this->mSearchTerm;
	}

	public function setSearchTerm($term) {
		$this->mSearchTerm = $term;
	}

	public function getRelevancyFunctionId() {
		return $this->mRelevancyFunctionId;
	}

	public function setRelevancyFunctionId($value) {
		$this->mRelevancyFunctionId = $value;
	}

	public static function showHit($result, $link, $redirect, $section, $extract, $data) {
		// adding class and extra params to result link
		$link = preg_replace('/( title=\")/i', ' class="mw-search-result-title" data-wid="' . $result->getWikiId() . '" data-pageid="' . $result->getPageId() . '" data-pagens="' . $result->getPageNS() . '" data-title="' . $result->getTitle()->getText() . '" data-pos="' . $result->getPosition() . '" data-sterm="' . urlencode( $result->getSearchTerm() ) . '" data-stype="' . ( $result->isCrossWikiaResult() ? 'inter' : 'intra' ) . '" data-rver="' . $result->getRelevancyFunctionId() . '"$1', $link);

		if($result->isCrossWikiaResult()) {
			$data = "<a href=\"" . $result->getUrl() . "\" title=\"" . $result->getUrl() . "\" style=\"text-decoration: none; font-size: small\"><span class=\"dark_text_2\">" . strtr( urldecode( $result->getUrl() ), array( 'http://' => '' ) ) . "</span></a>";
			//$data .= $result->getDebug();
		}
		else {
			$data = '';
		}

		// snippeting ugliness
		$link = preg_replace("/(<\/span>)('s)/", "$2$1", $link);
		return true;
	}

}

/**
 * Simple Title class wrapper for compatibility with Special:Search
 */
class SolrResultTitle extends Title {
	private $mUrl;

	public function __construct($ns, $title, $url, $id = 0) {
		$this->mInterwiki = '';
		$this->mFragment = '';
		$this->mNamespace = intval( $ns );
		$this->mDbkeyform = str_replace( ' ', '_', $title );
		$this->mArticleID = $id; //( $ns >= 0 ) ? -1 : 0;
		$this->mUrlform = wfUrlencode( $this->mDbkeyform );
		$this->mTextform = str_replace( '_', ' ', $title );

		$this->mUrl = $this->sanitizeUrl( $url );
	}

	public function getLinkUrl( $query = array(), $variant = false ) {
		return $this->mUrl;
	}

	private function sanitizeUrl($url) {
		//$url = wfUrlEncodeExt( $url );

		// RT #25474, #46891, #52759 ..damn you question marks!
		$url = str_replace( '?', '%3F', $url );

		return $url;
	}
}
