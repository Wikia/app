<?php

class ReviewedVersions extends UnlistedSpecialPage {
	public function __construct() {
		parent::__construct( 'ReviewedVersions' );
	}

	public function execute( $par ) {
		$request = $this->getRequest();

		$this->setHeaders();
		# Our target page
		$this->target = $request->getText( 'page' );
		$this->page = Title::newFromURL( $this->target );
		# Revision ID
		$this->oldid = $request->getVal( 'oldid' );
		$this->oldid = ( $this->oldid == 'best' ) ? 'best' : intval( $this->oldid );
		# We need a page...
		if ( is_null( $this->page ) ) {
			$this->getOutput()->showErrorPage( 'notargettitle', 'notargettext' );
			return;
		}

		$this->showStableList();
	}

	protected function showStableList() {
		$out = $this->getOutput();
		# Must be a content page
		if ( !FlaggedRevs::inReviewNamespace( $this->page ) ) {
			$out->addWikiMsg( 'reviewedversions-none', $this->page->getPrefixedText() );
			return;
		}
		$pager = new ReviewedVersionsPager( $this, array(), $this->page );
		$num = $pager->getNumRows();
		if ( $num ) {
			$out->addWikiMsg( 'reviewedversions-list',
				$this->page->getPrefixedText(), $this->getLang()->formatNum( $num ) );
			$out->addHTML( $pager->getNavigationBar() );
			$out->addHTML( "<ul>" . $pager->getBody() . "</ul>" );
			$out->addHTML( $pager->getNavigationBar() );
		} else {
			$out->addHTML( wfMsgExt( 'reviewedversions-none', array( 'parse' ),
				$this->page->getPrefixedText() ) );
		}
	}

	public function formatRow( $row ) {
		$rdatim = $this->getLang()->timeanddate( wfTimestamp( TS_MW, $row->rev_timestamp ), true );
		$fdatim = $this->getLang()->timeanddate( wfTimestamp( TS_MW, $row->fr_timestamp ), true );
		$fdate = $this->getLang()->date( wfTimestamp( TS_MW, $row->fr_timestamp ), true );
		$ftime = $this->getLang()->time( wfTimestamp( TS_MW, $row->fr_timestamp ), true );
		$review = wfMsgExt( 'reviewedversions-review', array( 'parseinline', 'replaceafter' ),
			$fdatim,
			Linker::userLink( $row->fr_user, $row->user_name ) .
			' ' . Linker::userToolLinks( $row->fr_user, $row->user_name ),
			$fdate, $ftime, $row->user_name
		);
		$lev = ( $row->fr_quality >= 1 )
			? wfMsgHtml( 'revreview-hist-quality' )
			: wfMsgHtml( 'revreview-hist-basic' );
		$link = Linker::makeKnownLinkObj( $this->page, $rdatim,
			'stableid=' . $row->fr_rev_id );
		return '<li>' . $link . ' (' . $review . ') <strong>[' . $lev . ']</strong></li>';
	}
}

/**
 * Query to list out stable versions for a page
 */
class ReviewedVersionsPager extends ReverseChronologicalPager {
	public $mForm, $mConds;

	function __construct( $form, $conds = array(), $title ) {
		$this->mForm = $form;
		$this->mConds = $conds;
		$this->pageID = $title->getArticleID();

		parent::__construct();
	}

	function formatRow( $row ) {
		return $this->mForm->formatRow( $row );
	}

	function getQueryInfo() {
		$conds = $this->mConds;
		$conds['fr_page_id'] = $this->pageID;
		$conds[] = 'fr_rev_id = rev_id';
		$conds[] = 'rev_deleted & ' . Revision::DELETED_TEXT . ' = 0';
		$conds[] = 'fr_user = user_id';
		return array(
			'tables'  => array( 'flaggedrevs', 'revision', 'user' ),
			'fields'  => 'fr_rev_id,fr_timestamp,rev_timestamp,fr_quality,fr_user,user_name',
			'conds'   => $conds,
			//'options' => array( 'USE INDEX' => array( 'flaggedrevs' => 'page_rev' ) )
		);
	}

	function getIndexField() {
		return 'fr_rev_id';
	}
}
