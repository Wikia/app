<?php

/**
 * SolrStore: The SolrStore Extesion is Semantic Mediawiki Searchprovieder based on Apache Solr.
 * 
 * This is the SpecialPage, displaying the SearchSets and Results
 * 
 * @defgroup SolrStore
 * @author Simon Bachenberg
 */
class SpecialSolrSearch extends SpecialPage {

	/**
	 * Set up basic search parameters from the request and user settings.
	 * Typically you'll pass $wgRequest and $wgUser.
	 *
	 * @param $request WebRequest
	 * @param $user User
	 */
	public function __construct() {
		parent::__construct( "SolrSearch" );
		global $wgRequest, $wgUser;
		$user = $wgUser;
		$request = $wgRequest;
		list( $this->limit, $this->offset ) = $request->getLimitOffset( 20, 'searchlimit' );

		$this->sk = $user->getSkin();
		$this->didYouMeanHtml = ''; # html of did you mean... link
	}

	function execute( $par ) {
		global $wgRequest, $wgUser, $wgSolrFields;

		$this->setHeaders();
		$SpecialSolrSearch = new SpecialSolrSearch( $wgRequest, $wgUser );

		# Get request data from, e.g.
		//$param = $wgRequest->getText ( 'param' );

		foreach ( $wgSolrFields as $set ) {
			if ( $par == $set->getName() ) {
				$fieldSet = $set;
			}
		}
		# Do stuff
		# ...
		// Strip underscores from title parameter; most of the time we'll want
		// text form here. But don't strip underscores from actual text params!
		//$titleParam = str_replace ( '_', ' ', $par );
		// Fetch the search term
//        $search = str_replace("\n", " ", $wgRequest->getText('solrsearch', $titleParam));

		if ( !isset( $fieldSet ) ) {
			$SpecialSolrSearch->showFieldSets();
		} else {
			$lable = $fieldSet->getLable();
			$firstTimeHere = true;
			foreach ( $fieldSet->getFields() as $field ) {
				if ( $firstTimeHere ) {
					$newLable [ 'solr' . trim( $field ) ] = trim( $lable[ 0 ] );
					$firstTimeHere = false;
				} else {
					$newLable [ 'solr' . trim( $field ) ] = trim( next( $lable ) );
				}

				$newFields [ 'solr' . trim( $field ) ] = $wgRequest->getText( 'solr' . trim( $field ) );
			}
			$fieldSet->setFields( $newFields );
			$fieldSet->setLable( $newLable );

			$SpecialSolrSearch->showResults( $fieldSet );
		}
	}

