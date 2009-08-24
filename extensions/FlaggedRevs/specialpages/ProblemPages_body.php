<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "FlaggedRevs extension\n";
	exit( 1 );
}

class ProblemPages extends SpecialPage
{
	public function __construct() {
		SpecialPage::SpecialPage( 'ProblemPages' );
		wfLoadExtensionMessages( 'ProblemPages' );
		wfLoadExtensionMessages( 'FlaggedRevs' );
	}

	public function execute( $par ) {
		global $wgRequest, $wgOut, $wgUser;
		$this->setHeaders();
		if( $wgUser->isAllowed( 'feedback' ) ) {
			if( $wgUser->isBlocked() ) {
				$wgOut->blockedPage();
				return;
			}
		} else {
			$wgOut->permissionRequired( 'feedback' );
			return;
		}
		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}
		$this->skin = $wgUser->getSkin();
		# Check if there is a featured level
		$this->namespace = $wgRequest->getInt( 'namespace' );
		$this->tag = $wgRequest->getVal( 'ratingtag' );
		$this->showForm();
		$this->showPageList();
	}

	protected function showForm() {
		global $wgOut, $wgTitle, $wgScript, $wgFlaggedRevsNamespaces;
		$form = Xml::openElement( 'form',
			array( 'name' => 'reviewedpages', 'action' => $wgScript, 'method' => 'get' ) );
		$form .= "<fieldset><legend>".wfMsgHtml('problempages-leg')."</legend>\n";
		$form .= Xml::hidden( 'title', $wgTitle->getPrefixedDBKey() );
		if( count($wgFlaggedRevsNamespaces) > 1 ) {
			$form .= FlaggedRevsXML::getNamespaceMenu( $this->namespace ) . '&nbsp;';
		}
		if( count( FlaggedRevs::getFeedbackTags() ) > 0 ) {
			$form .= FlaggedRevsXML::getTagMenu( $this->tag );
		}
		$form .= " ".Xml::submitButton( wfMsg( 'go' ) );
		$form .= "</fieldset></form>\n";
		$wgOut->addHTML( $form );
	}

	protected function showPageList() {
		global $wgOut;
		$tags = FlaggedRevs::getFeedbackTags();
		$pager = new ProblemPagesPager( $this, array(), $this->namespace, $this->tag );
		if( isset($tags[$this->tag]) && $pager->getNumRows() ) {
			$wgOut->addHTML( wfMsgExt('problempages-list', array('parse') ) );
			$wgOut->addHTML( $pager->getNavigationBar() );
			$wgOut->addHTML( $pager->getBody() );
			$wgOut->addHTML( $pager->getNavigationBar() );
		} else if( $this->tag ) { // must select first...
			$wgOut->addHTML( wfMsgExt('problempages-none', array('parse') ) );
		}
	}

	public function formatRow( $row ) {
		global $wgLang;
		$title = Title::makeTitle( $row->page_namespace, $row->page_title );
		$link = $this->skin->makeKnownLinkObj( $title, $title->getPrefixedText() );
		$hist = $this->skin->makeKnownLinkObj( $title, wfMsgHtml('hist'), 'action=history' );
		$stxt = '';
		if( !is_null($size = $row->page_len) ) {
			if($size == 0)
				$stxt = ' <small>' . wfMsgHtml('historyempty') . '</small>';
			else
				$stxt = ' <small>' . wfMsgExt('historysize', array('parsemag'),
					$wgLang->formatNum( $size ) ) . '</small>';
		}
		$ratinghist = SpecialPage::getTitleFor( 'RatingHistory' );
		$graph = $this->skin->makeKnownLinkObj( $ratinghist, wfMsg('problempages-graphs'), 
			'target='.$title->getPrefixedUrl() );
		return "<li>$link $stxt ($hist) ($graph)</li>";
	}
}

/**
 * Query to list out problematic pages
 */
class ProblemPagesPager extends AlphabeticPager {
	public $mForm, $mConds, $namespace, $tag;

	function __construct( $form, $conds = array(), $namespace=0, $tag ) {
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
		$this->tag = $tag;
		parent::__construct();
	}

	function formatRow( $row ) {
		return $this->mForm->formatRow( $row );
	}

	function getQueryInfo() {
		$conds = $this->mConds;
		$conds[] = 'rfp_page_id = page_id';
		$conds['rfp_tag'] = $this->tag;
		$conds['page_namespace'] = $this->namespace;
		// Has to be bad enough
		$x = 2;
		$conds[] = "rfp_ave_val < $x";
		// Reasonable sample
		$conds[] = 'rfp_count >= '.READER_FEEDBACK_SIZE;
		return array(
			'tables' => array('reader_feedback_pages','page'),
			'fields' => 'page_namespace,page_title,page_len,rfp_ave_val',
			'conds'  => $conds,
			'options' => array( 'USE INDEX' => array('reader_feedback_pages' => 'rfp_tag_val_page') )
		);
	}

	function getIndexField() {
		return 'rfp_ave_val';
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
