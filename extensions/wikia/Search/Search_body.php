<?php

class SolrSearch extends SearchEngine {
	/**
	 * Perform a full text search query and return a result set.
	 *
	 * @param string $term - Raw search term
	 * @return SolrSearchSet
	 * @access public
	 */
	function searchText( $term ) {
		//$words = "";
		//foreach(explode(' ', $term) as $word) {
		//	$words .= ( !empty($words) ? " AND " : "" ) . $word;
		//}
		//$queryString = "title:$words^10 OR html:$words";
		//echo $queryString;
		//return SolrSearchSet::newFromQuery( $queryString, $this->namespaces, $this->limit, $this->offset );
		//return SolrSearchSet::newFromQuery( "title:$term^10 OR html:$term", $this->namespaces, $this->limit, $this->offset );
		return SolrSearchSet::newFromQuery( $term, $this->namespaces, $this->limit, $this->offset );
	}

	//function searchTitle( $term ) {
	//	return SolrSearchSet::newFromQuery( "title:$term", $this->namespaces, $this->limit, $this->offset );
	//}

}

class SolrSearchSet extends SearchResultSet {

	private $mCanonicals = array();
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
	public static function newFromQuery( $query, $namespaces = array(), $limit = 20, $offset = 0 ) {
		global $wgSolrHost, $wgSolrPort, $wgMemc, $wgCityId;

		$fname = 'SolrSearchSet::newFromQuery';
		wfProfileIn( $fname );

		$solr = new Apache_Solr_Service($wgSolrHost, $wgSolrPort, '/solr');
		if($solr->ping()) {
			$params = array(
				'fl' => 'title,canonical,url,host,bytes,words,ns,lang,indexed,created,views', // fields we want to fetch back
				'bf' => 'title^10',
				'hl' => 'true',
				'hl.fl' => 'html,title', // highlight field
				'hl.snippets' => '2', // number of snippets per field
				'hl.fragsize' => '150', // snippet size in characters
				'hl.simple.pre' => '<span class="searchmatch">',
				'hl.simple.post' => '</span>',
				'indent' => 1,
				//'sort' => 'score desc, backlinks desc, views desc, revcount desc, created asc'
				//'sort' => 'backlinks desc, views desc, revcount desc, created asc'
			);

			if(count($namespaces)) {
				$nsQuery = '';
				foreach($namespaces as $namespace) {
					$nsQuery .= ( !empty($nsQuery) ? ' OR ' : '' ) . 'ns:' . $namespace;
				}
				$params['fq'] = $nsQuery; // filter results for selected ns
			}
			//$params['fq'] = "(" . $params['fq'] . ") AND wid:" . $wgCityId;
			$params['fq'] = "(" . $params['fq'] . ") AND wid:831";
			//echo "fq=" . $params['fq'] . "<br />";
			try {
				$query .= ' _val_:"scale(views,1,20)"';
				//echo "query:" . $query . "<br />";
				$response = $solr->search($query, $offset, $limit, $params);
			}
			catch (Exception $exception) {
				//print_r($exception);
				wfProfileOut( $fname );
				return null;
			}
		}
		else {
			wfDebug("Couldn't connect to Solr backend at: $wgSolrHost:$wgSolrPort\n");
			wfProfileOut( $fname );
			return null;
		}
		//echo "<pre>";
		//print_r($response->response);
		//print_r($response->highlighting);
		//exit;

		/*
		$suggestion = null;
		*/

		$resultDocs = $response->response->docs;
		$resultSnippets = is_object($response->highlighting) ? get_object_vars($response->highlighting) : array();
		$resultCount = count($resultDocs);
		$totalHits = $response->response->numFound;

		$resultSet = new SolrSearchSet( $query, $resultDocs, $resultSnippets, $resultCount, $totalHits /*, $suggestion */ );

		wfProfileOut( $fname );
		return $resultSet;
	}

	/**
	 * Private constructor. Use SolrSearchSet::newFromQuery().
	 *
	 * @param string $query
	 * @param array $lines
	 * @param int $resultCount
	 * @param int $totalHits
	 * @param string $suggestion
	 * @access private
	 */
	private function __construct( $query, $results, $snippets, $resultCount, $totalHits = null, $suggestion = null) {
		$this->mQuery             = $query;
		$this->mTotalHits         = $totalHits;
		$this->mResults           = $this->deDupe($results);
		$this->mSnippets          = $snippets;
		$this->mResultCount       = $resultCount;
		$this->mPos               = 0;
		//$this->mSuggestionQuery   = null;
		//$this->mSuggestionSnippet = '';
		//$this->parseSuggestion($suggestion);
	}

