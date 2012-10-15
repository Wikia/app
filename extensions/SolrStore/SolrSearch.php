<?php
/**
 * File holding the SolrSearch class
 *
 * @ingroup SolrStore
 * @file
 * @author Simon Bachenberg
 */

/**
 * TODO: Insert class description
 *
 * @ingroup SolrStore
 */
class SolrSearch extends SearchEngine {

	var $limit = 10;
	var $offset = 0;
	var $prefix = '';
	var $searchTerms = array();
	var $namespaces = array( NS_MAIN );
	var $showRedirects = false;
	var $solrTalker;

	function __construct( $db = null ) {
		global $wgSolrTalker;
	}

	/**
	 * Perform a full text search query and return a result set.
	 * If title searches are not supported or disabled, return null.
	 *
	 * @param string $term - Raw search term
	 * @return SolrSearchSet
	 */
	public function searchText( $term ) {
		return SolrSearchSet::newFromQuery(
			isset( $this->related ) ? 'related' : 'search',
			$term,
			$this->namespaces,
			$this->limit,
			$this->offset,
			$this->searchingEverything()
		);
	}

	/**
	 * Perform a title-only search query and return a result set.
	 *
	 * @param string $term - Raw search term
	 * @return SolrSearchSet
	 */
	public function searchTitle( $term ) {
		return null;
	}

