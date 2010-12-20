<?php

class SpecialWikiaSearch extends SpecialSearch {

	private $searchLocalWikiOnly = false;
	private $searchLocalWikiOnlySession = 'WikiaSearch-localOnly';
	private $isHeaderOut = false;

	public function __construct( &$request, &$user ) {
		global $wgSessionStarted;
		wfLoadExtensionMessages( 'WikiaSearch' );

		if(empty($wgSessionStarted)) {
			// start session
			wfSetupSession();
			$wgSessionStarted = true;
		}

		if(($request->getVal('fulltext') == null) && (isset($_SESSION[$this->searchLocalWikiOnlySession]) && ($_SESSION[$this->searchLocalWikiOnlySession] == true))) {
			$this->searchLocalWikiOnly = true;
		}
		elseif($request->getVal('fulltext') != null) {
			if($request->getcheck( 'thisWikiOnly' )) {
				$this->searchLocalWikiOnly = true;
				$_SESSION[$this->searchLocalWikiOnlySession] = true;
			}
			else {
				$this->searchLocalWikiOnly = false;
				$_SESSION[$this->searchLocalWikiOnlySession] = false;
			}
		}

		parent::__construct( $request, $user );
	}

	/**
	 * remove "go" page functionality for cross-wikia searching
	 * @see includes/specials/SpecialSearchOld#goResult($term)
	 */
	function goResult( $term ) {
		if($this->searchLocalWikiOnly) {
			parent::goResult( $term );
		}
		else {
			$this->showResults( $term, '' );
		}
	}

	public function shortDialog( $term ) {
		global $wgScript;

		$out  = Xml::openElement( 'form', array( 'id' => 'search', 'method' => 'get', 'action' => $wgScript ));
		$searchTitle = SpecialPage::getTitleFor( 'Search' );
		$out .= Xml::input( 'search', 50, $term, array( 'type' => 'text', 'id' => 'searchText', 'class' => 'wikia_search_field' ) );

		foreach( SearchEngine::searchableNamespaces() as $ns => $name ) {
			if( in_array( $ns, $this->namespaces ) ) {
				$out .= Xml::hidden( "ns{$ns}", '1' );
			}
		}
		$out .= Xml::hidden( 'title', $searchTitle->getPrefixedText() );
		$out .= Xml::hidden( 'fulltext', 'Search' );
		$out .= Xml::submitButton( wfMsg( 'searchbutton' ), array( 'name' => 'fulltext', 'id' => 'searchButton' ) );
		$out .= Xml::closeElement( 'form' );

		$out .= <<<STOP
<script type="text/javascript">
//<![CDATA[
$("#searchButton").click(function() { WET.byStr('centralSearch/searchBtn/click/phrase/' + $("#searchText").val()); $("#search").submit(); } );
//]]>
</script>
STOP;

		return $out;
	}

