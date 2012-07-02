<?php

class ReviewedPages extends SpecialPage {
	protected $pager = null;

	public function __construct() {
		parent::__construct( 'ReviewedPages' );
	}

	public function execute( $par ) {
		$request = $this->getRequest();

		$this->setHeaders();

		# Check if there is a featured level
		$maxType = FlaggedRevs::pristineVersions() ? 2 : 1;

		$this->namespace = $request->getInt( 'namespace' );
		$this->type = $request->getInt( 'level', - 1 );
		$this->type = min( $this->type, $maxType );
		$this->hideRedirs = $request->getBool( 'hideredirs', true );

		$this->pager = new ReviewedPagesPager(
			$this, array(), $this->type, $this->namespace, $this->hideRedirs );

		$this->showForm();
		$this->showPageList();
	}

	public function showForm() {
		global $wgScript;

		// Text to explain level select (if there are several levels)
		if ( FlaggedRevs::qualityVersions() ) {
			$this->getOutput()->addWikiMsg( 'reviewedpages-list',
				$this->getLang()->formatNum( $this->pager->getNumRows() ) );
		}
		$form = Html::openElement( 'form',
			array( 'name' => 'reviewedpages', 'action' => $wgScript, 'method' => 'get' ) );
		$form .= "<fieldset><legend>" . wfMsgHtml( 'reviewedpages-leg' ) . "</legend>\n";

		// show/hide links
		$showhide = array( wfMsgHtml( 'show' ), wfMsgHtml( 'hide' ) );
		$onoff = 1 - $this->hideRedirs;
		$link = Linker::link( $this->getTitle(), $showhide[$onoff], array(),
			 array( 'hideredirs' => $onoff, 'namespace' => $this->namespace )
		);
		$showhideredirs = wfMsgHtml( 'whatlinkshere-hideredirs', $link );

		$fields = array();
		$namespaces = FlaggedRevs::getReviewNamespaces();
		if ( count( $namespaces ) > 1 ) {
			$fields[] = FlaggedRevsXML::getNamespaceMenu( $this->namespace ) . ' ';
		}
		if ( FlaggedRevs::qualityVersions() ) {
			$fields[] = FlaggedRevsXML::getLevelMenu( $this->type ) . ' ';
		}
		$form .= implode( ' ', $fields ) . ' ';
		$form .= $showhideredirs;

		if ( count( $fields ) ) {
			$form .= " " . Xml::submitButton( wfMsg( 'go' ) );
		}
		$form .= Html::hidden( 'title', $this->getTitle()->getPrefixedDBKey() ) . "\n";
		$form .= "</fieldset>";
		$form .= Html::closeElement( 'form ' ) . "\n";

		$this->getOutput()->addHTML( $form );
	}

	protected function showPageList() {
		$out = $this->getOutput();
		$num = $this->pager->getNumRows();
		if ( $num ) {
			$out->addHTML( $this->pager->getNavigationBar() );
			$out->addHTML( $this->pager->getBody() );
			$out->addHTML( $this->pager->getNavigationBar() );
		} else {
			$out->addHTML( wfMsgExt( 'reviewedpages-none', array( 'parse' ) ) );
		}
	}

	public function formatRow( $row ) {
		$title = Title::newFromRow( $row );
		# Link to page
		$link = Linker::link( $title );
		# Direction mark
		$dirmark = wfUILang()->getDirMark();
		# Size (bytes)
		$stxt = '';
		if ( !is_null( $size = $row->page_len ) ) {
			if ( $size == 0 ) {
				$stxt = ' <small>' . wfMsgHtml( 'historyempty' ) . '</small>';
			} else {
				$stxt = ' <small>' .
					wfMsgExt( 'historysize', 'parsemag', $this->getLang()->formatNum( $size ) ) .
					'</small>';
			}
		}
		# Link to list of reviewed versions for page
		$list = Linker::linkKnown(
			SpecialPage::getTitleFor( 'ReviewedVersions' ),
			wfMsgHtml( 'reviewedpages-all' ),
			array(),
			'page=' . $title->getPrefixedUrl()
		);
		# Link to highest tier rev
		$best = '';
		if ( FlaggedRevs::qualityVersions() ) {
			$best = Linker::linkKnown(
				$title,
				wfMsgHtml( 'reviewedpages-best' ),
				array(),
				'stableid=best'
			);
			$best = " [$best]";
		}

		return "<li>$link $dirmark $stxt ($list)$best</li>";
	}
}

/**
 * Query to list out reviewed pages
 */
class ReviewedPagesPager extends AlphabeticPager {
	public $mForm, $mConds, $namespace, $type;

	function __construct( $form, $conds = array(), $type = 0, $namespace = 0, $hideRedirs = 1 ) {
		$this->mForm = $form;
		$this->mConds = $conds;
		$this->type = $type;
		# Must be a content page...
		if ( !is_null( $namespace ) ) {
			$namespace = intval( $namespace );
		}
		$vnamespaces = FlaggedRevs::getReviewNamespaces();
		if ( is_null( $namespace ) || !in_array( $namespace, $vnamespaces ) ) {
			$namespace = !$vnamespaces ? - 1 : $vnamespaces[0];
		}
		$this->namespace = $namespace;
		$this->hideRedirs = $hideRedirs;

		parent::__construct();
	}

	function formatRow( $row ) {
		return $this->mForm->formatRow( $row );
	}

	function getQueryInfo() {
		$conds = $this->mConds;
		$conds[] = 'page_id = fp_page_id';
		$index = 'PRIMARY';
		if ( $this->type >= 0 ) {
			$conds['fp_quality'] = $this->type;
			$index = 'fp_quality_page';
		}
		if ( $this->hideRedirs ) {
			$conds['page_is_redirect'] = 0;
		}
		$conds['page_namespace'] = $this->namespace; // Sanity check NS
		return array(
			'tables' => array( 'flaggedpages', 'page' ),
			'fields' => 'page_namespace,page_title,page_len,fp_page_id',
			'conds'  => $conds,
			'options' => array(
				'USE INDEX' => array( 'flaggedpages' => $index, 'page' => 'PRIMARY' )
			)
		);
	}

	function getIndexField() {
		return 'fp_page_id';
	}

	function doBatchLookups() {
		wfProfileIn( __METHOD__ );
		$lb = new LinkBatch();
		foreach ( $this->mResult as $row ) {
			$lb->add( $row->page_namespace, $row->page_title );
		}
		$lb->execute();
		wfProfileOut( __METHOD__ );
	}

	function getStartBody() {
		return '<ul>';
	}

	function getEndBody() {
		return '</ul>';
	}
}
