<?php

class LuceneSearch extends SearchEngine {
	/**
	 * Perform a full text search query and return a result set.
	 *
	 * @param string $term - Raw search term
	 * @return LuceneSearchSet
	 * @access public
	 */
	function searchText( $term ) {
		return LuceneSearchSet::newFromQuery( isset($this->related)? 'related' : 'search',
				$term, $this->namespaces, $this->limit, $this->offset, $this->searchingEverything() );
	}

	/**
	 * Perform a title-only search query and return a result set.
	 *
	 * @param string $term - Raw search term
	 * @return LuceneSearchSet
	 * @access public
	 */
	function searchTitle( $term ) {
		return null;		
	}

	/**
	 *  PrefixSearchBackend override for OpenSearch results
	 */
	static function prefixSearch( $ns, $search, $limit, &$results ) {
		$it = LuceneSearchSet::newFromQuery( 'prefix', $search, $ns, $limit, 0 );
		$results = array();
		if( $it ) { // $it can be null
			while( $res = $it->next() ) {
				$results[] = $res->getTitle()->getPrefixedText(); 
			}
		}
		return false;
	}

	/**
	 * Check if we are searching all the namespaces on this wiki
	 * 
	 * @return boolean
	 */
	function searchingEverything(){
		return $this->namespaces ==  array_keys( SearchEngine::searchableNamespaces() );
	}
		
	/**
	 * Prepare query for the lucene-search daemon:
	 * 
	 * 1) rewrite namespaces into standardized form 
	 * e.g. image:clouds -> [6]:clouds
	 * 
	 * 2) rewrite localizations of "search everything" keyword
	 * e.g. alle:heidegger -> all:heidegger
	 *
	 * @param string query 
	 * @return string rewritten query
	 * @access private
	 */
	function replacePrefixes( $query ) {
		global $wgContLang, $wgLuceneUseRelated;
		$fname = 'LuceneSearch::replacePrefixes';
		wfProfileIn($fname);
		$start = 0; $len = 0; // token start pos and length
		$rewritten = ''; // rewritten query
		$rindex = 0; // point to last rewritten character
		$inquotes = false;
		
		// "search everything" keyword
		$allkeyword = wfMsgForContent('searchall');			
		
		$qlen = strlen($query);
		
		// quick check, most of the time we don't need any rewriting
		if(strpos($query,':')===false){ 
			wfProfileOut($fname);
			return $query;
		}

		// check if this is query for related articles
		$relatedkey = wfMsgForContent('searchrelated').':';
		if($wgLuceneUseRelated && strncmp($query, $relatedkey, strlen($relatedkey)) == 0){
			$this->related = true;
			list($dummy,$ret) = explode(":",$query,2);
			wfProfileOut($fname);
			return trim($ret);
		}
		
		global $wgCanonicalNamespaceNames, $wgNamespaceAliases;
		$nsNamesRaw = array_merge($wgContLang->getNamespaces(), $wgCanonicalNamespaceNames, 
			array_keys( array_merge($wgNamespaceAliases, $wgContLang->getNamespaceAliases()) ) );
			
		# add all namespace names w/o spaces
		$nsNames = array();
		foreach($nsNamesRaw as $ns){
			if( $ns != ''){
				$nsNames[] = $ns;
				$nsNames[] = str_replace('_',' ',$ns);
			}
		}

		$regexp = implode('|',array_unique( $nsNames ));
		
		# rewrite the query by replacing valid namespace names
		$parts = preg_split('/(")/',$query,-1,PREG_SPLIT_DELIM_CAPTURE);
		$inquotes = false;
		$rewritten = '';
		foreach($parts as $part){
			if( $part == '"'){ # stuff in quote doesnt get rewritten
				$rewritten .= $part;
				$inquotes = !$inquotes;
			} elseif( $inquotes ){
				$rewritten .= $part;				
			} else{
				# replace namespaces
				$r = preg_replace_callback('/(^|[| :])('.$regexp.'):/i',array($this,'replaceNamespace'),$part);
				# replace to backend all: notation
				$rewritten .= str_replace($allkeyword.':', 'all:', $r);
			}
		}		
		wfProfileOut($fname);
		return $rewritten;
	}
	
