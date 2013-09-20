<?php

class MostvisitedpagesSpecialPage extends SpecialPage {
    private $mpp = null;
    private $showList = true;
    private $page = '';
    private $page_id = '';

	function __construct( $page = 'Mostvisitedpages' ) {
		$this->page = $page;
		parent::__construct( $this->page, '' );
	}

	function setList( $showList = false ) { $this->showList = $showList; }

	function setPageID ( $page_id ) { $this->page_id = $page_id; }

	function execute( $par = '' ) {
        $this->mpp = new MostvisitedpagesPage( $this->page );
		$this->mpp->setVisible( $this->showList );
		$this->mpp->setPageID( $this->page_id );
		if (!empty($this->showList)) {
			$this->setHeaders();
			global $wgOut, $wgTitle;
            $sk = RequestContext::getMain()->getSkin();
            if ( $this->page_id == 'latest' ) {
            	$wgOut->setSubtitle( $sk->makeLinkObj( $wgTitle, wfMsg('mostvisitedpagesalllink') ) );
			} else {
				$title = Title::makeTitle( NS_SPECIAL, sprintf("%s/latest", $this->page) );
            	$wgOut->setSubtitle( $sk->makeLinkObj( $title, wfMsg('mostvisitedpageslatestlink') ) );
			}
		} else {
			// return data as array - not like <LI> list
			$this->mpp->setListoutput(TRUE);
		}
		$this->mpp->execute( '' );
    }

    function getResult() { return $this->mpp->getResult(); }
}

class MostvisitedpagesPage extends QueryPage {
	protected $data = array();
	private $show = false;
	var $mArticle = "";
	var $mArticleId = "";
	var $mTitle = "";
	var $mName = '';
	var $order_column = 'count';

	function __construct($page) {
		$this->mName = $page;
		$this->mTitle = Title::makeTitle( NS_SPECIAL, $page );
		parent::__construct( $page, '' );
	}

	function setVisible( $show ) { $this->show = $show; }
	function setPageID( $page_id ) {
		$this->mArticleId = $page_id;
		if ( $page_id == 'latest' ) {
			$this->setOrder('prev_diff');
			$this->setOrderColumn('prev_diff');
		}
	}
	function setPageTitle( $page_title ) { $this->mArticle = $page_title; }
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
			$action = htmlspecialchars($this->mTitle->getLocalURL());

			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
			$oTmpl->set_vars( array(
				"action"		=> $action,
				"articleName"	=> $this->mArticle,
			));
			$res = $oTmpl->render("main-form");
		}
		wfProfileOut( __METHOD__ );
        return $res;
	}
	public function getResult() { return $this->data; }

	function getQueryInfo() {
		global $wgContentNamespaces, $wgEnableBlogArticles;

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
			"page_namespace" => $namespaces
		);

		if ( !empty($this->mArticle) ) {
			$dbr = wfGetDB( DB_SLAVE );
   			$where[] = " lower(page_title) " . $dbr->buildLike( $dbr->anyString(), strtolower( $this->mArticle ), $dbr->anyString() );
		}
		if ( !empty($this->mArticleId) && ( $this->mArticleId == 'latest' ) ) {
			$where[] = " prev_diff > 0 ";
		}
		if ( !empty($this->mArticleId) && ( $this->mArticleId != 'latest' ) ) {
			$where['page_id'] = intval($this->mArticleId);
		}

		return array (
			'tables' => array ( 'page', 'page_visited' ),
			'fields' => array (
				"'Mostpopularpages' AS type",
				'page_namespace AS namespace',
				'page_title AS title',
				"{$this->order_column} as value"
			),
			'conds' => $where
		);
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
