<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "FlaggedRevs extension\n";
	exit( 1 );
}

class StableVersions extends UnlistedSpecialPage
{
    public function __construct() {
        UnlistedSpecialPage::UnlistedSpecialPage( 'StableVersions' );
		wfLoadExtensionMessages( 'StableVersions' );
		wfLoadExtensionMessages( 'FlaggedRevs' );
    }

    public function execute( $par ) {
        global $wgRequest, $wgUser, $wgOut;

		$this->setHeaders();
		$this->skin = $wgUser->getSkin();
		# Our target page
		$this->target = $wgRequest->getText( 'page' );
		$this->page = Title::newFromUrl( $this->target );
		# Revision ID
		$this->oldid = $wgRequest->getVal( 'oldid' );
		$this->oldid = ($this->oldid=='best') ? 'best' : intval($this->oldid);
		# We need a page...
		if( is_null($this->page) ) {
			$wgOut->showErrorPage( 'notargettitle', 'notargettext' );
			return;
		}

		$this->showStableList();
	}

	protected function showStableList() {
		global $wgOut, $wgUser;
		# Must be a content page
		if( !FlaggedRevs::isPageReviewable( $this->page ) ) {
			$wgOut->addHTML( wfMsgExt('stableversions-none', array('parse'),
				$this->page->getPrefixedText() ) );
			return;
		}
		$pager = new StableRevisionsPager( $this, array(), $this->page );
		if( $pager->getNumRows() ) {
			$wgOut->addHTML( wfMsgExt('stableversions-list', array('parse'),
				$this->page->getPrefixedText() ) );
			$wgOut->addHTML( $pager->getNavigationBar() );
			$wgOut->addHTML( "<ul>" . $pager->getBody() . "</ul>" );
			$wgOut->addHTML( $pager->getNavigationBar() );
		} else {
			$wgOut->addHTML( wfMsgExt('stableversions-none', array('parse'),
				$this->page->getPrefixedText() ) );
		}
	}

	public function formatRow( $row ) {
		global $wgLang, $wgUser;

		$time = $wgLang->timeanddate( wfTimestamp(TS_MW, $row->rev_timestamp), true );
		$ftime = $wgLang->timeanddate( wfTimestamp(TS_MW, $row->fr_timestamp), true );
		$review = wfMsgExt( 'stableversions-review', array( 'parseinline', 'replaceafter' ), $ftime,
			$this->skin->userLink( $row->fr_user, $row->user_name ) .
			' ' . $this->skin->userToolLinks( $row->fr_user, $row->user_name ) );

		$lev = ( $row->fr_quality >=1 ) ? wfMsgHtml('hist-quality') : wfMsgHtml('hist-stable');
		$link = $this->skin->makeKnownLinkObj( $this->page, $time,
			'stableid='.$row->fr_rev_id );

		return '<li>'.$link.' ('.$review.') <strong>['.$lev.']</strong></li>';
	}
}

/**
 * Query to list out stable versions for a page
 */
class StableRevisionsPager extends ReverseChronologicalPager {
	public $mForm, $mConds;

	function __construct( $form, $conds = array(), $title ) {
		$this->mForm = $form;
		$this->mConds = $conds;
		$this->namespace = $title->getNamespace();
		$this->pageID = $title->getArticleID();

		parent::__construct();
	}

	function formatRow( $row ) {
		return $this->mForm->formatRow( $row );
	}

	function getQueryInfo() {
		global $wgFlaggedRevsNamespaces;

		$conds = $this->mConds;
		# Must be in a reviewable namespace
		if( !in_array($this->namespace, $wgFlaggedRevsNamespaces) ) {
			$conds[] = "1 = 0";
		}
		$conds["fr_page_id"] = $this->pageID;
		$conds[] = "fr_rev_id = rev_id";
		$conds[] = "fr_user = user_id";
		$conds[] = 'rev_deleted & '.Revision::DELETED_TEXT.' = 0';
		return array(
			'tables'  => array('flaggedrevs','revision','user'),
			'fields'  => 'fr_rev_id,fr_timestamp,rev_timestamp,fr_quality,fr_user,user_name',
			'conds'   => $conds,
			'options' => array( 'USE INDEX' => array('flaggedrevs' => 'PRIMARY') )
		);
	}

	function getIndexField() {
		return 'fr_rev_id';
	}
}
