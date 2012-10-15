<?php

abstract class AbuseFilterView extends ContextSource {
	/**
	 * @param $page SpecialPage
	 * @param $params array
	 */
	function __construct( $page, $params ) {
		$this->mPage = $page;
		$this->mParams = $params;
		$this->setContext( $this->mPage->getContext() );
	}

	/**
	 * @param string $subpage
	 * @return Title
	 */
	function getTitle( $subpage = '' ) {
		return $this->mPage->getTitle( $subpage );
	}

	abstract function show();

	/**
	 * @static
	 * @return bool
	 */
	static function canEdit() {
		global $wgUser;
		static $canEdit = null;

		if ( is_null( $canEdit ) ) {
			$canEdit = $wgUser->isAllowed( 'abusefilter-modify' );
		}

		return $canEdit;
	}

	/**
	 * @static
	 * @return bool
	 */
	static function canViewPrivate() {
		global $wgUser;
		static $canView = null;

		if ( is_null( $canView ) ) {
			$canView = self::canEdit() || $wgUser->isAllowed( 'abusefilter-view-private' );
		}

		return $canView;
	}
}

class AbuseFilterChangesList extends OldChangesList {
	public function insertExtra( &$s, &$rc, &$classes ) {
		$examineParams = empty( $rc->examineParams ) ? array() : $rc->examineParams;

		$title = SpecialPage::getTitleFor( 'AbuseFilter', 'examine/' . $rc->mAttribs['rc_id'] );
		$examineLink = Linker::link( $title, wfMsgExt( 'abusefilter-changeslist-examine', 'parseinline' ), array(), $examineParams );

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
