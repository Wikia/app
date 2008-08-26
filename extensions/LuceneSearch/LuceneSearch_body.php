<?php
/*
 * Copyright 2004, 2005 Kate Turner, Brion Vibber.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 * $Id: LuceneSearch.php 14800 2006-06-17 16:53:39Z robchurch $
 */

if (!defined('MEDIAWIKI')) {
	die( "This file is part of MediaWiki, it is not a valid entry point\n" );
}

global $IP;
require_once($IP.'/includes/SearchEngine.php');

class LuceneSearch extends SpecialPage
{
	var $namespaces;

	function LuceneSearch() {
		SpecialPage::SpecialPage('Search');
	}

	function makelink($term, $offset, $limit, $case='ignore') {
		global $wgRequest, $wgScript;
		if( $case == 'exact')
			$fulltext = htmlspecialchars(wfMsg('searchexactcase'));
		else
			$fulltext = htmlspecialchars(wfMsg('powersearch'));
		$link = $wgScript.'?title=Special:Search&amp;search='.
			urlencode($term).'&amp;fulltext='.$fulltext;
		foreach(SearchEngine::searchableNamespaces() as $ns => $name)
			if ($wgRequest->getCheck('ns' . $ns))
				$link .= '&amp;ns'.$ns.'=1';
		$link .= '&amp;offset='.$offset.'&amp;limit='.$limit;
		return $link;
	}

	function setHeaders() {
		global $wgRequest;
		if( $wgRequest->getVal( 'gen' ) == 'titlematch' ) {
			# NOP; avoid initializing the message cache
		} else {
			return parent::setHeaders();
		}
	}

	/**
	 * Callback for formatting of near-match title list.
	 *
	 * @param LuceneSearchSet $result
	 * @return string
	 * @access private
	 */
	function formatNearMatch( $result ) {
		$title = $result->getTitle();
		return wfMsg( 'searchnearmatch',
			$this->mSkin->makeKnownLinkObj( $title ) );
	}

