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
		return SolrSearchSet::newFromQuery( $term, $this->namespaces, $this->limit, $this->offset );
	}

}

class SolrSearchSet extends SearchResultSet {
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
		global $wgSolrHost, $wgSolrPort, $wgMemc;

		$fname = 'SolrSearchSet::newFromQuery';
		wfProfileIn( $fname );

		$solr = new Apache_Solr_Service($wgSolrHost, $wgSolrPort, '/solr');
		if($solr->ping()) {
			$params = array(
				'fl' => 'title,url,host,bytes,words,ns,lang,indexed,created', // fields we want to fetch back
				'hl' => 'true',
				'hl.fl' => 'html', // highlight field
				'hl.snippets' => '2', // number of snippets per field
				'hl.fragsize' => '150', // snippet size in characters
				'hl.simple.pre' => '<span class="searchmatch">',
				'hl.simple.post' => '</span>'
				/*'sort' => 'rank desc'*/
			);

			if(count($namespaces)) {
				$nsQuery = '';
				foreach($namespaces as $namespace) {
					$nsQuery .= ( !empty($nsQuery) ? ' OR ' : '' ) . 'ns:' . $namespace;
				}
				$params['fq'] = $nsQuery; // filter results for selected ns
			}

			try {
				$response = $solr->search($query, $offset, $limit, $params);
			}
			catch (Exception $exception) {
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
		$this->mResults           = $results;
		$this->mSnippets          = $snippets;
		$this->mResultCount       = $resultCount;
		$this->mPos               = 0;
		//$this->mSuggestionQuery   = null;
		//$this->mSuggestionSnippet = '';
		//$this->parseSuggestion($suggestion);
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
	/**
	 * Construct a result object from single Apache_Solr_Document object
	 *
	 * @param Apache_Solr_Document $document
	 */
	public function __construct( Apache_Solr_Document $document ) {
		$this->mTitle = new SolrResultTitle($document->ns, $document->title, $document->url);
		$this->mWordCount = $document->words;
		$this->mSize = $document->bytes;
		$this->mCreated = $document->created;
		$this->mIndexed = $document->indexed;
		$this->mHighlightText = null;
	}

	protected function initText() {
		return true;
	}

	public function setSnippets(Array $snippets) {
		$this->mSnippets = $snippets;
	}

	public function getTextSnippet($terms) {
		if( is_null($this->mHighlightText) ) {
			$this->mHighlightText = '';
			foreach($this->mSnippets as $snippet) {
				$this->mHighlightText .= $snippet . '... ';
			}
		}
		return $this->mHighlightText;
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
