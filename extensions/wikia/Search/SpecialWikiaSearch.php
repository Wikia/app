<?php

class SpecialWikiaSearch extends SpecialSearchOld {

	private $searchLocalWikiOnly = false;

	public function __construct( &$request, &$user ) {
		$this->searchLocalWikiOnly = $request->getcheck( 'thisWikiOnly' ) ? true : false;

		parent::__construct( $request, $user );
	}

	public function shortDialog( $term ) {
		// no change required at the moment
		return parent::shortDialog( $term );
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
		$searchField = Xml::input( 'search', 50, $term, array( 'type' => 'text', 'id' => 'powerSearchText' ) );
		$searchButton = Xml::submitButton( wfMsg( 'powersearch' ), array( 'name' => 'fulltext' ) ) . "\n";
		$searchTitle = SpecialPage::getTitleFor( 'Search' );
		$searchHiddens = Xml::hidden( 'title', $searchTitle->getPrefixedText() ) . "\n";
		$searchHiddens .= Xml::hidden( 'fulltext', 'Advanced search' ) . "\n";

		$extraRefinements = "<p>" . $redirect . " " . $redirectLabel . "</p>\n";
		wfRunHooks( 'SpecialSearchBoxExtraRefinements', array( &$extraRefinements ) );

		$out = "<br />";
		$out.= Xml::openElement( 'form', array(	'id' => 'powersearch', 'method' => 'get', 'action' => $wgScript ) );
		$out.= $searchHiddens;
		$out.= $searchField . "&nbsp;" . $searchButton;
		$out.= "<p>" . Xml::checkLabel( wfMsg( 'wikiasearch-search-this-wiki', array( $wgSitename ) ), 'thisWikiOnly', 'thisWikiOnly', $this->searchLocalWikiOnly ) . "</p>";
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
//]]>
</script>
STOP;

		return $out;
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

		$wgOut->addHTML( $this->shortDialog( $term ) );

		// Sometimes the search engine knows there are too many hits
		if ($titleMatches instanceof SearchResultTooMany) {
			$wgOut->addWikiText( '==' . wfMsg( 'toomanymatches' ) . "==\n" );
			$wgOut->addHTML( $this->powerSearchBox( $term ) );
			$wgOut->addHTML( $this->powerSearchFocus() );
			wfProfileOut( __METHOD__ );
			return;
		}

		// show number of results
		$num = ( $titleMatches ? $titleMatches->numRows() : 0 )
			+ ( $textMatches ? $textMatches->numRows() : 0);
		$totalNum = 0;
		if($titleMatches && !is_null($titleMatches->getTotalHits()))
			$totalNum += $titleMatches->getTotalHits();
		if($textMatches && !is_null($textMatches->getTotalHits()))
			$totalNum += $textMatches->getTotalHits();

			if ( $num > 0 ) {
			if ( $totalNum > 0 ){
				$top = wfMsgExt('showingresultstotal', array( 'parseinline' ),
					$this->offset+1, $this->offset+$num, $totalNum, $num );
			} elseif ( $num >= $this->limit ) {
				$top = wfShowingResults( $this->offset, $this->limit );
			} else {
				$top = wfShowingResultsNum( $this->offset, $this->limit, $num );
			}
			$wgOut->addHTML( "<p class='mw-search-numberresults'>{$top}</p>\n" );
		}

		// prev/next links
		if( $num || $this->offset ) {
			$prevnext = wfViewPrevNext( $this->offset, $this->limit,
				SpecialPage::getTitleFor( 'Search' ),
				wfArrayToCGI(
					$this->powerSearchOptions(),
					array( 'search' => $term ) ),
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
				$wgOut->wrapWikiMsg( "==$1==\n", 'notextmatches' );
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

}
