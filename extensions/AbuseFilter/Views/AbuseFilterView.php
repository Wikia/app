<?php
if ( !defined( 'MEDIAWIKI' ) )
	die();

abstract class AbuseFilterView {
	function __construct( $page, $params ) {
		$this->mPage = $page;
		$this->mParams = $params;
	}

	function getTitle( $subpage = '' ) {
		return $this->mPage->getTitle( $subpage );
	}

	abstract function show();

	function canEdit() {
		global $wgUser;
		static $canEdit = null;

		if ( is_null( $canEdit ) ) {
			$canEdit = $wgUser->isAllowed( 'abusefilter-modify' );
		}

		return $canEdit;
	}

	function canViewPrivate() {
		global $wgUser;
		static $canView = null;

		if ( is_null( $canView ) ) {
			$canView = $this->canEdit() || $wgUser->isAllowed( 'abusefilter-view-private' );
		}

		return $canView;
	}
}

class AbuseFilterChangesList extends OldChangesList {
	public function insertExtra( &$s, &$rc, &$classes ) {
		$sk = $this->skin;
		$examineParams = empty( $rc->examineParams ) ? array() : $rc->examineParams;

		$title = SpecialPage::getTitleFor( 'AbuseFilter', 'examine/' . $rc->mAttribs['rc_id'] );
		$examineLink = $sk->link( $title, wfMsgExt( 'abusefilter-changeslist-examine', 'parseinline' ), array(), $examineParams );

		$s .= " ($examineLink)";

		# If we have a match..
		if ( isset( $rc->filterResult ) ) {
			$class = $rc->filterResult ?
				'mw-abusefilter-changeslist-match' :
				'mw-abusefilter-changeslist-nomatch';

			$classes[] = $class;
		}
	}

	// Kill rollback links.
	public function insertRollback( &$s, &$rc ) { }
}
