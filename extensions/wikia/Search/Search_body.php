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
	 * @param string $method The protocol verb to use
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
			$response = $solr->search('html:'.$query.' OR title:'.$query, $offset, $limit /*, array('sort' => 'timestamp desc')*/);
		}
		else {
			echo "Error.";
		}
		//echo "<pre>";
		//print_r($response->response);
		//exit;

		/*
		$suggestion = null;
		$info = null;
		$interwiki = null;
		*/

		$resultDocs = $response->response->docs;
		$resultCount = count($resultDocs);
		$totalHits = $response->response->numFound;

		$resultSet = new SolrSearchSet( $query, $resultDocs, $resultCount, $totalHits /*, $suggestion, $info, $interwiki*/ );

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
	 * @param string $info
	 * @access private
	 */
	private function __construct( $query, $results, $resultCount, $totalHits = null, $suggestion = null, $info = null, $interwiki = null ) {
		$this->mQuery             = $query;
		$this->mTotalHits         = $totalHits;
		$this->mResults           = $results;
		$this->mResultCount       = $resultCount;
		$this->mPos               = 0;
		//$this->mSuggestionQuery   = null;
		//$this->mSuggestionSnippet = '';
		//$this->parseSuggestion($suggestion);
		$this->mInfo              = $info;
		$this->mInterwiki         = $interwiki;

		//echo "<pre>";
		//print_r($results);
		//exit;
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
	/**
	 * result url
	 */
	protected $mHitUrl;
	/**
	 * result title
	 */
	protected $mHitTitle;
	/**
	 * Construct a result object from single Apache_Solr_Document object
	 *
	 * @param Apache_Solr_Document $document
	 */
	public function __construct( Apache_Solr_Document $document ) {
		//echo "<pre>";
		//print_r($document);
		//exit;
		$namespace = $document->ns;
		$title = $document->title;

		$this->mHitUrl = $document->url;
		$this->mHitTitle = $title;

		$this->mTitle = Title::makeTitle( $namespace, $title );
		$this->mSectionTitle = '';
		$this->mWordCount = $document->words;
		$this->mSize = $document->bytes;

		/* w8 for highlightet snippets provided by solr
		if(isset($document->html)) {
			$this->mHighlightText = $document->html;
			//list( $this->mHighlightText, $dummy ) = $this->extractSnippet($document->html,'',"#h.text",true);
		}
		else {
			$this->mHighlightText = '';
		}
		*/
		$this->mHighlightText = null;

		$this->mText = null;
		$this->initText(isset($document->html) ? $document->html : '');
	}

	public static function makeHitLink($result, $skin, $link) {
		$link = '<a href="' . $result->getHitUrl() . '">' . $result->getHitTitle() . '</a>';
		return true;
	}

	protected function initText($text = '') {
		if($this->mText == null) {
			$this->mText = $text;
		}
	}

	public function getHitUrl() {
		return $this->mHitUrl;
	}

	public function getHitTitle() {
		return $this->mHitTitle;
	}

	public function getSectionTitle() {
		return $this->mSectionTitle;
	}

	public function getTextSnippet($terms) {
		if( is_null($this->mHighlightText) ) {
			return parent::getTextSnippet($terms);
		}
		return $this->mHighlightText;
	}

	public function isMissingRevision() {
		return false;
	}

	public function getByteSize() {
		return $this->mSize;
	}

	function getWordCount() {
		return $this->mWordCount;
	}

	protected function extractSnippet($lines, $nsText, $type, $useFinalSeparator=false) {
		if(!array_key_exists($type,$lines))
			return array(null,null);
		$ret = "";
		$original = null;
		foreach($lines[$type] as $h){
			list($s,$o) = $this->extractSnippetLine($h,$useFinalSeparator);
			$ret .= $s;
			$original = $o;
		}
		if($nsText!='')
			$ret = $nsText.':'.$ret;
		return array($ret,$original);
	}

	/**
	 * Parse one line of a snippet
	 *
	 * @param string $line
	 * @param boolean $useFinalSeparator if "..." is to be appended to the end of snippet
	 * @access protected
	 * @return array(snippet,unmodified text)
	 */
	protected function extractSnippetLine($line, $useFinalSeparator){
		$parts = explode(" ",$line);
		if(count($parts)!=4 && count($parts)!=5){
			wfDebug("Bad result line:".$line."\n");
			return "";
		}
		$splits = $this->stripBracketsSplit($parts[0]);
		$highlight = $this->stripBracketsSplit($parts[1]);
		$suffix = urldecode($this->stripBrackets($parts[2]));
		$text = urldecode($parts[3]);
		$original = null;
		if(count($parts) > 4)
			$original = urldecode($parts[4]);

		$splits[] = strlen($text);
		$start = 0;
		$snippet = "";
		$hi = 0;
		$ellipsis = wfMsgForContent( 'ellipsis' );

		foreach($splits as $sp){
			$sp = intval($sp);
			// highlight words!
			while($hi < count($highlight) && intval($highlight[$hi]) < $sp){
				$s = intval($highlight[$hi]);
				$e = intval($highlight[$hi+1]);
				$snippet .= substr($text,$start,$s-$start)."<span class='searchmatch'>".substr($text,$s,$e-$s)."</span>";
				$start = $e;
				$hi += 2;
			}
			// copy till split point
			$snippet .= substr($text,$start,$sp-$start);
			if($sp == strlen($text) && $suffix != '')
				$snippet .= $suffix;
			else if($useFinalSeparator)
				$snippet .= " <b>" . $ellipsis . "</b> ";

			$start = $sp;
		}
		return array($snippet,$original);
	}


	/**
	 * @access private
	 */
	private function stripBrackets($str){
		if($str == '[]')
			return '';
		return substr($str,1,strlen($str)-2);
	}

	/**
	 * @access private
	 * @return array
	 */
	private function stripBracketsSplit($str){
		$strip = $this->stripBrackets($str);
		if($strip == '')
			return array();
		else
			return explode(",",$strip);
	}

}