	function execute($par) {
		global $wgRequest, $wgOut, $wgTitle, $wgContLang, $wgUser,
			$wgScriptPath,
			$wgLuceneDisableTitleMatches, $wgLuceneDisableSuggestions,
			$wgUser;
		global $wgGoToEdit;

		wfLoadExtensionMessages( 'LuceneSearch' );
		$fname = 'LuceneSearch::execute';
		wfProfileIn( $fname );
		$this->setHeaders();
		$wgOut->addHTML('<!-- titlens = '. $wgTitle->getNamespace() . '-->');

		foreach(SearchEngine::searchableNamespaces() as $ns => $name)
			if ($wgRequest->getCheck('ns' . $ns))
				$this->namespaces[] = $ns;

		if (count($this->namespaces) == 0) {
			foreach(SearchEngine::searchableNamespaces() as $ns => $name) {
				if($wgUser->getOption('searchNs' . $ns)) {
					$this->namespaces[] = $ns;
				}
			}
			if (count($this->namespaces) == 0) {
				global $wgNamespacesToBeSearchedDefault;
				foreach( $wgNamespacesToBeSearchedDefault as $ns => $searchit ) {
					if( $searchit ) {
						$this->namespaces[] = $ns;
					}
				}
			}
		}

		$bits = split('/', $wgRequest->getVal('title'), 2);
		if(!empty($bits[1]))
			$q = str_replace('_', ' ', $bits[1]);
		else
			$q = $wgRequest->getText('search');
		list( $limit, $offset ) = $wgRequest->getLimitOffset( LS_PER_PAGE, 'searchlimit' );

		if( $wgRequest->getVal( 'gen' ) == 'titlematch' ) {
			$this->sendTitlePrefixes( $q, $limit );
			wfProfileOut( $fname );
			return;
		}

		$this->mSkin =& $wgUser->getSkin();
		if (!$wgLuceneDisableSuggestions)
			$wgOut->addHTML($this->makeSuggestJS());
		$wgOut->addLink(array(
			'rel' => 'stylesheet',
			'type' => 'text/css',
			'media' => 'screen,projection',
			'href' => $wgScriptPath . '/extensions/LuceneSearch/lucenesearch.css'
			)
		);

		$wgOut->addWikiText(wfMsg('searchresulttext'));
		$wgOut->addHTML($this->showShortDialog($q));

		if ($q === false || strlen($q) == 0) {
			// No search active. Put input focus in the search box.
			$wgOut->addHTML( $this->makeFocusJS() );
		} else {
			if (!($wgRequest->getText('fulltext'))) {
				$t = SearchEngine::getNearMatch($q);
				if(!is_null($t)) {
					$wgOut->redirect($t->getFullURL());
					wfProfileOut( $fname );
					return;
				}
			}

			# No match, generate an edit URL
			$t = Title::newFromText($q);
			if(!$wgRequest->getText('go') || is_null($t)) {
				$editurl = ''; # hrm...
			} else {
				wfRunHooks( 'SpecialSearchNogomatch', array( &$t ) );
				# If the feature is enabled, go straight to the edit page
				if ($wgGoToEdit) {
					$wgOut->redirect($t->getFullURL('action=edit'));
					return;
				}
				if( $t->quickUserCan( 'create' ) && $t->quickUserCan( 'edit' ) ) {
					$wgOut->addWikiText( wfMsg( 'noexactmatch', $t->getPrefixedText() ) );
				} else {
					$wgOut->addWikiText( wfMsg( 'noexactmatch-nocreate', $t->getPrefixedText() ) );
				}
			}

			$case = 'ignore';
			# Replace localized namespace prefixes (from lucene-search 2.0)
			global $wgLuceneSearchVersion;
			if($wgLuceneSearchVersion >= 2){
				$searchq = $this->replacePrefixes($q);
				if($wgRequest->getText('fulltext') == wfMsg('searchexactcase'))
					$case = 'exact';
			} else
				$searchq = $q;

			global $wgDisableTextSearch;
			if( !$wgDisableTextSearch ) {
				$results = LuceneSearchSet::newFromQuery( 'search', $searchq, $this->namespaces, $limit, $offset, $case );
			}

			if( $wgDisableTextSearch || $results === false ) {
				if ( $wgDisableTextSearch ) {
					$wgOut->addHTML(wfMsg('searchdisabled'));
				} else {
					$wgOut->addWikiText(wfMsg('lucenefallback'));
				}
				$wgOut->addHTML(wfMsg('googlesearch',
					htmlspecialchars($q),
					'utf-8',
                                        htmlspecialchars( wfMsg( 'search' ) ) ) );
				wfProfileOut( $fname );
				return;
			}

			$subtitleMsg = is_object( Title::newFromText( $q ) ) ? 'searchsubtitle' : 'searchsubtitleinvalid';
			$wgOut->setSubtitle( $wgOut->parse( wfMsg( $subtitleMsg, wfEscapeWikiText( $q ) ) ) );

			// If the search returned no results, an alternate fuzzy search
			// match may be displayed as a suggested search. Link it.
			if( $results->hasSuggestion() ) {
				$suggestion = $results->getSuggestion();
				$o = ' ' . wfMsg('searchdidyoumean',
						$this->makeLink( $suggestion, $offset, $limit, $case ),
						htmlspecialchars( $suggestion ) );
				$wgOut->addHTML( '<div style="text-align: center;">'.$o.'</div>' );
			}

			$nmtext = '';
			if ($offset == 0 && !$wgLuceneDisableTitleMatches) {
				$titles = LuceneSearchSet::newFromQuery( 'titlematch', $q, $this->namespaces, 5, $case );
				if( $titles && $titles->hasResults() ) {
					$nmtext = '<p>'.wfMsg('searchnearmatches').'</p>';
					$nmtext .= '<ul>';
					$nmtext .= implode( "\n", $titles->iterateResults(
						array( &$this, 'formatNearMatch' ) ) );
					$nmtext .= '</ul>';
					$nmtext .= '<hr />';
				}
			}

			$wgOut->addHTML($nmtext);

			if( !$results->hasResults() ) {
				# Pass search terms back in a few different formats
				# $1: Plain search terms
				# $2: Search terms with s/ /_/
				# $3: URL-encoded search terms
				$tmsg = array( htmlspecialchars( $q ), htmlspecialchars( str_replace( ' ', '_', $q ) ), wfUrlEncode( $q ) );
				$wgOut->addHtml( wfMsgWikiHtml( 'searchnoresults', $tmsg[0], $tmsg[1], $tmsg[2] ) );
			} else {
				#$showresults = min($limit, count($results)-$numresults);
				$i = $offset;
				$resq = trim(preg_replace("/[ |\\[\\]()\"{}+]+/", " ", $q));
				$contextWords = implode("|",
					array_map( array( &$this, 'regexQuote' ),
						$wgContLang->convertForSearchResult(split(" ", $resq))));

				$top = wfMsg('searchnumber', $offset + 1,
					min($results->getTotalHits(), $offset+$limit), $results->getTotalHits());
				$out = '<ul id="lucene-results">';
				$numchunks = ceil($results->getTotalHits() / $limit);
				$whichchunk = $offset / $limit;
				$prevnext = "";
				if ($whichchunk > 0)
					$prevnext .= '<a href="'.
						$this->makelink($q, $offset-$limit, $limit, $case).'">'.
						wfMsg('searchprev').'</a> ';
				$first = max($whichchunk - 11, 0);
				$last = min($numchunks, $whichchunk + 11);
				//$wgOut->addWikiText("whichchunk=$whichchunk numchunks=$numchunks first=$first last=$last num=".count($chunks)." limit=$limit offset=$offset results=".count($results)."\n\n");
				if ($last - $first > 1) {
					for($i = $first; $i < $last; $i++) {
						if ($i === $whichchunk)
							$prevnext .= '<strong>'.($i+1).'</strong> ';
						else
							$prevnext .= '<a href="'.
								$this->makelink($q, $limit*$i,
								$limit, $case).'">'.($i+1).'</a> ';
					}
				}
				if ($whichchunk < $last-1)
					$prevnext .= '<a href="'.
						$this->makelink($q, $offset + $limit, $limit, $case).'">'.
						wfMsg('searchnext').'</a> ';
				$prevnext = '<div style="text-align: center;">'.$prevnext.'</div>';
				$top .= $prevnext;
				$out .= implode( "\n", $results->iterateResults(
					array( &$this, 'showHit'), $contextWords ) );
				$out .= '</ul>';
			}
			$wgOut->addHTML('<hr />');
			if( isset( $top ) ) $wgOut->addHTML( $top );
			if( isset( $out ) ) $wgOut->addHTML( $out );
			if( isset( $prevnext ) ) $wgOut->addHTML('<hr />' . $prevnext);
			$wgOut->addHTML($this->showFullDialog($q));
		}
		$wgOut->setRobotpolicy('noindex,nofollow');
                $wgOut->setArticleRelated(false);
		wfProfileOut( $fname );
	}

