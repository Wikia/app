<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "FlaggedRevs extension\n";
	exit( 1 );
}

class UnreviewedPages extends SpecialPage
{
	public function __construct() {
		parent::__construct( 'UnreviewedPages', 'unreviewedpages' );
	}

	public function execute( $par ) {
		global $wgRequest, $wgUser, $wgOut;
		$this->setHeaders();
		if ( !$wgUser->isAllowed( 'unreviewedpages' ) ) {
			$wgOut->permissionRequired( 'unreviewedpages' );
			return;
		}
		$this->skin = $wgUser->getSkin();
		$this->showList( $wgRequest );
	}

	protected function showList( $wgRequest ) {
		global $wgOut, $wgScript;
		$namespaces = FlaggedRevs::getReviewNamespaces();
		$defaultNS = !$namespaces ? NS_MAIN : $namespaces[0];
		
		$namespace = $wgRequest->getIntOrNull( 'namespace', $defaultNS );
		$category = trim( $wgRequest->getVal( 'category' ) );
		$catTitle = Title::makeTitleSafe( NS_CATEGORY, $category );
		$category = is_null( $catTitle ) ? '' : $catTitle->getText();
		$level = $wgRequest->getInt( 'level' );
		$hideRedirs = $wgRequest->getBool( 'hideredirs', true );
		
		// show/hide links
		$showhide = array( wfMsgHtml( 'show' ), wfMsgHtml( 'hide' ) );
		$onoff = 1 - $hideRedirs;
		$link = $this->skin->link( $this->getTitle(), $showhide[$onoff], array(),
			 array( 'hideredirs' => $onoff, 'category' => $category, 'namespace' => $namespace )
		);
		$showhideredirs = wfMsgHtml( 'whatlinkshere-hideredirs', $link );

		$action = htmlspecialchars( $wgScript );
		$wgOut->addHTML( "<form action=\"$action\" method=\"get\">\n" .
			'<fieldset><legend>' . wfMsg( 'unreviewed-legend' ) . '</legend>' .
			Xml::hidden( 'title', $this->getTitle()->getPrefixedDBKey() ) . '<p>' );
		# Add dropdowns as needed
		if ( count( $namespaces ) > 1 ) {
			$wgOut->addHTML( FlaggedRevsXML::getNamespaceMenu( $namespace ) . '&nbsp;' );
		}
		if ( FlaggedRevs::qualityVersions() ) {
			$wgOut->addHTML( FlaggedRevsXML::getLevelMenu( $level, false, 1 ) . '&nbsp;' );
		}
		$wgOut->addHTML(
			"<span style='white-space: nowrap;'>" .
			Xml::label( wfMsg( "unreviewed-category" ), 'category' ) . '&nbsp;' .
			Xml::input( 'category', 30, $category, array( 'id' => 'category' ) ) .
			'</span><br />' .
			$showhideredirs . '&nbsp;&nbsp;' .
			Xml::submitButton( wfMsg( 'allpagessubmit' ) ) . "</p>\n" .
			"</fieldset></form>"
		);
		# This will start to get slower if live...
		if ( !$live = self::generalQueryOK() ) {
			$dbr = wfGetDB( DB_SLAVE );
			$ts = $dbr->selectField( 'querycache_info', 'qci_timestamp',
				array( 'qci_type' => 'fr_unreviewedpages' ), __METHOD__ );
			if ( $ts ) {
				global $wgLang;
				$ts = wfTimestamp( TS_MW, $ts );
				$td = $wgLang->timeanddate( $ts );
				$d = $wgLang->date( $ts );
				$t = $wgLang->time( $ts );
				$wgOut->addHTML( wfMsg( 'perfcachedts', $td, $d, $t ) );
			} else {
				$wgOut->addHTML( wfMsg( 'perfcached' ) );
			}
		}
		$pager = new UnreviewedPagesPager( $this, $live, $namespace,
			!$hideRedirs, $category, $level );
		if ( $pager->getNumRows() ) {
			$wgOut->addHTML( wfMsgExt( 'unreviewed-list', array( 'parse' ) ) );
			$wgOut->addHTML( $pager->getNavigationBar() );
			$wgOut->addHTML( $pager->getBody() );
			$wgOut->addHTML( $pager->getNavigationBar() );
		} else {
			$wgOut->addHTML( wfMsgExt( 'unreviewed-none', array( 'parse' ) ) );
		}
	}
	
