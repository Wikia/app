<?php

class ImageServingTest extends SpecialPage {
	
    private $mpa = null;

	function __construct() {
		parent::__construct( 'ImageServingTest', 'imageservingtest' );
	}

	function execute($article_id = null, $limit = "", $offset = "", $show = true) {
		global $wgRequest, $wgOut, $wgTitle, $wgUser;
		
		if( !$wgUser->isAllowed( 'imageservingtest' ) ) {
			$wgOut->permissionRequired( 'imageservingtest' );
			return;
		}
		
		
		wfLoadExtensionMessages( 'ImageServingTest' );
		
		$wgOut->addHTML(Xml::element("a", array("href" => $wgTitle->getLocalURL("option=1")), "1. Oasis related pages: 200 2:1" )."<br>" );
		$wgOut->addHTML(Xml::element("a", array("href" => $wgTitle->getLocalURL("option=2")), "2. Spotlights: 270 3:1" )."<br>" );
		$wgOut->addHTML(Xml::element("a", array("href" => $wgTitle->getLocalURL("option=3")), "3. Image OneBox for Search 100 1:1" )."<br>" );
		
		if (empty($limit) && empty($offset)) { 
            list( $limit, $offset ) = wfCheckLimits();
        }
        
        $this->mpp = new MostvisitedpagesPageIS($article_id, $show);
        
        $this->mpp->doQuery($wgRequest->getVal("offset",1), 10, $show );
    }
    
    function getResult() { return $this->mpp->getResult(); }

}


class MostvisitedpagesPageIS extends MostvisitedpagesPage {
	var $mName = "ImageServingTest";
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

	function getPageHeader() { return ""; }
	
	function linkParameters() {
		global $wgRequest;
		return array("option" => $wgRequest->getVal("option", 1));
	}

	function formatResult( $skin, $result ) {
		global $wgRequest;
		$res = false;
		if (empty($this->show)) {
			$this->data[$result->title] = array('value' => $result->value, 'namespace' => $result->namespace);
		} else {
			$title = Title::newFromText($result->title, $result->namespace);
			if ($title) {
				$result->title = Xml::element("a", array("href" => $title->getLocalURL()), $title->getFullText()) ;
				$size = 200;
				$prop = array("w" => 2, "h" => 1);
				switch($wgRequest->getVal("option", 1)) {
					case "2": 
						$size = 270;
						$prop = array("w" => 3, "h" => 1);						
					break;
					case "3":
						$size = 100;
						$prop = array("w" => 1, "h" => 1);
					break;
				}
				
				$is = new imageServing(array($title->getArticleId()), $size, $prop );
				$result->title .= "<div>";
				foreach ($is->getImages(5) as $key => $value){
					foreach ($value as $value2) {
						$result->title .= "<img src='{$value2['url']}' /> <br>";
						$result->title .= $value2['name']."<br>";
					}
				};
				$result->title .= "</div>";
			} 
			$res = wfSpecialList( $result->title, $result->value );
		}
		return $res;
	}
}