	/**
	 * Replaces localized namespace prefixes with the standard ones
	 * defined in lucene-search daemon global configuration
	 *
	 * Small parser that extracts prefixes (e.g. help from 'help:editing'),
	 * but ignores those that are within quotes (i.e. in a phrase). It
	 * replaces those with prefixes defined in messages searchall (all keyword)
	 * and searchincategory (incategory keyword), and in wgLuceneSearchNSPrefixes.
	 *
	 *
	 * @param query - search query
	 * @access private
	 */
	function replacePrefixes( $query ) {
		global $wgContLang;
		$qlen = strlen($query);
		$start = 0; $len = 0; // token start pos and length
		$rewritten = ''; // rewritten query
		$rindex = 0; // point to last rewritten character
		$inquotes = false;

		$allkeywords = explode("\n",wfMsg('searchall'));
		$incatkeywords = explode("\n",wfMsg('searchincategory'));
		$aliaspairs = explode("\n",wfMsg('searchaliases'));
		$aliases = array(); // alias => indexes
		foreach($aliaspairs as $ap){
			$parts = explode('|',$ap);
			if(count($parts) == 2){
				$namespaces = explode(',',$parts[1]);
				$rewrite = array();
				foreach($namespaces as $ns){
					$index = $wgContLang->getNsIndex($ns);
					if($index !== false){
						$rewrite[] = $index;
					}
				}
				$aliases[$parts[0]] = $rewrite;
			}
		}
		for($i = 0 ; $i < $qlen ; $i++){
			$c = $query[$i];

			// ignore chars in quotes
			if($inquotes && $c!='"');
			// check if $c is valid prefix character
			else if(($c >= 'a' && $c <= 'z') ||
				 ($c >= 'A' && $c <= 'Z') ||
				 $c == '_' || $c == '-' || $c ==','){
				if($len == 0){
					$start = $i; // begin of token
					$len = 1;
				} else
					$len++;
			// check for utf-8 chars
			} else if(($c >= "\xc0" && $c <= "\xff")){
				$utf8len = 1;
				for($j = $i+1; $j < $qlen; $j++){ // fetch extra utf-8 bytes
					if($query[$j] >= "\x80" && $query[$j] <= "\xbf")
						$utf8len++;
					else
						break;
				}
				if($len == 0){
					$start = $i;
					$len = $utf8len;
				} else
					$len += $utf8len;
				$i = $j - 1;  // we consumed the chars
			// check for end of prefix (i.e. semicolon)
			} else if($c == ':' && $len !=0){
				$rewrite = array(); // here we collect namespaces
				$prefixes = explode(',',substr($query,$start,$len));
				// iterate thru comma-separated list of prefixes
				foreach($prefixes as $prefix){
					$index = $wgContLang->getNsIndex($prefix);

					// check for special prefixes all/incategory
					if(in_array($prefix,$allkeywords)){
						$rewrite = 'all';
						break;
					} else if(in_array($prefix,$incatkeywords)){
						$rewrite = 'incategory';
						break;
					// check for localized names of namespaces
					} else if($index !== false)
						$rewrite[] = $index;
					// check aliases
					else if(isset($aliases[$prefix]))
						$rewrite = array_merge($rewrite,$aliases[$prefix]);

				}
				$translated = null;
				if($rewrite === 'all' || $rewrite === 'incategory')
					$translated = $rewrite;
				else if(count($rewrite) != 0)
					$translated = '['.implode(',',array_unique($rewrite)).']';

				if(isset($translated)){
					// append text before the prefix, and then the prefix
					$rewritten .= substr($query,$rindex,$start-$rindex);
					$rewritten .= $translated . ':';
					$rindex = $i+1;
				}

				$len = 0;
			} else{ // end of token
				if($c == '"') // get in/out of quotes
					$inquotes = !$inquotes;

				$len = 0;
			}

		}
		// add rest of the original query that doesn't need rewritting
		$rewritten .= substr($query,$rindex,$qlen-$rindex);

		return $rewritten;
	}