	/** callback to replace namespace names to internal notation, e.g. User: -> [2]: */ 
	function replaceNamespace($matches){
		global $wgContLang;
		$inx = $wgContLang->getNsIndex(str_replace(' ', '_', $matches[2]));
		if ($inx === false)
			return $matches[0];
		else
			return $matches[1]."[$inx]:";
		
	}
	
	function acceptListRedirects() {
		return false;
	}
	
	/** Merge the prefix into the query (if any) */
	function transformSearchTerm( $term ) {
		global $wgLuceneSearchVersion;
		
		if ( $wgLuceneSearchVersion >= 2.1 && $this->prefix != '' ){
			# convert to internal backend prefix notation 
			$term = $term.' prefix:'.$this->prefix;
		}
		return $term;
	}
}

class LuceneResult extends SearchResult {
	/**
	 * Construct a result object from single result line
	 * 
	 * @param array $lines
	 * @param string $method - method used to fetch these results
	 * @return array (float, Title)
	 * @access private
	 */
	function LuceneResult( $lines, $method ) {
		global $wgContLang;
		
		$score = null;
		$interwiki = null;
		$namespace = null;
		$title = null;
		
		$line = $lines['result'];
		wfDebug( "Lucene line: '$line'\n" );

		# detect format
		$parts = explode(' ', $line);
		if(count($parts) == 3)
			list( $score, $namespace, $title ) = $parts;
		else
			list( $score, $interwiki, $namespace, $nsText, $title ) = $parts;

		$score     = floatval( $score );
		$namespace = intval( $namespace );
		$title     = urldecode( $title );
		if(!isset($nsText))
			$nsText = $wgContLang->getNsText($namespace);
		else
			$nsText = urldecode($nsText);

		$this->mInterwiki = '';
		// make title
		if( is_null($interwiki)){
			$this->mTitle = Title::makeTitle( $namespace, $title );
		} else{
			$interwiki = urldecode( $interwiki );
			// there might be a better way to make an interwiki link			
			$t = $interwiki.':'.$nsText.':'.str_replace( '_', ' ', $title );
			$this->mTitle = Title::newFromText( $t );
			$this->mInterwiki = $interwiki;
		}
		
		$this->mScore = $score;
		
		$this->mWordCount = null;
		if(array_key_exists("#h.wordcount",$lines))
			$this->mWordCount = intval($lines["#h.wordcount"][0]);
			
		$this->mSize = null;
		if(array_key_exists("#h.size",$lines))
			$this->mSize = intval($lines["#h.size"][0]);
			
		$this->mDate = null;
		if(array_key_exists("#h.date",$lines))
			$this->mDate = $lines["#h.date"][0];
			
		// various snippets
		list( $this->mHighlightTitle, $dummy ) = $this->extractSnippet($lines,$nsText,"#h.title");
		if( is_null($this->mHighlightTitle) && $this->isInterwiki() ){
			// construct highlighted interwiki title without the interwiki part
			$this->mHighlightTitle = ($nsText==''? '' : $nsText.':') . str_replace( '_', ' ', $title );
		}
		
		list( $this->mHighlightText, $dummy ) = $this->extractSnippet($lines,'',"#h.text",true);
		
		list( $this->mHighlightRedirect, $redirect ) = $this->extractSnippet($lines,$nsText,"#h.redirect");
		$this->mRedirectTitle = null;
		if( !is_null($redirect)){
			# build redirect Title object			
			if($interwiki != ''){
				$t = $interwiki.':'.$redirect;
				$this->mRedirectTitle = Title::newFromText( $t );
			} else{
				$parts = explode(":",$redirect,2);
				$redirectNs = intval($parts[0]);
				$redirectText = str_replace('_', ' ', $parts[1]);
				$this->mRedirectTitle = Title::makeTitle($redirectNs,$redirectText);
			}
		}
			
		list( $this->mHighlightSection, $section) = $this->extractSnippet($lines,'',"#h.section");
		$this->mSectionTitle = null;
		if( !is_null($section)){
			# build title + fragment Title object
			$t = $nsText.':'.str_replace( '_', ' ', $title ).'#'.$section;
			$this->mSectionTitle = Title::newFromText($t);
		} 
		
		# fetch revision info if not an interwiki title, and not using prefix search
		if($this->mInterwiki == '' && $method != 'prefix')
			$this->mRevision = Revision::newFromTitle( $this->mTitle );
			
		if(!is_null($this->mTitle) && $this->mTitle->getNamespace() == NS_IMAGE)
			$this->mImage = wfFindFile( $this->mTitle );	
	}
	
