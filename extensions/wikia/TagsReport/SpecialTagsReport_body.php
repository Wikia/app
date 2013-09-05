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
	/* @var Title $mTitle */
	private $mTitle;
	private $mTag;
	/**
	 * constructor
	 */
	function  __construct() {
		parent::__construct( "TagsReport"  /*class*/, 'tagsreport' /*restriction*/);
	}

	public function execute( $subpage ) {
		global $wgUser, $wgOut, $wgRequest;

		if( $wgUser->isBlocked() ) {
			throw new UserBlockedError( $this->getUser()->mBlock );
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
		$action = htmlspecialchars($this->mTitle->getLocalURL());
		$tagList = $this->getTagsList();

		$timestamp = $this->getGenDate();
		if ( !empty( $timestamp ) ) {
			$wgOut->setSubtitle(wfMsg('tagsreportgenerated', $timestamp[0], $timestamp[1]));
		}

        $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $oTmpl->set_vars( array(
			"error"		=> $error,
            "action"	=> $action,
            "tagList"	=> $tagList,
            "mTag"  	=> $this->mTag,
            "timestamp"	=> $timestamp
        ));
        $wgOut->addHTML( $oTmpl->render("main-form") );
        wfProfileOut( __METHOD__ );
	}

	function showArticleList() {
		global $wgOut;
		global $wgCanonicalNamespaceNames;
		global $wgContLang;
        wfProfileIn( __METHOD__ );

		$articles = $this->getTagsInfo();

        $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $oTmpl->set_vars( array(
            "mTag"  		=> $this->mTag,
            "articles" 		=> $articles,
            "wgCanonicalNamespaceNames" => $wgCanonicalNamespaceNames,
            "wgContLang" 	=> $wgContLang,
            "skin"			=> RequestContext::getMain()->getSkin()
        ));
        $wgOut->addHTML( $oTmpl->render("tag-activity") );
        wfProfileOut( __METHOD__ );
	}

	function getResults() {
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
		global $wgMemc, $wgSharedDB, $wgStatsDB, $wgStatsDBEnabled;
		global $wgCityId;
		$tagsList = array();
		$memkey = wfForeignMemcKey( $wgSharedDB, null, "TagsReport", $wgCityId );
		$cached = $wgMemc->get($memkey);
		if ( !is_array ($cached) && !empty( $wgStatsDBEnabled ) ) {
			$dbs = wfGetDB(DB_SLAVE, array(), $wgStatsDB);
			if (!is_null($dbs)) {
				$query = "select ct_kind, count(*) as cnt from city_used_tags where ct_kind is not null and ct_wikia_id = {$wgCityId} group by ct_kind order by ct_kind";
				$res = $dbs->query ($query, __METHOD__);
				while ($row = $dbs->fetchObject($res)) {
					$tagsList[$row->ct_kind] = $row->cnt;
				}
				$dbs->freeResult($res);
				$wgMemc->set( $memkey, $tagsList, 60*60 );
			}
		} else {
			$tagsList = (array)$cached;
		}

		return $tagsList;
	}

	private function getTagsInfo() {
		global $wgMemc, $wgSharedDB, $wgStatsDB, $wgStatsDBEnabled;
		global $wgCityId;
		$tagsArticles = array();
		$memkey = wfForeignMemcKey( $wgSharedDB, null, "TagsReport", $this->mTag, $wgCityId );
		$cached = $wgMemc->get($memkey);
		if ( !is_array ($cached) && !empty( $wgStatsDBEnabled ) ) {
			$dbs = wfGetDB(DB_SLAVE, array(), $wgStatsDB);
			if (!is_null($dbs)) {
				$query = "select ct_namespace, ct_page_id from city_used_tags where ct_kind = " .$dbs->addQuotes( $this->mTag ). " and ct_wikia_id = {$wgCityId} order by ct_namespace";
				$res = $dbs->query ($query, __METHOD__);
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

	private function getGenDate() {
		global $wgLang, $wgStatsDB, $wgCityId, $wgStatsDBEnabled;

		if ( empty( $wgStatsDBEnabled ) ) {
			return array();
		}

		$dbs = wfGetDB(DB_SLAVE, array(), $wgStatsDB);
		$s = $dbs->selectRow(
			'city_used_tags',
			array( 'max(ct_timestamp) as ts' ),
			array( 'ct_wikia_id' =>  $wgCityId ),
			__METHOD__
		);

		return array(
			$wgLang->date( wfTimestamp( TS_MW, $s->ts ), true ),
			$wgLang->time( wfTimestamp( TS_MW, $s->ts ), true ),
		);
	}

}
