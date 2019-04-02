<?php
/**
 * Implements Special:Search
 *
 * Copyright © 2004 Brion Vibber <brion@pobox.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 * @ingroup SpecialPage
 */

/**
 * implements Special:Search - Run text & title search and display the output
 * @ingroup SpecialPage
 */
class SpecialSearch extends SpecialPage {
	/**
	 * Current search profile. Search profile is just a name that identifies
	 * the active search tab on the search page (content, help, discussions...)
	 * For users tt replaces the set of enabled namespaces from the query
	 * string when applicable. Extensions can add new profiles with hooks
	 * with custom search options just for that profile.
	 * null|string
	 */
	protected $profile;

	private $searchAdvanced;

	function getProfile() { return $this->profile; }

	/// Search engine
	protected $searchEngine;

	/// For links
	protected $extraParams = [];

	/// No idea, apparently used by some other classes
	protected $mPrefix;

	/**
	 * @var int
	 */
	protected $limit, $offset;

	/**
	 * @var array
	 */
	protected $namespaces;

	function getNamespaces() { return $this->namespaces; }

	/**
	 * @var bool
	 */
	protected $searchRedirects;

	/**
	 * @var string
	 */
	protected $didYouMeanHtml, $fulltext;

	const NAMESPACES_CURRENT = 'sense';

	public function __construct() {
		parent::__construct( 'Search' );
	}

	/**
	 * Entry point
	 *
	 * @param $pars string or null
	 * @throws FatalError
	 * @throws MWException
	 */
	public function execute( $par ) {
		$this->setHeaders();
		$this->outputHeader();
		$out = $this->getOutput();
		$out->allowClickjacking();
		$out->addModuleStyles( 'mediawiki.special' );

		// Strip underscores from title parameter; most of the time we'll want
		// text form here. But don't strip underscores from actual text params!
		$titleParam = str_replace( '_', ' ', $par );

		$request = $this->getRequest();

		// Fetch the search term
		$search = str_replace( "\n", " ", $request->getText( 'search', $titleParam ) );

		$this->load();

		if ( $request->getVal( 'fulltext' ) || !is_null( $request->getVal( 'offset' ) ) ||
			 !is_null( $request->getVal( 'searchx' ) ) ) {
			$this->showResults( $search );
		} else {
			$this->goResult( $search );
		}
	}

	/**
	 * Set up basic search parameters from the request and user settings.
	 *
	 * @see tests/phpunit/includes/specials/SpecialSearchTest.php
	 */
	public function load() {
		$request = $this->getRequest();
		list( $this->limit, $this->offset ) = $request->getLimitOffset( 20, 'searchlimit' );
		$this->mPrefix = $request->getVal( 'prefix', '' );

		$user = $this->getUser();

		# Extract manually requested namespaces
		$nslist = $this->powerSearch( $request );
		if ( !count( $nslist ) ) {
			# Fallback to user preference
			$nslist = SearchEngine::userNamespaces( $user );
		}

		$profile = null;
		if ( !count( $nslist ) ) {
			$profile = 'default';
		}

		$profile = $request->getVal( 'profile', $profile );
		$profiles = $this->getSearchProfiles();
		if ( $profile === null ) {
			// BC with old request format
			$profile = 'advanced';
			foreach ( $profiles as $key => $data ) {
				if ( $nslist === $data['namespaces'] && $key !== 'advanced' ) {
					$profile = $key;
				}
			}
			$this->namespaces = $nslist;
		} elseif ( $profile === 'advanced' ) {
			$this->namespaces = $nslist;
		} else {
			if ( isset( $profiles[$profile]['namespaces'] ) ) {
				$this->namespaces = $profiles[$profile]['namespaces'];
			} else {
				// Unknown profile requested
				$profile = 'default';
				$this->namespaces = $profiles['default']['namespaces'];
			}
		}

		// Redirects defaults to true, but we don't know whether it was ticked of or just missing
		$default = $request->getBool( 'profile' ) ? 0 : 1;
		$this->searchRedirects = $request->getBool( 'redirs', $default ) ? 1 : 0;
		$this->didYouMeanHtml = ''; # html of did you mean... link
		$this->fulltext = $request->getVal( 'fulltext' );
		$this->profile = $profile;
	}