	/**
	 * Stupid hack around PHP's limited lambda support
	 * @access private
	 */
	function regexQuote( $term ) {
		return '\b' . preg_quote( $term, '/' ) . '\b';
	}

	/**
	 * Send a list of titles starting with the given prefix.
	 * These are read by JavaScript code via an XmlHttpRequest
	 * and displayed in a drop-down box for selection.
	 *
	 * @param string $query
	 * @param int $limit
	 * @return void - side effects only
	 * @access private
	 */
	function sendTitlePrefixes( $query, $limit ) {
		global $wgOut;
		$wgOut->disable();

		if( $limit < 1 || $limit > 50 )
			$limit = 20;
		header('Content-Type: text/plain; charset=utf-8');
		if( strlen( $query ) < 1 ) {
			return;
		}

		/// @fixme -- this is totally missing atm
		return;

		$results = $this->doTitlePrefixSearch( $query, $limit );
		if( $results && count( $results ) > 0 ) {
			foreach( $results as $result ) {
				echo $result->getPrefixedUrl() . "\n";
			}
		}
	}

	function showHit($result, $terms) {
		$fname = 'LuceneSearch::showHit';
		wfProfileIn($fname);
		global $wgUser, $wgLang, $wgContLang, $wgTitle, $wgOut, $wgDisableSearchContext;

		$t = $result->getTitle();
		if(is_null($t)) {
			wfProfileOut($fname);
			return "<!-- Broken link in search result -->\n";
		}

		//$contextlines = $wgUser->getOption('contextlines');
		$contextlines = 2;
		$contextchars = $wgUser->getOption('contextchars');
		if ('' == $contextchars)
			$contextchars = 50;
		if ( intval($contextchars) > 5000 )
			$contextchars = 5000;

		$link = $this->mSkin->makeKnownLinkObj($t, '');

		if ( !$wgDisableSearchContext ) {
			$rev = Revision::newFromTitle($t);
			if ($rev === null) {
				wfProfileOut( $fname );
				return "<!--Broken link in search results: ".$t->getDBkey()."-->\n";
			}

			$text = $rev->getText();
			$size = wfMsgHtml( 'lucene-resultsize',
				$this->mSkin->formatSize( strlen( $text ) ),
				str_word_count( $text ) );
			$text = $this->removeWiki($text);
			$date = $wgContLang->timeanddate($rev->getTimestamp());
		} else {
			$text = '';
			$date = '';
		}

		$lines = explode("\n", $text);

		$max = intval($contextchars) + 1;
		$pat1 = "/(.*)($terms)(.{0,$max})/i";

		$lineno = 0;

		$extract = '';
		wfProfileIn($fname.'-extract');
		foreach ($lines as $line) {
			if (0 == $contextlines)
				break;
			++$lineno;
			if (!preg_match($pat1, $line, $m))
				continue;
			--$contextlines;
			$pre = $wgContLang->truncate($m[1], -$contextchars, '...');

			if (count($m) < 3)
				$post = '';
			else
				$post = $wgContLang->truncate($m[3], $contextchars, '...');

			$found = $m[2];

			$line = htmlspecialchars($pre . $found . $post);
			$pat2 = '/([^ ]*(' . $terms . ")[^ ]*)/i";
			$line = preg_replace($pat2,
			  "<span class='searchmatch'>\\1</span>", $line);

			$extract .= "<br /><small>{$line}</small>\n";
		}
		wfProfileOut($fname.'-extract');
		wfProfileOut($fname);
		if (!$wgDisableSearchContext) { $date = $wgContLang->timeanddate($rev->getTimestamp()); }
		else { $date = ''; }
		$percent = sprintf( '%2.1f', $result->getScore() * 100 );
		$score = wfMsg( 'lucene-searchscore', $wgLang->formatNum( $percent ) );
		//$url = $t->getFullURL();
		return '<li style="padding-bottom: 1em;">'.$link.$extract.'<br />'
			.'<span style="color: green; font-size: small;">'
			."$score - $size - $date</span></li>\n";
	}

