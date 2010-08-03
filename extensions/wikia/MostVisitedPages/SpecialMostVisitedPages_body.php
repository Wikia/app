<?php

class MostvisitedpagesSpecialPage extends SpecialPage {
    private $mpa = null;

	function __construct() {
		parent::__construct( 'Mostvisitedpages' );
	}

	function execute($article_id = null, $limit = "", $offset = "", $show = true) {
		wfLoadExtensionMessages("Mostvisitedpages");

		if (empty($limit) && empty($offset)) { 
            list( $limit, $offset ) = wfCheckLimits();
        }
        $this->mpp = new MostvisitedpagesPage($article_id, $show);
        
		if (!empty($show)) {
            $this->setHeaders();
			global $wgUser, $wgOut, $wgTitle;
            $sk = $wgUser->getSkin();
            if ( $article_id == 'latest' ) {
            	$wgOut->setSubtitle( $sk->makeLinkObj( $wgTitle, wfMsg('mostvisitedpagesalllink') ) );
			} else {
				$title = Title::makeTitle( NS_SPECIAL, sprintf("%s/latest", $this->mName) );
            	$wgOut->setSubtitle( $sk->makeLinkObj( $title, wfMsg('mostvisitedpageslatestlink') ) );
			}
        } else {
            // return data as array - not like <LI> list
            $this->mpp->setListoutput(TRUE);
        }
        $this->mpp->doQuery( $offset, $limit, $show );
    }
    
    function getResult() { return $this->mpp->getResult(); }
}

class MostvisitedpagesPage extends QueryPage {
	private $data = array();
	private $show = false;
	var $mArticle = "";
	var $mArticleId = "";
	var $mTitle = "";
	var $mName = "Mostvisitedpages";
	var $order_column = 'count';

	function __construct($page_id, $show) { 
		global $wgRequest;
		$this->show = $show; 
		$this->mArticle = $wgRequest->getVal('target');
		$this->mArticleId = $page_id;
		if ( $page_id == 'latest' ) {
			$this->setOrder('prev_diff');
			$this->setOrderColumn('prev_diff');
		}
		$this->mTitle = Title::makeTitle( NS_SPECIAL, $this->mName );
	}

	function getName() { return $this->mName; }
	function isExpensive() { return false; }
	function isSyndicated() { return false; }
	function sortDescending() { return true; }
	function setOrder($val) { $this->order = $val; }
	function setOrderColumn($val) { $this->order_column = $val; }
	function getOrder() {
		return sprintf(" ORDER BY value %s", ($this->sortDescending() ? 'DESC' : '') );
	}

	function getPageHeader() { 
        wfProfileIn( __METHOD__ );
        if (empty($this->show)) {
        	wfProfileOut( __METHOD__ );
        	return "";
		}
		
		$res = "";
		if ( $this->mArticleId != 'latest' ) {
			$action = $this->mTitle->escapeLocalURL("");

			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
			$oTmpl->set_vars( array(
				"action"		=> $action,
				"articleName"	=> $this->mArticle,
			));
			$res = $oTmpl->execute("main-form"); 
		}
		wfProfileOut( __METHOD__ );
        return $res;
	}
	public function getResult() { return $this->data; }

	function getSQL() {
		global $wgContentNamespaces, $wgEnableBlogArticles;
		$dbr = wfGetDB( DB_SLAVE );
		list( $page, $page_visited ) = $dbr->tableNamesN( 'page', 'page_visited' );
		$namespaces = array( NS_MAIN, NS_USER, NS_TALK, NS_USER_TALK, NS_IMAGE, NS_IMAGE_TALK );
		if ( !empty($wgContentNamespaces) && is_array($wgContentNamespaces) ) {
			foreach ($wgContentNamespaces as $nspace) {
				if ( !in_array($nspace, $namespaces) ) {
					$namespaces[] = $nspace;
				}
			}
		}
		if ( !empty($wgEnableBlogArticles) ) {
			if ( !in_array(NS_BLOG_ARTICLE, $namespaces) ) {
				$namespaces[] = NS_BLOG_ARTICLE;
			}			
		}
		
		$where = array( 
			" page_id = article_id ",
			" page_namespace in (" . $dbr->makeList( $namespaces ) . ") "
		);
		
		if ( !empty($this->mArticle) ) {
			$like = $dbr->escapeLike( $this->mArticle ) ;
   			$where[] = " lower(page_title) LIKE lower('%".$like."%') ";
		}
		if ( !empty($this->mArticleId) && ( $this->mArticleId == 'latest' ) ) {
			$where[] = " prev_diff > 0 ";
		}
		if ( !empty($this->mArticleId) && ( $this->mArticleId != 'latest' ) ) { 
			$where['page_id'] = intval($this->mArticleId);
		}
		
		$sql = $dbr->selectSQLText (
			array( $page, $page_visited ),
			array( "'Mostpopularpages' as type, page_namespace as namespace, page_title as title, " . $this->order_column . " as value" ),
			$where,
			__METHOD__	
		);

		error_log("sql = $sql \n");

		return $sql;
	}

	function formatResult( $skin, $result ) {
		$res = false;
		if (empty($this->show)) {
			$this->data[$result->title] = array('value' => $result->value, 'namespace' => $result->namespace);
		} else {
			$title = Title::newFromText($result->title, $result->namespace);
			if ($title) {
				$result->title = Xml::element("a", array("href" => $title->getLocalURL()), $title->getFullText()) ;
			} 
			$res = wfSpecialList( $result->title, $result->value );
		}
		return $res;
	}
}
