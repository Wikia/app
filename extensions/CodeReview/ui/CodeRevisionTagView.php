<?php

class CodeRevisionTagView extends CodeRevisionListView {
	function __construct( $repo, $tag ) {
		$this->mTag = $tag;

		if ( $this->mTag ) {
			$this->filters[] = wfMsg( 'code-revfilter-ct_tag', $this->mTag );
		}
		parent::__construct( $repo );
	}

	function getPager() {
		return new SvnRevTagTablePager( $this, $this->mTag );
	}
}

class SvnRevTagTablePager extends SvnRevTablePager {
	function __construct( $view, $tag ) {
		parent::__construct( $view );
		$this->mTag = $tag;
	}

	function getDefaultSort() {
		return 'ct_rev_id';
	}

	function getQueryInfo() {
		$info = parent::getQueryInfo();

		if ( $this->mView->mPath ) {
			array_unshift( $info['tables'], 'code_paths' );
			$info['conds'][] = 'cr_repo_id=cp_repo_id';
			$info['conds'][] = 'cr_id=cp_rev_id';
			$info['conds']['cp_path'] = $this->mView->mPath;
		}
		//Don't change table order, see http://www.mediawiki.org/wiki/Special:Code/MediaWiki/77733
		//Bug in mysql 4 allowed incorrect table ordering joins to work
		array_unshift( $info['tables'], 'code_tags' );
		$info['conds'][] = 'cr_repo_id=ct_repo_id';
		$info['conds'][] = 'cr_id=ct_rev_id';
		$info['conds']['ct_tag'] = $this->mTag; // fixme: normalize input?
		return $info;
	}

	function getTitle() {
		$repo = $this->mRepo->getName();
		return SpecialPage::getTitleFor( 'Code', "$repo/tag/$this->mTag" );
	}
}
