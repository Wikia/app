<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "ReaderFeedback extension\n";
	exit( 1 );
}

class RatedPages extends SpecialPage
{
    public function __construct() {
        parent::__construct( 'RatedPages' );
		wfLoadExtensionMessages( 'RatedPages' );
		wfLoadExtensionMessages( 'ReaderFeedback' );
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
		// Purge expired entries on one in every 10 queries
		if( 0 == mt_rand( 0, 10 ) ) {
			ReaderFeedback::purgeExpiredAverages();
		}
		$this->skin = $wgUser->getSkin();
		# Check if there is a featured level
		$this->namespace = $wgRequest->getInt( 'namespace' );
		$this->tag = $wgRequest->getVal( 'ratingtag' );
		$this->tier = $wgRequest->getInt( 'ratingtier' );

		$this->showForm();
		$this->showPageList();
	}

	protected function showForm() {
		global $wgOut, $wgScript, $wgFeedbackNamespaces;
		$form = Xml::openElement( 'form',
			array( 'name' => 'reviewedpages', 'action' => $wgScript, 'method' => 'get' ) );
		$form .= Xml::fieldset( wfMsg( 'ratedpages-leg' ) );
		$form .= Xml::hidden( 'title', $this->getTitle()->getPrefixedDBKey() );
		$form .= ReaderFeedbackXML::getRatingTierMenu($this->tier) . '&nbsp;';
		if( count($wgFeedbackNamespaces) > 1 ) {
			$form .= ReaderFeedbackXML::getNamespaceMenu( $this->namespace ) . '&nbsp;';
		}
		if( count( ReaderFeedback::getFeedbackTags() ) > 0 ) {
			$form .= ReaderFeedbackXML::getTagMenu( $this->tag );
		}
		$form .= " " . Xml::submitButton( wfMsg( 'go' ) ) .
			Xml::closeElement( 'fieldset' ) .
			Xml::closeElement( 'form' ) . "\n";

		$wgOut->addHTML( $form );
	}

	protected function showPageList() {
		global $wgOut;
		$tags = ReaderFeedback::getFeedbackTags();
		$pager = new RatedPagesPager( $this, array(), $this->namespace, $this->tag, $this->tier );
		if( isset($tags[$this->tag]) && $pager->getNumRows() ) {
			$wgOut->addHTML( wfMsgExt('ratedpages-list', array('parse') ) );
			$wgOut->addHTML( $pager->getNavigationBar() );
			$wgOut->addHTML( $pager->getBody() );
			$wgOut->addHTML( $pager->getNavigationBar() );
		} elseif( $this->tag ) { // must select first...
			$wgOut->addHTML( wfMsgExt('ratedpages-none', array('parse') ) );
		}
	}

	public function formatRow( $row ) {
		global $wgLang;
		$title = Title::makeTitle( $row->page_namespace, $row->page_title );
		$link = $this->skin->makeKnownLinkObj( $title, $title->getPrefixedText() );
		$hist = $this->skin->makeKnownLinkObj( $title, wfMsgHtml('hist'), 'action=history' );
		$stxt = '';
		if( !is_null($size = $row->page_len) ) {
			if( $size == 0 )
				$stxt = ' <small>' . wfMsgHtml('historyempty') . '</small>';
			else
				$stxt = ' <small>' . wfMsgExt('historysize', array('parsemag'),
					$wgLang->formatNum( $size ) ) . '</small>';
		}
		$ratinghist = SpecialPage::getTitleFor( 'RatingHistory' );
		$graph = $this->skin->makeKnownLinkObj( $ratinghist, wfMsgHtml('ratedpages-graphs'), 
			'target='.$title->getPrefixedUrl().'&period=93' );
		$count = wfMsgExt( 'ratedpages-count', array( 'parsemag', 'escape' ), $wgLang->formatNum( $row->rfp_count ) );
		return "<li>$link $stxt ($hist) ($graph) ($count)</li>";
	}
}

/**
 * Query to list out well recieved pages
 */
class RatedPagesPager extends AlphabeticPager {
	public $mForm, $mConds, $namespace, $tag;

	function __construct( $form, $conds = array(), $namespace=0, $tag, $tier ) {
		$this->mForm = $form;
		$this->mConds = $conds;
		# Must be a content page...
		global $wgFeedbackNamespaces;
		if( !is_null($namespace) ) {
			$namespace = intval($namespace);
		}
		if( is_null($namespace) || !in_array($namespace,$wgFeedbackNamespaces) ) {
			$namespace = empty($wgFeedbackNamespaces) ? -1 : $wgFeedbackNamespaces[0]; 	 
		}
		$this->namespace = $namespace;
		$this->tag = $tag;
		$this->tier = (int)$tier;
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
		// Has to be good/crappy enough
		switch( $this->tier ) {
			case 3: $conds[] = "rfp_ave_val > 3"; break;
			case 1: $conds[] = "rfp_ave_val < 2"; break;
			default: $conds[] = "rfp_ave_val >= 2 AND rfp_ave_val <= 3"; break;
		}
		// Reasonable samples only
		$conds[] = 'rfp_count >= '.$this->mDb->addQuotes( ReaderFeedback::getFeedbackSize() );
		return array(
			'tables'  => array('reader_feedback_pages','page'),
			'fields'  => 'page_namespace,page_title,page_len,rfp_ave_val,rfp_count',
			'conds'   => $conds,
			'options' => array( 'USE INDEX' => array('reader_feedback_pages' => 'rfp_tag_val_page') )
		);
	}
	
	function getDefaultDirections() {
		return false;
	}

	function getIndexField() {
		return 'rfp_ave_val';
	}
	
	function getStartBody() {
		wfProfileIn( __METHOD__ );
		# Do a link batch query...
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
