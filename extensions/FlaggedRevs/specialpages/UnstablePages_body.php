<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "FlaggedRevs extension\n";
	exit( 1 );
}

class Unstablepages extends SpecialPage
{
    public function __construct() {
        parent::__construct( 'UnstablePages' );
    }

    public function execute( $par ) {
        global $wgRequest, $wgUser;
		
		$this->setHeaders();
		$this->skin = $wgUser->getSkin();
		
		$this->namespace = $wgRequest->getInt( 'namespace' );
		
		$this->showForm();
		$this->showPageList();
	}
	
	protected function showForm() {
		global $wgOut, $wgScript;
		$namespaces = FlaggedRevs::getReviewNamespaces();
		$wgOut->addHTML( wfMsgExt( 'unstablepages-text', array( 'parseinline' ) ) );
		if ( count( $namespaces ) > 1 ) {
			$form = Xml::openElement( 'form', array( 'name' => 'unstablepages',
				'action' => $wgScript, 'method' => 'get' ) );
			$form .= "<fieldset><legend>" . wfMsg( 'unstablepages' ) . "</legend>\n";
			$form .= FlaggedRevsXML::getNamespaceMenu( $this->namespace ) . '&nbsp;';
			$form .= " " . Xml::submitButton( wfMsg( 'go' ) );
			$form .= Xml::hidden( 'title', $this->getTitle()->getPrefixedDBKey() );
			$form .= "</fieldset></form>\n";
			$wgOut->addHTML( $form );
		}
	}

	protected function showPageList() {
		global $wgOut, $wgUser, $wgLang;
		# Take this opportunity to purge out expired configurations
		FlaggedRevs::purgeExpiredConfigurations();
		$pager = new unstablepagesPager( $this, array(), $this->namespace );
		if ( $pager->getNumRows() ) {
			$wgOut->addHTML( $pager->getNavigationBar() );
			$wgOut->addHTML( $pager->getBody() );
			$wgOut->addHTML( $pager->getNavigationBar() );
		} else {
			$wgOut->addHTML( wfMsgExt( 'unstablepages-none', array( 'parse' ) ) );
		}
	}

	public function formatRow( $row ) {
		global $wgLang, $wgUser;

		$title = Title::makeTitle( $row->page_namespace, $row->page_title );
		$link = $this->skin->makeKnownLinkObj( $title, $title->getPrefixedText() );

		$stitle = SpecialPage::getTitleFor( 'Stabilization' );
		$config = $this->skin->makeKnownLinkObj( $stitle, wfMsgHtml( 'unstablepages-config' ),
			'page=' . $title->getPrefixedUrl() );
		$stable = $this->skin->makeKnownLinkObj( $title, wfMsgHtml( 'unstablepages-stable' ),
			'stable=1' );
		if ( $row->fpc_expiry != 'infinity' && strlen( $row->fpc_expiry ) ) {
			$expiry_description = " (" . wfMsgForContent(
				'protect-expiring',
				$wgLang->timeanddate( $row->fpc_expiry ),
				$wgLang->date( $row->fpc_expiry ),
				$wgLang->time( $row->fpc_expiry )
			) . ")";
		} else {
			$expiry_description = "";
		}

		return "<li>{$link} ({$config}) [{$stable}]{$expiry_description}</li>";
	}
}

/**
 * Query to list out stable versions for a page
 */
class UnstablePagesPager extends AlphabeticPager {
	public $mForm, $mConds, $namespace;

	function __construct( $form, $conds = array(), $namespace = 0 ) {
		$this->mForm = $form;
		$this->mConds = $conds;
		# Must be a content page...
		if ( !is_null( $namespace ) ) {
			$namespace = intval( $namespace );
		}
		$vnamespaces = FlaggedRevs::getReviewNamespaces();
		if ( is_null( $namespace ) || !in_array( $namespace, $vnamespaces ) ) {
			$namespace = !$vnamespaces ? - 1 : $vnamespaces[0];
		}
		$this->namespace = $namespace;
		parent::__construct();
	}

	function formatRow( $row ) {
		return $this->mForm->formatRow( $row );
	}

	function getQueryInfo() {
		$conds = $this->mConds;
		$conds[] = 'page_id = fpc_page_id';
		$conds['fpc_override'] = 0;
		$conds['page_namespace'] = $this->namespace;
		return array(
			'tables' => array( 'flaggedpage_config', 'page' ),
			'fields' => 'page_namespace,page_title,fpc_expiry,fpc_page_id',
			'conds'  => $conds,
			'options' => array()
		);
	}

	function getIndexField() {
		return 'fpc_page_id';
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