	/**
	 * PrefixSearchBackend override for OpenSearch results
	 */
	static function prefixSearch( $ns, $search, $limit, &$results ) {
		echo 'Prefix Search!<br />'; // @todo Is this a debug line? Certainly looks like one...if so, comment out/remove!
		$it = SolrSearchSet::newFromQuery( 'prefix', $search, $ns, $limit, 0 );
		$results = array();
		if ( $it ) { // $it can be null
			while ( $res = $it->next() ) {
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
	function searchingEverything() {
		return $this->namespaces == array_keys( SearchEngine::searchableNamespaces() );
	}

	/**
	 * Prepare query for the Solr-search daemon:
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
		global $wgContLang, $wgSolrUseRelated;

		wfProfileIn( __METHOD__ );
		$start = 0;
		$len = 0; // token start pos and length
		$rewritten = ''; // rewritten query
		$rindex = 0; // point to last rewritten character
		$inquotes = false;

		// "search everything" keyword
		$allkeyword = wfMsgForContent( 'searchall' );

		$qlen = strlen( $query );

		// quick check, most of the time we don't need any rewriting
		if ( strpos( $query, ':' ) === false ) {
			wfProfileOut( __METHOD__ );
			return $query;
		}

		// check if this is query for related articles
		$relatedkey = wfMsgForContent( 'searchrelated' ) . ':';
		if ( $wgSolrUseRelated && strncmp( $query, $relatedkey, strlen( $relatedkey ) ) == 0 ) {
			$this->related = true;
			list( $dummy, $ret ) = explode( ':', $query, 2 );
			wfProfileOut( __METHOD__ );
			return trim( $ret );
		}

		global $wgCanonicalNamespaceNames, $wgNamespaceAliases;
		$nsNamesRaw = array_merge(
			$wgContLang->getNamespaces(),
			$wgCanonicalNamespaceNames,
			array_keys( array_merge( $wgNamespaceAliases, $wgContLang->getNamespaceAliases() ) )
		);

		# add all namespace names w/o spaces
		$nsNames = array();
		foreach ( $nsNamesRaw as $ns ) {
			if ( $ns != '' ) {
				$nsNames[] = $ns;
				$nsNames[] = str_replace( '_', ' ', $ns );
			}
		}

		$regexp = implode( '|', array_unique( $nsNames ) );

		# rewrite the query by replacing valid namespace names
		$parts = preg_split( '/(")/', $query, -1, PREG_SPLIT_DELIM_CAPTURE );
		$inquotes = false;
		$rewritten = '';
		foreach ( $parts as $part ) {
			if ( $part == '"' ) { # stuff in quote doesnt get rewritten
				$rewritten .= $part;
				$inquotes = !$inquotes;
			} elseif ( $inquotes ) {
				$rewritten .= $part;
			} else {
				# replace namespaces
				$r = preg_replace_callback( '/(^|[| :])(' . $regexp . '):/i', array( $this, 'replaceNamespace' ), $part );
				# replace to backend all: notation
				$rewritten .= str_replace( $allkeyword . ':', 'all:', $r );
			}
		}

		wfProfileOut( __METHOD__ );
		return $rewritten;
	}

	/** callback to replace namespace names to internal notation, e.g. User: -> [2]: */
	function replaceNamespace( $matches ) {
		global $wgContLang;
		$inx = $wgContLang->getNsIndex( str_replace( ' ', '_', $matches[2] ) );
		if ( $inx === false ) {
			return $matches[0];
		} else {
			return $matches[1] . "[$inx]:";
		}
	}

	function acceptListRedirects() {
		return false;
	}

	/** Merge the prefix into the query (if any) */
	function transformSearchTerm( $term ) {
		global $wgSolrSearchVersion;

		if ( $wgSolrSearchVersion >= 2.1 && $this->prefix != '' ) {
			# convert to internal backend prefix notation
			$term = $term . ' prefix:' . $this->prefix;
		}

		return $term;
	}

}

class SolrResult extends SearchResult {

	/**
	 * Construct a result object from single result line
	 *
	 * @param array $lines
	 * @param string $method - method used to fetch these results
	 * @return array (float, Title)
	 * @access private
	 */
	function isMissingRevision() {
		return false;
	}

	function SolrResult( $result, $method ) {
		global $wgContLang;

		$score = null;
		$interwiki = null;
		$namespace = null;
		$title = null;

		$xml = $result;
		wfDebug( "Solr line: '$result'\n" );

		// Defining results

		$this->mDate = null;
		$score = $xml->float;
		$this->mScore = $score;

		// -------------------------------------
		// Get the shit out of the XML
		// -------------------------------------
		foreach ( $xml->arr as $doc ) {
			switch ( $doc['name'] ) {
				case 'text':
					$nsText = $doc->str;

					$this->mSize = '';
					$this->mWordCount = count( $doc->str );
					$snipmax = 10;
					$textsnip = '';
					$textsnipvar = 0;
					foreach ( $doc->str as $inner ) {
						$textsnipvar++;
						if ( $textsnipvar >= 4 && $textsnipvar <= $snipmax ) {
							$textsnip .= ' ' . $inner;
						}
						$this->mSize = $this->mSize + strlen( $inner );
					}
					$textsnip .= '...';
					$this->mSize = ( $this->mSize / 3 );
					// $this->mSize=$size;
					break;
				case 'Zuletzt geändert_dt':
					$this->mDate = $doc->date;
					break;
			}
		}

		foreach ( $xml->str as $docs ) {
			switch ( $docs['name'] ) {
				case 'pagetitle':
					$this->mTitle = $doc->str;
					break;
				case 'dbkey':
					$title = $doc->str;
					break;
				case 'interwiki':
					$this->mInterwiki = $doc->str;
					break;
			}
		}

		foreach ( $xml->int as $doci ) {
			switch ( $doci['name'] ) {
				case 'namespace':
					$namespace = $doc->str;
					break;
			}
		}

		$title = urldecode( $title );
		if ( !isset( $nsText ) ) {
			$nsText = $wgContLang->getNsText( $namespace );
		} else {
			$nsText = urldecode( $nsText );
		}

		// make title
		$this->mTitle = Title::makeTitle( $namespace, $title );

		// HIGHLIGHT
		// <em> & </em> Fix to <b> // if not, no highlighting!
		// TITLE (LINK)
		if ( $xml->highlight->title != '' ) {
			$this->mHighlightTitle = str_replace( '<em>', '<b>', $xml->highlight->title );
			$this->mHighlightTitle = str_replace( '</em>', '</b>', $this->mHighlightTitle );
		} else {
			$this->mHighlightTitle = '';
		}
		// TEXT (under link)
		// $this->mHighlightText=$xml->highlight->title;
		if ( $xml->highlight->Inhalt != '' ) {
			$this->mHighlightText = str_replace( '<em>', '<b>', $xml->highlight->Inhalt );
			$this->mHighlightText = str_replace( '</em>', '</b>', $this->mHighlightText );
			$this->mHighlightText .= '...';
		} else {// $this->mHighlightText=textsnip;
			if ( isset( $_REQUEST['search'] ) != '' && isset( $textsnip ) != '' ) {
				if ( strpos( strtolower( $textsnip ), strtolower( $_REQUEST['search'] ) ) ) {
					$tempc = strlen( $_REQUEST['search'] );
					$pos1 = strpos( strtolower( $textsnip ), strtolower( $_REQUEST['search'] ) );
					$tmpa = substr( $textsnip, 0, $pos1 );
					$tmpb = substr( $textsnip, ( $pos1 + $tempc ) );
					$this->mHighlightText = $tmpa . '<b>' . substr( $textsnip, $pos1, $tempc ) . '</b>' . $tmpb;
					// str_replace($_REQUEST['search'],"<b>".$_REQUEST['search']."</b>",$textsnip);
				} else {
					$this->mHighlightText = $textsnip;
				}
			} else {
				$this->mHighlightText = $textsnip;
			}
		}
		$this->mRedirectTitle = null;
		$this->mHighlightSection = null;
		$this->mSectionTitle = null;
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
	function extractSnippet( $lines, $nsText, $type, $useFinalSeparator = false ) {
		if ( !array_key_exists( $type, $lines ) ) {
			return array( null, null );
		}
		$ret = '';
		$original = null;
		foreach ( $lines[$type] as $h ) {
			list( $s, $o ) = $this->extractSnippetLine( $h, $useFinalSeparator );
			$ret .= $s;
			$original = $o;
		}
		if ( $nsText != '' ) {
			$ret = $nsText . ':' . $ret;
		}
		return array( $ret, $original );
	}

	/**
	 * Parse one line of a snippet
	 *
	 * @param string $line
	 * @param boolean $useFinalSeparator if "..." is to be appended to the end of snippet
	 * @access protected
	 * @return array(snippet,unmodified text)
	 */
	function extractSnippetLine( $line, $useFinalSeparator ) {
		$parts = explode( ' ', $line );
		if ( count( $parts ) != 4 && count( $parts ) != 5 ) {
			wfDebug( "Bad result line:" . $line . "\n" );
			return '';
		}
		$splits = $this->stripBracketsSplit( $parts[0] );
		$highlight = $this->stripBracketsSplit( $parts[1] );
		$suffix = urldecode( $this->stripBrackets( $parts[2] ) );
		$text = urldecode( $parts[3] );
		$original = null;
		if ( count( $parts ) > 4 ) {
			$original = urldecode( $parts[4] );
		}

		$splits[] = strlen( $text );
		$start = 0;
		$snippet = '';
		$hi = 0;
		$ellipsis = wfMsgForContent( 'ellipsis' );

		foreach ( $splits as $sp ) {
			$sp = intval( $sp );
			// highlight words!
			while ( $hi < count( $highlight ) && intval( $highlight[$hi] ) < $sp ) {
				$s = intval( $highlight[$hi] );
				$e = intval( $highlight[$hi + 1] );
				$snippet .= substr( $text, $start, $s - $start ) .
					'<span class="searchmatch">' . substr( $text, $s, $e - $s ) . '</span>';
				$start = $e;
				$hi += 2;
			}
			// copy till split point
			$snippet .= substr( $text, $start, $sp - $start );
			if ( $sp == strlen( $text ) && $suffix != '' ) {
				$snippet .= $suffix;
			} elseif ( $useFinalSeparator ) {
				$snippet .= ' <b>' . $ellipsis . '</b> ';
			}

			$start = $sp;
		}
		return array( $snippet, $original );
	}

	/**
	 * @access private
	 */
	function stripBrackets( $str ) {
		if ( $str == '[]' ) {
			return '';
		}
		return substr( $str, 1, strlen( $str ) - 2 );
	}

	/**
	 * @access private
	 * @return array
	 */
	function stripBracketsSplit( $str ) {
		$strip = $this->stripBrackets( $str );
		if ( $strip == '' ) {
			return array();
		} else {
			return explode( ',', $strip );
		}
	}

	function getTitle() {
		return $this->mTitle;
	}

	function getScore() {
		if ( is_null( $this->mScore ) ) {
			return null; // Solr scores are meaningless to the user...
		}

		return floatval( $this->mScore );
	}

	function getTitleSnippet( $terms ) {
		if ( is_null( $this->mHighlightTitle ) ) {
			return '';
		}
		return $this->mHighlightTitle;
	}

	function getTextSnippet( $terms ) {
		if ( is_null( $this->mHighlightText ) ) {
			return parent::getTextSnippet( $terms );
		}
		return $this->mHighlightText;
	}

	function getRedirectSnippet( $terms ) {
		/* if (isset($this->mHighlightRedirect))
		  if (is_null($this->mHighlightRedirect))
		  return '';
		  return $this->mHighlightRedirect;
		 */
		return null;
	}

	function getRedirectTitle() {
		return $this->mRedirectTitle;
	}

	function getSectionSnippet() {
		if ( is_null( $this->mHighlightSection ) ) {
			return null;
		}
		return $this->mHighlightSection;
	}

	function getSectionTitle() {
		if ( is_null( $this->mSectionTitle ) ) {
			return null;
		}
		return $this->mSectionTitle;
	}

	function getInterwikiPrefix() {
		return $this->mInterwiki;
	}

	function isInterwiki() {
		return $this->mInterwiki != '';
	}

	function getTimestamp() {
		if ( is_null( $this->mDate ) ) {
			return parent::getTimestamp();
		}
		return $this->mDate;
	}

	function getWordCount() {
		if ( is_null( $this->mWordCount ) ) {
			return parent::getWordCount();
		}
		return $this->mWordCount;
	}

	function getByteSize() {
		if ( is_null( $this->mSize ) ) {
			return parent::getByteSize();
		}
		return $this->mSize;
	}

	function hasRelated() {
		global $wgSolrSearchVersion, $wgSolrUseRelated;
		return $wgSolrSearchVersion >= 2.1 && $wgSolrUseRelated;
	}

}

class SolrSearchSet extends SearchResultSet {

	/**
	 * Contact the MWDaemon search server and return a wrapper
	 * object with the set of results. Results may be cached.
	 *
	 * @param $method String: the protocol verb to use
	 * @param $query String
	 * @param $limit Integer
	 * @param $offset Integer
	 * @param $searchAll Boolean
	 * @return array
	 */
	public static function newFromQuery( $method, $query, $namespaces = array(), $limit = 20, $offset = 0, $searchAll = false ) {
		wfProfileIn( __METHOD__ );

		$wgSolrTalker = new SolrTalker();

		$query = $wgSolrTalker->queryChecker( $query );
		$xml = $wgSolrTalker->solrQuery( $query, $offset, $limit, true, true ); // Abfrage ok, ergebniss in XML
		$totalHits = $xml->result['numFound'];

		$resultLines = array(); ;

		$highl = $xml->xpath( '//lst[@name="highlighting"]/lst' );

		$hli = 0;

		foreach ( $xml->result->doc as $doc ) {
			if ( isset( $highl[$hli]->arr ) ) {
				foreach ( $highl[$hli]->arr as $feld ) {
					if ( isset( $feld['name'] ) ) {
						switch ( $feld['name'] ) {
							case 'title':
								$doc[]->highlight->title = $feld->str;
								break;
							case 'Inhalt de_t':
								$doc[]->highlight->Inhalt = $feld->str;
								break;
						}
					}
				}
			}
			$hli++;
			$resultLines[] = $doc;
		}

		$suggestion = null;
		$info = null;
		$interwiki = null;

		$resultSet = new SolrSearchSet(
			$method, $query, $resultLines, count( $resultLines ), $totalHits,
			$suggestion, $info, $interwiki
		);

		wfProfileOut( __METHOD__ );
		return $resultSet;
	}

	static function startsWith( $source, $prefix ) {
		return strncmp( $source, $prefix, strlen( $prefix ) ) == 0;
	}

	/**
	 * Private constructor. Use SolrSearchSet::newFromQuery().
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
	function SolrSearchSet( $method, $query, $lines, $resultCount, $totalHits = null, $suggestion = null, $info = null, $interwiki = null ) {
		$this->mMethod = $method;
		$this->mQuery = $query;
		$this->mTotalHits = $totalHits;
		$this->mResults = $lines;
		$this->mResultCount = $resultCount;
		$this->mPos = 0;
		$this->mSuggestionQuery = null;
		$this->mSuggestionSnippet = '';
		$this->parseSuggestion( $suggestion );
		$this->mInfo = $info;
		$this->mInterwiki = $interwiki;
	}

	/** Get suggestions from a suggestion result line */
	function parseSuggestion( $suggestion ) {
		if ( is_null( $suggestion ) ) {
			return;
		}

		// parse split points and highlight changes
		list( $dummy, $points, $sug ) = explode( ' ', $suggestion );
		$sug = urldecode( $sug );
		$points = explode( ',', substr( $points, 1, -1 ) );
		array_unshift( $points, 0 );
		$suggestText = '';
		for ( $i = 1; $i < count( $points ); $i += 2 ) {
			$suggestText .= htmlspecialchars( substr( $sug, $points[$i - 1], $points[$i] - $points[$i - 1] ) );
			$suggestText .= '<em>' . htmlspecialchars( substr( $sug, $points[$i], $points[$i + 1] - $points[$i] ) ) . '</em>';
		}
		$suggestText .= htmlspecialchars( substr( $sug, end( $points ) ) );

		$this->mSuggestionQuery = $this->replaceGenericPrefixes( $sug );
		$this->mSuggestionSnippet = $this->replaceGenericPrefixes( $suggestText );
	}

	/** replace prefixes like [2]: that are not in phrases */
	function replaceGenericPrefixes( $text ) {
		$out = '';
		$phrases = explode( '"', $text );
		for ( $i = 0; $i < count( $phrases ); $i += 2 ) {
			$out .= preg_replace_callback(
				'/\[([0-9]+)\]:/',
				array( $this, 'genericPrefixCallback' ),
				$phrases[$i]
			);
			if ( $i + 1 < count( $phrases ) ) {
				$out .= '"' . $phrases[$i + 1] . '"'; // phrase text
			}
		}
		return $out;
	}

	function genericPrefixCallback( $matches ) {
		global $wgContLang;
		return $wgContLang->getFormattedNsText( $matches[1] ) . ':';
	}

	function numRows() {
		return $this->mResultCount;
	}

	function termMatches() {
		$resq = preg_replace( "/\\[.*?\\]:/", ' ', $this->mQuery ); # generic prefixes
		$resq = preg_replace( '/all:/', ' ', $resq );

		// @todo FIXME: this is ripped from SearchMySQL and probably kind of sucks,
		// but it handles quoted phrase searches more or less correctly.
		// Should encapsulate this stuff better.
		// @todo FIXME: This doesn't handle parenthetical expressions.
		$regexes = array();
		$m = array();
		$lc = SearchEngine::legalSearchChars();
		if ( preg_match_all( '/([-+<>~]?)(([' . $lc . ']+)(\*?)|"[^"]*")/', $resq, $m, PREG_SET_ORDER ) ) {
			foreach ( $m as $terms ) {
				if ( !empty( $terms[3] ) ) {
					// Match individual terms in result highlighting...
					$regexp = preg_quote( $terms[3], '/' );
					if ( $terms[4] ) {
						$regexp .= '[0-9A-Za-z_]+';
					}
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
	 */
	public function getTotalHits() {
		return $this->mTotalHits;
	}

	/**
	 * Return information about how and from where the results were fetched,
	 * should be useful for diagnostics and debugging
	 *
	 * @return string
	 */
	function getInfo() {
		if ( is_null( $this->mInfo ) ) {
			return null;
		}
		return 'Search results fetched via ' . $this->mInfo;
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
	 */
	public function hasSuggestion() {
		return is_string( $this->mSuggestionQuery ) && $this->mSuggestionQuery != '';
	}

	function getSuggestionQuery() {
		return $this->mSuggestionQuery;
	}

	function getSuggestionSnippet() {
		return $this->mSuggestionSnippet;
	}

	/**
	 * Fetches next search result, or false.
	 * @return SolrResult
	 * @abstract
	 */
	public function next() {
		if ( $this->mPos < $this->mResultCount ) {
			$this->mPos++;
			return new SolrResult( $this->mResults[$this->mPos - 1], $this->mMethod );
		} else {
			return null;
		}
	}

}
