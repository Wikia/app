<?php

/**
 * Class file for the SphinxMWSearch extension
 *
 * http://www.mediawiki.org/wiki/Extension:SphinxSearch
 *
 * Released under GNU General Public License (see http://www.fsf.org/licenses/gpl.html)
 *
 * @file
 * @ingroup Extensions
 * @author Svemir Brkic <svemir@deveblog.com>
 */

class SphinxMWSearch extends SearchEngine {

	var $categories = array();
	var $exc_categories = array();
	var $db;
	var $sphinx_client = null;
	var $prefix_handlers = array(
		'intitle' => 'filterByTitle',
		'incategory' => 'filterByCategory',
		'prefix' => 'filterByPrefix',
	);

	/**
	 * Do not go to a near match if query prefixed with ~
	 *
	 * @param $searchterm String
	 * @return Title
	 */
	public static function getNearMatch( $searchterm ) {
		if ( $searchterm[ 0 ] === '~' ) {
			return null;
		} else {
			return parent::getNearMatch( $searchterm );
		}
	}

	/**
	 *  PrefixSearchBackend override for OpenSearch results
	 */
	static function prefixSearch( $namespaces, $term, $limit, &$results ) {
		$search_engine = new SphinxMWSearch( wfGetDB( DB_SLAVE ) );
		$search_engine->namespaces = $namespaces;
		$search_engine->setLimitOffset( $limit, 0 );
		$result_set = $search_engine->searchText( '@page_title: ^' . $term . '*' );
		$results = array();
		if ( $result_set ) {
			while ( $res = $result_set->next() ) {
				$results[ ] = $res->getTitle()->getPrefixedText();
			}
		}
		return false;
	}

	/**
	 * Perform a full text search query and return a result set.
	 *
	 * @param string $term - Raw search term
	 * @return SphinxMWSearchResultSet
	 * @access public
	 */
	function searchText( $term ) {
		global $wgSphinxSearch_index_list;

		if ( !$this->sphinx_client ) {
			$this->sphinx_client = $this->prepareSphinxClient( $term );
		}

		if ( $this->sphinx_client ) {
			$this->searchTerms = $term;
			$escape = '/';
			$delims = array(
				'(' => ')',
				'[' => ']',
				'"' => '',
			);
			// temporarily replace already escaped characters
			$placeholders = array(
				'\\(' => '_PLC_O_PAR_',
				'\\)' => '_PLC_C_PAR_',
				'\\[' => '_PLC_O_BRA_',
				'\\]' => '_PLC_C_BRA_',
				'\\"' => '_PLC_QUOTE_',
			);
			$term = str_replace(array_keys($placeholders), $placeholders, $term);
			foreach ($delims as $open => $close) {
				$open_cnt = substr_count( $term, $open );
				if ($close) {
					// if counts do not match, escape them all
					$close_cnt = substr_count( $term, $close );
					if ($open_cnt != $close_cnt) {
						$escape .= $open . $close;
					}
				} elseif ($open_cnt % 2 == 1) {
					// if there is no closing symbol, count should be even
					$escape .= $open;
				}
			}
			$term = str_replace($placeholders, array_keys($placeholders), $term);
			$term = addcslashes( $term, $escape );
			wfDebug( "SphinxSearch query: $term\n" );
			$resultSet = $this->sphinx_client->Query(
				$term,
				$wgSphinxSearch_index_list
			);
		} else {
			$resultSet = false;
		}

		if ( $resultSet === false ) {
			return null;
		} else {
			return new SphinxMWSearchResultSet( $resultSet, $term, $this->sphinx_client, $this->db );
		}
	}

