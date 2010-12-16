<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "FlaggedRevs extension\n";
	exit( 1 );
}

class ReviewedPages extends SpecialPage
{
	public function __construct() {
		parent::__construct( 'ReviewedPages' );
    }

	public function execute( $par ) {
		global $wgRequest, $wgUser;

		$this->setHeaders();
		$this->skin = $wgUser->getSkin();

		# Check if there is a featured level
		$maxType = FlaggedRevs::pristineVersions() ? 2 : 1;
		$this->namespace = $wgRequest->getInt( 'namespace' );
		$this->type = $wgRequest->getInt( 'level', - 1 );
		$this->type = min( $this->type, $maxType );
		$this->hideRedirs = $wgRequest->getBool( 'hideredirs', true );
		
		$this->showForm();
		$this->showPageList();
	}

	public function showForm() {
		global $wgOut, $wgScript;

		$form = Xml::openElement( 'form',
			array( 'name' => 'reviewedpages', 'action' => $wgScript, 'method' => 'get' ) );
		$form .= "<fieldset><legend>" . wfMsg( 'reviewedpages-leg' ) . "</legend>\n";

		// show/hide links
		$showhide = array( wfMsgHtml( 'show' ), wfMsgHtml( 'hide' ) );
		$onoff = 1 - $this->hideRedirs;
		$link = $this->skin->link( $this->getTitle(), $showhide[$onoff], array(),
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
		$form .= Xml::hidden( 'title', $this->getTitle()->getPrefixedDBKey() );
		$form .= "</fieldset></form>\n";

		$wgOut->addHTML( $form );
	}

	protected function showPageList() {
		global $wgOut, $wgUser, $wgLang;

		$pager = new ReviewedPagesPager( $this, array(), $this->type,
			$this->namespace, $this->hideRedirs );
		$num = $pager->getNumRows();
		if ( $num ) {
			$wgOut->addHTML( wfMsgExt( 'reviewedpages-list', array( 'parse' ), $num ) );
			$wgOut->addHTML( $pager->getNavigationBar() );
			$wgOut->addHTML( $pager->getBody() );
			$wgOut->addHTML( $pager->getNavigationBar() );
		} else {
			$wgOut->addHTML( wfMsgExt( 'reviewedpages-none', array( 'parse' ) ) );
		}
	}

	public function formatRow( $row ) {
		global $wgLang, $wgUser;

		$title = Title::makeTitle( $row->page_namespace, $row->page_title );
		$link = $this->skin->makeKnownLinkObj( $title, $title->getPrefixedText() );

		$stxt = '';
		if ( !is_null( $size = $row->page_len ) ) {
			if ( $size == 0 )
				$stxt = ' <small>' . wfMsgHtml( 'historyempty' ) . '</small>';
			else
				$stxt = ' <small>' . wfMsgExt( 'historysize', array( 'parsemag' ),
					$wgLang->formatNum( $size ) ) . '</small>';
		}

		$SVtitle = SpecialPage::getTitleFor( 'ReviewedVersions' );
		$list = $this->skin->makeKnownLinkObj( $SVtitle, wfMsgHtml( 'reviewedpages-all' ),
			'page=' . $title->getPrefixedUrl() );
		$best = $this->skin->makeKnownLinkObj( $title, wfMsgHtml( 'reviewedpages-best' ),
			'stableid=best' );

		return "<li>$link $stxt ($list) [$best]</li>";
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
			'options' => array( 'USE INDEX' => array( 'flaggedpages' => $index,
				'page' => 'PRIMARY' ) )
		);
	}

	function getIndexField() {
		return 'fp_page_id';
	}
	
	function getStartBody() {
		wfProfileIn( __METHOD__ );
		# Do a link batch query
		$lb = new LinkBatch();
		while ( $row = $this->mResult->fetchObject() ) {
			$lb->add( $row->page_namespace, $row->page_title );
		}
		$lb->execute();
		wfProfileOut( __METHOD__ );
		return '<ul>';
	}
	
	function getEndBody() {
		return '</ul>';
	}
}
