<?php

class CodeRevisionAuthorView extends CodeRevisionListView {

	function __construct( $repo, $author ) {
		parent::__construct( $repo );
		$this->mAuthor = $author;
		$this->mUser = $this->mRepo->authorWikiUser( $author );
	}

	function getPager() {
		return new SvnRevAuthorTablePager( $this, $this->mAuthor );
	}

	function linkStatus() {
		if ( !$this->mUser ) {
			return wfMsg( 'code-author-orphan', $this->authorLink( $this->mAuthor ) );
		}

		return wfMsgHtml( 'code-author-haslink',
			$this->skin->userLink( $this->mUser->getId(), $this->mUser->getName() ) .
			$this->skin->userToolLinks(
				$this->mUser->getId(),
				$this->mUser->getName(),
				false, /* default for redContribsWhenNoEdits */
				Linker::TOOL_LINKS_EMAIL /* Add "send e-mail" link */
			) );
	}

	function execute() {
		global $wgOut, $wgUser;

		$linkInfo = $this->linkStatus();

		if ( $wgUser->isAllowed( 'codereview-link-user' ) ) {
			$repo = $this->mRepo->getName();
			$page = SpecialPage::getTitleFor( 'Code', "$repo/author/$this->mAuthor/link" );
			$linkInfo .= ' (' . $this->skin->link( $page,
				wfMsg( 'code-author-' . ( $this->mUser ? 'un':'' ) . 'link' ) ) . ')' ;
		}

		$repoLink = $this->skin->link( SpecialPage::getTitleFor( 'Code', $this->mRepo->getName() ),
			htmlspecialchars( $this->mRepo->getName() ) );
		$fields = array(
			'code-rev-repo' => $repoLink,
			'code-rev-author' => $this->mAuthor,
		);

		$wgOut->addHTML( $this->formatMetaData( $fields ) . $linkInfo );

		parent::execute();
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
