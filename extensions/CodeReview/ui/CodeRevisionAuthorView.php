<?php

class CodeRevisionAuthorView extends CodeRevisionListView {
	function __construct( $repoName, $author ) {
		parent::__construct( $repoName );
		$this->mAuthor = $author;
		$this->mUser = $this->authorWikiUser( $author );
		$this->mAppliedFilter = wfMsg( 'code-revfilter-cr_author', $author );
	}

	function getPager() {
		return new SvnRevAuthorTablePager( $this, $this->mAuthor );
	}

	function linkStatus() {
		if ( !$this->mUser )
			return wfMsg( 'code-author-orphan' );

		return wfMsgHtml( 'code-author-haslink',
			$this->mSkin->userLink( $this->mUser->getId(), $this->mUser->getName() ) .
			$this->mSkin->userToolLinks( $this->mUser->getId(), $this->mUser->getName() ) );
	}

	function execute() {
		global $wgOut, $wgUser;

		$linkInfo = $this->linkStatus();

		if ( $wgUser->isAllowed( 'codereview-link-user' ) ) {
			$repo = $this->mRepo->getName();
			$page = SpecialPage::getTitleFor( 'Code', "$repo/author/$this->mAuthor/link" );
			$linkInfo .= ' (' . $this->mSkin->link( $page,
				wfMsg( 'code-author-' . ( $this->mUser ? 'un':'' ) . 'link' ) ) . ')' ;
		}

		$repoLink = $wgUser->getSkin()->link( SpecialPage::getTitleFor( 'Code', $this->mRepo->getName() ),
			htmlspecialchars( $this->mRepo->getName() ) );
		$fields = array(
			'code-rev-repo' => $repoLink,
			'code-rev-author' => $this->authorLink( $this->mAuthor ),
		);

		$wgOut->addHTML( $this->formatMetaData( $fields ) . $linkInfo );

		parent::execute();
	}
	
	function getSpecializedWhereClause( $dbr ) {
		return array( 'cr_author' => $this->mAuthor );
	}

}

class SvnRevAuthorTablePager extends SvnRevTablePager {
	function __construct( $view, $author ) {
		parent::__construct( $view );
		$this->mAuthor = $author;
	}

	function getQueryInfo() {
		$info = parent::getQueryInfo();
		$info['conds']['cr_author'] = $this->mAuthor; // fixme: normalize input?
		return $info;
	}

	function getTitle() {
		$repo = $this->mRepo->getName();
		return SpecialPage::getTitleFor( 'Code', "$repo/author/$this->mAuthor" );
	}
}