	/**
	 * Get the pair [highlighted snippet, unmodified text] for highlighted text
	 *
	 * @param string $lines
	 * @param string $nsText textual form of namespace
	 * @param string $type
	 * @param boolean $useFinalSeparator
	 * @return array (highlighted, unmodified text)
	 */
	function extractSnippet($lines, $nsText, $type, $useFinalSeparator=false){
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
	function extractSnippetLine($line, $useFinalSeparator){
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
	function stripBrackets($str){
		if($str == '[]')
			return '';
		return substr($str,1,strlen($str)-2);
	}
	
	/**
	 * @access private
	 * @return array
	 */
	function stripBracketsSplit($str){
		$strip = $this->stripBrackets($str);
		if($strip == '')
			return array();
		else
			return explode(",",$strip);
	}

	function getTitle() {
		return $this->mTitle;
	}

	function getScore() {
		return null; // lucene scores are meaningless to the user... 
	}
	
	function getTitleSnippet($terms){				
		if( is_null($this->mHighlightTitle) )
			return '';
		return $this->mHighlightTitle;
	}
	
	function getTextSnippet($terms) {
		if( is_null($this->mHighlightText) )
			return parent::getTextSnippet($terms);
		return $this->mHighlightText;
	}
	
	function getRedirectSnippet($terms) {
		if( is_null($this->mHighlightRedirect) )
			return '';
		return $this->mHighlightRedirect;
	}
	
	function getRedirectTitle(){
		return $this->mRedirectTitle;
	}
	
	function getSectionSnippet(){
		if( is_null($this->mHighlightSection) )
			return '';
		return $this->mHighlightSection;
	}
	
	function getSectionTitle(){
		return $this->mSectionTitle;
	}
	
	function getInterwikiPrefix(){
		return $this->mInterwiki;
	}
	
	function isInterwiki(){
		return $this->mInterwiki != '';
	}
	
	function getTimestamp(){
		if( is_null($this->mDate) )
			return parent::getTimestamp();
		return $this->mDate;
	}
	
	function getWordCount(){
		if( is_null($this->mWordCount) )
			return parent::getWordCount();
		return $this->mWordCount;
	}
	
	function getByteSize(){
		if( is_null($this->mSize) )
			return parent::getByteSize();
		return $this->mSize;
	}	
	
	function hasRelated(){
	 	global $wgLuceneSearchVersion, $wgLuceneUseRelated;
	 	return $wgLuceneSearchVersion >= 2.1 && $wgLuceneUseRelated;
	}
}

class LuceneSearchSet extends SearchResultSet {
	/**
	 * Contact the MWDaemon search server and return a wrapper
	 * object with the set of results. Results may be cached.
	 *
	 * @param string $method The protocol verb to use
	 * @param string $query
	 * @param int $limit
	 * @param int $offset
	 * @param bool $searchAll
	 * @return array
	 * @access public
	 */
	static function newFromQuery( $method, $query, $namespaces = array(), 
	    $limit = 20, $offset = 0, $searchAll = False ) {
	    	
		$fname = 'LuceneSearchSet::newFromQuery';
		wfProfileIn( $fname );
		
		global $wgLuceneHost, $wgLucenePort, $wgDBname, $wgMemc;
		global $wgLuceneSearchVersion, $wgLuceneSearchCacheExpiry;
		global $wgLuceneSearchTimeout;
		
		$hosts = $wgLuceneHost;
		if( $method == 'prefix'){
			global $wgLucenePrefixHost;
			if( isset($wgLucenePrefixHost) )
				$hosts = $wgLucenePrefixHost;
		}
			
		if( is_array( $hosts ) ) {
			$pick = mt_rand( 0, count( $hosts ) - 1 );
			$host = $hosts[$pick];
		} else {
			$host = $hosts;
		}
		
		$enctext = rawurlencode( trim( $query ) );
		$searchUrl = "http://$host:$wgLucenePort/$method/$wgDBname/$enctext?" .
			wfArrayToCGI( array(
				'namespaces' => implode( ',', $namespaces ),
				'offset'     => $offset,
				'limit'      => $limit,
				'version'    => $wgLuceneSearchVersion,
				'iwlimit'	 => 10,
				'searchall'  => $searchAll? 1 : 0,
			) );
				
		// try to fetch cached if caching is turned on
		if($wgLuceneSearchCacheExpiry > 0){
			$key = "$wgDBname:lucene:" . md5( $searchUrl );
			$resultSet = $wgMemc->get( $key );
			if( is_object( $resultSet ) ) {
				wfDebug( "$fname: got cached lucene results for key $key\n" );
				wfProfileOut( $fname );
				return $resultSet;
			}
		}

		// Search server will be in local network but may not trigger checks on
		// Http::isLocal(), so suppress usage of $wgHTTPProxy if enabled.
		$httpOpts = array( 'proxy' => false );
		
		wfDebug( "Fetching search data from $searchUrl\n" ); 
		wfSuppressWarnings();
		wfProfileIn( $fname.'-contact-'.$host );
		$data = Http::get( $searchUrl, $wgLuceneSearchTimeout, $httpOpts); 
		wfProfileOut( $fname.'-contact-'.$host );
		wfRestoreWarnings();
		if( $data === false ) {
			// Network error or server error
			wfProfileOut( $fname );
			return null;
		} else {
			$inputLines = explode( "\n", trim( $data ) );
			$resultLines = array_map( 'trim', $inputLines );
		}

		$suggestion = null;
		$totalHits = null;
		$info = null;
		$interwiki = null;
		
		# All methods have same syntax... 
		$totalHits = array_shift( $resultLines );
		if( $totalHits === false ) {
			# I/O error? this shouldn't happen
			wfDebug( "Couldn't read summary line...\n" );
		} else {
			$totalHits = intval( $totalHits );
			wfDebug( "total [$totalHits] hits\n" );
			if($wgLuceneSearchVersion >= 2.1){
				# second line is info
				list($dummy,$info) = explode(' ',array_shift($resultLines),2);
				# third line is suggestions
				$s = array_shift($resultLines);
				if(self::startsWith($s,'#suggest '))
					$suggestion = $s;
					
				# fifth line is interwiki info line
				$iwHeading = array_shift($resultLines);
				list($dummy,$iwCount,$iwTotal) = explode(' ',$iwHeading);
				if($iwCount>0){
					# pack interwiki lines into a separate result set
					$interwikiLen = 0; 
					while(!self::startsWith($resultLines[$interwikiLen],"#results")) 
						$interwikiLen++;
					$interwikiLines = array_splice($resultLines,0,$interwikiLen);
					$interwiki = new LuceneSearchSet( $method, $query, $interwikiLines, intval($iwCount), intval($iwTotal) );
				}
				
				# how many results we got
				list($dummy,$resultCount) = explode(" ",array_shift($resultLines));
				$resultCount = intval($resultCount);
			} else{
				$resultCount = count($resultLines);
			}
		}
		
		
		$resultSet = new LuceneSearchSet( $method, $query, $resultLines, $resultCount, $totalHits, 
		             $suggestion, $info, $interwiki );
		
		if($wgLuceneSearchCacheExpiry > 0){
			wfDebug( "$fname: caching lucene results for key $key\n" );
			$wgMemc->add( $key, $resultSet, $wgLuceneSearchCacheExpiry );
		}
		
		wfProfileOut( $fname );
		return $resultSet;
	}
	
	static function startsWith($source, $prefix){
   		return strncmp($source, $prefix, strlen($prefix)) == 0;
	}
	
	/**
	 * Private constructor. Use LuceneSearchSet::newFromQuery().
	 * 
	 * @param string $method
	 * @param string $query
	 * @param array $lines
	 * @param int $resultCount
	 * @param int $totalHits
	 * @param string $suggestion
	 * @param string $info
	 * @access private
	 */
	function LuceneSearchSet( $method, $query, $lines, $resultCount, $totalHits = null, $suggestion = null, $info = null, $interwiki = null ) {
		$this->mMethod            = $method;
		$this->mQuery             = $query;
		$this->mTotalHits         = $totalHits;
		$this->mResults           = $lines;
		$this->mResultCount       = $resultCount;
		$this->mPos               = 0;
		$this->mSuggestionQuery   = null;
		$this->mSuggestionSnippet = '';
		$this->parseSuggestion($suggestion);
		$this->mInfo              = $info;
		$this->mInterwiki         = $interwiki;
	}
	
	/** Get suggestions from a suggestion result line */
	function parseSuggestion($suggestion){
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
	
	/** replace prefixes like [2]: that are not in phrases */
	function replaceGenericPrefixes($text){
		$out = "";
		$phrases = explode('"',$text);
		for($i=0;$i<count($phrases);$i+=2){
			$out .= preg_replace_callback('/\[([0-9]+)\]:/', array($this,'genericPrefixCallback'), $phrases[$i]);
			if($i+1 < count($phrases))
				$out .= '"'.$phrases[$i+1].'"'; // phrase text	
		}
		return $out;
	}
	
	function genericPrefixCallback($matches){
		global $wgContLang;
		return $wgContLang->getFormattedNsText($matches[1]).":";
	}
	
	function numRows() {
		return $this->mResultCount;
	}
	
	function termMatches() {		
		$resq = preg_replace( "/\\[.*?\\]:/", " ", $this->mQuery ); # generic prefixes
		$resq = preg_replace( "/all:/", " ", $resq ); 
		
		// Fixme: this is ripped from SearchMySQL and probably kind of sucks,
		// but it handles quoted phrase searches more or less correctly.
		// Should encapsulate this stuff better.
		
		// FIXME: This doesn't handle parenthetical expressions.
		$regexes = array();
		$m = array();
		$lc = SearchEngine::legalSearchChars();
		if( preg_match_all( '/([-+<>~]?)(([' . $lc . ']+)(\*?)|"[^"]*")/',
			  $resq, $m, PREG_SET_ORDER ) ) {
			foreach( $m as $terms ) {
				if( !empty( $terms[3] ) ) {
					// Match individual terms in result highlighting...
					$regexp = preg_quote( $terms[3], '/' );
					if( $terms[4] ) $regexp .= "[0-9A-Za-z_]+";
				} else {
					// Match the quoted term in result highlighting...
					$regexp = preg_quote( str_replace( '"', '', $terms[2] ), '/' );
				}
				$regexes[] = $regexp;
			}
			wfDebug( __METHOD__ . ': Match with /' . implode( '|', $regexes ) . "/\n" );
		} else {
			wfDebug( "Can't understand search query '{$resq}'\n" );
		}
		return $regexes;
	}
	
	/**
	 * Stupid hack around PHP's limited lambda support
	 * @access private
	 */
	function regexQuote( $term ) {
		return preg_quote( $term, '/' );
	}
	
	function hasResults() {
		return count( $this->mResults ) > 0;
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
	
	/**
	 * Return information about how and from where the results were fetched,
	 * should be useful for diagnostics and debugging 
	 *
	 * @return string
	 */
	function getInfo() {
		if( is_null($this->mInfo) )
			return null;
		return "Search results fetched via ".$this->mInfo;
	}
	
	/**
	 * Return a result set of hits on other (multiple) wikis associated with this one
	 *
	 * @return SearchResultSet
	 */
	function getInterwikiResults() {
		return $this->mInterwiki;
	}
	
	/**
	 * Some search modes return a suggested alternate term if there are
	 * no exact hits. Returns true if there is one on this set.
	 *
	 * @return bool
	 * @access public
	 */
	function hasSuggestion() {
		return is_string( $this->mSuggestionQuery ) && $this->mSuggestionQuery != '';
	}
	
	function getSuggestionQuery(){
		return $this->mSuggestionQuery;
	}
	
	function getSuggestionSnippet(){
		return $this->mSuggestionSnippet;
	}
	
	/**
	 * Fetches next search result, or false.
	 * @return LuceneResult
	 * @access public
	 * @abstract
	 */
	function next() {			
	 	# Group together lines belonging to one hit
		$group = array();
		
		for(;$this->mPos < count($this->mResults);$this->mPos++){
			$l = trim($this->mResults[$this->mPos]);
			if(count($group) == 0) // main line
				$group['result'] = $l;
			else if($l[0] == '#'){ // additional meta
				list($meta,$value) = explode(" ",$l,2);				
				$group[$meta][] = $value; 
			} else
				break;	
		}
		if($group == false)
			return false;
		else
			return new LuceneResult( $group, $this->mMethod );
	}
	
}
