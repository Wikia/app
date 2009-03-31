<?php

// Special:Code/MediaWiki
class CodeRevisionListView extends CodeView {
	public $mRepo, $mPath;
	function __construct( $repoName ) {
		global $wgRequest;
		parent::__construct();
		$this->mRepo = CodeRepository::newFromName( $repoName );
		$this->mPath = htmlspecialchars( trim( $wgRequest->getVal( 'path' ) ) );
		if( strlen($this->mPath) && $this->mPath[0] !== '/' ) {
			$this->mPath = "/{$this->mPath}"; // make sure this is a valid path
		}
		$this->mAuthor = null;
	}

	function execute() {
		global $wgOut;
		if( !$this->mRepo ) {
			$view = new CodeRepoListView();
			$view->execute();
			return;
		}
		$this->showForm();
		$pager = $this->getPager();
		$wgOut->addHTML( 
			$pager->getNavigationBar() .
			$pager->getLimitForm() . 
			$pager->getBody() . 
			$pager->getNavigationBar()
		);
	}
	
	function showForm( $path = '' ) {
		global $wgOut, $wgScript;
		if( $this->mAuthor ) {
			$special = SpecialPage::getTitleFor( 'Code', $this->mRepo->getName().'/author/'.$this->mAuthor );
		} else {
			$special = SpecialPage::getTitleFor( 'Code', $this->mRepo->getName().'/path' );
		}
		$wgOut->addHTML( 
			Xml::openElement( 'form', array( 'action' => $wgScript, 'method' => 'get' ) ) .
			"<fieldset><legend>".wfMsgHtml('code-pathsearch-legend')."</legend>" .
				Xml::hidden( 'title', $special->getPrefixedDBKey() ) .
				Xml::inputlabel( wfMsg("code-pathsearch-path"), 'path', 'path', 55, $this->mPath ) .
				'&nbsp;' . Xml::submitButton( wfMsg( 'allpagessubmit' ) ) . "\n" .
			"</fieldset>" . Xml::closeElement( 'form' )
		);
	}
	
	function getPager() {
		return new SvnRevTablePager( $this );
	}
}

// Pager for CodeRevisionListView
class SvnRevTablePager extends TablePager {

	function __construct( $view ) {
		global $IP;
		$this->mView = $view;
		$this->mRepo = $view->mRepo;
		$this->mDefaultDirection = true;
		$this->mCurSVN = SpecialVersion::getSvnRevision( $IP );
		parent::__construct();
	}
	
	function getSVNPath() {
		return $this->mView->mPath;
	}

	function isFieldSortable( $field ) {
		return $field == $this->getDefaultSort();
	}

	function getDefaultSort() {
		return strlen( $this->getSVNPath() ) ? 'cp_rev_id' : 'cr_id';
	}

	function getQueryInfo() {
		// Path-based query...
		if( $this->getDefaultSort() === 'cp_rev_id' ) {
			return array(
				'tables' => array( 'code_paths', 'code_rev', 'code_comment' ),
				'fields' => array_keys( $this->getFieldNames() ),
				'conds' => array( 
					'cp_repo_id' => $this->mRepo->getId(),
					'cp_path LIKE '.$this->mDb->addQuotes($this->mDb->escapeLike( $this->getSVNPath() ).'%'),
					// performance
					'cp_rev_id > '.$this->mRepo->getLastStoredRev() - 20000
				),
				'options' => array( 'GROUP BY' => 'cp_rev_id', 'USE INDEX' => array('code_path' => 'cp_repo_id') ),
				'join_conds' => array( 
					'code_rev' => array( 'INNER JOIN', 'cr_repo_id = cp_repo_id AND cr_id = cp_rev_id' ),
					'code_comment' => array( 'LEFT JOIN', 'cc_repo_id = cp_repo_id AND cc_rev_id = cp_rev_id' )
				)
			);
		// No path; entire repo...
		} else {
			return array(
				'tables' => array( 'code_rev', 'code_comment' ),
				'fields' => array_keys( $this->getFieldNames() ),
				'conds' => array( 'cr_repo_id' => $this->mRepo->getId() ),
				'options' => array( 'GROUP BY' => 'cr_id' ),
				'join_conds' => array( 
					'code_comment' => array('LEFT JOIN','cc_repo_id = cr_repo_id AND cc_rev_id = cr_id')
				)
			);
		}
		return false;
	}

	function getFieldNames() {
		return array(
			$this->getDefaultSort() => wfMsg( 'code-field-id' ),
			'cr_status' => wfMsg( 'code-field-status' ),
			'COUNT( DISTINCT cc_id)' => wfMsg( 'code-field-comments' ),
			'cr_path' => wfMsg( 'code-field-path' ),
			'cr_message' => wfMsg( 'code-field-message' ),
			'cr_author' => wfMsg( 'code-field-author' ),
			'cr_timestamp' => wfMsg( 'code-field-timestamp' ),
		);
	}

	function formatValue( $name, $value ) {
		global $wgUser, $wgLang;
		switch( $name ) {
		case 'cp_rev_id':
		case 'cr_id':
			return $this->mView->mSkin->link(
				SpecialPage::getTitleFor( 'Code', $this->mRepo->getName() . '/' . $value ),
				htmlspecialchars( $value ) );
		case 'cr_status':
			return $this->mView->mSkin->link(
				SpecialPage::getTitleFor( 'Code',
					$this->mRepo->getName() . '/status/' . $value ),
				htmlspecialchars( $this->mView->statusDesc( $value ) ) );
		case 'cr_author':
			return $this->mView->authorLink( $value );
		case 'cr_message':
			return $this->mView->messageFragment( $value );
		case 'cr_timestamp':
			global $wgLang;
			return $wgLang->timeanddate( $value, true );
		case 'COUNT( DISTINCT cc_id)':
			return intval( $value );
		case 'cr_path':
			return Xml::element('div', array( 'title' => (string)$value ),
				$wgLang->truncate( (string)$value, 30, '...' ) );
		}
	}
	
	// Note: this function is poorly factored in the parent class
	function formatRow( $row ) {
		global $wgWikiSVN;
		$css = "mw-codereview-status-{$row->cr_status}";
		if( $this->mRepo->mName == $wgWikiSVN ) {
			$css .= " mw-codereview-" . ( $row->{$this->getDefaultSort()} <= $this->mCurSVN ? 'live' : 'notlive' );
		}
		return str_replace( '<tr>', Xml::openElement( 'tr', array( 'class' => $css ) ),
			parent::formatRow( $row ) );
	}

	function getTitle() {
		return SpecialPage::getTitleFor( 'Code', $this->mRepo->getName() );
	}
}