	public function powerSearchBox( $term ) {
		global $wgScript, $wgContLang, $wgSitename;

		$namespaces = SearchEngine::searchableNamespaces();

		// group namespaces into rows according to subject; try not to make too
		// many assumptions about namespace numbering
		$rows = array();
		foreach( $namespaces as $ns => $name ) {
			$subj = MWNamespace::getSubject( $ns );
			if( !array_key_exists( $subj, $rows ) ) {
				$rows[$subj] = "";
			}
			$name = str_replace( '_', ' ', $name );
			if( '' == $name ) {
				$name = wfMsg( 'blanknamespace' );
			}
			$rows[$subj] .= Xml::openElement( 'td', array( 'style' => 'white-space: nowrap' ) ) .
					Xml::checkLabel( $name, "ns{$ns}", "mw-search-ns{$ns}", in_array( $ns, $this->namespaces ) ) .
					Xml::closeElement( 'td' ) . "\n";
		}
		$rows = array_values( $rows );
		$numRows = count( $rows );

		// lay out namespaces in multiple floating two-column tables so they'll
		// be arranged nicely while still accommodating different screen widths
		$rowsPerTable = 3;  // seems to look nice

		// float to the right on RTL wikis
		$tableStyle = ( $wgContLang->isRTL() ?
				'float: right; margin: 0 0 1em 1em' :
				'float: left; margin: 0 1em 1em 0' );

		$tables = "";
		for( $i = 0; $i < $numRows; $i += $rowsPerTable ) {
			$tables .= Xml::openElement( 'table', array( 'style' => $tableStyle ) );
			for( $j = $i; $j < $i + $rowsPerTable && $j < $numRows; $j++ ) {
				$tables .= "<tr>\n" . $rows[$j] . "</tr>";
			}
			$tables .= Xml::closeElement( 'table' ) . "\n";
		}

		$redirect = Xml::check( 'redirs', $this->searchRedirects, array( 'value' => '1', 'id' => 'redirs' ) );
		$redirectLabel = Xml::label( wfMsg( 'powersearch-redir' ), 'redirs' );
		$searchField = Xml::input( 'search', 50, $term, array( 'type' => 'text', 'id' => 'powerSearchText', 'class' => 'wikia_search_field' ) );
		$searchButton = Xml::submitButton( wfMsg( 'searchbutton' ), array( 'name' => 'fulltext', 'id' => 'powerSearchButton' ) ) . "\n";
		$searchTitle = SpecialPage::getTitleFor( 'Search' );
		$searchHiddens = Xml::hidden( 'title', $searchTitle->getPrefixedText() ) . "\n";
		$searchHiddens .= Xml::hidden( 'fulltext', 'Advanced search' ) . "\n";

		$extraRefinements = "<p>" . $redirect . " " . $redirectLabel . "</p>\n";
		wfRunHooks( 'SpecialSearchBoxExtraRefinements', array( &$extraRefinements ) );

		$out = Xml::openElement( 'form', array( 'id' => 'powersearch', 'method' => 'get', 'action' => $wgScript ) );
		$out.= $searchHiddens;
		$out.= $searchField;
		$out.= $searchButton;
		$out.= "<p style=\"clear: left;\" id=\"searchthiswikilabel\">" . Xml::checkLabel( wfMsg( 'wikiasearch-search-this-wiki', array( $wgSitename ) ), 'thisWikiOnly', 'thisWikiOnly', $this->searchLocalWikiOnly ) . "</p>";
		$out.= Xml::openElement( 'div', array( 'id' => 'powersearch-advanced', 'style' => ( $this->searchLocalWikiOnly ? 'display: block;' : 'display: none;' ) ) );
		$out.= Xml::fieldset( wfMsg( 'powersearch-legend' ),
				"<p>" . wfMsgExt( 'powersearch-ns', array( 'parseinline' ) ) . "</p>" .
				$tables .
				"<hr style=\"clear: both\" />" .
				$extraRefinements );
		$out.= Xml::closeElement( 'div' );
		$out.= Xml::closeElement ( 'form' );

		$out .= <<<STOP
<script type="text/javascript">
//<![CDATA[
$("#thisWikiOnly").click(function() { if(this.checked) { $("#powersearch-advanced").show(); } else { $("#powersearch-advanced").hide(); } } );
$("#powersearchButton").click(function() { WET.byStr('centralSearch/powerSearchBtn/click/phrase/' + $("#powerSearchText").val()); $("#powersearch").submit() } );
$("#thisWikiOnly").click(function() { WET.byStr('centralSearch/checkbox/searchLocally/state/' + $("#thisWikiOnly").is(":checked")); } );
//]]>
</script>
STOP;

		return $out;
	}

	public function setupPage( $term ) {
		global $wgOut, $wgSupressPageTitle, $wgSupressSiteNotice;
		if( !empty( $term ) ){
			$wgOut->setPageTitle( wfMsg( 'searchresults') );	//left for skins other than Monaco
			$wgSupressPageTitle = true;
			$wgSupressSiteNotice = true;
			$wgOut->setHTMLTitle( wfMsg( 'pagetitle', wfMsg( 'searchresults-title', $term) ) );
		}
		$wgSupressPageTitle = true;
		$wgSupressSiteNotice = true;
		//$subtitlemsg = ( Title::newFromText( $term ) ? 'searchsubtitle' : 'searchsubtitleinvalid' );
		//$wgOut->setSubtitle( $wgOut->parse( wfMsg( $subtitlemsg, wfEscapeWikiText($term) ) ) );
		$wgOut->setArticleRelated( false );
		$wgOut->setRobotPolicy( 'noindex,nofollow' );
		if(!$this->isHeaderOut) {
			$wgOut->addHTML('<div class="wikia_search_header dark_text_1">' . wfMsg( 'wikiasearch-search-wikia' ) . '</div>');
			$this->isHeaderOut = true;
		}
	}