	/**
	 * @return SphinxClient: ready to run or false if term is empty
	 */
	function prepareSphinxClient( &$term ) {
		global $wgSphinxSearch_sortmode, $wgSphinxSearch_sortby, $wgSphinxSearch_host,
			$wgSphinxSearch_port, $wgSphinxSearch_index_weights,
			$wgSphinxSearch_mode, $wgSphinxSearch_maxmatches,
			$wgSphinxSearch_cutoff, $wgSphinxSearch_weights;

		// don't do anything for blank searches
		if ( trim( $term ) === '' ) {
			return false;
		}

		wfRunHooks( 'SphinxSearchBeforeResults', array(
			&$term,
			&$this->offset,
			&$this->namespaces,
			&$this->categories,
			&$this->exc_categories
		) );

		$cl = new SphinxClient();

		$cl->SetServer( $wgSphinxSearch_host, $wgSphinxSearch_port );
		if ( $wgSphinxSearch_weights && count( $wgSphinxSearch_weights ) ) {
			$cl->SetFieldWeights( $wgSphinxSearch_weights );
		}
		if ( is_array( $wgSphinxSearch_index_weights ) ) {
			$cl->SetIndexWeights( $wgSphinxSearch_index_weights );
		}
		if ( $wgSphinxSearch_mode ) {
			$cl->SetMatchMode( $wgSphinxSearch_mode );
		}
		if ( $this->namespaces && count( $this->namespaces ) ) {
			$cl->SetFilter( 'page_namespace', $this->namespaces );
		}
		if( !$this->showRedirects ) {
			$cl->SetFilter( 'page_is_redirect', array( 0 ) );
		}
		if ( $this->categories && count( $this->categories ) ) {
			$cl->SetFilter( 'category', $this->categories );
			wfDebug( "SphinxSearch included categories: " . join( ', ', $this->categories ) . "\n" );
		}
		if ( $this->exc_categories && count( $this->exc_categories ) ) {
			$cl->SetFilter( 'category', $this->exc_categories, true );
			wfDebug( "SphinxSearch excluded categories: " . join( ', ', $this->exc_categories ) . "\n" );
		}
		$cl->SetSortMode( $wgSphinxSearch_sortmode, $wgSphinxSearch_sortby );
		$cl->SetLimits(
			$this->offset,
			$this->limit,
			$wgSphinxSearch_maxmatches,
			$wgSphinxSearch_cutoff
		);

		wfRunHooks( 'SphinxSearchBeforeQuery', array( &$term, &$cl ) );

		return $cl;
	}

	/**
	 * Find snippet highlight settings for a given user
	 *
	 * @param $user User
	 * @return Array contextlines, contextchars
	 */
	public static function userHighlightPrefs( &$user ) {
		$contextlines = $user->getOption( 'contextlines', 2 );
		$contextchars = $user->getOption( 'contextchars', 75 );
		return array( $contextlines, $contextchars );
	}

	/**
	 * Prepare query for sphinx search daemon
	 *
	 * @param string $query
	 * @return string rewritten query
	 */
	function replacePrefixes( $query ) {
		if ( trim( $query ) === '' ) {
			return $query;
		}

		// ~ prefix is used to avoid near-term search, remove it now
		if ( $query[ 0 ] === '~' ) {
			$query = substr( $query, 1 );
		}

		$parts = preg_split( '/(")/', $query, -1, PREG_SPLIT_DELIM_CAPTURE );
		$inquotes = false;
		$rewritten = '';
		foreach ( $parts as $key => $part ) {
			if ( $part == '"' ) { // stuff in quotes doesn't get rewritten
				$rewritten .= $part;
				$inquotes = !$inquotes;
			} elseif ( $inquotes ) {
				$rewritten .= $part;
			} else {
				if ( strpos( $query, ':' ) !== false ) {
					$regexp = $this->preparePrefixRegexp();
					$part = preg_replace_callback(
						'/(^|[| :]|-)(' . $regexp . '):([^ ]+)/i',
						array( $this, 'replaceQueryPrefix' ),
						$part
					);
				}
				$rewritten .= str_replace(
					array( ' OR ', ' AND ' ),
					array( ' | ', ' & ' ),
					$part
				);
			}
		}
		return $rewritten;
	}

