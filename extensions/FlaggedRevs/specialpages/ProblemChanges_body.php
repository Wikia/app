<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "FlaggedRevs extension\n";
	exit( 1 );
}

class ProblemChanges extends SpecialPage
{
	public function __construct() {
		parent::__construct( 'ProblemChanges' );
		$this->includable( true );
	}

	public function execute( $par ) {
		global $wgRequest, $wgUser, $wgOut;
		$this->setHeaders();
		$this->skin = $wgUser->getSkin();
		$this->level = $wgRequest->getInt( 'level', - 1 );
		$this->tag = trim( $wgRequest->getVal( 'tagfilter' ) );
		$this->category = trim( $wgRequest->getVal( 'category' ) );
		$catTitle = Title::newFromText( $this->category );
		$this->category = is_null( $catTitle ) ? '' : $catTitle->getText();
		$feedType = $wgRequest->getVal( 'feed' );
		if ( $feedType ) {
			return $this->feed( $feedType );
		}
		$this->setSyndicated();
		$this->showList( $par );
	}
	
	protected function setSyndicated() {
		global $wgOut, $wgRequest;
		$queryParams = array(
			'level'     => $wgRequest->getIntOrNull( 'level' ),
			'tag'       => $wgRequest->getVal( 'tag' ),
			'category'  => $wgRequest->getVal( 'category' ),
		);
		$wgOut->setSyndicated( true );
		$wgOut->setFeedAppendQuery( wfArrayToCGI( $queryParams ) );
	}

	public function showList( $par ) {
		global $wgOut, $wgScript, $wgUser;
		$limit = $this->parseParams( $par );
		$pager = new ProblemChangesPager( $this, $this->level, $this->category, $this->tag );
		// Apply limit if transcluded
		$pager->mLimit = $limit ? $limit : $pager->mLimit;
		// Viewing the page normally...
		if ( !$this->including() ) {
			$action = htmlspecialchars( $wgScript );
			$tagForm = ChangeTags::buildTagFilterSelector( $this->tag );
			$wgOut->addHTML(
				"<form action=\"$action\" method=\"get\">\n" .
				'<fieldset><legend>' . wfMsg( 'problemchanges-legend' ) . '</legend>' .
				Xml::hidden( 'title', $this->getTitle()->getPrefixedDBKey() )
			);
			$form =
				( FlaggedRevs::qualityVersions()
					? "<span style='white-space: nowrap;'>" .
						FlaggedRevsXML::getLevelMenu( $this->level, 'revreview-filter-stable' ) .
						'</span> '
					: ""
				);
			if ( count( $tagForm ) ) {
				$form .= Xml::tags( 'td', array( 'class' => 'mw-label' ), $tagForm[0] );
				$form .= Xml::tags( 'td', array( 'class' => 'mw-input' ), $tagForm[1] );
			}
			$form .= '<br />' .
				Xml::label( wfMsg( "problemchanges-category" ), 'wpCategory' ) . '&nbsp;' .
				Xml::input( 'category', 30, $this->category,
					array( 'id' => 'wpCategory' ) ) . ' ';
			$form .= Xml::submitButton( wfMsg( 'allpagessubmit' ) ) . "\n" .
				"</fieldset></form>";
			# Add filter options
			$wgOut->addHTML( $form );
			# Add list output
			if ( $pager->getNumRows() ) {
				$wgOut->addHTML( $pager->getNavigationBar() );
				$wgOut->addHTML( $pager->getBody() );
				$wgOut->addHTML( $pager->getNavigationBar() );
			} else {
				$wgOut->addHTML( wfMsgExt( 'problemchanges-none', array( 'parse' ) ) );
			}
		// If this page is transcluded...
		} else {
			if ( $pager->getNumRows() ) {
				$wgOut->addHTML( $pager->getBody() );
			} else {
				$wgOut->addHTML( wfMsgExt( 'problemchanges-none', array( 'parse' ) ) );
			}
		}
	}
	
	protected function parseParams( $par ) {
		global $wgLang;
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
		global $wgFeed, $wgFeedClasses, $wgRequest;
		if ( !$wgFeed ) {
			global $wgOut;
			$wgOut->addWikiMsg( 'feed-unavailable' );
			return;
		}
		if ( !isset( $wgFeedClasses[$type] ) ) {
			global $wgOut;
			$wgOut->addWikiMsg( 'feed-invalid' );
			return;
		}
		$feed = new $wgFeedClasses[$type](
			$this->feedTitle(),
			wfMsg( 'tagline' ),
			$this->getTitle()->getFullUrl() );

		$pager = new ProblemChangesPager( $this, $this->category );
		$limit = $wgRequest->getInt( 'limit', 50 );
		global $wgFeedLimit;
		$pager->mLimit = min( $wgFeedLimit, $limit );

		$feed->outHeader();
		if ( $pager->getNumRows() > 0 ) {
			while ( $row = $pager->mResult->fetchObject() ) {
				$feed->outItem( $this->feedItem( $row ) );
			}
		}
		$feed->outFooter();
	}
	
