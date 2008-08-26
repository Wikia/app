<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "FlaggedRevs extension\n";
	exit( 1 );
}

wfLoadExtensionMessages( 'ReviewedPages' );
wfLoadExtensionMessages( 'FlaggedRevs' );

class ReviewedPages extends SpecialPage
{
    function __construct() {
        SpecialPage::SpecialPage( 'ReviewedPages' );
    }

    function execute( $par ) {
        global $wgRequest, $wgUser, $wgFlaggedRevValues, $wgFlaggedRevPristine;

		$this->setHeaders();
		$this->skin = $wgUser->getSkin();

		# Check if there is a featured level
		$maxType = FlaggedRevs::pristineVersions() ? 2 : 1;
		$this->namespace = $wgRequest->getInt( 'namespace' );
		$this->type = $wgRequest->getInt( 'level' );
		$this->type = $this->type <= $maxType ? $this->type : 0;
		
		$this->showForm();
		$this->showPageList();
	}

	function showForm() {
		global $wgOut, $wgTitle, $wgScript, $wgFlaggedRevsNamespaces;

		$form = Xml::openElement( 'form',
			array( 'name' => 'reviewedpages', 'action' => $wgScript, 'method' => 'get' ) );
		$form .= "<fieldset><legend>".wfMsg('reviewedpages-leg')."</legend>\n";
		
		if( count($wgFlaggedRevsNamespaces) > 1 ) {
			$form .= FlaggedRevsXML::getNamespaceMenu( $this->namespace ) . '&nbsp;';
		}
		$form .= self::getLevelMenu( $this->type );

		$form .= " ".Xml::submitButton( wfMsg( 'go' ) );
		$form .= Xml::hidden( 'title', $wgTitle->getPrefixedDBKey() );
		$form .= "</fieldset></form>\n";

		$wgOut->addHTML( $form );
	}

	function showPageList() {
		global $wgOut, $wgUser, $wgLang;

		$pager = new ReviewedPagesPager( $this, array(), $this->type, $this->namespace );
		if( $pager->getNumRows() ) {
			$wgOut->addHTML( wfMsgExt('reviewedpages-list', array('parse') ) );
			$wgOut->addHTML( $pager->getNavigationBar() );
			$wgOut->addHTML( $pager->getBody() );
			$wgOut->addHTML( $pager->getNavigationBar() );
		} else {
			$wgOut->addHTML( wfMsgExt('reviewedpages-none', array('parse') ) );
		}
	}

	function formatRow( $row ) {
		global $wgLang, $wgUser;

		$title = Title::makeTitle( $row->page_namespace, $row->page_title );
		$link = $this->skin->makeKnownLinkObj( $title, $title->getPrefixedText() );

		$stxt = '';
		if( !is_null($size = $row->page_len) ) {
			if($size == 0)
				$stxt = ' <small>' . wfMsgHtml('historyempty') . '</small>';
			else
				$stxt = ' <small>' . wfMsgExt('historysize', array('parsemag'), $wgLang->formatNum( $size ) ) . '</small>';
		}

		$SVtitle = SpecialPage::getTitleFor( 'Stableversions' );
		$list = $this->skin->makeKnownLinkObj( $SVtitle, wfMsgHtml('reviewedpages-all'),
			'page=' . $title->getPrefixedUrl() );
		$best = $this->skin->makeKnownLinkObj( $title, wfMsgHtml('reviewedpages-best'),
			'stableid=best' );

		return "<li>$link $stxt ($list) [$best]</li>";
	}
	
	/**
	* Get a selector of review levels
	* @param int $selected, selected level
	*/
	public static function getLevelMenu( $selected=null ) {
		$form = Xml::openElement( 'select', array('name' => 'level') );
		$form .= Xml::option( wfMsg( "reviewedpages-lev-0" ), 0, $selected==0 );
		if( FlaggedRevs::qualityVersions() )
			$form .= Xml::option( wfMsg( "reviewedpages-lev-1" ), 1, $selected==1 );
		if( FlaggedRevs::pristineVersions() )
			$form .= Xml::option( wfMsg( "reviewedpages-lev-2" ), 2, $selected==2 );
		$form .= Xml::closeElement('select')."\n";
		return $form;
	}
}

/**
 * Query to list out reviewed pages
 */
class ReviewedPagesPager extends AlphabeticPager {
	public $mForm, $mConds, $namespace, $type;

	function __construct( $form, $conds = array(), $type=0, $namespace=0 ) {
		$this->mForm = $form;
		$this->mConds = $conds;
		$this->type = $type;
		# Must be a content page...
		global $wgFlaggedRevsNamespaces;
		if( !is_null($namespace) ) {
			$namespace = intval($namespace);
		}
		if( is_null($namespace) || !in_array($namespace,$wgFlaggedRevsNamespaces) ) {
			$namespace = empty($wgFlaggedRevsNamespaces) ? -1 : $wgFlaggedRevsNamespaces[0]; 	 
		}
		$this->namespace = $namespace;

		parent::__construct();
	}

	function formatRow( $row ) {
		return $this->mForm->formatRow( $row );
	}

	function getQueryInfo() {
		$conds = $this->mConds;
		$conds[] = 'page_id = fp_page_id';
		$conds['fp_quality'] = $this->type;
		$conds['page_namespace'] = $this->namespace;
		return array(
			'tables' => array('flaggedpages','page'),
			'fields' => 'page_namespace,page_title,page_len,fp_page_id',
			'conds'  => $conds,
			'options' => array( 'USE INDEX' => array('flaggedpages' => 'fp_quality_page') )
		);
	}

	function getIndexField() {
		return 'fp_page_id';
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