	/**
	 * If an exact title match can be found, jump straight ahead to it.
	 *
	 * @param $term String
	 */
	public function goResult( $term ) {
		$this->setupPage( $term );
		# Try to go to page as entered.
		$t = Title::newFromText( $term );
		# If the string cannot be used to create a title
		if ( is_null( $t ) ) {
			$this->showResults( $term );

			return;
		}
		$searchWithNamespace = $t->getNamespace() != 0 ? true : false;
		# If there's an exact or very near match, jump right there.
		$t = SearchEngine::getNearMatch( $term );

		if ( !Hooks::run( 'SpecialSearchGo', [ &$t, &$term ] ) ) {
			# Hook requested termination
			return;
		}

		if ( !is_null( $t ) && ( $searchWithNamespace || $t->getNamespace() == NS_MAIN ||
								 $t->getNamespace() == NS_CATEGORY ) ) {
			// Wikia change (ADi): hook call added
			Hooks::run( 'SpecialSearchIsgomatch', [ &$t, $term ] );
			$this->getOutput()->redirect( $t->getFullURL() );

			return;
		}
		# No match, generate an edit URL
		$t = Title::newFromText( $term );
		if ( !is_null( $t ) ) {
			global $wgGoToEdit;
			Hooks::run( 'SpecialSearchNogomatch', [ &$t ] );
			wfDebugLog( 'nogomatch', $t->getText(), false );

			# If the feature is enabled, go straight to the edit page
			if ( $wgGoToEdit ) {
				$this->getOutput()->redirect( $t->getFullURL( [ 'action' => 'edit' ] ) );

				return;
			}
		}

		$this->showResults( $term );
	}