	public function formatRow( $row ) {
		global $wgLang, $wgUser, $wgMemc;

		$stxt = $underReview = $watching = '';
		$title = Title::newFromRow( $row );
		$link = $this->skin->makeKnownLinkObj( $title, null, 'redirect=no&reviewing=1' );
		$hist = $this->skin->makeKnownLinkObj( $title, wfMsgHtml( 'hist' ),
			'action=history&reviewing=1' );
		if ( !is_null( $size = $row->page_len ) ) {
			$stxt = ( $size == 0 )
				? wfMsgHtml( 'historyempty' )
				: wfMsgExt( 'historysize', array( 'parsemag' ), $wgLang->formatNum( $size ) );
			$stxt = " <small>$stxt</small>";
		}
		# Get how long the first unreviewed edit has been waiting...
		static $currentTime;
		$currentTime = wfTimestamp( TS_UNIX ); // now
		$firstPendingTime = wfTimestamp( TS_UNIX, $row->creation );
		$hours = ( $currentTime - $firstPendingTime ) / 3600;
		// After three days, just use days
		if ( $hours > ( 3 * 24 ) ) {
			$days = round( $hours / 24, 0 );
			$age = ' ' . wfMsgExt( 'unreviewed-days', array( 'parsemag' ), $days );
		// If one or more hours, use hours
		} elseif ( $hours >= 1 ) {
			$hours = round( $hours, 0 );
			$age = ' ' . wfMsgExt( 'unreviewed-hours', array( 'parsemag' ), $hours );
		} else {
			$age = ' ' . wfMsg( 'unreviewed-recent' ); // hot off the press :)
		}
		if ( $wgUser->isAllowed( 'unwatchedpages' ) ) {
			$uw = self::usersWatching( $title );
			$watching = $uw
				? wfMsgExt( 'unreviewed-watched', array( 'parsemag' ), $uw )
				: wfMsgHtml( 'unreviewed-unwatched' );
			$watching = " $watching"; // Oh-noes!
		} else {
			$uw = - 1;
		}
		$css = self::getLineClass( $hours, $uw );
		$css = $css ? " class='$css'" : "";
		$pageId = isset( $row->page_id ) ? $row->page_id : $row->qc_value;
		$key = wfMemcKey( 'unreviewedPages', 'underReview', $pageId );
		$val = $wgMemc->get( $key );
		# Show if a user is looking at this page
		if ( $val ) {
			$underReview = " <b class='fr-under-review'>" .
				wfMsgHtml( 'unreviewed-viewing' ) . '</b>';
		}

		return( "<li{$css}>{$link} {$stxt} ({$hist})" .
			"{$age}{$watching}{$underReview}</li>" );
	}
	
	/**
	 * Get number of users watching a page. Max is 5.
	 * @param Title $title
	 */
	public static function usersWatching( $title ) {
		global $wgMiserMode;
		$dbr = wfGetDB( DB_SLAVE );
		$count = - 1;
		if ( $wgMiserMode ) {
			# Get a rough idea of size
			$count = $dbr->estimateRowCount( 'watchlist', '*',
				array( 'wl_namespace' => $title->getNamespace(),
					'wl_title' => $title->getDBkey() ),
				__METHOD__ );
		}
		# If it is small, just COUNT() it, otherwise, stick with estimate...
		if ( $count == - 1 || $count <= 100 ) {
			global $wgCookieExpiration;
			# Get number of active editors watchling this
			$cutoff = $dbr->timestamp( wfTimestamp( TS_UNIX ) - 2 * $wgCookieExpiration );
			$res = $dbr->select( array( 'watchlist', 'user' ), '1',
				array( 'wl_namespace' => $title->getNamespace(),
					'wl_title' => $title->getDBkey(),
					'wl_user = user_id',
					// logged in or out
					'user_touched > ' . $dbr->addQuotes( $cutoff ) ),
				__METHOD__,
				array( 'USE INDEX' => array( 'watchlist' => 'namespace_title' ) )
			);
			$count = $dbr->numRows( $res );
		}
		return $count;
	}
	
	protected static function getLineClass( $hours, $uw ) {
		if ( $uw == 0 )
			return 'fr-unreviewed-unwatched';
		else if ( $hours > 20 * 24 )
			return 'fr-pending-long2';
		else if ( $hours > 7 * 24 )
			return 'fr-pending-long';
		else
			return "";
	}
	
	/**
	 * There may be many pages, most of which are reviewed
	 */
	public static function generalQueryOK() {
		$namespaces = FlaggedRevs::getReviewNamespaces();
		if ( !$namespaces || !wfQueriesMustScale() ) {
			return true;
		}
		# Get est. of fraction of pages that are reviewed
		$dbr = wfGetDB( DB_SLAVE );
		$reviewedpages = $dbr->estimateRowCount( 'flaggedpages', '*', array(), __METHOD__ );
		$pages = $dbr->estimateRowCount( 'page', '*',
			array( 'page_namespace' => $namespaces ),
			__METHOD__
		);
		$ratio = $pages / ( $pages - $reviewedpages );
		# If dist. is equal, # of rows scanned = $ratio * LIMIT (or until list runs out)
		return ( $ratio <= 400 );
	}
}

/**
 * Query to list out unreviewed pages
 */
class UnreviewedPagesPager extends AlphabeticPager {
	public $mForm, $mConds;
	private $live, $namespace, $category, $showredirs;

