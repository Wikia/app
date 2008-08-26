<?php
/*
 * Short description and installation instruction available at http://staff.wikia.com/wiki/WikiaSearch
 * @author Inez Korczyński inez (at) wikia.com
 */
if(!defined('MEDIAWIKI')) {
	die();
}

define("LUCENE", 0);
define("CSE", 1);

require_once("$IP/extensions/wikia/WikiaSearch/WikiaSearchTemplates.php");
require_once("$IP/extensions/wikia/WikiaSearch/WikiaSearchEngine.php");
include_once("$IP/includes/SpecialPage.php");

class WikiaSearch extends SpecialPage {

	var $advanced = false; /* use advanced search form? */

	var $tab = null; /* requested tab */

	var $useTabsSearch = false;

	var $useGoogleSearch = false;

	var $useOldMatches = false;

	var $tabs = array(); /* array of search tabs parameters */

	var $engine = null;

	var $simpleQuery;

	var $formURL;

	var $page;

	var $pagee;

	var $rows;

	function WikiaSearch() {
		global $wgRequest, $wgMessageCache;
		$search = $wgRequest->getText( 'search');
		if( $wgRequest->getVal( 'go' ) || $wgRequest->getVal( 'go_x') || $wgRequest->getVal('go_y') )
		{
			$this->goResult( $search );
		}

		SpecialPage::SpecialPage("Search");
		$wgMessageCache->addMessage('thiswiki', 'This wiki');
		$wgMessageCache->addMessage('allwikis', 'All Wikia');
		$wgMessageCache->addMessage('wikipedia', 'Wikipedia');
		$wgMessageCache->addMessage('theweb', 'The Web');
		$wgMessageCache->addMessage('resultsof', 'Results $1 - $2 of $3');
		$wgMessageCache->addMessage('searcherror', '<br />Sorry! An error occured during your search. Please check your query.');
		$wgMessageCache->addMessage('length', 'length: $1');
		$wgMessageCache->addMessage('searchbutton', 'Search');
		$wgMessageCache->addMessage('noresults', "No page with that title exists.  You can:
		
		* '''[[Special:CreatePage|create this page]]'''
		* See all pages within this wiki that [[Special:Whatlinkshere/$1|link to this page]].");
	}

	function goResult( $search ) {
		global $wgOut, $wgGoToEdit;
		$title = Title::newFromText( $search );
		wfRunHooks( 'SearchCache', array( $search ) );

		if( !is_null( $title ) && $title->mArticleID != -1) {
			$wgOut->redirect( $title->getFullURL() );
			return;
		}

		$title = SearchEngine::getNearMatch( $search );

		if( !is_null( $title ) && $title->mArticleID != -1) {
			$wgOut->redirect( $title->getFullURL() );
			return;
		}
	}

	function getEngine() {
		if( ! $this->useTabsSearch ) {
			if ( $this->useGoogleSearch ) {
				return CSE;
			} else {
				return LUCENE;
			}
		}

		for( $i = 0; $i < count($this->tabs); $i++ ) {
			if( $this->tabs[$i]['active'] == TRUE ) {
				if( isset($this->tabs[$i]['cx']) ){
					return CSE;
				} else {
					return LUCENE;
				}
			}
		}
	}

	function getTabId($cx) {
		if($cx != null) {
			for( $i = 0; $i < count($this->tabs); $i++ ) {
				if($this->tabs[$i]['cx'] == $cx) {
					return $i;
				}
			}
		}
		return null;
	}

	function getCSEParam() {
		return "q={$this->simpleQuery}&sa=Search&cof=FORID%3A9";
	}

	function getLUCENEParam() {
		return "search={$this->simpleQuery}";
	}

	function getEngineForTab($id) {
		if(isset($this->tabs[$id]['cx']) && $this->tabs[$id]['cx'] != null) {
			return CSE;
		} else {
			return LUCENE;
		}
	}

	function execute($par) {
		global $wgRequest, $wgOut, $wgUser, $wgDefaultSearch, $wgDefaultSearchTab;

		if ( ! is_int ( $wgDefaultSearch ) ) {
			$wgDefaultSearch = 0;
		}

		$searchType = $wgUser->getOption( 'searchtype', $wgDefaultSearch);
		if ( $searchType == 0) {
			$this->useTabsSearch = true;
		} else if ( $searchType == 1) {
			$this->useTabsSearch = true;
			$this->useGoogleSearch = true;
		} else if ( $searchType == 2) {

		} else if ( $searchType == 3) {
			$this->useOldMatches = true;
		}

		$this->rows = (int) $wgUser->getOption( 'searchlimit' );
		if( ! is_int($this->rows) ){
			$this->rows = 10;
		}

		$wgOut->setPageTitle( wfMsg( 'searchresults' ) );

		/* affect tabs and non-tabs search */
		if( $wgRequest->getText('adv') == "true" ) {
			$this->advanced = true;
		}
		$this->page = (int) $wgRequest->getText('page', 1);
		if( ! is_int( $this->page ) ) {
			$this->page = 1;
		}

		$this->pagee = (int) $wgRequest->getText('pagee', 1);
		if( ! is_int( $this->pagee ) ) {
			$this->pagee = 1;
		}

		/* tab number and google search append only to tabs search interface */
		if( $this->useTabsSearch == true ) {

			$this->tabs[0] = array('name' => wfMsg('thiswiki'));
			$this->tabs[1] = array('name' => wfMsg('allwikis'));

			if($this->useGoogleSearch == true) {
				global $wgGoogleID;
				$this->tabs[0]['cx'] = $wgGoogleID;
				$this->tabs[1]['cx'] = '006946227951768953224:cvq-prxgh24';
			}

			$this->tabs[2] = array('name' => wfMsg('wikipedia'), 'cx' => '006946227951768953224:z6qol-m55ym');
			$this->tabs[3] = array('name' => wfMsg('theweb'), 'cx' => '006946227951768953224:ojsaib9fcnc');

			if ( $wgDefaultSearchTab == "" ) {
				$wgDefaultSearchTab = 0;
			}

			$this->tab = $this->getTabId($wgRequest->getText('cx', null));
			if( $this->tab == null) {
				$this->tab = $wgRequest->getText('tab', $wgDefaultSearchTab);
				if( $this->tab == "" ) {
					$this->tab = $wgDefaultSearchTab;
				}
			}

			$this->tabs[$this->tab]['active'] = true;
		}

		$target = Title::newFromText("Search", NS_SPECIAL);
		$this->formURL = $target->getLocalURL();


		if($this->advanced) {
			$wgOut->addHTML("This is Advanced search form... <br />");
			$wgOut->addHTML("...and Advanced search results <br />");

		} else {
			$this->simpleQuery = $wgRequest->getText('search', $wgRequest->getText('q'));

			$this->engine = $this->getEngine();

			if( $this->engine == LUCENE ) {
				$form = $this->getLuceneForm();
			} else {
				$this->redirIfNeeded();
				$form = $this->getCSEForm();
			}

			$wgOut->addHTML( $form );

			$wgOut->addScript ( '<link rel="stylesheet" type="text/css" href="/extensions/wikia/WikiaSearch/search.css" />' );

			if( $this->useTabsSearch == true ) {
				$wgOut->addHTML( $this->printTabs() );
			}

			if($this->simpleQuery != "") {
				wfRunHooks( 'SearchCache', array( $this->simpleQuery ) );
				if( $this->engine == LUCENE ) {

					$engine = new SimpleWikiaSearchEngine();
					$engine->setRows($this->rows);
					$engine->setWord($this->simpleQuery);
					$engine->setOffset(($this->page-1)*$this->rows);
					$engine->setOnly($this->tab);

					if($this->useTabsSearch == false && $this->useOldMatches == true) {
						$results = $engine->getResultsArray(true, false);
						$wgOut->addHTML( $this->getLuceneResultsBox($results, wfMsg('titlematches'), 'page', true));
						$wgOut->addHTML( $this->getLucenePager($results, 'page') );
						$wgOut->addHTML( '<br /><br />' );
						$engine->setOffset(($this->pagee-1)*$this->rows);
						$results = $engine->getResultsArray(false, true);
						$wgOut->addHTML( $this->getLuceneResultsBox($results, wfMsg('textmatches'), 'pagee'));
						$wgOut->addHTML( $this->getLucenePager($results, 'pagee') );
					} else {
						$results = $engine->getResultsArray();
						$wgOut->addHTML( $this->getLuceneResultsBox($results) );
						$wgOut->addHTML( $this->getLucenePager($results) );
					}
				} else {
					$wgOut->addHTML( $this->getCSEResultsBox() );
				}
			}
		}
	}

	function printTabs() {
		global $activetabtemplate, $tabtemplate, $tabstemplate;

		$searchTitle = title::makeTitle(NS_SPECIAL, $this->getTitle()->getText());

		$li = array();

		for($i = 0; $i < count($this->tabs); $i++) {

			if($this->tabs[$i]['active'] == true) {
				$li[] = sprintf($activetabtemplate, $this->tabs[$i]['name'], $this->tabs[$i]['name']);
			} else {
				if($this->getEngineForTab($i) == LUCENE) {
					$param = "tab={$i}&" . $this->getLUCENEParam();
				} else {
					$param = "cx={$this->tabs[$i]['cx']}&" . $this->getCSEParam();
				}
				$li[] = sprintf($tabtemplate, $searchTitle->getLocalURL($param), $this->tabs[$i]['name'], $this->tabs[$i]['name']);
			}
		}

		return sprintf($tabstemplate, implode('', $li));
	}

	function redirIfNeeded() {
		global $wgGoogleID, $wgOut, $wgRequest;
		if ( $this->simpleQuery != "" && $wgRequest->getText('cx') == "" ) {
			$searchTitle = title::makeTitle(NS_SPECIAL, $this->getTitle()->getText());
			$param = "cx={$wgGoogleID}&" . $this->getCSEParam();
			$wgOut->redirect($searchTitle->getLocalURL($param));
		}
	}

	function getLuceneForm() {
		global $luceneform;
		return sprintf($luceneform, $this->formURL, $this->tab, $this->simpleQuery, wfMsg('searchbutton'), wfMsg('searchbutton'));
	}

	function getCSEForm() {
		global $cseform;
		return sprintf($cseform, $this->formURL, $this->tabs[$this->tab]['cx'], wfMsg('searchbutton'), wfMsg('searchbutton'));
	}

	function getCSEResultsBox() {
		global $cseresultsbox;
		return $cseresultsbox;
	}

	function getLuceneResultsBox($results, $title = '', $page = 'page', $showcontent = false) {
		global $luceneresulttemplate, $resultsnum, $noresults, $wgRequest;

		if($results == false){
			return wfMsg('searcherror');
		}

		if($results['responseHeader']['numFound'] == 0) {
			return sprintf($resultsnum, $title, '') . sprintf($noresults, wfMsgExt('Noresults', 'parseinline', $wgRequest->getText( 'search' )));
		}

		$html = sprintf($resultsnum, $title, wfMsg('resultsof', ($this->$page * $this->rows) - $this->rows + 1, min($this->$page * $this->rows,$results['responseHeader']['numFound']), $results['responseHeader']['numFound']));

		for($i = 0; $i < count($results['results']); $i++) {
			$res = $results['results'][$i];
			if( $showcontent == true ) {
				$fragment = substr( $res['content'], 0, 255 );
				$fragment = substr( $fragment, 0, strrpos( $fragment, ' ' ) );
			} else {
				$fragment = $res['highlighted'];
			}
			$html .= sprintf($luceneresulttemplate,  $res['url'], $res['title'], strip_tags( $fragment , '<b>' ), htmlspecialchars($res['url']), $res['url'], wfMsg('length', $res['size']) , date('j M Y', wfTimestamp(TS_UNIX, $res['date'])));
		}

		return $html;
	}

	function getLucenePager($results, $page = 'page') {

		$resultsCount = $results['responseHeader']['numFound'];
		$pageCount = ceil( $resultsCount / $this->rows ) ;

		if ($pageCount < 2) {
			return;
		}

		$searchTitle = title::makeTitle(NS_SPECIAL, $this->getTitle()->getText());

		global $nextprevlink;

		if ($this->$page > 1) {
			$prevUrl = $searchTitle->getLocalURL("{$page}=".($this->$page - 1)."&search=".urlencode($this->simpleQuery)."&tab=".$this->tab);
			$prevText = "<b>&lt;</b>";
			$prev = sprintf($nextprevlink, $prevUrl, wfMsg('allpagesprev'), $prevText)." ";
		}

		if ($this->$page < $pageCount) {
			$nextUrl = $searchTitle->getLocalURL("{$page}=".($this->$page + 1)."&search=".urlencode($this->simpleQuery)."&tab=".$this->tab);
			$nextText = "<b>&gt;</b>";
			$next = sprintf($nextprevlink, $nextUrl, wfMsg('allpagesnext'), $nextText);
		}

		if($page == 'page') {
			$alt_page = 'pagee';
		} else {
			$alt_page = 'page';
		}
		$result = '';
		for ($i = max($this->$page - 5, 1); $i <= min($this->$page + 5, $pageCount); $i++) {
			if ($i == $this->$page)
				$result .= " $i ";
			else {
				$url = $searchTitle->getLocalURL((($this->$alt_page != 1) ? "{$alt_page}=".$this->$alt_page."&" : "")."{$page}=$i&search=".urlencode($this->simpleQuery)."&tab=".$this->tab);
				$result .= sprintf("<a href=\"%s\">%d</a> ", htmlspecialchars($url), $i);
			}
		}

		global $searchpager;

		return sprintf($searchpager, $prev . $result . $next);
	}
}

$wgExtensionFunctions[] = 'wfWikiaSearch';

function wfWikiaSearch() {
	SpecialPage::addPage(new WikiaSearch);
}
?>