	/**
	 * Remove duplicates (like redirects) from the result set
	 */
	private function deDupe(Array $results) {
		$deDupedResults = array();
		foreach($results as $result) {
			$result->canonical = str_replace('_', ' ', $result->canonical);
			$result->title = str_replace('_', ' ', $result->title);
			if(isset($result->canonical) && !empty($result->canonical)) {
				if(!in_array($result->canonical, $this->mCanonicals)) {
					//echo "Got canonical for: " . $result->title . ", canonical is: " . $result->canonical . "<br />";
					$this->mCanonicals[] = $result->canonical;
					$deDupedResults[] = $result;
				}
				else {
					//echo "(!) Already have: " . $result->canonical . " - " . $result->title . " - deduped<br />";
					continue;
				}
			}
			else if(!in_array($result->title, $this->mCanonicals)) {
				$this->mCanonicals[] = $result->title;
				$deDupedResults[] = $result;
			}
		}
		//echo "<pre>";
		//print_r($deDupedResults);
		//exit;
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

	function numRows() {
		return $this->mResultCount;
	}

	/**
	 * Fetches next search result, or false.
	 * @return LuceneResult
	 * @access public
	 * @abstract
	 */
	function next() {
		if(isset($this->mResults[$this->mPos])) {
			$solrResult = new SolrResult($this->mResults[$this->mPos]);
			$url = $this->mResults[$this->mPos]->url;
			if(isset($this->mSnippets[$url]->html)) {
				$solrResult->setSnippets($this->mSnippets[$url]->html);
			}
			if(isset($this->mSnippets[$url]->title[0])) {
				$solrResult->setHighlightTitle($this->mSnippets[$url]->title[0]);
			}
			$this->mPos++;
		}
		else {
			$solrResult = false;
		}

		return $solrResult;
	}

	/*
	private function parseSuggestion($suggestion) {
		if( is_null($suggestion) )
			return;
		// parse split points and highlight changes
		list($dummy,$points,$sug) = explode(" ",$suggestion);
		$sug = urldecode($sug);
		$points = explode(",",substr($points,1,-1));
		array_unshift($points,0);
		$suggestText = "";
		for($i=1;$i<count($points);$i+=2){
			$suggestText .= htmlspecialchars(substr($sug,$points[$i-1],$points[$i]-$points[$i-1]));
			$suggestText .= '<em>'.htmlspecialchars(substr($sug,$points[$i],$points[$i+1]-$points[$i]))."</em>";
		}
		$suggestText .= htmlspecialchars(substr($sug,end($points)));

		$this->mSuggestionQuery = $this->replaceGenericPrefixes($sug);
		$this->mSuggestionSnippet = $this->replaceGenericPrefixes($suggestText);
	}
	*/
}

class SolrResult extends SearchResult {
	private $mSnippets = array();
	private $mCreated = null;
	private $mIndexed = null;
	private $mHighlightTitle = null;
	/**
	 * Construct a result object from single Apache_Solr_Document object
	 *
	 * @param Apache_Solr_Document $document
	 */
	public function __construct( Apache_Solr_Document $document ) {
		//echo "<pre>";
		//print_r($document);
		//var_dump(isset($document->canonical));
		//echo "</pre>";
		$this->mTitle = new SolrResultTitle($document->ns, urldecode( ( ( isset($document->canonical) && !empty($document->canonical) ) ? $document->canonical : $document->title) ), $document->url);
		$this->mWordCount = $document->words;
		$this->mSize = $document->bytes;
		$this->mCreated = isset($document->created) ? $document->created : 0;
		$this->mIndexed = isset($document->indexed) ? $document->indexed : 0;
		$this->mHighlightText = null;
	}

	protected function initText() {
		return true;
	}

	public function setSnippets(Array $snippets) {
		$this->mSnippets = $snippets;
	}

	public function setHighlightTitle($title) {
		$this->mHighlightTitle = urldecode($title);
	}

	public function getTextSnippet($terms = null) {
		if( is_null($this->mHighlightText) ) {
			$this->mHighlightText = '';
			foreach($this->mSnippets as $snippet) {
				$this->mHighlightText .= $snippet . '... ';
			}
		}
		return $this->mHighlightText;
	}

	public function getTitleSnippet($terms = null) {
		return ( !is_null($this->mHighlightTitle) ? $this->mHighlightTitle : '' );
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

}

/**
 * Simple Title class wrapper for compatibility with Special:Search
 */
class SolrResultTitle extends Title {
	private $mUrl;

	public function __construct($ns, $title, $url) {
		$this->mInterwiki = '';
		$this->mFragment = '';
		$this->mNamespace = 0; //$ns = intval( $ns );
		$this->mDbkeyform = str_replace( ' ', '_', $title );
		$this->mArticleID = 0; //( $ns >= 0 ) ? -1 : 0;
		$this->mUrlform = wfUrlencode( $this->mDbkeyform );
		$this->mTextform = str_replace( '_', ' ', $title );

		$this->mUrl = $url;
	}

	public function getLinkUrl( $query = array(), $variant = false ) {
		return $this->mUrl;
	}
}