	function __construct(
		$form, $live, $namespace, $redirs = false, $category = null, $level = 0
	) {
		$this->mForm = $form;
		$this->live = (bool)$live;
		# Must be a content page...

		if ( !is_null( $namespace ) ) {
			$namespace = intval( $namespace );
		}
		$vnamespaces = FlaggedRevs::getReviewNamespaces();
		if ( is_null( $namespace ) || !in_array( $namespace, $vnamespaces ) ) {
			$namespace = !$vnamespaces ? - 1 : $vnamespaces[0];
		}
		$this->namespace = $namespace;
		$this->category = $category ? str_replace( ' ', '_', $category ) : null;
		$this->level = intval( $level );
		$this->showredirs = (bool)$redirs;
		parent::__construct();
		// Don't get to expensive
		$this->mLimitsShown = array( 20, 50 );
		$this->mLimit = min( $this->mLimit, 50 );
	}

	function formatRow( $row ) {
		return $this->mForm->formatRow( $row );
	}

	function getQueryInfo() {
		if ( !$this->live ) {
			return $this->getQueryCacheInfo();
		}
		$conds = $this->mConds;
		$fields = array( 'page_namespace', 'page_title', 'page_len', 'page_id',
			'MIN(rev_timestamp) AS creation' );
		# Filter by level
		if ( $this->level == 1 ) {
			$conds[] = "fp_page_id IS NULL OR fp_quality = 0";
		} else {
			$conds[] = 'fp_page_id IS NULL';
		}
		# Reviewable pages only
		$conds['page_namespace'] = $this->namespace;
		# No redirects
		if ( !$this->showredirs ) {
			$conds['page_is_redirect'] = 0;
		}
		# Filter by category
		if ( $this->category ) {
			$tables = array( 'categorylinks', 'page', 'flaggedpages', 'revision' );
			$fields[] = 'cl_sortkey';
			$conds['cl_to'] = $this->category;
			$conds[] = 'cl_from = page_id';
			$this->mIndexField = 'cl_sortkey';
			$useIndex = array( 'categorylinks' => 'cl_sortkey' );
			$groupBy = 'cl_sortkey,cl_from';
		} else {
			$tables = array( 'page', 'flaggedpages', 'revision' );
			$this->mIndexField = 'page_title';
			$useIndex = array( 'page' => 'name_title' );
			$groupBy = 'page_title';
		}
		$useIndex['revision'] = 'page_timestamp'; // sigh...
		return array(
			'tables'  => $tables,
			'fields'  => $fields,
			'conds'   => $conds,
			'options' => array( 'USE INDEX' => $useIndex, 'GROUP BY' => $groupBy ),
			'join_conds' => array(
				'revision'     => array( 'LEFT JOIN', 'rev_page=page_id' ), // Get creation date
				'flaggedpages' => array( 'LEFT JOIN', 'fp_page_id=page_id' )
			)
		);
	}
	
	function getQueryCacheInfo() {
		$conds = $this->mConds;
		$fields = array( 'page_namespace', 'page_title', 'page_len', 'qc_value',
			'MIN(rev_timestamp) AS creation' );
		# Re-join on flaggedpages to double-check since things
		# could have changed since the cache date. Also, use
		# the proper cache for this level.
		if ( $this->level == 1 ) {
			$conds['qc_type'] = 'fr_unreviewedpages_q';
			$conds[] = "fp_page_id IS NULL OR fp_quality < {$this->level}";
		} else {
			$conds['qc_type'] = 'fr_unreviewedpages';
			$conds[] = 'fp_page_id IS NULL';
		}
		# Reviewable pages only
		$conds['qc_namespace'] = $this->namespace;
		# No redirects
		if ( !$this->showredirs ) {
			$conds['page_is_redirect'] = 0;
		}
		$this->mIndexField = 'qc_value'; // page_id
		# Filter by category
		if ( $this->category ) {
			$tables = array( 'page', 'categorylinks', 'querycache', 'flaggedpages', 'revision' );
			$conds['cl_to'] = $this->category;
			$conds[] = 'cl_from = qc_value'; // page_id
		} else {
			$tables = array( 'page', 'querycache', 'flaggedpages', 'revision' );
		}
		$useIndex = array( 'querycache' => 'qc_type', 'page' => 'PRIMARY',
			'revision' => 'page_timestamp' ); // sigh...
		return array(
			'tables'  => $tables,
			'fields'  => $fields,
			'conds'   => $conds,
			'options' => array( 'USE INDEX' => $useIndex, 'GROUP BY' => 'qc_value' ),
			'join_conds' => array(
				'querycache'    => array( 'LEFT JOIN', 'qc_value=page_id' ),
				'revision'      => array( 'LEFT JOIN', 'rev_page=page_id' ), // Get creation date
				'flaggedpages'  => array( 'LEFT JOIN', 'fp_page_id=page_id' ),
				'categorylinks' => array( 'LEFT JOIN',
					array( 'cl_from=page_id', 'cl_to' => $this->category ) )
			)
		);
	}

	function getIndexField() {
		return $this->mIndexField;
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