	/**
	 * @param string $term
	 * @param string $extra Extra HTML to add after "did you mean"
	 */
	public function showResults( $term, $extra = '' ) {
		wfProfileIn( __METHOD__ );
		global $wgOut, $wgUser;
		$sk = $wgUser->getSkin();

		$search = SearchEngine::create();
		$search->setLimitOffset( $this->limit, $this->offset );
		$search->setNamespaces( $this->namespaces );
		$search->showRedirects = $this->searchRedirects;
		$search->prefix = $this->mPrefix;
		$term = $search->transformSearchTerm($term);

		$this->setupPage( $term );

		$rewritten = $search->replacePrefixes($term);
		$titleMatches = $search->searchTitle( $rewritten );
		$textMatches = $search->searchText( $rewritten );

		// Wikia change /Begin (ADi)
		if(($search instanceof SearchErrorReporting) && $search->getError()) {
			$wgOut->addWikiText( '==' . $search->getError() . '==' );
			$wgOut->addHTML( $search->getErrorTracker());
			$wgOut->addHTML( $this->powerSearchBox( $term ) );
			$wgOut->addHTML( $this->powerSearchFocus() );
			wfProfileOut( __METHOD__ );
			return;
		}
		// Wikia change /End (ADi)

		// did you mean... suggestions
		if($textMatches && $textMatches->hasSuggestion()){
			$st = SpecialPage::getTitleFor( 'Search' );

			# mirror Go/Search behaviour of original request
			$didYouMeanParams = array( 'search' => $textMatches->getSuggestionQuery() );
			if($this->fulltext != NULL)
				$didYouMeanParams['fulltext'] = $this->fulltext;
			$stParams = wfArrayToCGI(
				$didYouMeanParams,
				$this->powerSearchOptions()
			);

			$suggestLink = $sk->makeKnownLinkObj( $st,
				$textMatches->getSuggestionSnippet(),
				$stParams );

			$wgOut->addHTML('<div class="searchdidyoumean">'.wfMsg('search-suggest',$suggestLink).'</div>');
		}

		$wgOut->addHTML( $extra );

		//$wgOut->wrapWikiMsg( "<div class='mw-searchresult'>\n$1</div>", 'searchresulttext' );

		if( '' === trim( $term ) ) {
			// Empty query -- straight view of search form
			global $wgSupressPageTitle, $wgSupressSiteNotice;
			$wgSupressPageTitle = true;
			$wgSupressSiteNotice = true;
			$wgOut->setSubtitle( '' );
			$wgOut->addHTML( $this->powerSearchBox( $term ) );
			$wgOut->addHTML( $this->powerSearchFocus() );
			wfProfileOut( __METHOD__ );
			return;
		}

		global $wgDisableTextSearch;
		if ( $wgDisableTextSearch ) {
			global $wgSearchForwardUrl;
			if( $wgSearchForwardUrl ) {
				$url = str_replace( '$1', urlencode( $term ), $wgSearchForwardUrl );
				$wgOut->redirect( $url );
				wfProfileOut( __METHOD__ );
				return;
			}
			global $wgInputEncoding;
			$wgOut->addHTML(
				Xml::openElement( 'fieldset' ) .
				Xml::element( 'legend', null, wfMsg( 'search-external' ) ) .
				Xml::element( 'p', array( 'class' => 'mw-searchdisabled' ), wfMsg( 'searchdisabled' ) ) .
				wfMsg( 'googlesearch',
					htmlspecialchars( $term ),
					htmlspecialchars( $wgInputEncoding ),
					htmlspecialchars( wfMsg( 'searchbutton' ) )
				) .
				Xml::closeElement( 'fieldset' )
			);
			wfProfileOut( __METHOD__ );
			return;
		}

		//count number of results
		$num = ( $titleMatches ? $titleMatches->numRows() : 0 ) + ( $textMatches ? $textMatches->numRows() : 0);
		$totalNum = 0;
		if($titleMatches && !is_null($titleMatches->getTotalHits())) {
			$totalNum += $titleMatches->getTotalHits();
		}
		if($textMatches && !is_null($textMatches->getTotalHits())) {
			$totalNum += $textMatches->getTotalHits();
		}

		//show top search form
		if( $num > 0 ) {
			$wgOut->addHTML( $this->shortDialog( $term ) );
		}

		// Sometimes the search engine knows there are too many hits
		if ($titleMatches instanceof SearchResultTooMany) {
			$wgOut->addWikiText( '==' . wfMsg( 'toomanymatches' ) . "==\n" );
			$wgOut->addHTML( $this->powerSearchBox( $term ) );
			$wgOut->addHTML( $this->powerSearchFocus() );
			wfProfileOut( __METHOD__ );
			return;
		}

		// show number of results
		if ( $num > 0 ) {
			if ( $totalNum > 0 ){
				$top = wfMsgExt('showingresultstotal', array( 'parseinline' ),
					$this->offset+1, $this->offset+$num, $totalNum, $num );
			} elseif ( $num >= $this->limit ) {
				$top = wfShowingResults( $this->offset, $this->limit );
			} else {
				$top = wfShowingResultsNum( $this->offset, $this->limit, $num );
			}
			$wgOut->addHTML( "<p class='mw-search-numberresults' style='clear: left;'>{$top}</p>\n" );
		}

		// prev/next links
		if( $num || $this->offset ) {
			$prevnext = wfViewPrevNext( $this->offset, $this->limit,
				SpecialPage::getTitleFor( 'Search' ),
				wfArrayToCGI(
					$this->powerSearchOptions(),
					array( 'search' => $term, 'thisWikiOnly' => $this->searchLocalWikiOnly ? '1' : '0' ) ),
					($num < $this->limit) );
			//if ($showTopControls) $wgOut->addHTML( "<p class='mw-search-pager-top'>{$prevnext}</p>\n" );
			wfRunHooks( 'SpecialSearchResults', array( $term, &$titleMatches, &$textMatches ) );
		} else {
			wfRunHooks( 'SpecialSearchNoResults', array( $term ) );
		}

		if( $titleMatches ) {
			if( $titleMatches->numRows() ) {
				$wgOut->wrapWikiMsg( "==$1==\n", 'titlematches' );
				$wgOut->addHTML( $this->showMatches( $titleMatches ) );
			}
			$titleMatches->free();
		}

		if( $textMatches ) {
			// output appropriate heading
			if( $textMatches->numRows() ) {
				if($titleMatches)
					$wgOut->wrapWikiMsg( "==$1==\n", 'textmatches' );
				else // if no title matches the heading is redundant
					$wgOut->addHTML("<br/>");
			} elseif( $num == 0 ) {
				# Don't show the 'no text matches' if we received title matches
				$wgOut->addHTML( "<p style='clear: left;'>" );
				$wgOut->wrapWikiMsg( "==$1==\n", 'notextmatches' );
				$wgOut->addHTML( "</p>" );
			}
			// show interwiki results if any
			if( $textMatches->hasInterwikiResults() )
				$wgOut->addHTML( $this->showInterwiki( $textMatches->getInterwikiResults(), $term ));
			// show results
			if( $textMatches->numRows() )
				$wgOut->addHTML( $this->showMatches( $textMatches ) );

			$textMatches->free();
		}

		if ( $num == 0 ) {
			$wgOut->addWikiMsg( 'nonefound' );
		}
		if( $num || $this->offset ) {
			$wgOut->addHTML( "<p class='mw-search-pager-bottom'>{$prevnext}</p>\n" );
		}
		$wgOut->addHTML( $this->powerSearchBox( $term ) );
		wfProfileOut( __METHOD__ );
	}

	/**
	 * Show whole set of results
	 *
	 * @param SearchResultSet $matches
	 */
	function showMatches( &$matches ) {
		wfProfileIn( __METHOD__ );

		global $wgContLang;
		$terms = $wgContLang->convertForSearchResult( $matches->termMatches() );

		$out = "";

		$infoLine = $matches->getInfo();
		if( !is_null($infoLine) )
			$out .= "\n<!-- {$infoLine} -->\n";


		$off = $this->offset + 1;
		$out .= "<ul class='mw-search-results' style='margin-left: 0;'>\n";

		while( $result = $matches->next() ) {
			$out .= $this->showHit( $result, $terms );
		}
		$out .= "</ul>\n";

		$out .= <<<STOP
<script type="text/javascript">
//<![CDATA[
$(".mw-search-result-title").bind('click', function() { WET.byStr('centralSearch/result/click/title/'+this.title+'/url/'+this.href); } );
//]]>
</script>
STOP;

		// convert the whole thing to desired language variant
		global $wgContLang;
		$out = $wgContLang->convert( $out );
		wfProfileOut( __METHOD__ );
		return $out;
	}

}
