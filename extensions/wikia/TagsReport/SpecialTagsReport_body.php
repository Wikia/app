<?php
/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Piotr Molski <moli@wikia-inc.com> for Wikia.com
 * @version: 1.0
 */

if ( !defined( 'MEDIAWIKI' ) ) { 
	echo "This is MediaWiki extension and cannot be used standalone.\n"; exit( 1 ) ; 
}

class TagsReportPage extends SpecialPage {
	private $mTitle;
	private $mTag;
	/**
	 * constructor
	 */
	function  __construct() {
		parent::__construct( "TagsReport"  /*class*/, 'tagsreport' /*restriction*/);
		wfLoadExtensionMessages("TagsReport");
	}
	
	public function execute( $subpage ) {
		global $wgUser, $wgOut, $wgRequest;

		if( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}
		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}
		if( !$wgUser->isAllowed( 'tagsreport' ) ) {
			$this->displayRestrictionError();
			return;
		}

		/**
		 * initial output
		 */
		$this->mTitle = Title::makeTitle( NS_SPECIAL, 'TagsReport' );
		$wgOut->setPageTitle( wfMsg('tagsreporttitle') );
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );
		$this->mTag = $wgRequest->getVal ('target');

		/**
		 * show form
		 */
		$this->showForm();
		$this->showArticleList();
	}

	/* draws the form itself  */
	function showForm ($error = "") {
		global $wgOut;
        wfProfileIn( __METHOD__ );
		$action = $this->mTitle->escapeLocalURL("");
		$tagList = $this->getTagsList();

        $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $oTmpl->set_vars( array(
			"error"		=> $error,
            "action"	=> $action,
            "tagList"	=> $tagList,
            "mTag"  	=> $this->mTag,
        ));
        $wgOut->addHTML( $oTmpl->execute("main-form") );
        wfProfileOut( __METHOD__ );
	}
	
	function showArticleList() {
		global $wgOut, $wgRequest ;
		global $wgCanonicalNamespaceNames;
		global $wgContLang, $wgUser;
        wfProfileIn( __METHOD__ );

		$articles = $this->getTagsInfo();
				
        $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $oTmpl->set_vars( array(
            "mTag"  		=> $this->mTag,
            "articles" 		=> $articles,
            "wgCanonicalNamespaceNames" => $wgCanonicalNamespaceNames,
            "wgContLang" 	=> $wgContLang,
            "skin"			=> $wgUser->getSkin()
        ));
        $wgOut->addHTML( $oTmpl->execute("tag-activity") );
        wfProfileOut( __METHOD__ );
	}
	
	function getResults() {
		global $wgOut, $wgRequest ;
        wfProfileIn( __METHOD__ );

		/* no list when no user */
		if (empty($this->mTag)) {
			wfProfileOut( __METHOD__ );
			return false ;
		}

		/* before, we need that numResults */
        wfProfileOut( __METHOD__ );
	}
	
	private function getTagsList() {
		global $wgMemc, $wgSharedDB, $wgDBStats;
		global $wgCityId;
		$tagsList = array();
		$memkey = wfForeignMemcKey( $wgSharedDB, null, "TagsReport", $wgCityId );
		$cached = $wgMemc->get($memkey);
		if (!is_array ($cached)) { 
			$dbs = wfGetDBExt();
			if (!is_null($dbs)) {
				$query = "select ct_kind, count(*) as cnt from `{$wgDBStats}`.`city_used_tags` where ct_kind is not null and ct_wikia_id = {$wgCityId} group by ct_kind order by ct_kind";
				$res = $dbs->query ($query);
				while ($row = $dbs->fetchObject($res)) {
					$tagsList[$row->ct_kind] = $row->cnt;
				}
				$dbs->freeResult($res);
				$wgMemc->set( $memkey, $tagsList, 60*60 );
			}
		} else { 
			$tagsList = $cached;
		}
		
		return $tagsList;
	}
	
	private function getTagsInfo() {
		global $wgMemc, $wgSharedDB, $wgDBStats;
		global $wgCityId;
		$tagsArticles = array();
		$memkey = wfForeignMemcKey( $wgSharedDB, null, "TagsReport", $this->mTag, $wgCityId );
		$cached = $wgMemc->get($memkey);
		if (!is_array ($cached)) { 
			$dbs = wfGetDBExt();
			if (!is_null($dbs)) {
				$query = "select ct_namespace, ct_page_id from `{$wgDBStats}`.`city_used_tags` where ct_kind = " .$dbs->addQuotes( $this->mTag ). " and ct_wikia_id = {$wgCityId} order by ct_namespace";
				$res = $dbs->query ($query);
				while ($row = $dbs->fetchObject($res)) {
					$tagsArticles[$row->ct_namespace][] = $row->ct_page_id;
				}
				$dbs->freeResult($res);
				$wgMemc->set( $memkey, $tagsArticles, 60*60*3 );
			}
		} else { 
			$tagsArticles = $cached;
		}
		
		return $tagsArticles;
	}
	
}
