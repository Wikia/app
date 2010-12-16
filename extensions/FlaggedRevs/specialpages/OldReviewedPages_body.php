<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "FlaggedRevs extension\n";
	exit( 1 );
}

class OldReviewedPages extends SpecialPage
{
	public function __construct() {
		parent::__construct( 'OldReviewedPages' );
		$this->includable( true );
	}

	public function execute( $par ) {
		global $wgRequest, $wgUser, $wgOut;
		$this->setHeaders();
		$this->skin = $wgUser->getSkin();
		$this->namespace = $wgRequest->getIntOrNull( 'namespace' );
		$this->level = $wgRequest->getInt( 'level', - 1 );
		$this->category = trim( $wgRequest->getVal( 'category' ) );
		$catTitle = Title::makeTitleSafe( NS_CATEGORY, $this->category );
		$this->category = is_null( $catTitle ) ? '' : $catTitle->getText();
		$this->size = $wgRequest->getIntOrNull( 'size' );
		$this->watched = $wgRequest->getCheck( 'watched' );
		$this->stable = $wgRequest->getCheck( 'stable' );
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
			'namespace' => $wgRequest->getIntOrNull( 'namespace' ),
			'level'     => $wgRequest->getIntOrNull( 'level' ),
			'category'  => $wgRequest->getVal( 'category' ),
		);
		$wgOut->setSyndicated( true );
		$wgOut->setFeedAppendQuery( wfArrayToCGI( $queryParams ) );
	}

	public function showList( $par ) {
		global $wgOut, $wgScript, $wgUser;
		$namespaces = FlaggedRevs::getReviewNamespaces();
		
		$limit = $this->parseParams( $par );
		$pager = new OldReviewedPagesPager( $this, $this->namespace, $this->level,
			$this->category, $this->size, $this->watched, $this->stable );
		// Apply limit if transcluded
		$pager->mLimit = $limit ? $limit : $pager->mLimit;
		// Viewing the page normally...
		if ( !$this->including() ) {
			$action = htmlspecialchars( $wgScript );
			$wgOut->addHTML(
				"<form action=\"$action\" method=\"get\">\n" .
				'<fieldset><legend>' . wfMsg( 'oldreviewedpages-legend' ) . '</legend>' .
				Xml::hidden( 'title', $this->getTitle()->getPrefixedDBKey() )
			);
			$form =
				( count( $namespaces ) > 1 ?
					"<span style='white-space: nowrap;'>" .
					FlaggedRevsXML::getNamespaceMenu( $this->namespace, '' ) . '</span> '
					: ""
				) .
				( FlaggedRevs::qualityVersions()
					? "<span style='white-space: nowrap;'>" .
						FlaggedRevsXML::getLevelMenu( $this->level, 'revreview-filter-stable' ) .
						'</span> '
					: ""
				) .
				( ( !FlaggedRevs::isStableShownByDefault()
					&& !FlaggedRevs::forDefaultVersionOnly() )
					? "<span style='white-space: nowrap;'>" .
						Xml::check( 'stable', $this->stable, array( 'id' => 'wpStable' ) ) .
						Xml::label( wfMsg( 'oldreviewed-stable' ), 'wpStable' ) . '</span> '
					: ""
				);
			if ( $form ) $form .= '<br />';
			$form .=
				Xml::label( wfMsg( "oldreviewed-category" ), 'wpCategory' ) . '&nbsp;' .
				Xml::input( 'category', 30, $this->category,
					array( 'id' => 'wpCategory' ) ) . ' ' .
				( $wgUser->getId() ?
					Xml::check( 'watched', $this->watched, array( 'id' => 'wpWatched' ) ) .
					Xml::label( wfMsg( 'oldreviewed-watched' ), 'wpWatched' ) . ' '
					: ""
				);
			$form .= '<br />' .
				Xml::label( wfMsg( 'oldreviewed-size' ), 'wpSize' ) .
				Xml::input( 'size', 4, $this->size, array( 'id' => 'wpSize' ) ) . ' ' .
				Xml::submitButton( wfMsg( 'allpagessubmit' ) ) . "\n" .
				"</fieldset></form>";
			# Add filter options
			$wgOut->addHTML( $form );
			# Add list output
			$num = $pager->getNumRows();
			$wgOut->addHTML( wfMsgExt( 'oldreviewedpages-list', array( 'parse' ), $num ) );
			if ( $num ) {
				$wgOut->addHTML( $pager->getNavigationBar() );
				$wgOut->addHTML( $pager->getBody() );
				$wgOut->addHTML( $pager->getNavigationBar() );
			} else {
				$wgOut->addHTML( wfMsgExt( 'oldreviewedpages-none', array( 'parse' ) ) );
			}
		// If this page is transcluded...
		} else {
			if ( $pager->getNumRows() ) {
				$wgOut->addHTML( $pager->getBody() );
			} else {
				$wgOut->addHTML( wfMsgExt( 'oldreviewedpages-none', array( 'parse' ) ) );
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
			if ( preg_match( '/^namespace=(.*)$/', $bit, $m ) ) {
				$ns = $wgLang->getNsIndex( $m[1] );
				if ( $ns !== false ) {
					$this->namespace = $ns;
				}
			}
			if ( preg_match( '/^category=(.+)$/', $bit, $m ) ) {
				$this->category = $m[1];
			}
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

		$pager = new OldReviewedPagesPager( $this, $this->namespace, $this->category );
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
		$page = SpecialPage::getPage( 'OldReviewedPages' );
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
				$comments );
		} else {
			return null;
		}
	}
	
	public function formatRow( $row ) {
		global $wgLang, $wgUser, $wgMemc;

		$title = Title::newFromRow( $row );
		$link = $this->skin->makeKnownLinkObj( $title );
		$css = $stxt = $review = $quality = $underReview = '';
		$stxt = ChangesList::showCharacterDifference( $row->rev_len, $row->page_len );
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
class OldReviewedPagesPager extends AlphabeticPager {
	public $mForm, $mConds;
	private $category, $namespace;

	function __construct( $form, $namespace, $level = - 1, $category = '',
		$size = null, $watched = false, $stable = false )
	{
		$this->mForm = $form;
		# Must be a content page...
		$vnamespaces = FlaggedRevs::getReviewNamespaces();
		if ( is_null( $namespace ) ) {
			$namespace = $vnamespaces;
		} else {
			$namespace = intval( $namespace );
		}
		# Sanity check
		if ( !in_array( $namespace, $vnamespaces ) ) {
			$namespace = $vnamespaces;
		}
		$this->namespace = $namespace;
		# Sanity check level: 0 = sighted; 1 = quality; 2 = pristine
		$this->level = ( $level >= 0 && $level <= 2 ) ? $level : - 1;
		$this->category = $category ? str_replace( ' ', '_', $category ) : null;
		$this->size = ( $size !== null ) ? intval( $size ) : null;
		$this->watched = (bool)$watched;
		$this->stable = $stable && !FlaggedRevs::isStableShownByDefault()
			&& !FlaggedRevs::forDefaultVersionOnly();
		parent::__construct();
		// Don't get to expensive
		$this->mLimitsShown = array( 20, 50, 100 );
		$this->mLimit = min( $this->mLimit, 100 );
	}

	function formatRow( $row ) {
		return $this->mForm->formatRow( $row );
	}
	
	function getDefaultQuery() {
		$query = parent::getDefaultQuery();
		$query['category'] = $this->category;
		return $query;
	}
	
	function getDefaultDirections() {
		return false;
	}

	function getQueryInfo() {
		global $wgUser;
		$conds = $this->mConds;
		$tables = array( 'page', 'revision' );
		$fields = array( 'page_namespace', 'page_title', 'page_len', 'rev_len', 'page_latest' );
		# Show outdated "stable" versions
		if ( $this->level < 0 ) {
			$tables[] = 'flaggedpages';
			$fields[] = 'fp_stable AS stable';
			$fields[] = 'fp_quality AS quality';
			$fields[] = 'fp_pending_since AS pending_since';
			$conds[] = 'page_id = fp_page_id';
			# Overconstrain rev_page to force PK use
			$conds[] = 'rev_page = page_id AND rev_id = fp_stable';
			$conds[] = 'fp_pending_since IS NOT NULL';
			$useIndex = array( 'flaggedpages' => 'fp_pending_since', 'page' => 'PRIMARY' );
			# Filter by pages configured to be stable
			if ( $this->stable ) {
				$tables[] = 'flaggedpage_config';
				$conds[] = 'fp_page_id = fpc_page_id';
				$conds['fpc_override'] = 1;
			}
			# Filter by category
			if ( $this->category ) {
				$tables[] = 'categorylinks';
				$conds[] = 'cl_from = fp_page_id';
				$conds['cl_to'] = $this->category;
				$useIndex['categorylinks'] = 'cl_from';
			}
			$this->mIndexField = 'fp_pending_since';
		# Show outdated version for a specific review level
		} else {
			$tables[] = 'flaggedpage_pending';
			$fields[] = 'fpp_rev_id AS stable';
			$fields[] = 'fpp_quality AS quality';
			$fields[] = 'fpp_pending_since AS pending_since';
			$conds[] = 'page_id = fpp_page_id';
			# Overconstrain rev_page to force PK use
			$conds[] = 'rev_page = page_id AND rev_id = fpp_rev_id';
			$conds[] = 'fpp_pending_since IS NOT NULL';
			$useIndex = array( 'flaggedpage_pending' => 'fpp_quality_pending',
				'page' => 'PRIMARY' );
			# Filter by review level
			$conds['fpp_quality'] = $this->level;
			# Filter by pages configured to be stable
			if ( $this->stable ) {
				$tables[] = 'flaggedpage_config';
				$conds[] = 'fpp_page_id = fpc_page_id';
				$conds['fpc_override'] = 1;
			}
			# Filter by category
			if ( $this->category != '' ) {
				$tables[] = 'categorylinks';
				$conds[] = 'cl_from = fpp_page_id';
				$conds['cl_to'] = $this->category;
				$useIndex['categorylinks'] = 'cl_from';
			}
			$this->mIndexField = 'fpp_pending_since';
		}
		$fields[] = $this->mIndexField; // Pager needs this
		# Filter namespace
		if ( $this->namespace !== null ) {
			$conds['page_namespace'] = $this->namespace;
		}
		# Filter by watchlist
		if ( $this->watched && ( $uid = $wgUser->getId() ) ) {
			$tables[] = 'watchlist';
			$conds[] = "wl_user = '$uid'";
			$conds[] = 'page_namespace = wl_namespace';
			$conds[] = 'page_title = wl_title';
		}
		# Filter by bytes changed
		if ( $this->size !== null && $this->size >= 0 ) {
			# Get absolute difference for comparison. ABS(x-y)
			# is broken due to mysql unsigned int design.
			$conds[] = 'GREATEST(page_len,rev_len)-LEAST(page_len,rev_len) <= ' .
				intval( $this->size );
		}
		return array(
			'tables'  => $tables,
			'fields'  => $fields,
			'conds'   => $conds,
			'options' => array( 'USE INDEX' => $useIndex )
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
