<?php

class SpecialIndexPager extends AlphabeticPager {

	public $mSearchTitle;
	private $mJSid = 0;

	function __construct( $search ) {
		$this->mSearchTitle = $search;
		parent::__construct();	
		// This can potentially be a lot of data, set a lower max limit
		$this->mLimit = $this->mLimit > 1000 ? 1000 : $this->mLimit;
	}

	function formatRow( $row ) {
		$sk = $this->getSkin();
		if ( $row->type == 'page' ) {
			$title = Title::makeTitle( $row->ns, $row->title );
			$ret = Xml::openElement( 'tr' );
			$link = $sk->link( $title, null, array(), array(), array( 'known', 'noclasses' ) );
			$blankarr = $this->arrow( '' ) . '&nbsp;';
			$ret .= Xml::tags( 'td', null, $blankarr );
			$ret .= Xml::tags( 'td', null, $link );
			$ret .= Xml::tags( 'td', null, '&nbsp;' );
			$ret .= Xml::closeElement( 'tr' );
			return $ret;
		} else {
			$ret = Xml::openElement( 'tr' );
			$targettitle = Title::makeTitle( $row->ns, $row->title );
			$title = SpecialPage::getTitleFor( 'Index', $row->title );
			$link = $sk->link( $title, $targettitle->getPrefixedText(), array( 'class'=>'mw-index' ), array(), array( 'known', 'noclasses' ) );
			
			$jsid = $this->mJSid;
			$expandTitle = wfMsgHtml( 'index-expand-detail' );
			$closeTitle = wfMsgHtml( 'index-hide-detail' );
			$toggleLink = "onclick='toggleVisibility($jsid); return false'";
			$tl = "<span id='mw-index-open-$jsid' class='mw-index-expanded' style='visibility:hidden' ><a href='#' $toggleLink title='$expandTitle'>" . $this->sideArrow() . "</a></span>";
			$tl .= "<span id='mw-index-close-$jsid' class='mw-index-hidden' style='display:none'><a href='#' $toggleLink title='$closeTitle'>" . $this->downArrow() . "</a></span>";
			
			$ret .= Xml::tags( 'td', array( 'style' => 'vertical-align:top' ), $tl . '&nbsp' );
			$ret .= Xml::tags( 'td', array( 'style' => 'vertical-align:top' ), $link );
			$ret .= Xml::openElement( 'td' );
			$ret .= Xml::openElement( 'ul', 
				array( 'style' => 'margin-top:1em', 'class'=>'mw-index-hidden', 'id'=>"mw-index-inner-$jsid" ) 
			);			
			$pages = explode( '|', $row->extra );
			foreach( $pages as $page ) {
				$bits = explode( ':', $page, 2 );
				$t = Title::makeTitle( $bits[0], $bits[1] );
				$ln = $sk->link( $t, null, array(), array(), array( 'known', 'noclasses' ) );
				$ret .= Xml::tags( 'li', null, $ln );				
			}
			$ret .= Xml::closeElement( 'ul' );
			$ret .= Xml::closeElement( 'td' );
			$ret .= Xml::closeElement( 'tr' );
			$this->mJSid++;
			return $ret;		
		}
	}
		
	protected function arrow( $dir, $alt='', $title='' ) {
		global $wgStylePath;
		$encUrl = htmlspecialchars( $wgStylePath . '/common/images/Arr_' . $dir . '.png' );
		$encAlt = htmlspecialchars( $alt );
		$encTitle = htmlspecialchars( $title );
		return "<img src=\"$encUrl\" width=\"12\" height=\"12\" alt=\"$encAlt\" title=\"$encTitle\" />";
	}

	protected function sideArrow() {
		global $wgContLang;
		$dir = $wgContLang->isRTL() ? 'l' : 'r';
		return $this->arrow( $dir, '+', wfMsg( 'index-expand-detail' ) );
	}

	protected function downArrow() {
		return $this->arrow( 'd', '-', wfMsg( 'index-hide-detail' ) );
	}

	protected function spacerArrow() {
		return $this->arrow( '', codepointToUtf8( 0xa0 ) ); // non-breaking space
	}

	
	
	// Since we're overriding reallyDoQuery, we don't really need this
	// its easier to just do it all in one function
	function getQueryInfo() { }
	
	function getIndexField() {
		return 'title';	
	}
	
	function getEmptyBody() {
		return "<tr><td class='errorbox'>" . wfMsgHtml( 'index-no-results' ) ."</td></tr>";	
	}
	
