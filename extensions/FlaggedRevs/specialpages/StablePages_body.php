<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "FlaggedRevs extension\n";
	exit( 1 );
}

class StablePages extends SpecialPage
{
	public function __construct() {
        SpecialPage::SpecialPage( 'StablePages' );
		wfLoadExtensionMessages( 'StablePages' );
		wfLoadExtensionMessages( 'FlaggedRevs' );
    }

	public function execute( $par ) {
        global $wgRequest, $wgUser;
		
		$this->setHeaders();
		$this->skin = $wgUser->getSkin();
		
		$this->namespace = $wgRequest->getInt( 'namespace' );
		$this->precedence = $wgRequest->getInt( 'precedence', FlaggedRevs::getPrecedence() );
		
		$this->showForm();
		$this->showPageList();
	}
	
	protected function showForm() {
		global $wgOut, $wgTitle, $wgScript, $wgFlaggedRevsNamespaces;
		$wgOut->addHTML( wfMsgExt('stablepages-text', array('parseinline') ) );
		if( count($wgFlaggedRevsNamespaces) > 1 ) {
			$form = Xml::openElement( 'form', array( 'name' => 'stablepages', 'action' => $wgScript, 'method' => 'get' ) );
			$form .= "<fieldset><legend>".wfMsg('stablepages')."</legend>\n";
			$form .= FlaggedRevsXML::getNamespaceMenu( $this->namespace ) . '&nbsp;';
			$form .= Xml::label( wfMsg('stablepages-precedence'), 'wpPrecedence' ) . '&nbsp;';
			$form .= FlaggedRevsXML::getPrecedenceMenu( $this->precedence ) . '&nbsp;';
			$form .= " ".Xml::submitButton( wfMsg( 'go' ) );
			$form .= Xml::hidden( 'title', $wgTitle->getPrefixedDBKey() );
			$form .= "</fieldset></form>\n";
			$wgOut->addHTML( $form );
		}
	}

	protected function showPageList() {
		global $wgOut, $wgUser, $wgLang;
		# Take this opportunity to purge out expired configurations
		FlaggedRevs::purgeExpiredConfigurations();
		$pager = new StablePagesPager( $this, array(), $this->namespace, $this->precedence );
		if( $pager->getNumRows() ) {
			$wgOut->addHTML( $pager->getNavigationBar() );
			$wgOut->addHTML( $pager->getBody() );
			$wgOut->addHTML( $pager->getNavigationBar() );
		} else {
			$wgOut->addHTML( wfMsgExt('stablepages-none', array('parse') ) );
		}
	}

	public function formatRow( $row ) {
		global $wgLang, $wgUser;

		$title = Title::makeTitle( $row->page_namespace, $row->page_title );
		$link = $this->skin->makeKnownLinkObj( $title, $title->getPrefixedText() );

		$stitle = SpecialPage::getTitleFor( 'Stabilization' );
		$config = $this->skin->makeKnownLinkObj( $stitle, wfMsgHtml('stablepages-config'),
			'page=' . $title->getPrefixedUrl() );
		$stable = $this->skin->makeKnownLinkObj( $title, wfMsgHtml('stablepages-stable'), 'stable=1' );

		if( intval($row->fpc_select) === FLAGGED_VIS_PRISTINE ) {
			$type = wfMsgHtml('stablepages-prec-pristine');
		} else if( intval($row->fpc_select) === FLAGGED_VIS_QUALITY ) {
			$type = wfMsgHtml('stablepages-prec-quality');
		} else {
			$type = wfMsgHtml('stablepages-prec-none');
		}

		if( $row->fpc_expiry != 'infinity' && strlen($row->fpc_expiry) ) {
			$expiry_description = " (".wfMsgForContent( 'protect-expiring', $wgLang->timeanddate($row->fpc_expiry) ).")";
		} else {
			$expiry_description = "";
		}

		return "<li>{$link} ({$config}) [{$stable}] (<b>{$type}</b>) <i>{$expiry_description}</i></li>";
	}
}

/**
 * Query to list out stable versions for a page
 */
class StablePagesPager extends AlphabeticPager {
	public $mForm, $mConds, $namespace;

	function __construct( $form, $conds = array(), $namespace=0, $precedence=NULL ) {
		$this->mForm = $form;
		$this->mConds = $conds;
		# Must be a content page...
		global $wgFlaggedRevsNamespaces;
		if( !is_null($namespace) ) {
			$namespace = intval($namespace);
		}
		if( is_null($namespace) || !in_array($namespace,$wgFlaggedRevsNamespaces) ) {
			$namespace = empty($wgFlaggedRevsNamespaces) ? -1 : $wgFlaggedRevsNamespaces[0]; 	 
		}
		$this->namespace = $namespace;
		$this->precedence = $precedence;
		parent::__construct();
	}

	function formatRow( $row ) {
		return $this->mForm->formatRow( $row );
	}

	function getQueryInfo() {
		$conds = $this->mConds;
		$conds[] = 'page_id = fpc_page_id';
		$conds['fpc_override'] = 1;
		if( $this->precedence !== NULL && $this->precedence >= 0 ) {
			$conds['fpc_select'] = $this->precedence;
		}
		$conds['page_namespace'] = $this->namespace;
		return array(
			'tables' => array('flaggedpage_config','page'),
			'fields' => 'page_namespace,page_title,fpc_expiry,fpc_page_id,fpc_select',
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
		while( $row = $this->mResult->fetchObject() ) {
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