	/* Basic wikitext removal */
	function removeWiki($text) {
		//$text = preg_replace("/'{2,5}/", "", $text);
		$text = preg_replace("/\[[a-z]+:\/\/[^ ]+ ([^]]+)\]/", "\\2", $text);
		//$text = preg_replace("/\[\[([^]|]+)\]\]/", "\\1", $text);
		//$text = preg_replace("/\[\[([^]]+\|)?([^|]]+)\]\]/", "\\2", $text);
		$text = preg_replace("/\\{\\|(.*?)\\|\\}/", "", $text);
		$text = preg_replace("/\\[\\[[A-Za-z_-]+:([^|]+?)\\]\\]/", "", $text);
		$text = preg_replace("/\\[\\[([^|]+?)\\]\\]/", "\\1", $text);
		$text = preg_replace("/\\[\\[([^|]+\\|)(.*?)\\]\\]/", "\\2", $text);
		$text = preg_replace("/<\/?[^>]+>/", "", $text);
		$text = preg_replace("/'''''/", "", $text);
		$text = preg_replace("/('''|<\/?[iIuUbB]>)/", "", $text);
		$text = preg_replace("/''/", "", $text);

		return $text;
	}

	function showShortDialog($term) {
		global $wgScript, $wgLuceneDisableSuggestions;
		global $wgLuceneSearchExactCase;

		$action = "$wgScript";
		$searchButton = '<input type="submit" name="fulltext" value="' .
			htmlspecialchars(wfMsg('powersearch')) . "\" />\n";
		if($wgLuceneSearchExactCase){
			$exactSearch = '<input type="submit" name="fulltext" value="' .
			htmlspecialchars(wfMsg('searchexactcase')) . "\" />\n";
			$leftMargin = "10%";
		} else{
			$exactSearch = "";
			$leftMargin = "25%";
		}
		$onkeyup = $wgLuceneDisableSuggestions ? '' :
			' onkeyup="resultType()" autocomplete="off" ';
		$searchField = "<div><input type='text' id='lsearchbox' $onkeyup "
			. "style='margin-left: $leftMargin; width: 50%; ' value=\""
			. htmlspecialchars($term) . '"'
			. " name=\"search\" />\n"
			. "<span id='loadStatus'></span>"
			. $searchButton
			. $exactSearch
			. "<div id='results'></div></div>";

		$ret = $searchField /*. $searchButton*/;
                return
		  '<form id="search" method="get" '
                  . "action=\"$action\"><input type='hidden' name='title' value='Special:Search' />\n<div>{$ret}</div>\n</form>\n";
	}

