<?php

class ProblemChanges extends SpecialPage {
	protected $pager = null;

	public function __construct() {
		parent::__construct( 'ProblemChanges' );
		$this->mIncludable = true;
	}

	public function execute( $par ) {
		$request = $this->getRequest();

		$this->setHeaders();
		$this->currentUnixTS = wfTimestamp( TS_UNIX ); // now

		$this->level = $request->getInt( 'level', - 1 );
		$this->tag = trim( $request->getVal( 'tagfilter' ) );
		$category = trim( $request->getVal( 'category' ) );
		$catTitle = Title::newFromText( $category );
		$this->category = is_null( $catTitle ) ? '' : $catTitle->getText();
		$feedType = $request->getVal( 'feed' );

		$incLimit = 0;
		if ( $this->including() ) {
			$incLimit = $this->parseParams( $par ); // apply non-URL params
		}

		$this->pager = new ProblemChangesPager(
			$this, $this->level, $this->category, $this->tag );

		# Output appropriate format...
		if ( $feedType != null ) {
			$this->feed( $feedType );
		} else {
			if ( $this->including() ) {
				$this->pager->setLimit( $incLimit ); // apply non-URL limit
			} else {
				$this->setSyndicated();
				$this->showForm();
			}
			$this->showPageList();
		}
	}
	
	protected function setSyndicated() {
		$request = $this->getRequest();
		$queryParams = array(
			'level'     => $request->getIntOrNull( 'level' ),
			'tag'       => $request->getVal( 'tag' ),
			'category'  => $request->getVal( 'category' ),
		);
		$this->getOutput()->setSyndicated( true );
		$this->getOutput()->setFeedAppendQuery( wfArrayToCGI( $queryParams ) );
	}

	public function showForm() {
		global $wgScript;

		// Add explanatory text
		$this->getOutput()->addWikiMsg( 'problemchanges-list',
			$this->getLang()->formatNum( $this->pager->getNumRows() ) );

		$form = Html::openElement( 'form', array( 'name' => 'problemchanges',
			'action' => $wgScript, 'method' => 'get' ) ) . "\n";
		$form .= "<fieldset><legend>" . wfMsg( 'problemchanges-legend' ) . "</legend>\n";
		$form .= Html::hidden( 'title', $this->getTitle()->getPrefixedDBKey() ) . "\n";
		$form .=
			( FlaggedRevs::qualityVersions()
				? "<span style='white-space: nowrap;'>" .
					FlaggedRevsXML::getLevelMenu( $this->level, 'revreview-filter-stable' ) .
					'</span> '
				: ""
			);
		$tagForm = ChangeTags::buildTagFilterSelector( $this->tag );
		if ( count( $tagForm ) ) {
			$form .= Xml::tags( 'td', array( 'class' => 'mw-label' ), $tagForm[0] );
			$form .= Xml::tags( 'td', array( 'class' => 'mw-input' ), $tagForm[1] );
		}
		$form .= '<br />' .
			Xml::label( wfMsg( "problemchanges-category" ), 'wpCategory' ) . '&#160;' .
			Xml::input( 'category', 30, $this->category, array( 'id' => 'wpCategory' ) ) . ' ';
		$form .= Xml::submitButton( wfMsg( 'allpagessubmit' ) ) . "\n";
		$form .= '</fieldset>';
		$form .= Html::closeElement( 'form' ) . "\n";

		$this->getOutput()->addHTML( $form );
	}

	public function showPageList() {
		$out = $this->getOutput();
		// Viewing the page normally...
		if ( !$this->including() ) {
			if ( $this->pager->getNumRows() ) {
				$out->addHTML( $this->pager->getNavigationBar() );
				$out->addHTML( $this->pager->getBody() );
				$out->addHTML( $this->pager->getNavigationBar() );
			} else {
				$out->addWikiMsg( 'problemchanges-none' );
			}
		// If this page is transcluded...
		} else {
			if ( $this->pager->getNumRows() ) {
				$out->addHTML( $this->pager->getBody() );
			} else {
				$out->addWikiMsg( 'problemchanges-none' );
			}
		}
	}

	// set pager parameters from $par, return pager limit
	protected function parseParams( $par ) {
		$bits = preg_split( '/\s*,\s*/', trim( $par ) );
		$limit = false;
		foreach ( $bits as $bit ) {
			if ( is_numeric( $bit ) )
				$limit = intval( $bit );
			$m = array();
			if ( preg_match( '/^limit=(\d+)$/', $bit, $m ) )
				$limit = intval( $m[1] );
			if ( preg_match( '/^category=(.+)$/', $bit, $m ) )
				$this->category = $m[1];
			if ( preg_match( '/^tagfilter=(.+)$/', $bit, $m ) )
				$this->tag = $m[1];
		}
		return $limit;
	}
	
