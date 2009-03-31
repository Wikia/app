<?php

class CodeRevisionStatusView extends CodeRevisionListView {
	function __construct( $repoName, $status ) {
		parent::__construct( $repoName );
		$this->mStatus = $status;
	}
	
	function getPager() {
		return new SvnRevStatusTablePager( $this, $this->mStatus );
	}
}

class SvnRevStatusTablePager extends SvnRevTablePager {
	function __construct( $view, $status ) {
		parent::__construct( $view );
		$this->mStatus = $status;
	}
	
	function getQueryInfo() {
		$info = parent::getQueryInfo();
		$info['conds']['cr_status'] = $this->mStatus; // fixme: normalize input?
		return $info;
	}

	function getTitle(){
		$repo = $this->mRepo->getName();
		return SpecialPage::getTitleFor( 'Code', "$repo/status/$this->mStatus" );
	}
}