	/**
	 * @param $term string
	 * @throws FatalError
	 * @throws MWException
	 */
	public function showResults( $term ) {
		global $wgContLang, $wgScript;
		wfProfileIn( __METHOD__ );

		$search = $this->getSearchEngine();
		$search->setLimitOffset( $this->limit, $this->offset );
		$search->setNamespaces( $this->namespaces );
		$search->showRedirects = $this->searchRedirects; // BC
		$search->setFeatureData( 'list-redirects', $this->searchRedirects );
		$search->prefix = $this->mPrefix;
		$term = $search->transformSearchTerm( $term );

		Hooks::run( 'SpecialSearchSetupEngine', [ $this, $this->profile, $search ] );

		$this->setupPage( $term );

		$out = $this->getOutput();

		$t = Title::newFromText( $term );

		// fetch search results
		$rewritten = $search->replacePrefixes( $term );

		$titleMatches = $search->searchTitle( $rewritten );
		if ( !( $titleMatches instanceof SearchResultTooMany ) ) {
			$textMatches = $search->searchText( $rewritten );
		}

		// did you mean... suggestions
		if ( $textMatches && $textMatches->hasSuggestion() ) {
			$st = SpecialPage::getTitleFor( 'Search' );

			# mirror Go/Search behaviour of original request ..
			$didYouMeanParams = [ 'search' => $textMatches->getSuggestionQuery() ];

			if ( $this->fulltext != null ) {
				$didYouMeanParams['fulltext'] = $this->fulltext;
			}

			$stParams = array_merge( $didYouMeanParams, $this->powerSearchOptions() );

			$suggestionSnippet = $textMatches->getSuggestionSnippet();

			if ( $suggestionSnippet == '' ) {
				$suggestionSnippet = null;
			}

			$suggestLink = Linker::linkKnown( $st, $suggestionSnippet, [], $stParams );

			$this->didYouMeanHtml =
				'<div class="searchdidyoumean">' . wfMsg( 'search-suggest', $suggestLink ) .
				'</div>';
		}
		// start rendering the page
		$out->addHtml( Xml::openElement( 'form', [
				'id' => ( $this->profile === 'advanced' ? 'powersearch' : 'search' ),
				'method' => 'get',
				'action' => $wgScript,
			] ) );

		$out->addHtml( Xml::openElement( 'table', [
				'id' => 'mw-search-top-table',
				'border' => 0,
				'cellpadding' => 0,
				'cellspacing' => 0,
			] ) . Xml::openElement( 'tr' ) . Xml::openElement( 'td' ) . "\n" .
					   $this->shortDialog( $term ) . Xml::closeElement( 'td' ) .
					   Xml::closeElement( 'tr' ) . Xml::closeElement( 'table' ) );

		// Sometimes the search engine knows there are too many hits
		if ( $titleMatches instanceof SearchResultTooMany ) {
			$out->wrapWikiMsg( "==$1==\n", 'toomanymatches' );
			wfProfileOut( __METHOD__ );

			return;
		}

		$filePrefix = $wgContLang->getFormattedNsText( NS_FILE ) . ':';
		if ( trim( $term ) === '' || $filePrefix === trim( $term ) ) {
			$out->addHTML( $this->searchFocus() );
			$out->addHTML( $this->formHeader( $term, 0, 0 ) );
			$out->addHtml( $this->getProfileForm( $this->profile, $term ) );
			$out->addHTML( '</form>' );
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
		$numTitleMatches =
			$titleMatches && !is_null( $titleMatches->getTotalHits() )
				? $titleMatches->getTotalHits() : $titleMatchesNum;
		$numTextMatches =
			$textMatches && !is_null( $textMatches->getTotalHits() ) ? $textMatches->getTotalHits()
				: $textMatchesNum;

		// get total number of results if backend can calculate it
		$totalRes = 0;
		if ( $titleMatches && !is_null( $titleMatches->getTotalHits() ) ) {
			$totalRes += $titleMatches->getTotalHits();
		}
		if ( $textMatches && !is_null( $textMatches->getTotalHits() ) ) {
			$totalRes += $textMatches->getTotalHits();
		}

		// show number of results and current offset
		/* Wikia change begin - @author: Macbre (merge 1.19 MoLi) */
		if ( !( F::app()->checkSkin( [ 'oasis' ] ) ) ) {
			$out->addHTML( $this->formHeader( $term, $num, $totalRes ) );
			$out->addHtml( $this->getProfileForm( $this->profile, $term ) );
		}
		/* Wikia change end */

		$out->addHtml( Xml::closeElement( 'form' ) );
		$out->addHtml( "<div class='searchresults'>" );

		// prev/next links
		if ( $num || $this->offset ) {
			// Show the create link ahead
			$this->showCreateLink( $t );
			$prevnext =
				$this->getLanguage()
					->viewPrevNext( $this->getTitle(), $this->offset, $this->limit,
						$this->powerSearchOptions() + [ 'search' => $term ],
						max( $titleMatchesNum, $textMatchesNum ) < $this->limit );
			//$out->addHTML( "<p class='mw-search-pager-top'>{$prevnext}</p>\n" );
			Hooks::run( 'SpecialSearchResults', [ $term, &$titleMatches, &$textMatches ] );
		} else {
			Hooks::run( 'SpecialSearchNoResults', [ $term ] );
		}

		$out->parserOptions()->setEditSection( false );
		if ( $titleMatches ) {
			if ( $numTitleMatches > 0 ) {
				$out->wrapWikiMsg( "==$1==\n", 'titlematches' );
				$out->addHTML( $this->showMatches( $titleMatches ) );
			}
			$titleMatches->free();
		}
		if ( $textMatches ) {
			// output appropriate heading
			if ( $numTextMatches > 0 && $numTitleMatches > 0 ) {
				// if no title matches the heading is redundant
				$out->wrapWikiMsg( "==$1==\n", 'textmatches' );
			}
			// show interwiki results if any
			if ( $textMatches->hasInterwikiResults() ) {
				$out->addHTML( $this->showInterwiki( $textMatches->getInterwikiResults(), $term ) );
			}
			// show results
			if ( $numTextMatches > 0 ) {
				$out->addHTML( $this->showMatches( $textMatches ) );
			}

			$textMatches->free();
		}
		if ( $num === 0 ) {
			$out->wrapWikiMsg( "<p class=\"mw-search-nonefound\">\n$1</p>",
				[ 'search-nonefound', wfEscapeWikiText( $term ) ] );
			$this->showCreateLink( $t );
		}
		$out->addHtml( "</div>" );

		if ( $num || $this->offset ) {
			$out->addHTML( "<p class='mw-search-pager-bottom'>{$prevnext}</p>\n" );
		}

		// show number of results and current offset
		/* Wikia change begin - @author: Macbre */
		if ( F::app()->checkSkin( [ 'oasis' ] ) ) {
			$out->addHTML( $this->formHeader( $term, $num, $totalRes ) );
			$out->addHtml( $this->getProfileForm( $this->profile, $term ) );
			if ( $this->searchAdvanced ) {
				$out->addHTML( $this->powerSearchBox( $term ) );
			}
			$out->addHtml( Xml::closeElement( 'form' ) );
		}
		/* Wikia change end */

		wfProfileOut( __METHOD__ );
	}

	/**
	 * @param $t Title
	 * @return void
	 * @throws FatalError
	 * @throws MWException
	 */
	protected function showCreateLink( $t ) {
		/* Wikia change begin - @author: Macbre */
		/* Don't show "create an article" link in Oasis */
		if ( F::app()->checkSkin( [ 'oasis' ] ) ) {
			return;
		}
		/* Wikia change end */

		// show direct page/create link if applicable

		// Check DBkey !== '' in case of fragment link only.
		if ( is_null( $t ) || $t->getDBkey() === '' ) {
			// invalid title
			// preserve the paragraph for margins etc...
			$this->getOutput()->addHtml( '<p></p>' );

			return;
		}

		if ( $t->isKnown() ) {
			$messageName = 'searchmenu-exists';
		} elseif ( $t->userCan( 'create' ) ) {
			$messageName = 'searchmenu-new';
		} else {
			$messageName = 'searchmenu-new-nocreate';
		}
		$params = [ $messageName, wfEscapeWikiText( $t->getPrefixedText() ) ];
		Hooks::run( 'SpecialSearchCreateLink', [ $t, &$params ] );

		if ( $messageName ) {
			$this->getOutput()
				->wrapWikiMsg( "<p class=\"mw-search-createlink\">\n$1</p>", $params );
		} else {
			// preserve the paragraph for margins etc...
			$this->getOutput()->addHtml( '<p></p>' );
		}
	}

	/**
	 * @param $term string
	 */
	protected function setupPage( $term ) {
		# Should advanced UI be used?
		$this->searchAdvanced = ( $this->profile === 'advanced' );
		$out = $this->getOutput();
		if ( strval( $term ) !== '' ) {
			$out->setPageTitle( $this->msg( 'searchresults' ) );
			$out->setHTMLTitle( $this->msg( 'pagetitle',
				$this->msg( 'searchresults-title', $term )->plain() ) );
		}
		// add javascript specific to special:search
		$out->addModules( 'mediawiki.special.search' );
	}

	/**
	 * Extract "power search" namespace settings from the request object,
	 * returning a list of index numbers to search.
	 *
	 * @param $request WebRequest
	 * @return array
	 */
	protected function powerSearch( &$request ) {
		$arr = [];
		foreach ( SearchEngine::searchableNamespaces() as $ns => $name ) {
			if ( $request->getCheck( 'ns' . $ns ) ) {
				$arr[] = $ns;
			}
		}

		return $arr;
	}

	/**
	 * Reconstruct the 'power search' options for links
	 *
	 * @return array
	 */
	protected function powerSearchOptions() {
		$opt = [];
		$opt['redirs'] = $this->searchRedirects ? 1 : 0;
		if ( $this->profile !== 'advanced' ) {
			$opt['profile'] = $this->profile;
		} else {
			foreach ( $this->namespaces as $n ) {
				$opt['ns' . $n] = 1;
			}
		}

		return $opt + $this->extraParams;
	}

	/**
	 * Show whole set of results
	 *
	 * @param $matches SearchResultSet
	 *
	 * @return string
	 */
	protected function showMatches( &$matches ) {
		global $wgContLang;
		wfProfileIn( __METHOD__ );

		$terms = $wgContLang->convertForSearchResult( $matches->termMatches() );

		$out = "";
		$infoLine = $matches->getInfo();
		if ( !is_null( $infoLine ) ) {
			$out .= "\n<!-- {$infoLine} -->\n";
		}
		$out .= "<ul class='mw-search-results'>\n";
		$num = 0;
		$result = $matches->next();
		while ( $result ) {
			// Wikia change /Begin (ADi)
			Hooks::run( 'SpecialSearchShowHit', [ &$out, $result, $terms, $num ] );
			// Wikia change /End (ADi)
			$out .= $this->showHit( $result, $terms );
			$result = $matches->next();
			$num ++;
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
	 * @param $terms array: terms to highlight
	 *
	 * @return string
	 * @throws FatalError
	 * @throws MWException
	 */
	protected function showHit( $result, $terms ) {
		wfProfileIn( __METHOD__ );

		if ( $result->isBrokenTitle() ) {
			wfProfileOut( __METHOD__ );

			return "<!-- Broken link in search result -->\n";
		}

		$t = $result->getTitle();

		$titleSnippet = $result->getTitleSnippet( $terms );

		if ( $titleSnippet == '' ) {
			$titleSnippet = null;
		}

		$link_t = clone $t;

		Hooks::run( 'ShowSearchHitTitle', [ &$link_t, &$titleSnippet, $result, $terms, $this ] );

		$link = Linker::linkKnown( $link_t, $titleSnippet );

		//If page content is not readable, just return the title.
		//This is not quite safe, but better than showing excerpts from non-readable pages
		//Note that hiding the entry entirely would screw up paging.
		if ( !$t->userCan( 'read' ) ) {
			wfProfileOut( __METHOD__ );

			return "<li>{$link}</li>\n";
		}

		// If the page doesn't *exist*... our search index is out of date.
		// The least confusing at this point is to drop the result.
		// You may get less results, but... oh well. :P
		if ( $result->isMissingRevision() ) {
			wfProfileOut( __METHOD__ );

			return "<!-- missing page " . htmlspecialchars( $t->getPrefixedText() ) . "-->\n";
		}

		// format redirects / relevant sections
		$redirectTitle = $result->getRedirectTitle();
		$redirectText = $result->getRedirectSnippet( $terms );
		$sectionTitle = $result->getSectionTitle();
		$sectionText = $result->getSectionSnippet( $terms );
		$redirect = '';

		if ( !is_null( $redirectTitle ) ) {
			if ( $redirectText == '' ) {
				$redirectText = null;
			}

			$redirect =
				"<span class='searchalttitle'>" .
				wfMsg( 'search-redirect', Linker::linkKnown( $redirectTitle, $redirectText ) ) .
				"</span>";
		}

		$section = '';

		if ( !is_null( $sectionTitle ) ) {
			if ( $sectionText == '' ) {
				$sectionText = null;
			}

			$section =
				"<span class='searchalttitle'>" .
				wfMsg( 'search-section', Linker::linkKnown( $sectionTitle, $sectionText ) ) .
				"</span>";
		}

		// format text extract
		$extract = "<div class='searchresult'>" . $result->getTextSnippet( $terms ) . "</div>";

		$lang = $this->getLanguage();

		// format score
		if ( is_null( $result->getScore() ) ) {
			// Search engine doesn't report scoring info
			$score = '';
		} else {
			$percent = sprintf( '%2.1f', $result->getScore() * 100 );
			$score = wfMsg( 'search-result-score', $lang->formatNum( $percent ) ) . ' - ';
		}

		// format description
		$byteSize = $result->getByteSize();
		$wordCount = $result->getWordCount();
		$timestamp = $result->getTimestamp();
		$size =
			wfMsgExt( 'search-result-size', [ 'parsemag', 'escape' ],
				$lang->formatSize( $byteSize ), $lang->formatNum( $wordCount ) );

		if ( $t->getNamespace() == NS_CATEGORY ) {
			$cat = Category::newFromTitle( $t );
			$size =
				wfMsgExt( 'search-result-category-size', [ 'parsemag', 'escape' ],
					$lang->formatNum( $cat->getPageCount() ),
					$lang->formatNum( $cat->getSubcatCount() ),
					$lang->formatNum( $cat->getFileCount() ) );
		}

		$date = $lang->timeanddate( $timestamp );

		// link to related articles if supported
		$related = '';
		if ( $result->hasRelated() ) {
			$st = SpecialPage::getTitleFor( 'Search' );
			$stParams = array_merge( $this->powerSearchOptions(), [
					'search' => wfMsgForContent( 'searchrelated' ) . ':' . $t->getPrefixedText(),
					'fulltext' => wfMsg( 'search' ),
				] );

			$related =
				' -- ' . Linker::linkKnown( $st, wfMsg( 'search-relatedarticle' ), [], $stParams );
		}

		// Include a thumbnail for media files...
		if ( $t->getNamespace() == NS_FILE ) {
			$img = wfFindFile( $t );
			if ( $img ) {
				$thumb = $img->transform( [ 'width' => 120, 'height' => 120 ] );
				if ( $thumb ) {
					$desc = wfMsg( 'parentheses', $img->getShortDesc() );

					// Wikia change /Begin (ADi)
					$resultData =
						"<div class='mw-search-result-data'>{$score}{$desc} - {$date}{$related}</div>";
					Hooks::run( 'SearchShowHit',
						[ $result, &$link, &$redirect, &$section, &$extract, &$resultData ] );
					// Wikia change /End

					wfProfileOut( __METHOD__ );
					// Float doesn't seem to interact well with the bullets.
					// Table messes up vertical alignment of the bullets.
					// Bullets are therefore disabled (didn't look great anyway).
					return "<li>" . '<table class="searchResultImage">' . '<tr>' .
						   '<td width="120" align="center" valign="top">' .
						   $thumb->toHtml( [ 'desc-link' => true ] ) . '</td>' .
						   '<td valign="top">' . $link . $extract . $resultData . '</td>' .
						   '</tr>' . '</table>' . "</li>\n";
				}
			}
		}

		// Wikia change /Begin (ADi)
		$resultData =
			"<div class='mw-search-result-data'>{$score}{$size} - {$date}{$related}</div>";
		Hooks::run( 'SearchShowHit',
			[ $result, &$link, &$redirect, &$section, &$extract, &$resultData ] );
		// Wikia change /End

		wfProfileOut( __METHOD__ );

		return "<li><div class='mw-search-result-heading'>{$link} {$redirect} {$section} {$extract}</div>\n{$resultData}</li>\n";
	}

	/**
	 * Show results from other wikis
	 *
	 * @param $matches SearchResultSet
	 * @param $query string
	 *
	 * @return string
	 */
	protected function showInterwiki( &$matches, $query ) {
		global $wgContLang;
		wfProfileIn( __METHOD__ );
		$terms = $wgContLang->convertForSearchResult( $matches->termMatches() );

		$out =
			"<div id='mw-search-interwiki'><div id='mw-search-interwiki-caption'>" .
			wfMsg( 'search-interwiki-caption' ) . "</div>\n";
		$out .= "<ul class='mw-search-iwresults'>\n";

		// work out custom project captions
		$customCaptions = [];
		$customLines =
			explode( "\n",
				wfMsg( 'search-interwiki-custom' ) ); // format per line <iwprefix>:<caption>
		foreach ( $customLines as $line ) {
			$parts = explode( ":", $line, 2 );
			if ( count( $parts ) == 2 ) // validate line
			{
				$customCaptions[$parts[0]] = $parts[1];
			}
		}

		$prev = null;
		$result = $matches->next();
		while ( $result ) {
			$out .= $this->showInterwikiHit( $result, $prev, $terms, $query, $customCaptions );
			$prev = $result->getInterwikiPrefix();
			$result = $matches->next();
		}
		// TODO: should support paging in a non-confusing way (not sure how though, maybe via ajax)..
		$out .= "</ul></div>\n";

		// convert the whole thing to desired language variant
		$out = $wgContLang->convert( $out );
		wfProfileOut( __METHOD__ );

		return $out;
	}

	/**
	 * Show single interwiki link
	 *
	 * @param $result SearchResult
	 * @param $lastInterwiki string
	 * @param $terms array
	 * @param $query string
	 * @param $customCaptions array: iw prefix -> caption
	 *
	 * @return string
	 * @throws MWException
	 */
	protected function showInterwikiHit( $result, $lastInterwiki, $terms, $query, $customCaptions
	) {
		wfProfileIn( __METHOD__ );

		if ( $result->isBrokenTitle() ) {
			wfProfileOut( __METHOD__ );

			return "<!-- Broken link in search result -->\n";
		}

		$t = $result->getTitle();

		$titleSnippet = $result->getTitleSnippet( $terms );

		if ( $titleSnippet == '' ) {
			$titleSnippet = null;
		}

		$link = Linker::linkKnown( $t, $titleSnippet );

		// format redirect if any
		$redirectTitle = $result->getRedirectTitle();
		$redirectText = $result->getRedirectSnippet( $terms );
		$redirect = '';
		if ( !is_null( $redirectTitle ) ) {
			if ( $redirectText == '' ) {
				$redirectText = null;
			}

			$redirect =
				"<span class='searchalttitle'>" .
				wfMsg( 'search-redirect', Linker::linkKnown( $redirectTitle, $redirectText ) ) .
				"</span>";
		}

		$out = "";
		// display project name
		if ( is_null( $lastInterwiki ) || $lastInterwiki != $t->getInterwiki() ) {
			if ( array_key_exists( $t->getInterwiki(), $customCaptions ) ) {
				// captions from 'search-interwiki-custom'
				$caption = $customCaptions[$t->getInterwiki()];
			} else {
				// default is to show the hostname of the other wiki which might suck
				// if there are many wikis on one hostname
				$parsed = wfParseUrl( $t->getFullURL() );
				$caption = wfMsg( 'search-interwiki-default', $parsed['host'] );
			}
			// "more results" link (special page stuff could be localized, but we might not know target lang)
			$searchTitle = Title::newFromText( $t->getInterwiki() . ":Special:Search" );
			$searchLink = Linker::linkKnown( $searchTitle, wfMsg( 'search-interwiki-more' ), [], [
					'search' => $query,
					'fulltext' => 'Search',
				] );
			$out .= "</ul><div class='mw-search-interwiki-project'><span class='mw-search-interwiki-more'>
				{$searchLink}</span>{$caption}</div>\n<ul>";
		}

		$out .= "<li>{$link} {$redirect}</li>\n";
		wfProfileOut( __METHOD__ );

		return $out;
	}

	/**
	 * @param $profile
	 * @param $term
	 * @return string
	 * @throws FatalError
	 * @throws MWException
	 */
	protected function getProfileForm( $profile, $term ) {
		// Hidden stuff
		$opts = [];
		$opts['redirs'] = $this->searchRedirects;
		$opts['profile'] = $this->profile;

		if ( $profile === 'advanced' ) {
			return $this->powerSearchBox( $term, $opts );
		} else {
			$form = '';
			Hooks::run( 'SpecialSearchProfileForm', [ $this, &$form, $profile, $term, $opts ] );

			return $form;
		}
	}

	/**
	 * Generates the power search box at [[Special:Search]]
	 *
	 * @param $term string: search term
	 * @param $opts array
	 * @return string: HTML form
	 * @throws FatalError
	 * @throws MWException
	 */
	protected function powerSearchBox( $term, $opts ) {
		// Groups namespaces into rows according to subject
		$rows = [];
		foreach ( SearchEngine::searchableNamespaces() as $namespace => $name ) {
			$subject = MWNamespace::getSubject( $namespace );
			if ( !array_key_exists( $subject, $rows ) ) {
				$rows[$subject] = "";
			}
			$name = str_replace( '_', ' ', $name );
			if ( $name == '' ) {
				$name = wfMsg( 'blanknamespace' );
			}
			$rows[$subject] .= Xml::openElement( 'td', [ 'style' => 'white-space: nowrap' ] ) .
							   Xml::checkLabel( $name, "ns{$namespace}", "mw-search-ns{$namespace}",
								   in_array( $namespace, $this->namespaces ) ) .
							   Xml::closeElement( 'td' );
		}
		$rows = array_values( $rows );
		$numRows = count( $rows );

		// Lays out namespaces in multiple floating two-column tables so they'll
		// be arranged nicely while still accommodating different screen widths
		$namespaceTables = '';
		for ( $i = 0; $i < $numRows; $i += 4 ) {
			$namespaceTables .= Xml::openElement( 'table',
				[ 'cellpadding' => 0, 'cellspacing' => 0, 'border' => 0 ] );
			for ( $j = $i; $j < $i + 4 && $j < $numRows; $j ++ ) {
				$namespaceTables .= Xml::tags( 'tr', null, $rows[$j] );
			}
			$namespaceTables .= Xml::closeElement( 'table' );
		}

		$showSections = [ 'namespaceTables' => $namespaceTables ];

		// Show redirects check only if backend supports it
		if ( $this->getSearchEngine()->supports( 'list-redirects' ) ) {
			$showSections['redirects'] =
				Xml::checkLabel( wfMsg( 'powersearch-redir' ), 'redirs', 'redirs',
					$this->searchRedirects );
		}

		Hooks::run( 'SpecialSearchPowerBox', [ &$showSections, $term, $opts ] );

		$hidden = '';
		unset( $opts['redirs'] );
		foreach ( $opts as $key => $value ) {
			$hidden .= Html::hidden( $key, $value );
		}

		// Return final output
		return Xml::openElement( 'fieldset',
				[ 'id' => 'mw-searchoptions', 'style' => 'margin:0em;' ] ) .
			   Xml::element( 'legend', null, wfMsg( 'powersearch-legend' ) ) .
			   Xml::tags( 'h4', null, wfMsgExt( 'powersearch-ns', [ 'parseinline' ] ) ) .
			   Xml::tags( 'div', [ 'id' => 'mw-search-togglebox' ],
				   Xml::label( wfMsg( 'powersearch-togglelabel' ), 'mw-search-togglelabel' ) .
				   Xml::element( 'input', [
						   'type' => 'button',
						   'id' => 'mw-search-toggleall',
						   'value' => wfMsg( 'powersearch-toggleall' ),
					   ] ) . Xml::element( 'input', [
						   'type' => 'button',
						   'id' => 'mw-search-togglenone',
						   'value' => wfMsg( 'powersearch-togglenone' ),
					   ] ) ) . Xml::element( 'div', [ 'class' => 'divider' ], '', false ) .
			   implode( Xml::element( 'div', [ 'class' => 'divider' ], '', false ),
				   $showSections ) . $hidden . Xml::closeElement( 'fieldset' );
	}

	/**
	 * @return string
	 */
	protected function searchFocus() {
		$id = $this->searchAdvanced ? 'powerSearchText' : 'searchText';

		return Html::inlineScript( /*
			 * Wikia change
			 * @author Jakub Olek
			 * removing deprecated code ...
			 */
			"$(function() {" . "document.getElementById('$id').focus();" . "});" );
		// Wikia change end
	}

	protected function getSearchProfiles() {
		// Builds list of Search Types (profiles)
		$nsAllSet = array_keys( SearchEngine::searchableNamespaces() );

		$profiles = [
			'default' => [
				'message' => 'searchprofile-articles',
				'tooltip' => 'searchprofile-articles-tooltip',
				'namespaces' => SearchEngine::defaultNamespaces(),
				'namespace-messages' => SearchEngine::namespacesAsText( SearchEngine::defaultNamespaces() ),
			],
			'images' => [
				'message' => 'searchprofile-images',
				'tooltip' => 'searchprofile-images-tooltip',
				'namespaces' => [ NS_FILE ],
			],
			'help' => [
				'message' => 'searchprofile-project',
				'tooltip' => 'searchprofile-project-tooltip',
				'namespaces' => SearchEngine::helpNamespaces(),
				'namespace-messages' => SearchEngine::namespacesAsText( SearchEngine::helpNamespaces() ),
			],
			'all' => [
				'message' => 'searchprofile-everything',
				'tooltip' => 'searchprofile-everything-tooltip',
				'namespaces' => $nsAllSet,
			],
			'advanced' => [
				'message' => 'searchprofile-advanced',
				'tooltip' => 'searchprofile-advanced-tooltip',
				'namespaces' => self::NAMESPACES_CURRENT,
			],
		];

		Hooks::run( 'SpecialSearchProfiles', [ &$profiles ] );

		foreach ( $profiles as &$data ) {
			if ( !is_array( $data['namespaces'] ) ) {
				continue;
			}
			sort( $data['namespaces'] );
		}

		return $profiles;
	}

	/**
	 * @param $term
	 * @param $resultsShown
	 * @param $totalNum
	 * @return string
	 * @throws FatalError
	 * @throws MWException
	 */
	protected function formHeader( $term, $resultsShown, $totalNum ) {
		/* Wikia change begin - @author: Macbre */
		$out =
			Xml::openElement( 'table', [
				'id' => 'mw-search-top-table',
				'border' => 0,
				'cellpadding' => 0,
				'cellspacing' => 0,
			] ) . Xml::openElement( 'tr' ) . Xml::openElement( 'td' ) . "\n" .
			$this->shortDialog( $term ) . Xml::closeElement( 'td' ) . Xml::closeElement( 'tr' ) .
			Xml::closeElement( 'table' );
		/* Wikia change end */

		$out .= Xml::openElement( 'div', [ 'class' => 'mw-search-formheader' ] );

		$bareterm = $term;
		if ( $this->startsWithImage( $term ) ) {
			// Deletes prefixes
			$bareterm = substr( $term, strpos( $term, ':' ) + 1 );
		}

		$profiles = $this->getSearchProfiles();
		$lang = $this->getLanguage();

		// Outputs XML for Search Types
		$out .= Xml::openElement( 'div', [ 'class' => 'search-types' ] );
		$out .= Xml::openElement( 'ul' );
		foreach ( $profiles as $id => $profile ) {
			if ( !isset( $profile['parameters'] ) ) {
				$profile['parameters'] = [];
			}
			$profile['parameters']['profile'] = $id;

			$tooltipParam =
				isset( $profile['namespace-messages'] )
					? $lang->commaList( $profile['namespace-messages'] ) : null;
			$out .= Xml::tags( 'li', [
					'class' => $this->profile === $id ? 'current' : 'normal',
				], $this->makeSearchLink( $bareterm, [], wfMsg( $profile['message'] ),
				wfMsg( $profile['tooltip'], $tooltipParam ), $profile['parameters'] ) );
		}
		$out .= Xml::closeElement( 'ul' );
		$out .= Xml::closeElement( 'div' );

		// Results-info
		if ( $resultsShown > 0 ) {
			if ( $totalNum > 0 ) {
				$top =
					wfMsgExt( 'showingresultsheader', [ 'parseinline' ],
						$lang->formatNum( $this->offset + 1 ),
						$lang->formatNum( $this->offset + $resultsShown ),
						$lang->formatNum( $totalNum ), wfEscapeWikiText( $term ),
						$lang->formatNum( $resultsShown ) );
			} elseif ( $resultsShown >= $this->limit ) {
				$top =
					wfMsgExt( 'showingresults', [ 'parseinline' ], $lang->formatNum( $this->limit ),
						$lang->formatNum( $this->offset + 1 ) );
			} else {
				$top =
					wfMsgExt( 'showingresultsnum', [ 'parseinline' ],
						$lang->formatNum( $this->limit ), $lang->formatNum( $this->offset + 1 ),
						$lang->formatNum( $resultsShown ) );
			}
			$out .= Xml::tags( 'div', [ 'class' => 'results-info' ],
				Xml::tags( 'ul', null, Xml::tags( 'li', null, $top ) ) );
		}

		$out .= Xml::element( 'div', [ 'style' => 'clear:both' ], '', false );
		$out .= Xml::closeElement( 'div' );

		return $out;
	}

	/**
	 * @param $term string
	 * @return string
	 * @throws FatalError
	 * @throws MWException
	 */
	protected function shortDialog( $term ) {
		$out = Html::hidden( 'title', $this->getTitle()->getPrefixedText() );
		$out .= Html::hidden( 'profile', $this->profile ) . "\n";
		// Term box
		$out .= Html::input( 'search', $term, 'search', [
				'id' => $this->profile === 'advanced' ? 'powerSearchText' : 'searchText',
				'size' => '50',
				#'autofocus' // Wikia - commented out due to BugId:4016
			] ) . "\n";

		$out .= Html::hidden( 'fulltext', 'Search' ) . "\n";
		$out .= Xml::submitButton( wfMsg( 'searchbutton' ) ) . "\n";

		// Wikia change (ADi) /begin
		Hooks::run( 'SpecialSearchShortDialog', [ $term, &$out ] );

		// Wikia change (ADi) /end

		return $out . $this->didYouMeanHtml;
	}

	/**
	 * Make a search link with some target namespaces
	 *
	 * @param $term string
	 * @param $namespaces array ignored
	 * @param $label string: link's text
	 * @param $tooltip string: link's tooltip
	 * @param $params array: query string parameters
	 * @return string: HTML fragment
	 */
	protected function makeSearchLink( $term, $namespaces, $label, $tooltip, $params = [] ) {
		$opt = $params;
		foreach ( $namespaces as $n ) {
			$opt['ns' . $n] = 1;
		}
		$opt['redirs'] = $this->searchRedirects;

		$stParams = array_merge( [
			'search' => $term,
			'fulltext' => wfMsg( 'search' ),
		], $opt );

		return Xml::element( 'a', [
				'href' => $this->getTitle()->getLocalURL( $stParams ),
				'title' => $tooltip,
			], $label );
	}

	/**
	 * Check if query starts with image: prefix
	 *
	 * @param $term string: the string to check
	 * @return Boolean
	 */
	protected function startsWithImage( $term ) {
		global $wgContLang;

		$p = explode( ':', $term );
		if ( count( $p ) > 1 ) {
			return $wgContLang->getNsIndex( $p[0] ) == NS_FILE;
		}

		return false;
	}

	/**
	 * Check if query starts with all: prefix
	 *
	 * @param $term string: the string to check
	 * @return Boolean
	 */
	protected function startsWithAll( $term ) {
		$allkeyword = wfMsgForContent( 'searchall' );

		$p = explode( ':', $term );
		if ( count( $p ) > 1 ) {
			return $p[0] == $allkeyword;
		}

		return false;
	}

	/**
	 * @since 1.18
	 *
	 * @return SearchEngine
	 */
	public function getSearchEngine() {
		if ( $this->searchEngine === null ) {
			$this->searchEngine = SearchEngine::create();
		}

		return $this->searchEngine;
	}

	/**
	 * Users of hook SpecialSearchSetupEngine can use this to
	 * add more params to links to not lose selection when
	 * user navigates search results.
	 * @since 1.18
	 *
	 * @param $key
	 * @param $value
	 */
	public function setExtraParam( $key, $value ) {
		$this->extraParams[$key] = $value;
	}

}
