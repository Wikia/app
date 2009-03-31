<?php

class CodeRevisionTagView extends CodeRevisionListView {
	function __construct( $repoName, $tag ) {
		parent::__construct( $repoName );
		$this->mTag = $tag;
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
	
	function getQueryInfo() {
		$info = parent::getQueryInfo();
		$info['tables'][] = 'code_tags';
		$info['conds'][] = 'cr_repo_id=ct_repo_id';
		$info['conds'][] = 'cr_id=ct_rev_id';
		$info['conds']['ct_tag'] = $this->mTag; // fixme: normalize input?
		return $info;
	}

	function getTitle(){
		$repo = $this->mRepo->getName();
		return SpecialPage::getTitleFor( 'Code', "$repo/tag/$this->mTag" );
	}
}