	function showFullDialog($term) {
		global $wgContLang, $wgLuceneSearchExactCase;
		$namespaces = '';
		foreach(SearchEngine::searchableNamespaces() as $ns => $name) {
			$checked = in_array($ns, $this->namespaces)
			           ? ' checked="checked"' : '';
			$name = str_replace('_', ' ', $name);
			if('' == $name) {
				$name = wfMsg('blanknamespace');
			}
			$namespaces .= " <label><input type='checkbox' value=\"1\" name=\"" .
			               "ns{$ns}\"{$checked} />{$name}</label>\n";
		}

		$searchField = "<input type='text' name=\"search\" value=\"" .
					   htmlspecialchars($term) ."\" size=\"16\" />\n";

		$searchButton = '<input type="submit" name="fulltext" value="' .
						htmlspecialchars(wfMsg('powersearch')) . "\" />\n";

		if($wgLuceneSearchExactCase){
			$exactSearch = '<input type="submit" name="fulltext" value="' .
			htmlspecialchars(wfMsg('searchexactcase')) . "\" />\n";
		} else
			$exactSearch = "";

		$redirect = ''; # What's this for?
		$ret = wfMsg('lucenepowersearchtext',
			$namespaces, $redirect, $searchField,
			'', '', '', '', '', # Dummy placeholders
			$searchButton, $exactSearch);

		$title = Title::makeTitle(NS_SPECIAL, 'Search');
		$action = $title->escapeLocalURL();
		return "<br /><br />\n<form id=\"powersearch\" method=\"get\" " .
		"action=\"$action\">\n{$ret}\n</form>\n";
	}

	function makeFocusJS() {
		return "<script type='text/javascript'>" .
			"document.getElementById('lsearchbox').focus();" .
			"</script>";
	}

