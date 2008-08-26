<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "FlaggedRevs extension\n";
	exit( 1 );
}
wfLoadExtensionMessages( 'UnreviewedPages' );
wfLoadExtensionMessages( 'FlaggedRevs' );

class UnreviewedPages extends SpecialPage
{
    function __construct() {
        SpecialPage::SpecialPage( 'UnreviewedPages', 'unreviewedpages' );
    }

    function execute( $par ) {
        global $wgRequest, $wgUser, $wgOut;
		$this->setHeaders();
		if( !$wgUser->isAllowed( 'unreviewedpages' ) ) {
			$wgOut->permissionRequired( 'unreviewedpages' );
			return;
		}
		$this->skin = $wgUser->getSkin();
		$this->showList( $wgRequest );
	}

	function showList( $wgRequest ) {
		global $wgOut, $wgScript, $wgTitle, $wgFlaggedRevsNamespaces;
		# If no NS given, then just use the first of $wgFlaggedRevsNamespaces
		$defaultNS = empty($wgFlaggedRevsNamespaces) ? 0 : $wgFlaggedRevsNamespaces[0];
		$namespace = $wgRequest->getIntOrNull( 'namespace', $defaultNS );
		$category = trim( $wgRequest->getVal( 'category' ) );

		$action = htmlspecialchars( $wgScript );
		$wgOut->addHTML( "<form action=\"$action\" method=\"get\">\n" .
			'<fieldset><legend>' . wfMsg('unreviewed-legend') . '</legend>' .
			Xml::hidden( 'title', $wgTitle->getPrefixedDBKey() ) . '<p>' );
		if( count($wgFlaggedRevsNamespaces) > 1 ) {
			$wgOut->addHTML( FlaggedRevsXML::getNamespaceMenu( $namespace ) . '&nbsp;' );
		}
		$wgOut->addHTML( Xml::label( wfMsg("unreviewed-category"), 'category' ) .
			' ' . Xml::input( 'category', 35, $category, array('id' => 'category') ) .
			'&nbsp;&nbsp;' . Xml::submitButton( wfMsg( 'allpagessubmit' ) ) . "</p>\n" .
			"</fieldset></form>"
		);
		# This will start to get slower...
		if( $category || self::generalQueryOK() ) {
			$pager = new UnreviewedPagesPager( $this, $namespace, $category );
			if( $pager->getNumRows() ) {
				$wgOut->addHTML( wfMsgExt('unreviewed-list', array('parse') ) );
				$wgOut->addHTML( $pager->getNavigationBar() );
				$wgOut->addHTML( $pager->getBody() );
				$wgOut->addHTML( $pager->getNavigationBar() );
			} else {
				$wgOut->addHTML( wfMsgExt('unreviewed-none', array('parse') ) );
			}
		}
	}
	
	function formatRow( $result ) {
		global $wgLang, $wgUser;

		$title = Title::makeTitle( $result->page_namespace, $result->page_title );
		$link = $this->skin->makeKnownLinkObj( $title );
		$hist = $this->skin->makeKnownLinkObj( $title, wfMsgHtml('hist'), 'action=history' );
		$css = $stxt = $review = '';
		if( !is_null($size = $result->page_len) ) {
			global $wgLang;
			$stxt = ($size == 0) ? 
				wfMsgHtml('historyempty') : wfMsgExt('historysize', array('parsemag'), $wgLang->formatNum( $size ) );
			$stxt = " <small>$stxt</small>";
		}
		if( $wgUser->isAllowed('unwatchedpages') ) {
			$uw = self::usersWatching( $title );
			$watching = $uw ? wfMsgExt("unreviewed-watched",array('parsemag'),$uw,$uw) : wfMsgHtml("unreviewed-unwatched");
			$watching = " $watching";
			// Oh-noes!
			$css = $uw ? "" : " class='fr-unreviewed-unwatched'";
		} else {
			$watching = "";
		}

		return( "<li{$css}>{$link} {$stxt} ({$hist}) {$review}{$watching}</li>" );
	}
	
	/**
	* Get number of users watching a page. Max is 5.
	* @param Title $title
	*/
	public static function usersWatching( $title ) {
		global $wgMiserMode;
		$dbr = wfGetDB( DB_SLAVE );
		if( $wgMiserMode ) {
			# Get a rough idea of size
			$count = $dbr->estimateRowCount( 'watchlist', '*',
				array( 'wl_namespace' => $title->getNamespace(), 'wl_title' => $title->getDBKey() ),
				__METHOD__ );
			# If it is small, just COUNT() it, otherwise, stick with estimate...
			if( $count <= 10 ) {
				$count = $dbr->selectField( 'watchlist', 'COUNT(*)',
					array( 'wl_namespace' => $title->getNamespace(), 'wl_title' => $title->getDBKey() ),
					__METHOD__ );
			}
		} else {
			$count = $dbr->selectField( 'watchlist', 'COUNT(*)',
				array( 'wl_namespace' => $title->getNamespace(), 'wl_title' => $title->getDBKey() ),
				__METHOD__ );
		}
		return $count;
	}
	
	/**
	* There may be many pages, most of which are reviewed
	*/
	public static function generalQueryOK() {
		global $wgFlaggedRevsNamespaces;
		if( !wfQueriesMustScale() )
			return true;
		# Get est. of fraction of pages that are reviewed
		$dbr = wfGetDB( DB_SLAVE );
		$reviewedpages = $dbr->estimateRowCount( 'flaggedpages', '*', array(), __METHOD__ );
		$pages = $dbr->estimateRowCount( 'page', '*', array('page_namespace' => $wgFlaggedRevsNamespaces), __METHOD__ );
		$ratio = $pages/($pages - $reviewedpages);
		# If dist. is normalized, # of rows scanned = $ratio * LIMIT (or until list runs out)
		return ($ratio <= 200);
	}
}

/**
 * Query to list out unreviewed pages
 */
class UnreviewedPagesPager extends AlphabeticPager {
	public $mForm, $mConds;
	private $namespace, $category;

	function __construct( $form, $namespace, $category=NULL, $conds = array() ) {
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
		$this->category = $category ? str_replace(' ','_',$category) : NULL;
		
		parent::__construct();
	}

	function formatRow( $row ) {
		return $this->mForm->formatRow( $row );
	}

	function getQueryInfo() {
		$conds = $this->mConds;
		$fields = array('page_namespace','page_title','page_len','fp_stable');
		$conds[] = 'fp_reviewed IS NULL';
		# Reviewable pages only
		$conds['page_namespace'] = $this->namespace;
		# No redirects
		$conds['page_is_redirect'] = 0;
		# Filter by category
		if( $this->category ) {
			$tables = array( 'categorylinks', 'page', 'flaggedpages' );
			$fields[] = 'cl_sortkey';
			$conds['cl_to'] = $this->category;
			$conds[] = 'cl_from = page_id';
			$this->mIndexField = 'cl_sortkey';
			$useIndex = array( 'categorylinks' => 'cl_sortkey' );
		} else {
			$tables = array( 'page', 'flaggedpages' );
			$fields[] = 'page_id';
			$this->mIndexField = 'page_title';
			$useIndex = array( 'page' => 'name_title' );
		}
		return array(
			'tables'  => $tables,
			'fields'  => $fields,
			'conds'   => $conds,
			'options' => array( 'USE INDEX' => $useIndex ),
			'join_conds' => array( 'flaggedpages' => array('LEFT JOIN','fp_page_id=page_id') )
		);
	}

	function getIndexField() {
		return $this->mIndexField;
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