	/**
	 * @param $fieldSet String
	 */
	public function showFieldSets() {
		global $wgOut, $wgUser, $wgScript, $wgSolrFields;
		wfProfileIn( __METHOD__ );

		//$sk = $wgUser->getSkin ();


		$wgOut->setPageTitle( wfMsg( 'solrstore-searchFieldSets-title' ) );
		$wgOut->setHTMLTitle( wfMsg( 'pagetitle', wfMsg( 'solrstore-searchFieldSets-title', 'SolrSearch: Select FieldSet' ) ) );

		$wgOut->setArticleRelated( false );
		$wgOut->addHtml( '<div class="solrsearch-fieldset">' );
		$wgOut->addHtml( wfMsg( 'solrstore-searchFieldSets-select' ) );
		$wgOut->addHtml( '<ul>' );

		//TODO: If no SearchSets exist, provide a shot Manual how to create some!
		foreach ( $wgSolrFields as $set ) {
			$name = $set->getName();
			$wgOut->addHtml( "<li><a href=\"$wgScript/Special:SolrSearch/$name\">$name</a></li>" );
		}
		$wgOut->addHtml( '</ul>' );
		$wgOut->addHtml( "</div>" );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * @param $fieldSet String
	 */
	public function showResults( $fieldSet ) {
		global $wgOut, $wgUser, $wgContLang, $wgScript, $wgSolrShowRelated, $wgSolrDebug;
		wfProfileIn( __METHOD__ );

		$sk = $wgUser->getSkin();

		$this->searchEngine = SearchEngine::create();
		$search = & $this->searchEngine;
		$search->setLimitOffset( $this->limit, $this->offset );

		$this->setupPage( $fieldSet );

		$t = Title::newFromText( $fieldSet->getName() );

		//Do we have Title matches
		$fields = $fieldSet->getFields();

		//Build Solr query string form the fields
		if ( isset( $fields[ 'solrsearch' ] ) ) {
			$query = $fields[ 'solrsearch' ];
		} else {
			$query = '';
		}

		$firsttime = true;
		$fieldSeperator = $fieldSet->getFieldSeperator();
		foreach ( $fields as $key=>$value ) {
			if ( $key != 'solrsearch' && !empty( $value ) ) {
				if ( $firsttime ) {
					$query = trim( $query ) . ' ' . trim( substr( $key, 4 ) ) . ':' . '(' . ($value) . ')';
					$firsttime = false;
				} else {
					$query = trim( $query ) . " $fieldSeperator " . trim( substr( $key, 4 ) ) . ':' . '(' . ($value) . ')';
				}
			}
		}

		if ( !empty( $query ) ) {
			$query .=$fieldSet->getQuery();
		}
		// TODO: More Exception Handling for Format Exceptions
		try {
			$titleMatches = $search->searchTitle( $query );

			if ( !($titleMatches instanceof SearchResultTooMany) )
				$textMatches = $search->searchText( $query );

			// did you mean... suggestions
			if ( $textMatches && $textMatches->hasSuggestion() ) {
				$st = SpecialPage::getTitleFor( 'SolrSearch' );

				# mirror Go/Search behaviour of original request ..
				$didYouMeanParams = array( 'solrsearch'=>$textMatches->getSuggestionQuery() );

				$stParams = $didYouMeanParams;

				$suggestionSnippet = $textMatches->getSuggestionSnippet();

				if ( $suggestionSnippet == '' )
					$suggestionSnippet = null;

				$suggestLink = $sk->linkKnown(
						$st, $suggestionSnippet, array( ), $stParams
				);

				$this->didYouMeanHtml = '<div class="searchdidyoumean">'
						. wfMsg( 'search-suggest', $suggestLink )
						. '</div>';
			}
		} catch ( Exception $exc ) {
			#Todo: Catch different Exceptions not just one for all
			$textMatches = false;
			$titleMatches = false;
			$wgOut->addHTML( '<p class="solr-error">' . wfMsg( 'solrstore-error' ) . '<p\>' );
			if ( $wgSolrDebug ) {
				$wgOut->addHTML( '<p class="solr-error">' . $exc . '<p\>' );
			}
		}
		// start rendering the page
		$wgOut->addHtml(
				Xml::openElement(
						'form', array(
					'id'=>'solrsearch',
					'method'=>'get',
					'action'=>$wgScript
						)
				)
		);
		$wgOut->addHtml(
				Xml::openElement( 'table', array(
					'id'=>'mw-search-top-table',
					'border'=>0,
					'cellpadding'=>0,
					'cellspacing'=>0
						)
				) .
				Xml::openElement( 'tr' ) .
				Xml::openElement( 'td' ) . "\n" .
				$this->shortDialog( $fieldSet ) .
				Xml::closeElement( 'td' ) .
				Xml::closeElement( 'tr' ) .
				Xml::closeElement( 'table' )
		);

		// Sometimes the search engine knows there are too many hits
		if ( $titleMatches instanceof SearchResultTooMany ) {
			$wgOut->addWikiText( '==' . wfMsg( 'toomanymatches' ) . "==\n" );
			wfProfileOut( __METHOD__ );
			return;
		}

		$filePrefix = $wgContLang->getFormattedNsText( NS_FILE ) . ':';
		if ( trim( $query ) === '' || $filePrefix === trim( $query ) ) {
			$wgOut->addHTML( $this->formHeader( 0, 0 ) );
			$wgOut->addHTML( '</form>' );
			// Empty query -- straight view of search form
			wfProfileOut( __METHOD__ );
			return;
		}
		// Get number of results
		$titleMatchesNum = $titleMatches ? $titleMatches->numRows() : 0;
		$textMatchesNum = $textMatches ? $textMatches->numRows() : 0;
		// Total initial query matches (possible false positives)
		$num = $titleMatchesNum + $textMatchesNum;

		// Get total actual results (after second filtering, if any)
		$numTitleMatches = $titleMatches && !is_null( $titleMatches->getTotalHits() ) ?
				$titleMatches->getTotalHits() : $titleMatchesNum;
		$numTextMatches = $textMatches && !is_null( $textMatches->getTotalHits() ) ?
				$textMatches->getTotalHits() : $textMatchesNum;

		// get total number of results if backend can calculate it
		$totalRes = 0;
		if ( $titleMatches && !is_null( $titleMatches->getTotalHits() ) )
			$totalRes += $titleMatches->getTotalHits();
		if ( $textMatches && !is_null( $textMatches->getTotalHits() ) )
			$totalRes += $textMatches->getTotalHits();

		// show number of results and current offset
		$wgOut->addHTML( $this->formHeader( $num, $totalRes ) );
		$wgOut->addHtml( Xml::closeElement( 'form' ) );
		$wgOut->addHtml( "<div class='searchresults'>" );

		// prev/next links
		if ( $num || $this->offset ) {
			// Show the create link ahead
			if ( $wgSolrShowRelated ) {
				$this->showCreateLink( $t );
			}
			$prevnext = wfViewPrevNext(
					$this->offset, $this->limit, SpecialPage::getTitleFor( 'SolrSearch/' . $fieldSet->mName ), wfArrayToCGI( $fieldSet->mFields ), max( $titleMatchesNum, $textMatchesNum ) < $this->limit );
			wfRunHooks( 'SpecialSolrSearchResults', array( $fieldSet, &$titleMatches, &$textMatches ) );
		} else {
			wfRunHooks( 'SpecialSolrSearchNoResults', array( $fieldSet ) );
		}

		if ( $titleMatches ) {
			if ( $numTitleMatches > 0 ) {
				$wgOut->wrapWikiMsg( "==$1==\n", 'titlematches' );
				$wgOut->addHTML( $this->showMatches( $titleMatches ) );
			}
			$titleMatches->free();
		}
		if ( $textMatches ) {
			// output appropriate heading
			if ( $numTextMatches > 0 && $numTitleMatches > 0 ) {
				// if no title matches the heading is redundant
				$wgOut->wrapWikiMsg( "==$1==\n", 'textmatches' );
			} elseif ( $totalRes == 0 ) {
				# Don't show the 'no text matches' if we received title matches
				$wgOut->wrapWikiMsg( "==$1==\n", 'notextmatches' );
			}

			// show results
			if ( $numTextMatches > 0 ) {
				$wgOut->addHTML( $this->showMatches( $textMatches ) );
			}

			$textMatches->free();
		}

		$wgOut->addHtml( "</div>" );

		if ( $num || $this->offset ) {
			$wgOut->addHTML( "<p class='mw-search-pager-bottom'>{$prevnext}</p>\n" );
		}
		wfProfileOut( __METHOD__ );
	}

	protected function showCreateLink( $t ) {
		global $wgOut;

		// show direct page/create link if applicable
		$messageName = null;
		if ( !is_null( $t ) ) {
			if ( $t->isKnown() ) {
				$messageName = 'searchmenu-exists';
			} elseif ( $t->userCan( 'create' ) ) {
				$messageName = 'searchmenu-new';
			} else {
				$messageName = 'searchmenu-new-nocreate';
			}
		}
		if ( $messageName ) {
			$wgOut->wrapWikiMsg( "<p class=\"mw-search-createlink\">\n$1</p>", array( $messageName, wfEscapeWikiText( $t->getPrefixedText() ) ) );
		} else {
			// preserve the paragraph for margins etc...
			$wgOut->addHtml( '<p></p>' );
		}
	}

	/**
	 *
	 */
	protected function setupPage( $fieldSet ) {
		global $wgOut;

		if ( !empty( $fieldSet ) ) {
			$wgOut->setPageTitle( wfMsg( 'solrsearch-title' ) . ': ' . $fieldSet->getName() );
			$wgOut->setHTMLTitle( wfMsg( 'pagetitle', wfMsg( 'solrsearch', $fieldSet->getName() ) ) );
		}
		$wgOut->setArticleRelated( false );
		$wgOut->setRobotPolicy( 'noindex,nofollow' );
		// add javascript specific to special:search
		$wgOut->addModules( 'mediawiki.legacy.search' );
		$wgOut->addModules( 'mediawiki.special.search' );
	}

	/**
	 * Show whole set of results
	 *
	 * @param $matches SearchResultSet
	 */
	protected function showMatches( &$matches ) {
		global $wgContLang;
		wfProfileIn( __METHOD__ );

		$fieldSets = $wgContLang->convertForSearchResult( $matches->termMatches() );

		$out = "";
		$infoLine = $matches->getInfo();
		if ( !is_null( $infoLine ) ) {
			$out .= "\n<!-- {$infoLine} -->\n";
		}
		$out .= "<ul class='mw-search-results'>\n";

		while ( $result = $matches->next() ) {
			$out .= $this->showHit( $result, $fieldSets );
		}
		$out .= "</ul>\n";

		// convert the whole thing to desired language variant
		$out = $wgContLang->convert( $out );
		wfProfileOut( __METHOD__ );
		return $out;
	}

	/**
	 * Format a single hit result
	 *
	 * @param $result SearchResult
	 * @param $fieldSets Array: terms to highlight
	 */
	protected function showHit( $result, $fieldSets ) {
		global $wgLang, $wgUser;
		wfProfileIn( __METHOD__ );

		if ( $result->isBrokenTitle() ) {
			wfProfileOut( __METHOD__ );
			return "<!-- Broken link in search result -->\n";
		}

		$sk = $wgUser->getSkin();
		$t = $result->getTitle();

		$titleSnippet = $result->getTitleSnippet( $fieldSets );

		if ( $titleSnippet == '' )
			$titleSnippet = null;

		$link_t = clone $t;

		wfRunHooks( 'ShowSearchHitTitle', array( &$link_t, &$titleSnippet, $result, $fieldSets, $this ) );

		$link = $this->sk->linkKnown(
				$link_t, $titleSnippet
		);
		// FÜLLEN
		//If page content is not readable, just return the title.
		//This is not quite safe, but better than showing excerpts from non-readable pages
		//Note that hiding the entry entirely would screw up paging.
		// ---- HIER
		if ( !$t->userCanRead() ) {
			wfProfileOut( __METHOD__ );
			return "<li>{$link}</li>\n";
		}
		//return "<li>{$link}</li>\n";
		// If the page doesn't *exist*... our search index is out of date.
		// The least confusing at this point is to drop the result.
		// You may get less results, but... oh well. :P
		// ---- HIER
		if ( $result->isMissingRevision() ) {
			wfProfileOut( __METHOD__ );
			return "<!-- missing page " . htmlspecialchars( $t->getPrefixedText() ) . "-->\n";
		}

		// format redirects / relevant sections
		$redirectTitle = $result->getRedirectTitle();
		$redirectText = $result->getRedirectSnippet( $fieldSets );
		$sectionTitle = $result->getSectionTitle();
		$sectionText = $result->getSectionSnippet( $fieldSets );
		$redirect = '';

		if ( !is_null( $redirectTitle ) ) {
			if ( $redirectText == '' )
				$redirectText = null;

			$redirect = "<span class='searchalttitle'>" .
					wfMsg( 'search-redirect', $this->sk->linkKnown( $redirectTitle, $redirectText ) ) .
					"</span>";
		}

		$section = '';


		if ( !is_null( $sectionTitle ) ) {
			if ( $sectionText == '' )
				$sectionText = null;

			$section = "<span class='searchalttitle'>" .
					wfMsg( 'search-section', $this->sk->linkKnown( $sectionTitle, $sectionText ) ) .
					"</span>";
		}

		// format text extract
		$extract = "<div class='searchresult'>" . $result->getTextSnippet( $fieldSets ) . "</div>";

		// format score
		if ( is_null( $result->getScore() ) ) {
			// Search engine doesn't report scoring info
			$score = '';
		} else {
			$percent = sprintf( '%2.1f', $result->getScore() * 100 );
			$score = wfMsg( 'search-result-score', $wgLang->formatNum( $percent ) ) . ' - ';
		}

		// format description
		$byteSize = $result->getByteSize();
		$wordCount = $result->getWordCount();
		$timestamp = $result->getTimestamp();
		$size = wfMsgExt( 'search-result-size', array( 'parsemag', 'escape' ), $this->sk->formatSize( $byteSize ), $wgLang->formatNum( $wordCount ) );

		if ( $t->getNamespace() == NS_CATEGORY ) {
			$cat = Category::newFromTitle( $t );
			$size = wfMsgExt( 'search-result-category-size', array( 'parsemag', 'escape' ), $wgLang->formatNum( $cat->getPageCount() ), $wgLang->formatNum( $cat->getSubcatCount() ), $wgLang->formatNum( $cat->getFileCount() ) );
		}

		$date = $wgLang->timeanddate( $timestamp );

		// link to related articles if supported
		$related = '';
		if ( $result->hasRelated() ) {
			$st = SpecialPage::getTitleFor( 'SolrSearch' );
			$stParams = array( 'solrsearch'=>wfMsgForContent( 'searchrelated' ) . ':' . $t->getPrefixedText() );
			$related = ' -- ' . $sk->linkKnown( $st, wfMsg( 'search-relatedarticle' ), array( ), $stParams );
		}

		// Include a thumbnail for media files...
		// WE HAVE NEVER TESTED THIS HERE!!!
		if ( $t->getNamespace() == NS_FILE ) {
			$img = wfFindFile( $t );
			if ( $img ) {
				$thumb = $img->transform( array( 'width'=>120, 'height'=>120 ) );
				if ( $thumb ) {
					$desc = wfMsg( 'parentheses', $img->getShortDesc() );
					wfProfileOut( __METHOD__ );
					// Float doesn't seem to interact well with the bullets.
					// Table messes up vertical alignment of the bullets.
					// Bullets are therefore disabled (didn't look great anyway).
					return "<li>" .
							'<table class="searchResultImage">' .
							'<tr>' .
							'<td width="120" align="center" valign="top">' .
							$thumb->toHtml( array( 'desc-link'=>true ) ) .
							'</td>' .
							'<td valign="top">' .
							$link .
							$extract .
							"<div class='mw-search-result-data'>{$score}{$desc}{$date}{$related}</div>" .
							'</td>' .
							'</tr>' .
							'</table>' .
							"</li>\n";
				}
			}
		}

		wfProfileOut( __METHOD__ );
		// HIER kommt die score ausgabe:
		return "<li><div class='mw-search-result-heading'>{$link} {$redirect} {$section}</div> {$extract}\n" .
				"<div class='mw-search-result-data'>{$score}{$date}{$related}</div>" .
				"</li>\n";
	}

	protected function formHeader( $resultsShown, $totalNum ) {
		global $wgLang;

		$out = Xml::openElement( 'div', array( 'class'=>'mw-search-formheader' ) );

		// Results-info
		if ( $resultsShown > 0 ) {
			if ( $totalNum > 0 ) {
				$top = wfMsgExt( 'showingresultsheader', array( 'parseinline' ), $wgLang->formatNum( $this->offset + 1 ), $wgLang->formatNum( $this->offset + $resultsShown ), $wgLang->formatNum( $totalNum ), $wgLang->formatNum( $resultsShown )
				);
			} elseif ( $resultsShown >= $this->limit ) {
				$top = wfShowingResults( $this->offset, $this->limit );
			} else {
				$top = wfShowingResultsNum( $this->offset, $this->limit, $resultsShown );
			}
			$out .= Xml::tags( 'div', array( 'class'=>'results-info' ), Xml::tags( 'ul', null, Xml::tags( 'li', null, $top ) ) );
		}

		$out .= Xml::element( 'div', array( 'style'=>'clear:both' ), '', false );
		$out .= Xml::closeElement( 'div' );

		return $out;
	}

	protected function shortDialog( $fieldSet ) {
		$searchTitle = SpecialPage::getTitleFor( 'SolrSearch' );


		if ( $fieldSet->getName() != 'search' ) {
			$out = Html::hidden( 'title', $searchTitle->getPrefixedText() . '/' . $fieldSet->getName() ) . "\n";
		} else {
			$out = Html::hidden( 'title', $searchTitle->getPrefixedText() ) . "\n";
		}
		// Term box

		$lable = $fieldSet->getLable();
		$out .= '<table>';

		foreach ( $fieldSet->getFields() as $key=>$value ) {
			$out .= '<tr>';
			if ( isset( $lable[ $key ] ) ) {
				$out .= '<th>' . $lable[ $key ] . '</th>';
			}
			$out .= '<td>';
			$out .= Html::input( $key, $value, $key, array(
						'id'=>$key,
						'size'=>'50',
						'autofocus'
					) ) . "\n";
			$out .= '</td></tr>';
		}
		$out .= '<table>';
		$out .= Xml::submitButton( wfMsg( 'searchbutton' ) ) . "\n";
		return $out . $this->didYouMeanHtml;
	}

}

?>