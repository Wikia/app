<?php

// Special:Code/MediaWiki
class CodeCommentsListView extends CodeView {
	public $mRepo;

	function __construct( $repoName ) {
		parent::__construct();
		$this->mRepo = CodeRepository::newFromName( $repoName );
	}

	function execute() {
		global $wgOut;
		$pager = $this->getPager();
		$wgOut->addHTML(
			$pager->getNavigationBar() .
			$pager->getLimitForm() .
			$pager->getBody() .
			$pager->getNavigationBar()
		);
	}

	function getPager() {
		return new CodeCommentsTablePager( $this );
	}
	function getRepo() {
		return $this->mRepo;
	}
}

// Pager for CodeRevisionListView
class CodeCommentsTablePager extends SvnTablePager {

	function isFieldSortable( $field ) {
		return $field == 'cr_timestamp';
	}

	function getDefaultSort() { return 'cc_timestamp'; }

	function getQueryInfo() {
		return array(
			'tables' => array( 'code_comment', 'code_rev' ),
			'fields' => array_keys( $this->getFieldNames() ),
			'conds' => array( 'cc_repo_id' => $this->mRepo->getId() ),
			'join_conds' => array(
				'code_rev' => array( 'LEFT JOIN', 'cc_repo_id = cr_repo_id AND cc_rev_id = cr_id' )
			)
		);
	}

	function getFieldNames() {
		return array(
			'cc_timestamp' => wfMsg( 'code-field-timestamp' ),
			'cc_user_text' => wfMsg( 'code-field-user' ),
			'cc_rev_id' => wfMsg( 'code-field-id' ),
			'cr_status' => wfMsg( 'code-field-status' ),
			'cr_message' => wfMsg( 'code-field-message' ),
			'cc_text' => wfMsg( 'code-field-text' ),
		);
	}

	function formatValue( $name, $value ) {
		global $wgLang;
		switch( $name ) {
		case 'cc_rev_id':
			return $this->mView->mSkin->link(
				SpecialPage::getTitleFor( 'Code', $this->mRepo->getName() . '/' . $value . '#code-comments' ),
				htmlspecialchars( $value ) );
		case 'cr_status':
			return $this->mView->mSkin->link(
				SpecialPage::getTitleFor( 'Code',
					$this->mRepo->getName() . '/status/' . $value ),
				htmlspecialchars( $this->mView->statusDesc( $value ) ) );
		case 'cc_user_text':
			return $this->mView->mSkin->userLink( -1, $value );
		case 'cr_message':
			return $this->mView->messageFragment( $value );
		case 'cc_text':
			# Truncate this, blah blah...
			return htmlspecialchars( $wgLang->truncate( $value, 300 ) );
		case 'cc_timestamp':
			global $wgLang;
			return $wgLang->timeanddate( $value, true );
		}
	}

	function getTitle() {
		return SpecialPage::getTitleFor( 'Code', $this->mRepo->getName() . '/comments' );
	}
}
