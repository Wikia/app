<?php
/**
 *
 * @addtogroup SpecialPage
 */

/**
 *
 */

$wgSpecialPages['SpecialNewVideos'] = array( 'IncludableSpecialPage', 'wfSpecialNewVideos' );
#$wgExtensionFunctions[] = 'wfSpecialNewVideos';
function wfSpecialNewVideos( $par, $specialPage ) {
	global $wgUser, $wgOut, $wgLang, $wgRequest, $wgGroupPermissions;

	$wpIlMatch = $wgRequest->getText( 'wpIlMatch' );
	$dbr = wfGetDB( DB_SLAVE );
	$sk = $wgUser->getSkin();
	$shownav = !$specialPage->including();
	$hidebots = $wgRequest->getBool('hidebots',1);

	$hidebotsql = '';
	if ($hidebots) {

		/** Make a list of group names which have the 'bot' flag
		    set.
		*/
		$botconds=array();
		foreach ($wgGroupPermissions as $groupname=>$perms) {
			if(array_key_exists('bot',$perms) && $perms['bot']) {
				$botconds[]="ug_group='$groupname'";
			}
		}

		/* If not bot groups, do not set $hidebotsql */
		if ($botconds) {
			$isbotmember=$dbr->makeList($botconds, LIST_OR);

			/** This join, in conjunction with WHERE ug_group
			    IS NULL, returns only those rows from IMAGE
		    	where the uploading user is not a member of
		    	a group which has the 'bot' permission set.
			*/
			$ug = $dbr->tableName('user_groups');
			$hidebotsql = " LEFT OUTER JOIN $ug ON video_user_name=ug_user AND ($isbotmember)";
		}
	}

	$video = $dbr->tableName('video');

	$sql="SELECT video_timestamp from $image";
	if ($hidebotsql) {
		$sql .= "$hidebotsql WHERE ug_group IS NULL";
	}
	$sql.=' ORDER BY video_timestamp DESC LIMIT 1';
	$res = $dbr->query($sql, 'wfSpecialNewVideos');
	$row = $dbr->fetchRow($res);
	if($row!==false) {
		$ts=$row[0];
	} else {
		$ts=false;
	}
	$dbr->freeResult($res);
	$sql='';

	/** If we were clever, we'd use this to cache. */
	$latestTimestamp = wfTimestamp( TS_MW, $ts);

	/** Hardcode this for now. */
	$limit = 48;

	if ( $parval = intval( $par ) ) {
		if ( $parval <= $limit && $parval > 0 ) {
			$limit = $parval;
		}
	}

	$where = array();
	$searchpar = '';
	if ( $wpIlMatch != '' ) {
		$nt = Title::newFromUrl( $wpIlMatch );
		if($nt ) {
			$m = $dbr->strencode( strtolower( $nt->getDBkey() ) );
			$m = str_replace( '%', "\\%", $m );
			$m = str_replace( '_', "\\_", $m );
			$where[] = "LCASE(video_name) LIKE '%{$m}%'";
			$searchpar = '&wpIlMatch=' . urlencode( $wpIlMatch );
		}
	}

	$invertSort = false;
	if( $until = $wgRequest->getVal( 'until' ) ) {
		$where[] = 'video_timestamp < ' . $dbr->timestamp( $until );
	}
	if( $from = $wgRequest->getVal( 'from' ) ) {
		$where[] = 'video_timestamp >= ' . $dbr->timestamp( $from );
		$invertSort = true;
	}
	$sql='SELECT video_name, video_url, video_user_name, video_user_id, '.
	     " video_timestamp FROM $video";

	if($hidebotsql) {
		$sql .= $hidebotsql;
		$where[]='ug_group IS NULL';
	}
	if(count($where)) {
		$sql.=' WHERE '.$dbr->makeList($where, LIST_AND);
	}
	$sql.=' ORDER BY video_timestamp '. ( $invertSort ? '' : ' DESC' );
	$sql.=' LIMIT '.($limit+1);
	$res = $dbr->query($sql, 'wfSpecialNewVideos');

	/**
	 * We have to flip things around to get the last N after a certain date
	 */
	$videos = array();
	while ( $s = $dbr->fetchObject( $res ) ) {
		if( $invertSort ) {
			array_unshift( $videos, $s );
		} else {
			array_push( $videos, $s );
		}
	}
	$dbr->freeResult( $res );

	$gallery = new VideoGallery();
	$firstTimestamp = null;
	$lastTimestamp = null;
	$shownVideos = 0;
	foreach( $videos as $s ) {
		if( ++$shownVideos > $limit ) {
			# One extra just to test for whether to show a page link;
			# don't actually show it.
			break;
		}

		$name = $s->video_name;
		$ut = $s->video_user_name;

		$nt = Title::newFromText( $name, NS_IMAGE );
		$vid = new Video( $nt );
		$ul = $sk->makeLinkObj( Title::makeTitle( NS_USER, $ut ), $ut );

		$gallery->add( $vid, "$ul<br />\n<i>".$wgLang->timeanddate( $s->video_timestamp, true )."</i><br />\n" );

		$timestamp = wfTimestamp( TS_MW, $s->video_timestamp );
		if( empty( $firstTimestamp ) ) {
			$firstTimestamp = $timestamp;
		}
		$lastTimestamp = $timestamp;
	}

	$bydate = wfMsg( 'bydate' );
	$lt = $wgLang->formatNum( min( $shownImages, $limit ) );
	if ($shownav) {
		$text = wfMsgExt( 'imagelisttext', array('parse'), $lt, $bydate );
		$wgOut->addHTML( $text . "\n" );
	}

	$sub = wfMsg( 'ilsubmit' );
	$titleObj = SpecialPage::getTitleFor( 'NewVideos' );
	$action = $titleObj->escapeLocalURL( $hidebots ? '' : 'hidebots=0' );
	if ($shownav) {
		$wgOut->addHTML( "<form id=\"imagesearch\" method=\"post\" action=\"" .
		  "{$action}\">" .
			Xml::input( 'wpIlMatch', 20, $wpIlMatch ) . ' ' .
		  Xml::submitButton( $sub, array( 'name' => 'wpIlSubmit' ) ) .
		  "</form>" );
	}

	/**
	 * Paging controls...
	 */

	# If we change bot visibility, this needs to be carried along.
	if(!$hidebots) {
		$botpar='&hidebots=0';
	} else {
		$botpar='';
	}
	$now = wfTimestampNow();
	$date = $wgLang->timeanddate( $now, true );
	$dateLink = $sk->makeKnownLinkObj( $titleObj, wfMsgHtml( 'sp-newimages-showfrom', $date ), 'from='.$now.$botpar.$searchpar );

	$botLink = $sk->makeKnownLinkObj($titleObj, wfMsgHtml( 'showhidebots', ($hidebots ? wfMsgHtml('show') : wfMsgHtml('hide'))),'hidebots='.($hidebots ? '0' : '1').$searchpar);

	$prevLink = wfMsgHtml( 'prevn', $wgLang->formatNum( $limit ) );
	if( $firstTimestamp && $firstTimestamp != $latestTimestamp ) {
		$prevLink = $sk->makeKnownLinkObj( $titleObj, $prevLink, 'from=' . $firstTimestamp . $botpar . $searchpar );
	}

	$nextLink = wfMsgHtml( 'nextn', $wgLang->formatNum( $limit ) );
	if( $shownImages > $limit && $lastTimestamp ) {
		$nextLink = $sk->makeKnownLinkObj( $titleObj, $nextLink, 'until=' . $lastTimestamp.$botpar.$searchpar );
	}

	$prevnext = '<p>' . $botLink . ' '. wfMsgHtml( 'viewprevnext', $prevLink, $nextLink, $dateLink ) .'</p>';

	if ($shownav)
		$wgOut->addHTML( $prevnext );

	if( count( $images ) ) {
		$wgOut->addHTML( $gallery->toHTML() );
		if ($shownav)
			$wgOut->addHTML( $prevnext );
	} else {
		$wgOut->addWikiText( wfMsg( 'novideos' ) );
	}
}

?>