	function makeSuggestJS() {
		global $wgScript, $wgArticlePath;
		return <<<___EOF___
<script type="text/javascript"><!--

function openXMLHttpRequest() {
	if( window.XMLHttpRequest ) {
		return new XMLHttpRequest();
	} else if( window.ActiveXObject && navigator.platform != 'MacPPC' ) {
		// IE/Mac has an ActiveXObject but it doesn't work.
		return new ActiveXObject("Microsoft.XMLHTTP");
	} else {
		return null;
	}
}
var xmlHttp = openXMLHttpRequest();
var searchCache = {};
var searchStr;
var searchTimeout;

function getResults()
{
  var encStr = escape(searchStr.replace(/ /g, '_'));
  xmlHttp.open("GET", "$wgScript?title=Special:Search&gen=titlematch&ns0=0&limit=10&search="
    + encStr, true);

  xmlHttp.onreadystatechange = parseResults;
  xmlHttp.send(null);
}

function parseResults()
{
  if (xmlHttp.readyState > 3)
  {
    document.getElementById("loadStatus").innerHTML = "";
    var resultArr = xmlHttp.responseText.split("\\n");
    resultArr.pop(); // trim final newline
    searchCache[searchStr.toLowerCase()] = resultArr;
    showResults(resultArr);
  }
}

function showResults(resultArr)
{
  var returnStr = "";
  var resultsEl = document.getElementById("results");

  if (resultArr.length < 1)
    resultsEl.innerHTML = "No results";
  else
  {
    resultsEl.innerHTML = "";

    for (var i=0; i < resultArr.length; i++)
    {
      var linkEl = document.createElement("a");
      linkEl.href = "$wgArticlePath".replace(/\\$1/, resultArr[i]);
      var textEl = document.createTextNode(decodeURIComponent(resultArr[i]).replace(/_/g, ' '));
      linkEl.appendChild(textEl);
      resultsEl.appendChild(linkEl);
    }
  }

  resultsEl.style.display = "block";
}

function resultType()
{
  if (!xmlHttp) return;
  searchStr = document.getElementById("lsearchbox").value;
  if (searchTimeout) clearTimeout(searchTimeout);

  if (searchStr != "")
  {
    if (searchCache[searchStr.toLowerCase()])
      showResults(searchCache[searchStr.toLowerCase()])
    else
      searchTimeout = setTimeout(getResults, 500);
  }
  else
  {
    document.getElementById("results").style.display = "none";
  }
}
//--></script>
___EOF___;
	}
}

class LuceneResult {
	/**
	 * Read an input line from a socket and return a score & title pair.
	 * Will return FALSE if no more data or I/O error.
	 *
	 * @param resource $sock
	 * @return array (float, Title)
	 * @access private
	 */
	function LuceneResult( $line ) {
		wfDebug( "Lucene line: '$line'\n" );
		list( $score, $namespace, $title ) = split( ' ', $line );

		$score     = floatval( $score );
		$namespace = intval( $namespace );
		$title     = urldecode( $title );

		$this->mTitle = Title::makeTitle( $namespace, $title );
		$this->mScore = $score;
	}

	function getTitle() {
		return $this->mTitle;
	}

	function getScore() {
		return $this->mScore;
	}
}

