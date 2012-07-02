<?php
/**
 * Special:NewVideos - a special page for showing recently added videos
 * Reuses various bits and pieces from SpecialNewimages.php
 *
 * @file
 * @ingroup Extensions
 */

class NewVideos extends IncludableSpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'NewVideos' );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgGroupPermissions;

		$out = $this->getOutput();
		$request = $this->getRequest();
		$lang = $this->getLang();
		
		$out->setPageTitle( wfMsgHtml( 'newvideos' ) );

		$wpIlMatch = $request->getText( 'wpIlMatch' );
		$dbr = wfGetDB( DB_SLAVE );
		$sk = $this->getSkin();
		$shownav = !$this->including();
		$hidebots = $request->getBool( 'hidebots', 1 );

		$hidebotsql = '';
		if( $hidebots ) {
			/*
			 * Make a list of group names which have the 'bot' flag
			 * set.
			 */
			$botconds = array();
			foreach( $wgGroupPermissions as $groupname => $perms ) {
				if( array_key_exists( 'bot', $perms ) && $perms['bot'] ) {
					$botconds[] = "ug_group='$groupname'";
				}
			}

			/* If not bot groups, do not set $hidebotsql */
			if( $botconds ) {
				$isbotmember = $dbr->makeList( $botconds, LIST_OR );

				/*
				 * This join, in conjunction with WHERE ug_group
				 * IS NULL, returns only those rows from IMAGE
				 * where the uploading user is not a member of
				 * a group which has the 'bot' permission set.
				 */
				$ug = $dbr->tableName( 'user_groups' );
				$hidebotsql = " LEFT OUTER JOIN $ug ON video_user_name=ug_user AND ($isbotmember)";
			}
		}

		$video = $dbr->tableName( 'video' );

		$sql = "SELECT video_timestamp FROM $video";
		if( $hidebotsql ) {
			$sql .= "$hidebotsql WHERE ug_group IS NULL";
		}
		$sql.= ' ORDER BY video_timestamp DESC LIMIT 1';
		$res = $dbr->query( $sql, __METHOD__ );
		$row = $dbr->fetchRow( $res );
		if( $row !== false ) {
			$ts = $row[0];
		} else {
			$ts = false;
		}
		$sql = '';

		/** If we were clever, we'd use this to cache. */
		$latestTimestamp = wfTimestamp( TS_MW, $ts );

		/** Hardcode this for now. */
		$limit = 48;

		if ( $parval = intval( $par ) ) {
			if ( $parval <= $limit && $parval > 0 ) {
				$limit = $parval;
			}
		}

		$where = array();
		$searchpar = array();
		if ( $wpIlMatch != '' ) {
			$nt = Title::newFromUrl( $wpIlMatch );
			if( $nt ) {
				$m = $dbr->strencode( strtolower( $nt->getDBkey() ) );
				$m = str_replace( '%', "\\%", $m );
				$m = str_replace( '_', "\\_", $m );
				$where[] = "LCASE(video_name) LIKE '%{$m}%'";
				$searchpar['wpIlMatch'] = $wpIlMatch;
			}
		}

		$invertSort = false;
		if( $until = $request->getVal( 'until' ) ) {
			$where[] = 'video_timestamp < ' . $dbr->timestamp( $until );
		}
		if( $from = $request->getVal( 'from' ) ) {
			$where[] = 'video_timestamp >= ' . $dbr->timestamp( $from );
			$invertSort = true;
		}
		$sql = 'SELECT video_name, video_url, video_user_name, video_user_id, '.
				" video_timestamp FROM $video";

		if( $hidebotsql ) {
			$sql .= $hidebotsql;
			$where[] = 'ug_group IS NULL';
		}
		if( count( $where ) ) {
			$sql.= ' WHERE ' . $dbr->makeList( $where, LIST_AND );
		}
		$sql.= ' ORDER BY video_timestamp '. ( $invertSort ? '' : ' DESC' );
		$sql.= ' LIMIT ' . ( $limit + 1 );
		$res = $dbr->query( $sql, __METHOD__ );

		// We have to flip things around to get the last N after a certain date
		$videos = array();
		foreach( $res as $s ) {
			if( $invertSort ) {
				array_unshift( $videos, $s );
			} else {
				array_push( $videos, $s );
			}
		}

		$gallery = new VideoGallery();
		$firstTimestamp = null;
		$lastTimestamp = null;
		$shownVideos = 0;
		foreach( $videos as $s ) {
			if( ++$shownVideos > $limit ) {
				// One extra just to test for whether to show a page link;
				// don't actually show it.
				break;
			}

			$name = $s->video_name;
			$ut = $s->video_user_name;

			$nt = Title::newFromText( $name, NS_VIDEO );
			$vid = new Video( $nt, $this->getContext() );
			$ul = $sk->makeLinkObj( Title::makeTitle( NS_USER, $ut ), $ut );

			$gallery->add(
				$vid,
				"$ul<br />\n<i>" .
					$lang->timeanddate( $s->video_timestamp, true ) .
					"</i><br />\n"
			);

			$timestamp = wfTimestamp( TS_MW, $s->video_timestamp );
			if( empty( $firstTimestamp ) ) {
				$firstTimestamp = $timestamp;
			}
			$lastTimestamp = $timestamp;
		}

		$bydate = wfMsg( 'bydate' );
		$lt = $lang->formatNum( min( $shownVideos, $limit ) );
		if( $shownav ) {
			$text = wfMsgExt( 'imagelisttext', 'parse', $lt, $bydate );
			$out->addHTML( $text . "\n" );
		}

		$sub = wfMsg( 'ilsubmit' );
		$titleObj = SpecialPage::getTitleFor( 'NewVideos' );
		$action = $titleObj->escapeLocalURL( $hidebots ? '' : 'hidebots=0' );
		if( $shownav ) {
			$out->addHTML(
				"<form id=\"imagesearch\" method=\"post\" action=\"{$action}\">" .
				Xml::input( 'wpIlMatch', 20, $wpIlMatch ) . ' ' .
				Xml::submitButton( $sub, array( 'name' => 'wpIlSubmit' ) ) .
				'</form>'
			);
		}

		// Paging controls...

		# If we change bot visibility, this needs to be carried along.
		if( !$hidebots ) {
			$botpar = array( 'hidebots' => 0 );
		} else {
			$botpar = array();
		}
		$now = wfTimestampNow();
		$date = $lang->date( $now, true );
		$time = $lang->time( $now, true );
		$query = array_merge(
			array( 'from' => $now ),
			$botpar,
			$searchpar
		);

		$dateLink = $sk->linkKnown(
			$titleObj,
			htmlspecialchars( wfMsgHtml( 'sp-newimages-showfrom', $date, $time ) ),
			array(),
			$query
		);

		$query = array_merge(
			array( 'hidebots' => ( $hidebots ? 0 : 1 ) ),
			$searchpar
		);

		$showhide = $hidebots ? wfMsg( 'show' ) : wfMsg( 'hide' );

		$botLink = $sk->linkKnown(
			$titleObj,
			htmlspecialchars( wfMsg( 'showhidebots', $showhide ) ),
			array(),
			$query
		);

		$opts = array( 'parsemag', 'escapenoentities' );
		$prevLink = wfMsgExt( 'pager-newer-n', $opts, $lang->formatNum( $limit ) );
		if( $firstTimestamp && $firstTimestamp != $latestTimestamp ) {
			$query = array_merge(
				array( 'from' => $firstTimestamp ),
				$botpar,
				$searchpar
			);
			$prevLink = $sk->linkKnown(
				$titleObj,
				$prevLink,
				array(),
				$query
			);
		}

		$nextLink = wfMsgExt( 'pager-older-n', $opts, $lang->formatNum( $limit ) );
		if( $shownVideos > $limit && $lastTimestamp ) {
			$query = array_merge(
				array( 'until' => $lastTimestamp ),
				$botpar,
				$searchpar
			);

			$nextLink = $sk->linkKnown(
				$titleObj,
				$nextLink,
				array(),
				$query
			);
		}

		$prevnext = '<p>' . $botLink . ' ' .
			wfMsgHtml( 'viewprevnext', $prevLink, $nextLink, $dateLink ) .
			'</p>';

		if( $shownav ) {
			$out->addHTML( $prevnext );
		}

		if( count( $videos ) ) {
			$out->addHTML( $gallery->toHTML() );
			if( $shownav ) {
				$out->addHTML( $prevnext );
			}
		} else {
			$out->addWikiMsg( 'video-no-videos' );
		}
	}
}