	// Need to override reallyDoQuery() to do the UNION
	function reallyDoQuery( $offset, $limit, $descending ) {	
		$limit = ' LIMIT ' . intval( $limit );
		$order = " ORDER BY {$this->mIndexField}";	
		if ( $descending ) {
			$operator = '>';
		} else {
			$order .= ' DESC';
			$operator = '<';
		}		
		
		$pageconds = array();
		$indexconds = array();
		if ( $offset != '' ) {
			$pageconds[] = 'page_title' . $operator . $this->mDb->addQuotes( $offset );
			$indexconds[] = 'in_title' . $operator . $this->mDb->addQuotes( $offset );
		}	
		$ns = $this->mSearchTitle->getNamespace();
		$like = $this->mDb->escapeLike( $this->mSearchTitle->getDBkey() ) . '%';
		
		$pageconds[] = "page_namespace = $ns";
		$pageconds[] = "page_title LIKE '$like'";
		$indexconds[] = "in_namespace = $ns";
		$indexconds[] = "in_title LIKE '$like'";
		
		
		$pagequery = $this->mDb->selectSQLText( 'page', 
			"page_title AS title, page_namespace AS ns, 'page' AS type, NULL AS extra",
			$pageconds,
			''
		);
		$indexquery = $this->mDb->selectSQLText( array('indexes', 'page'), 
			"in_title AS title, in_namespace AS ns, 'index' AS type, 
			GROUP_CONCAT(page_namespace,':',page_title SEPARATOR '|') AS extra",
			$indexconds,
			'',
			array( 'GROUP BY' => 'in_namespace, in_title' ),
			array( 'page' => array('JOIN','page_id=in_from') )
		);
		
		$union = $this->mDb->unionQueries( array( $pagequery, $indexquery ), false );
		$union .= $order . $limit;		

		$res = $this->mDb->query( $union, __METHOD__ );
		return new ResultWrapper( $this->mDb, $res );
	}

}

class SpecialIndex extends SpecialPage {
	function __construct() {
		wfLoadExtensionMessages('IndexFunction');
		parent::__construct( 'Index' );
	}
 
	function execute( $par ) {	
 
		$this->setHeaders();
		if ($par) {
			$t1 = Title::newFromText( $par );
			$this->showDabPage( $t1 );
		} else { 	
			$this->showSearchForm();	
		}

	}
	
	function showSearchForm() {
		global $wgOut, $wgRequest, $wgScript;
		$search = $wgRequest->getText( 'searchtext' );
		$wgOut->addWikiMsg( 'index-search-explain' );
		$form = Xml::openElement( 'fieldset', array( 'style'=>'line-height:200%' ) ) . 
		Xml::element( 'legend', array(), wfMsgHtml( 'index-legend' ) ) . 
		Xml::openElement( 'form', array( 'method'=>'GET', 'action'=>$wgScript ) ) .
		 Xml::hidden( 'title', $this->getTitle()->getPrefixedDbKey() ) .

		Xml::label( wfMsg( 'index-search' ), 'mw-index-searchtext' ) .
		Xml::input( 'searchtext', 100, $search, array( 'id' => 'mw-index-searchtext' ) ) . 
		'<br />' . 
		Xml::submitButton( wfMsg( 'index-submit' ) ) .

		Xml::closeElement( 'form' ) . 
		Xml::closeElement( 'fieldset' );		

		$wgOut->addHTML( $form );
		
		$t = Title::newFromText( $search );
		
		if ( !is_null( $t) ) {
			$t = Title::newFromText( $wgRequest->getVal( 'searchtext' ) );
			$pager = new SpecialIndexPager( $t );
			$out = Xml::openElement( 'div', array( 'id'=>'mw-index-searchresults' ) ) .
				'<div id="use-js-note" style="display:none">' . wfMsgExt( 'index-details-explain' , array( 'parse' ) ) . '</div>' .
				$pager->getNavigationBar() .
				Xml::openElement( 'table' ) . 
				$pager->getBody() . 
				Xml::closeElement( 'table' ) .
				$pager->getNavigationBar() .
				Xml::closeElement( 'div' );
			$wgOut->addHtml( $out );
	
		}
	
	}
	