	/**
	 * @return string Regexp to match namespaces and other prefixes
	 */
	function preparePrefixRegexp() {
		global $wgContLang, $wgCanonicalNamespaceNames, $wgNamespaceAliases;

		// "search everything" keyword
		$allkeyword = wfMsgForContent( 'searchall' );
		$this->prefix_handlers[ $allkeyword ] = 'searchAllNamespaces';

		$all_prefixes = array_merge(
			$wgContLang->getNamespaces(),
			$wgCanonicalNamespaceNames,
			array_keys( array_merge( $wgNamespaceAliases, $wgContLang->getNamespaceAliases() ) ),
			array_keys( $this->prefix_handlers )
		);

		$regexp_prefixes = array();
		foreach ( $all_prefixes as $prefix ) {
			if ( $prefix != '' ) {
				$regexp_prefixes[] = preg_quote( str_replace( ' ', '_', $prefix ), '/' );
			}
		}

		return implode( '|', array_unique( $regexp_prefixes ) );
	}

	/**
	 * preg callback to process foo: prefixes in the query
	 * 
	 * @param array $matches
	 * @return string
	 */
	function replaceQueryPrefix( $matches ) {
		if ( isset( $this->prefix_handlers[ $matches[ 2 ] ] ) ) {
			$callback = $this->prefix_handlers[ $matches[ 2 ] ];
			return $this->$callback( $matches );
		} else {
			return $this->filterByNamespace( $matches );
		}
	}

	function filterByNamespace( $matches ) {
		global $wgContLang;
		$inx = $wgContLang->getNsIndex( str_replace( ' ', '_', $matches[ 2 ] ) );
		if ( $inx === false ) {
			return $matches[ 0 ];
		} else {
			$this->namespaces[] = $inx;
			return $matches[ 3 ];
		}
	}

	function searchAllNamespaces( $matches ) {
		$this->namespaces = null;
		return $matches[ 3 ];
	}

	function filterByTitle( $matches ) {
		return '@page_title ' . $matches[ 3 ];
	}

	function filterByPrefix( $matches ) {
		$prefix = $matches[ 3 ];
		if ( strpos( $matches[ 3 ], ':' ) !== false ) {
			global $wgContLang;
			list( $ns, $prefix ) = explode( ':', $matches[ 3 ] );
			$inx = $wgContLang->getNsIndex( str_replace( ' ', '_', $ns ) );
			if ( $inx !== false ) {
				$this->namespaces = array( $inx );
			}
		}
		return '@page_title ^' . $prefix . '*';
	}

	function filterByCategory( $matches ) {
		$page_id = $this->db->selectField( 'page', 'page_id',
			array(
				'page_title' => $matches[ 3 ],
				'page_namespace' => NS_CATEGORY
			),
			__METHOD__
		);
		$category = intval( $page_id );
		if ( $matches[ 1 ] === '-' ) {
			$this->exc_categories[ ] = $category;
		} else {
			$this->categories[ ] = $category;
		}
		return '';
	}

}

class SphinxMWSearchResultSet extends SearchResultSet {

	var $mNdx = 0;
	var $sphinx_client;
	var $mSuggestion = '';
	var $db;
	var $total_hits = 0;

	function __construct( $resultSet, $terms, $sphinx_client, $dbr ) {
		global $wgSearchHighlightBoundaries;

		$this->sphinx_client = $sphinx_client;
		$this->mResultSet = array();
		$this->db = $dbr ? $dbr : wfGetDB( DB_SLAVE );
		if ( is_array( $resultSet ) && isset( $resultSet['matches'] ) ) {
			$this->total_hits = $resultSet[ 'total_found' ];
			foreach ( $resultSet['matches'] as $id => $docinfo ) {
				$res = $this->db->select(
					'page',
					array( 'page_id', 'page_title', 'page_namespace' ),
					array( 'page_id' => $id ),
					__METHOD__,
					array()
				);
				if ( $this->db->numRows( $res ) > 0 ) {
					$this->mResultSet[] = $this->db->fetchObject( $res );
				}
			}
		}
		$this->mNdx = 0;
		$this->mTerms = preg_split( "/$wgSearchHighlightBoundaries+/ui", $terms );
	}