	/**
	 * Output a subscription feed listing recent edits to this page.
	 * @param string $type
	 */
	protected function feed( $type ) {
		global $wgFeed, $wgFeedClasses, $wgFeedLimit;

		if ( !$wgFeed ) {
			$this->getOutput()->addWikiMsg( 'feed-unavailable' );
			return;
		}
		if ( !isset( $wgFeedClasses[$type] ) ) {
			$this->getOutput()->addWikiMsg( 'feed-invalid' );
			return;
		}
		$feed = new $wgFeedClasses[$type](
			$this->feedTitle(),
			wfMsg( 'tagline' ),
			$this->getTitle()->getFullUrl()
		);
		$this->pager->mLimit = min( $wgFeedLimit, $this->pager->mLimit );

		$feed->outHeader();
		if ( $this->pager->getNumRows() > 0 ) {
			foreach ( $this->pager->mResult as $row ) {
				$feed->outItem( $this->feedItem( $row ) );
			}
		}
		$feed->outFooter();
	}
	
	protected function feedTitle() {
		global $wgContLanguageCode, $wgSitename;

		$page = SpecialPage::getPage( 'ProblemChanges' );
		$desc = $page->getDescription();
		return "$wgSitename - $desc [$wgContLanguageCode]";
	}

	protected function feedItem( $row ) {
		$title = Title::MakeTitle( $row->page_namespace, $row->page_title );
		if ( $title ) {
			$date = $row->pending_since;
			$comments = $title->getTalkPage()->getFullURL();
			$curRev = Revision::newFromTitle( $title );
			return new FeedItem(
				$title->getPrefixedText(),
				FeedUtils::formatDiffRow( $title, $row->stable, $curRev->getId(),
					$row->pending_since, $curRev->getComment() ),
				$title->getFullURL(),
				$date,
				$curRev->getUserText(),
				$comments
			);
		} else {
			return null;
		}
	}
	
	public function formatRow( $row ) {
		$css = $quality = $tags = $underReview = '';
		
		$title = Title::newFromRow( $row );
		$link = Linker::link( $title );
		$review = Linker::linkKnown( $title,
			wfMsg( 'pendingchanges-diff' ),
			array(),
			array( 'diff' => 'cur', 'oldid' => $row->stable ) + FlaggedRevs::diffOnlyCGI()
		);
		# Show quality level if there are several
		if ( FlaggedRevs::qualityVersions() ) {
			$quality = $row->quality
				? wfMsgHtml( 'revreview-lev-quality' )
				: wfMsgHtml( 'revreview-lev-basic' );
			$quality = " <b>[{$quality}]</b>";
		}
		# What are the tags?
		$dbTags = self::getChangeTags( $title->getArticleID(), $row->stable );
		if ( $dbTags ) {
			$tags = htmlspecialchars( implode( ', ', $dbTags ) );
			$tags = ' <b>' . wfMsgHtml( 'parentheses', $tags ) . '</b>';
		}
		# Is anybody watching?
		if ( !$this->including() && $this->getUser()->isAllowed( 'unreviewedpages' ) ) {
			$uw = FRUserActivity::numUsersWatchingPage( $title );
			$watching = $uw
				? wfMsgExt( 'pendingchanges-watched', 'parsemag', $this->getLang()->formatNum( $uw ) )
				: wfMsgHtml( 'pendingchanges-unwatched' );
			$watching = " {$watching}";
		} else {
			$uw = - 1;
			$watching = ''; // leave out data
		}
		# Get how long the first unreviewed edit has been waiting...
		if ( $row->pending_since ) {
			$firstPendingTime = wfTimestamp( TS_UNIX, $row->pending_since );
			$hours = ( $this->currentUnixTS - $firstPendingTime ) / 3600;
			// After three days, just use days
			if ( $hours > ( 3 * 24 ) ) {
				$days = round( $hours / 24, 0 );
				$age = wfMsgExt( 'pendingchanges-days',
					'parsemag', $this->getLang()->formatNum( $days ) );
			// If one or more hours, use hours
			} elseif ( $hours >= 1 ) {
				$hours = round( $hours, 0 );
				$age = wfMsgExt( 'pendingchanges-hours',
					'parsemag', $this->getLang()->formatNum( $hours ) );
			} else {
				$age = wfMsg( 'pendingchanges-recent' ); // hot off the press :)
			}
			// Oh-noes!
			$css = self::getLineClass( $hours, $uw );
			$css = $css ? " class='$css'" : "";
		} else {
			$age = ""; // wtf?
		}
		# Show if a user is looking at this page
		list( $u, $ts ) = FRUserActivity::getUserReviewingDiff( $row->stable, $row->page_latest );
		if ( $u !== null ) {
			$underReview = ' <span class="fr-under-review">' .
				wfMsgHtml( 'pendingchanges-viewing' ) . '</span>';
		}

		return( "<li{$css}>{$link} ({$review}) <i>{$age}</i>" .
			"{$quality}{$tags}{$watching}{$underReview}</li>" );
	}
	