	protected function feedTitle() {
		global $wgContLanguageCode, $wgSitename;
		$page = SpecialPage::getPage( 'problemchanges' );
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
		global $wgLang, $wgUser, $wgMemc;

		$css = $stxt = $quality = $underReview = '';
		$title = Title::makeTitle( $row->page_namespace, $row->page_title );
		$link = $this->skin->makeKnownLinkObj( $title );
		$review = $this->skin->makeKnownLinkObj( $title,
			wfMsg( 'oldreviewed-diff' ),
			'diff=cur&oldid='.intval($row->stable).'&diffonly=0' );
		# Show quality level if there are several
		if ( FlaggedRevs::qualityVersions() ) {
			$quality = $row->quality ?
				wfMsgHtml( 'revreview-lev-quality' ) : wfMsgHtml( 'revreview-lev-basic' );
			$quality = " <b>[{$quality}]</b>";
		}
		# Is anybody watching?
		if ( !$this->including() && $wgUser->isAllowed( 'unreviewedpages' ) ) {
			$uw = UnreviewedPages::usersWatching( $title );
			$watching = $uw
				? wfMsgExt( 'oldreviewedpages-watched', 'parsemag', $uw )
				: wfMsgHtml( 'oldreviewedpages-unwatched' );
			$watching = " {$watching}";
		} else {
			$uw = - 1;
			$watching = ''; // leave out data
		}
		# Get how long the first unreviewed edit has been waiting...
		if ( $row->pending_since ) {
			static $currentTime;
			$currentTime = wfTimestamp( TS_UNIX ); // now
			$firstPendingTime = wfTimestamp( TS_UNIX, $row->pending_since );
			$hours = ( $currentTime - $firstPendingTime ) / 3600;
			// After three days, just use days
			if ( $hours > ( 3 * 24 ) ) {
				$days = round( $hours / 24, 0 );
				$age = wfMsgExt( 'oldreviewedpages-days', array( 'parsemag' ), $days );
			// If one or more hours, use hours
			} elseif ( $hours >= 1 ) {
				$hours = round( $hours, 0 );
				$age = wfMsgExt( 'oldreviewedpages-hours', array( 'parsemag' ), $hours );
			} else {
				$age = wfMsg( 'oldreviewedpages-recent' ); // hot off the press :)
			}
			// Oh-noes!
			$css = self::getLineClass( $hours, $uw );
			$css = $css ? " class='$css'" : "";
		} else {
			$age = ""; // wtf?
		}
		$key = wfMemcKey( 'stableDiffs', 'underReview', $row->stable, $row->page_latest );
		# Show if a user is looking at this page
		if ( ( $val = $wgMemc->get( $key ) ) ) {
			$underReview = " <b class='fr-under-review'>" .
				wfMsgHtml( 'oldreviewedpages-viewing' ) . '</b>';
		}

		return( "<li{$css}>{$link} {$stxt} ({$review}) <i>{$age}</i>" .
			"{$quality}{$watching}{$underReview}</li>" );
	}
	
	/**
	 * Get the timestamp of the next revision
	 *
	 * @param integer $revision  Revision ID. Get the revision that was after this one.
	 * @param integer $page, page ID
	 */
	protected function getNextRevisionTimestamp( $revision, $page ) {
		$dbr = wfGetDB( DB_SLAVE );
		
		return $dbr->selectField( 'revision', 'rev_timestamp',
			array(
				'rev_page' => $page,
				'rev_id > ' . intval( $revision )
			),
			__METHOD__,
			array( 'ORDER BY' => 'rev_id' )
		);
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
	public $mForm, $mConds;
	private $category, $namespace, $tag;

	function __construct( $form, $level = - 1, $category = '', $tag = '' )
	{
		$this->mForm = $form;
		# Must be a content page...
		$this->namespace = FlaggedRevs::getReviewNamespaces();
		# Sanity check level: 0 = sighted; 1 = quality; 2 = pristine
		$this->level = ( $level >= 0 && $level <= 2 ) ? $level : - 1;
		$this->tag = $tag;
		$this->category = $category ? str_replace( ' ', '_', $category ) : null;
		parent::__construct();
		// Don't get to expensive
		$this->mLimitsShown = array( 20, 50, 100 );
		$this->mLimit = min( $this->mLimit, 100 );
	}

	function formatRow( $row ) {
		return $this->mForm->formatRow( $row );
	}
	
	function getDefaultDirections() {
		return false;
	}

	function getQueryInfo() {
		global $wgUser, $wgOldChangeTagsIndex;
		$conds = $this->mConds;
		$tables = array( 'revision', 'change_tag', 'page' );
		$fields = array( 'page_namespace' , 'page_title', 'page_latest' );
		$ctIndex = $wgOldChangeTagsIndex ? 'ct_rev_id' : 'change_tag_rev_tag';
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
			$useIndex = array( 'flaggedpages' => 'fp_pending_since', 'change_tag' => $ctIndex );
			# Filter by category
			if ( $this->category != '' ) {
				array_unshift( $tables, 'categorylinks' ); // order matters
				$conds[] = 'cl_from = fp_page_id';
				$conds['cl_to'] = $this->category;
				$useIndex['categorylinks'] = 'cl_from';
			}
			array_unshift( $tables, 'flaggedpages' ); // order matters
			$this->mIndexField = 'fp_pending_since';
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
			$useIndex = array( 'flaggedpage_pending' => 'fpp_quality_pending',
				'change_tag' => $ctIndex );
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