	function showDabPage( Title $t1 ) {
		global $wgOut, $wgUser, $wgSpecialIndexContext;
		$sk = $wgUser->getSkin();
		$wgOut->setPagetitle( $t1->getPrefixedText() );
		$dbr = wfGetDB( DB_SLAVE );
		$pages = $dbr->select( array('page', 'indexes'),
			array( 'page_id', 'page_namespace', 'page_title' ),
			array( 'in_namespace'=>$t1->getNamespace(), 'in_title'=>$t1->getDBkey() ),
			__METHOD__, 
			array('ORDER BY'=> 'page_namespace, page_title'),
			array( 'indexes' => array('JOIN', 'in_from=page_id') )
		);
		
		$list = array();
		foreach( $pages as $row ) {
			$t = Title::newFromRow( $row );
			$list[strval($row->page_id)] = array( 'title' => $t, 'cats' => array() );
		}
		if (count($list) == 0) {
			$wgOut->addWikiMsg( 'index-emptylist', $t1->getPrefixedText() );
			return;
		} elseif (count($list) == 1) {
			$target = reset( $list );
			$wgOut->redirect( $target['title']->getLocalURL() );
		} 
		$wgOut->addWikiMsg( 'index-disambig-start', $t1->getPrefixedText() );
		$keys = array_keys( $list );
		$set = '(' . implode(',', $keys) . ')';
		
		$exclude = wfMsg('index-exclude-categories');
		$excludecats = array();
		if ($exclude) {
			$exclude = explode( '\n', $exclude );
			foreach( $exclude as $cat ) {
				if (!$cat) {
					continue;
				}
				$cat = Title::newFromText( $cat, NS_CATEGORY );
				if ( !is_null($cat) ) {
					$excludecats[] = $dbr->addQuotes( $cat->getDBkey() );
				}
			}
			$excludecats = 'AND cl_to NOT IN (' . implode(',', $excludecats) . ')';
		} else {
			$excludecats = '';
		}
		
		$categories = $dbr->select( 'categorylinks',
			array('cl_from', 'cl_to'),
			"cl_from IN $set $excludecats",
			__METHOD__,
			array('ORDER BY' => 'cl_from')
		);
		$groups = array();
		$catlist = array();
		foreach( $categories as $row ) {
			$ct = Title::newFromText( $row->cl_to, NS_CATEGORY );
			$textform = $ct->getText();
			$list[strval($row->cl_from)]['cats'][] = $textform;
			if ( array_key_exists( $textform, $catlist ) ) {
				$catlist[$textform][] = strval($row->cl_from);
			} else {
				$catlist[$textform] = array ( strval($row->cl_from) );
			}
		}
		if (count($catlist) > 2) {
			while (true) {
				arsort($catlist);
				$group = reset( $catlist );
				if (count($group) == 0) {
					break;
				}
				$keys = array_keys($catlist, $group);
				$heading = $keys[0];
				$grouphtml = Xml::element('h2', null, $heading);
				$grouphtml .= Xml::openElement( 'ul' );
				foreach( $group as $pageid ) {
					$t = $list[$pageid]['title'];
					$cats = $list[$pageid]['cats'];					
					$grouphtml .= $this->makeContextLine( $t, $cats );					
					unset( $list[$pageid] );
					ksort($list);
					foreach($catlist as $remaining) {
						$key = array_search( $pageid, $remaining );
						if ( $key !== false ) {
							$masterkeys = array_keys($catlist, $remaining);
							$heading = $masterkeys[0];
							unset($catlist[$heading][$key]);
							sort($catlist[$heading]);
						}
					}
				}
				$grouphtml .= Xml::closeElement( 'ul' );
				$groups[] = $grouphtml;
				unset( $catlist[$heading] );
				if (count($catlist) == 0) {
					break;
				}		
			}
			if (count($list) != 0) { //Pages w/ no cats
				$grouphtml = Xml::openElement( 'ul' );
				foreach( $list as $pageid => $info ) {
					$grouphtml .= $this->makeContextLine( $info['title'], array() );
				}
				$grouphtml .= Xml::closeElement('ul');
				$groups = array_merge( array($grouphtml), $groups);
			}
			$out = implode( "\n", $groups );
		} else {
			$out = Xml::openElement( 'ul' );
			foreach( $list as $pageid => $info ) {
				$out .= $this->makeContextLine( $info['title'], $info['cats'] );
			}
			$out .= Xml::closeElement('ul');
		}
		
		$wgOut->addHtml($out);
	}
	
	private function makeContextLine( $title, $cats ) {
		global $wgUser, $wgSpecialIndexContext;
		$sk = $wgUser->getSkin();
		$link = $sk->link( $title, null, array(), array(), array( 'known', 'noclasses' ) );
		if ( $wgSpecialIndexContext == 'extract' ) {
			$extracter = new IndexAbstracts();
			$text = $extracter->getExtract( $title );
			if ( $text != '' ) {
				if ( stripos( $text, $title->getPrefixedText() ) !== false ) {
					$search = preg_quote( $title->getPrefixedText(), '/' );
					$line = preg_replace( "/$search/i", $link, $text, 1 );
				} else {
					$line = $link . '&nbsp;&ndash&nbsp;' . $text;
				}
			} else {
				$line = $link;
			}
			$line = Xml::tags( 'li', array(), $line );
		} elseif ( $wgSpecialIndexContext == 'categories' ) {
			if ( $cats ) {
				$line = $link . '&nbsp;&ndash&nbsp;' . implode( ', ', $cats );
				$line = Xml::tags( 'li', array(), $line );
			} else {
				$line = Xml::tags( 'li', array(), $link );
			}
		} else {
			$line = Xml::tags( 'li', array(), $link );
		}
		return $line;
	}
	
}