	/**
	 * Get the tags of the revisions of a page after a certain rev
	 * @param integer $pageId, page ID
	 * @param integer $revId, rev ID
	 * @return Array
	 */
	protected static function getChangeTags( $pageId, $revId ) {
		$tags = array();
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			array( 'revision', 'change_tag' ),
			'DISTINCT(ct_tag)', // unique tags
			array( 'rev_page' => $pageId,
				'rev_id > ' . intval( $revId ),
				'rev_id = ct_rev_id' ),
			__METHOD__
		);
		foreach( $res as $row ) {
			$tags[] = $row->ct_tag;
		}
		return $tags;
	}
	
	protected static function getLineClass( $hours, $uw ) {
		if ( $uw == 0 )
			return 'fr-unreviewed-unwatched';
		else
			return "";
	}
}

/**
 * Query to list out outdated reviewed pages
 */
class ProblemChangesPager extends AlphabeticPager {
	public $mForm;
	protected $category, $namespace, $tag;

	const PAGE_LIMIT = 100; // Don't get too expensive

	function __construct( $form, $level = - 1, $category = '', $tag = '' )
	{
		$this->mForm = $form;
		# Must be a content page...
		$this->namespace = FlaggedRevs::getReviewNamespaces();
		# Sanity check level: 0 = checked; 1 = quality; 2 = pristine
		$this->level = ( $level >= 0 && $level <= 2 ) ? $level : - 1;
		$this->tag = $tag;
		$this->category = $category ? str_replace( ' ', '_', $category ) : null;
		parent::__construct();
		// Don't get to expensive
		$this->mLimitsShown = array( 20, 50, 100 );
		$this->setLimit( $this->mLimit ); // apply max limit
	}

	function setLimit( $limit ) {
		$this->mLimit = min( $limit, self::PAGE_LIMIT );
	}

	function formatRow( $row ) {
		return $this->mForm->formatRow( $row );
	}

	function getDefaultDirections() {
		return false;
	}

	function getQueryInfo() {
		global $wgOldChangeTagsIndex;
		$tables = array( 'revision', 'change_tag', 'page' );
		$fields = array( 'page_namespace' , 'page_title', 'page_latest' );
		$ctIndex = $wgOldChangeTagsIndex ?
			'ct_rev_id' : 'change_tag_rev_tag';
		# Show outdated "stable" pages
		if ( $this->level < 0 ) {
			$fields[] = 'fp_stable AS stable';
			$fields[] = 'fp_quality AS quality';
			$fields[] = 'fp_pending_since AS pending_since';
			# Find revisions that are tagged as such
			$conds[] = 'fp_pending_since IS NOT NULL';
			$conds[] = 'rev_page = fp_page_id';
			$conds[] = 'rev_id > fp_stable';
			$conds[] = 'ct_rev_id = rev_id';
			if ( $this->tag != '' ) {
				$conds['ct_tag'] = $this->tag;
			}
			$conds[] = 'page_id = fp_page_id';
			$useIndex = array(
				'flaggedpages' => 'fp_pending_since', 'change_tag' => $ctIndex );
			# Filter by category
			if ( $this->category != '' ) {
				array_unshift( $tables, 'categorylinks' ); // order matters
				$conds[] = 'cl_from = fp_page_id';
				$conds['cl_to'] = $this->category;
				$useIndex['categorylinks'] = 'cl_from';
			}
			array_unshift( $tables, 'flaggedpages' ); // order matters
			$this->mIndexField = 'fp_pending_since';
			$this->mExtraSortFields = array( 'fp_page_id' );
			$groupBy = 'fp_pending_since,fp_page_id';
		# Show outdated pages for a specific review level
		} else {
			$fields[] = 'fpp_rev_id AS stable';
			$fields[] = 'fpp_quality AS quality';
			$fields[] = 'fpp_pending_since AS pending_since';
			$conds[] = 'fpp_pending_since IS NOT NULL';
			$conds[] = 'page_id = fpp_page_id';
			# Find revisions that are tagged as such
			$conds[] = 'rev_page = page_id';
			$conds[] = 'rev_id > fpp_rev_id';
			$conds[] = 'rev_id = ct_rev_id';
			$conds['ct_tag'] = $this->tag;
			$useIndex = array(
				'flaggedpage_pending' => 'fpp_quality_pending', 'change_tag' => $ctIndex );
			# Filter by review level
			$conds['fpp_quality'] = $this->level;
			# Filter by category
			if ( $this->category ) {
				array_unshift( $tables, 'categorylinks' ); // order matters
				$conds[] = 'cl_from = fpp_page_id';
				$conds['cl_to'] = $this->category;
				$useIndex['categorylinks'] = 'cl_from';
			}
			array_unshift( $tables, 'flaggedpage_pending' ); // order matters
			$this->mIndexField = 'fpp_pending_since';
			$this->mExtraSortFields = array( 'fpp_page_id' );
			$groupBy = 'fpp_pending_since,fpp_page_id';
		}
		$fields[] = $this->mIndexField; // Pager needs this
		$conds['page_namespace'] = $this->namespace; // sanity check NS
		return array(
			'tables'  => $tables,
			'fields'  => $fields,
			'conds'   => $conds,
			'options' => array( 'USE INDEX' => $useIndex,
				'GROUP BY' => $groupBy, 'STRAIGHT_JOIN' )
		);
	}

	function getIndexField() {
		return $this->mIndexField;
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