class LuceneSearchSet {
	/**
	 * Contact the MWDaemon search server and return a wrapper
	 * object with the set of results. Results may be cached.
	 *
	 * @param string $method The protocol verb to use
	 * @param string $query
	 * @param int $limit
	 * @return array
	 * @access public
	 * @static
	 */
	function newFromQuery( $method, $query, $namespaces = array(), $limit = 10, $offset = 0, $case = 'ignore' ) {
		$fname = 'LuceneSearchSet::newFromQuery';
		wfProfileIn( $fname );

		global $wgLuceneHost, $wgLucenePort, $wgLuceneSearchVersion;
		global $wgDBname, $wgMemc;

		$enctext = rawurlencode( trim( $query ) );
		$searchPath = "/$method/$wgDBname/$enctext?" .
			wfArrayToCGI( array(
				'namespaces' => implode( ',', $namespaces ),
				'offset'     => $offset,
				'limit'      => $limit,
				'case'       => $case,
			) );

		global $wgOut;
		$wgOut->addHtml( "<!-- querying $searchPath -->\n" );

		// Cache results for fifteen minutes; they'll be read again
		// on reloads and paging.
		$key = wfMemcKey( 'lucene', $wgLuceneSearchVersion, md5( $searchPath ) );

		$resultSet = $wgMemc->get( $key );
		if( is_object( $resultSet ) ) {
			wfDebug( "$fname: got cached lucene results for key $key\n" );
			wfProfileOut( $fname );
			return $resultSet;
		}

		if( is_array( $wgLuceneHost ) ) {
			$hosts = $wgLuceneHost;
		} else {
			$hosts = array( $wgLuceneHost );
		}
		$remaining = count( $hosts );
		$pick = mt_rand( 0, count( $hosts ) - 1 );
		$data = false;

		while( $data === false && $remaining-- > 0 ) {
			// Start at a random position in the list, and rotate through
			// until we find a host that works or run out of hosts.
			$pick = ($pick + 1) % count( $hosts );
			$host = $hosts[$pick];
			$searchUrl = "http://$host:$wgLucenePort$searchPath";

			wfDebug( "Fetching search data from $searchUrl\n" );
			wfSuppressWarnings();
			wfProfileIn( $fname.'-contact-'.$host );
			$data = Http::get( $searchUrl );
			wfProfileOut( $fname.'-contact-'.$host );
			wfRestoreWarnings();

			if( $data === false ) {
				wfDebug( "Failed on $searchUrl!\n" );
			}
		}

		if( $data === false || $data === '' ) {
			// Network error or server error
			wfProfileOut( $fname );
			return false;
		} else {
			$inputLines = explode( "\n", trim( $data ) );
			$resultLines = array_map( 'trim', $inputLines );
		}

		$suggestion = null;
		$totalHits = null;

		if( $method == 'search' ) {
			# This method outputs a summary line first.
			$totalHits = array_shift( $resultLines );
			if( $totalHits === false ) {
				# I/O error? this shouldn't happen
				wfDebug( "Couldn't read summary line...\n" );
			} else {
				$totalHits = intval( $totalHits );
				wfDebug( "total [$totalHits] hits\n" );
				if( $totalHits == 0 ) {
					# No results, but we got a suggestion...
					$suggestion = urldecode( array_shift( $resultLines ) );
					wfDebug( "no results; suggest: [$suggestion]\n" );
				}
			}
		}

		$resultSet = new LuceneSearchSet( $resultLines, $totalHits, $suggestion );

		wfDebug( $fname.": caching lucene results for key $key\n" );
		global $wgLuceneCacheExpiry;
		$wgMemc->add( $key, $resultSet, $wgLuceneCacheExpiry );

		wfProfileOut( $fname );
		return $resultSet;
	}

	/**
	 * Private constructor. Use LuceneSearchSet::newFromQuery().
	 *
	 * @param array $lines
	 * @param int $totalHits
	 * @param string $suggestion
	 * @access private
	 */
	function LuceneSearchSet( $lines, $totalHits = null, $suggestion = null ) {
		$this->mTotalHits  = $totalHits;
		$this->mSuggestion = $suggestion;
		$this->mResults    = $lines;
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
	 * Some search modes return a suggested alternate term if there are
	 * no exact hits. Returns true if there is one on this set.
	 *
	 * @return bool
	 * @access public
	 */
	function hasSuggestion() {
		return is_string( $this->mSuggestion ) && $this->mSuggestion != '';
	}

	/**
	 * Some search modes return a suggested alternate term if there are
	 * no exact hits. Check hasSuggestion() first.
	 *
	 * @return string
	 * @access public
	 */
	function getSuggestion() {
		return $this->mSuggestion;
	}

	/**
	 * Iterate over all returned results, passing LuceneResult objects
	 * to a given callback for processing.
	 *
	 * @param callback $callback
	 * @param mixed $userdata Optional data to pass to the callback
	 * @return array
	 * @access public
	 */
	function iterateResults( $callback, $userdata = null ) {
		$out = array();
		foreach( $this->mResults as $key => $line ) {
			$item = call_user_func( $callback, new LuceneResult( $line ), $userdata );
			if ( !is_null($item) ) $out[$key] = $item;
		}
		return $out;
	}
}