	/**
	 * Some search modes return a suggested alternate term if there are
	 * no exact hits. Returns true if there is one on this set.
	 *
	 * @return Boolean
	 */
	function hasSuggestion() {
		global $wgSphinxSuggestMode;

		if ( $wgSphinxSuggestMode ) {
			$this->mSuggestion = '';
			if ( $wgSphinxSuggestMode === 'enchant' ) {
				$this->suggestWithEnchant();
			} elseif ( $wgSphinxSuggestMode === 'soundex' ) {
				$this->suggestWithSoundex();
			} elseif ( $wgSphinxSuggestMode === 'aspell' ) {
				$this->suggestWithAspell();
			}
			if ($this->mSuggestion) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Wiki-specific search suggestions using enchant library.
	 * Use SphinxSearch_setup.php to create the dictionary
	 */
	function suggestWithEnchant() {
		if (!function_exists('enchant_broker_init')) {
			return;
		}
		$broker = enchant_broker_init();
		enchant_broker_set_dict_path($broker, ENCHANT_MYSPELL, dirname( __FILE__ ));
		if ( enchant_broker_dict_exists( $broker, 'sphinx' ) ) {
			$dict = enchant_broker_request_dict( $broker, 'sphinx' );
			$suggestion_found = false;
			$full_suggestion = '';
			foreach ( $this->mTerms as $word ) {
				if ( !enchant_dict_check($dict, $word) ) {
					$suggestions = enchant_dict_suggest($dict, $word);
					while ( count( $suggestions ) ) {
						$candidate = array_shift( $suggestions );
						if ( strtolower($candidate) != strtolower($word) ) {
							$word = $candidate;
							$suggestion_found = true;
							break;
						}
					}
				}
				$full_suggestion .= $word . ' ';
			}
			enchant_broker_free_dict( $dict );
			if ($suggestion_found) {
				$this->mSuggestion = trim( $full_suggestion );
			}
		}
		enchant_broker_free( $broker );
	}

	/**
	 * Default (weak) suggestions implementation relies on MySQL soundex
	 */
	function suggestWithSoundex() {
		$joined_terms = $this->db->addQuotes( join( ' ', $this->mTerms ) );
		$res = $this->db->select(
			array( 'page' ),
			array( 'page_title' ),
			array(
				"page_title SOUNDS LIKE " . $joined_terms,
				// avoid (re)recommending the search string
				"page_title NOT LIKE " . $joined_terms
			),
			__METHOD__,
			array(
				'ORDER BY' => 'page_counter desc',
				'LIMIT' => 1
			)
		);
		$suggestion = $this->db->fetchObject( $res );
		if ( is_object( $suggestion ) ) {
			$this->mSuggestion = trim( $suggestion->page_title );
		}
	}

	function suggestWithAspell() {
		global $wgLanguageCode, $wgSphinxSearchPersonalDictionary, $wgSphinxSearchAspellPath;

		// aspell will only return mis-spelled words, so remember all here
		$words = $this->mTerms;
		$word_suggestions = array();
		foreach ( $words as $word ) {
			$word_suggestions[ $word ] = $word;
		}

		// prepare the system call with optional dictionary
		$aspellcommand = 'echo ' . escapeshellarg( join( ' ', $words ) ) .
			' | ' . escapeshellarg( $wgSphinxSearchAspellPath ) .
			' -a --ignore-accents --ignore-case --lang=' . $wgLanguageCode;
		if ( $wgSphinxSearchPersonalDictionary ) {
			$aspellcommand .= ' --home-dir=' . dirname( $wgSphinxSearchPersonalDictionary );
			$aspellcommand .= ' -p ' . basename( $wgSphinxSearchPersonalDictionary );
		}

		// run aspell
		$shell_return = shell_exec( $aspellcommand );

		// parse return line by line
		$returnarray = explode( "\n", $shell_return );
		$suggestion_needed = false;
		foreach ( $returnarray as $key => $value ) {
			// lines with suggestions start with &
			if ( $value[0] === '&' ) {
				$correction = explode( ' ', $value );
				$word = $correction[ 1 ];
				$suggestions = substr( $value, strpos( $value, ':' ) + 2 );
				$suggestions = explode( ', ', $suggestions );
				if ( count( $suggestions ) ) {
					$guess = array_shift( $suggestions );
					if ( strtolower( $word ) != strtolower( $guess ) ) {
						$word_suggestions[ $word ] = $guess;
						$suggestion_needed = true;
					}
				}
			}
		}

		if ( $suggestion_needed ) {
			$this->mSuggestion = join( ' ', $word_suggestions );
		}
	}

	/**
	 * @return String: suggested query, null if none
	 */
	function getSuggestionQuery(){
		return $this->mSuggestion;
	}

	/**
	 * @return String: HTML highlighted suggested query, '' if none
	 */
	function getSuggestionSnippet(){
		return $this->mSuggestion;
	}

	/**
	 * @return Array: search terms
	 */
	function termMatches() {
		return $this->mTerms;
	}

	/**
	 * @return Integer: number of results
	 */
	function numRows() {
		return count( $this->mResultSet );
	}

	/**
	 * Some search modes return a total hit count for the query
	 * in the entire article database. This may include pages
	 * in namespaces that would not be matched on the given
	 * settings.
	 *
	 * Return null if no total hits number is supported.
	 *
	 * @return Integer
	 */
	function getTotalHits() {
		return $this->total_hits;
	}

	/**
	 * Return information about how and from where the results were fetched.
	 *
	 * @return string
	 */
	function getInfo() {
		return wfMsg( 'sphinxPowered', "http://www.sphinxsearch.com" );
	}

	/**
	 * @return SphinxMWSearchResult: next result, false if none
	 */
	function next() {
		if ( isset( $this->mResultSet[$this->mNdx] ) ) {
			$row = $this->mResultSet[$this->mNdx];
			++$this->mNdx;
			return new SphinxMWSearchResult( $row, $this->sphinx_client );
		} else {
			return false;
		}
	}

	function free() {
		unset( $this->mResultSet );
	}

}

class SphinxMWSearchResult extends SearchResult {

	var $sphinx_client = null;

	function __construct( $row, $sphinx_client ) {
		$this->sphinx_client = $sphinx_client;
		parent::__construct( $row );
	}

	/**
	 * Emulates SearchEngine getTextSnippet so that we can use our own userHighlightPrefs
	 * (only needed until userHighlightPrefs in SearchEngine is fixed)
	 *
	 * @param $terms array of terms to highlight
	 * @return string highlighted text snippet
	 */
	function getTextSnippet( $terms ) {
		global $wgUser, $wgAdvancedSearchHighlighting;
		global $wgSphinxSearchMWHighlighter, $wgSphinxSearch_index;

		$this->initText();
		list( $contextlines, $contextchars ) = SphinxMWSearch::userHighlightPrefs( $wgUser );
		if ( $wgSphinxSearchMWHighlighter ) {
			$h = new SearchHighlighter();
			if ( $wgAdvancedSearchHighlighting ) {
				return $h->highlightText( $this->mText, $terms, $contextlines, $contextchars );
			} else {
				return $h->highlightSimple( $this->mText, $terms, $contextlines, $contextchars );
			}
		}

		$excerpts_opt = array(
			"before_match" => "(searchmatch)",
			"after_match" => "(/searchmatch)",
			"chunk_separator" => " ... ",
			"limit" => $contextlines * $contextchars,
			"around" => $contextchars,
		);

		$excerpts = $this->sphinx_client->BuildExcerpts(
			array( $this->mText ),
			$wgSphinxSearch_index,
			join( ' ', $terms ),
			$excerpts_opt
		);

		if ( is_array( $excerpts ) ) {
			$ret = '';
			foreach ( $excerpts as $entry ) {
				// remove some wiki markup
				$entry = preg_replace(
					'/([\[\]\{\}\*\#\|\!]+|==+|<br ?\/?>)/',
					' ',
					$entry
				);
				$entry = str_replace(
					array("<", ">"),
					array("&lt;", "&gt;"),
					$entry
				);
				$entry = str_replace(
					array( "(searchmatch)", "(/searchmatch)" ),
					array( "<span class='searchmatch'>", "</span>" ),
					$entry
				);
				$ret .= "<div style='margin: 0.2em 1em 0.2em 1em;'>$entry</div>\n";
			}
		} else {
			$ret = wfMsg( 'internalerror_info', $this->sphinx_client->GetLastError() );
		}
		return $ret;
	}

}
