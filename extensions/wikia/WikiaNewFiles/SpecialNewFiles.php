<?php
/**
 * @file
 * @ingroup SpecialPage
 * This is a direct copy of SpecialNewimages::wfSpecialNewimages with some
 * alterations for Wikia
 *
 */

function wfSpecialWikiaNewFiles ( $par, $specialPage ) {
	global $wgUser, $wgOut, $wgLang, $wgRequest, $wgMiserMode, $wgUseWikiaNewFiles;
	global $wgJsMimeType, $wgScriptPath, $wgStyleVersion, $wgExtensionMessagesFiles;
	global $wmu;

	$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"$wgScriptPath/extensions/wikia/WikiaNewFiles/js/WikiaNewFiles.js?$wgStyleVersion\"></script>\n" );

	$wpIlMatch = $wgRequest->getText( 'wpIlMatch' );
	$dbr = wfGetDB( DB_SLAVE );
	$sk = $wgUser->getSkin();
	$shownav = !$specialPage->including();
	$hidebots = $wgRequest->getBool( 'hidebots' , 1 );

	$hidebotsql = '';
	if ( $hidebots ) {
		# Make a list of group names which have the 'bot' flag set.
		$botconds = array();
		foreach ( User::getGroupsWithPermission('bot') as $groupname ) {
			$botconds[] = 'ug_group = ' . $dbr->addQuotes( $groupname );
		}

		# If not bot groups, do not set $hidebotsql
		if ( $botconds ) {
			$isbotmember = $dbr->makeList( $botconds, LIST_OR );

			# This join, in conjunction with WHERE ug_group IS NULL, returns
			# only those rows from IMAGE where the uploading user is not a mem-
			# ber of a group which has the 'bot' permission set.
			$ug = $dbr->tableName( 'user_groups' );
			$hidebotsql = " LEFT JOIN $ug ON img_user=ug_user AND ($isbotmember)";
		}
	}

	$image = $dbr->tableName( 'image' );

	$sql = "SELECT img_timestamp from $image";
	if ($hidebotsql) {
		$sql .= "$hidebotsql WHERE ug_group IS NULL";
	}
	$sql .= ' ORDER BY img_timestamp DESC LIMIT 1';
	$res = $dbr->query( $sql, __FUNCTION__ );
	$row = $dbr->fetchRow( $res );
	if( $row !== false ) {
		$ts = $row[0];
	} else {
		$ts = false;
	}
	$dbr->freeResult( $res );
	$sql = '';

	# If we were clever, we'd use this to cache.
	$latestTimestamp = wfTimestamp( TS_MW, $ts );

	# Hardcode this for now.
	$limit = 48;

	if ( $parval = intval( $par ) ) {
		if ( $parval <= $limit && $parval > 0 ) {
			$limit = $parval;
		}
	}

	$where = array();
	$searchpar = '';
	if ( $wpIlMatch != '' && !$wgMiserMode) {
		$nt = Title::newFromUrl( $wpIlMatch );
		if( $nt ) {
			$m = $dbr->escapeLike( strtolower( $nt->getDBkey() ) );
			$where[] = "LOWER(img_name) LIKE '%{$m}%'";
			$searchpar = '&wpIlMatch=' . urlencode( $wpIlMatch );
		}
	}

	$invertSort = false;
	if( $until = $wgRequest->getVal( 'until' ) ) {
		$where[] = "img_timestamp < '" . $dbr->timestamp( $until ) . "'";
	}
	if( $from = $wgRequest->getVal( 'from' ) ) {
		$where[] = "img_timestamp >= '" . $dbr->timestamp( $from ) . "'";
		$invertSort = true;
	}
	$sql='SELECT img_size, img_name, img_user, img_user_text,'.
	     "img_description,img_timestamp FROM $image";

	if( $hidebotsql ) {
		$sql .= $hidebotsql;
		$where[] = 'ug_group IS NULL';
	}

	// hook by Wikia, Bartek Lapinski 26.03.2009, for videos and stuff
	wfRunHooks( 'SpecialNewImages::beforeQuery', array( &$where ) );

	if( count( $where ) ) {
		$sql .= ' WHERE ' . $dbr->makeList( $where, LIST_AND );
	}
	$sql.=' ORDER BY img_timestamp '. ( $invertSort ? '' : ' DESC' );
	$sql.=' LIMIT ' . ( $limit + 1 );
	$res = $dbr->query( $sql, __FUNCTION__ );

	/**
	 * We have to flip things around to get the last N after a certain date
	 */
	$images = array();
	while ( $s = $dbr->fetchObject( $res ) ) {
		if( $invertSort ) {
			array_unshift( $images, $s );
		} else {
			array_push( $images, $s );
		}
	}
	$dbr->freeResult( $res );

	$gallery = new WikiaPhotoGallery();
	$gallery->parseParams(array("rowdivider" => true));
	$firstTimestamp = null;
	$lastTimestamp = null;
	$shownImages = 0;
	foreach( $images as $s ) {
		$shownImages++;
		if( $shownImages > $limit ) {
			# One extra just to test for whether to show a page link;
			# don't actually show it.
			break;
		}

		$name = $s->img_name;
		$ut = $s->img_user_text;

		$nt = Title::newFromText( $name, NS_FILE );
		$ul = $sk->link( Title::makeTitle( NS_USER, $ut ), $ut, array('class' => 'wikia-gallery-item-user') );
		$timeago = wfTimeFormatAgo($s->img_timestamp);

		$links = getLinkedFiles($s);

		// If there are more than two files, remove the 2nd and link to the
		// image page
		if (count($links) == 2) {
			array_splice($links, 1);
			$moreFiles = true;
		} else {
			$moreFiles = false;
		}

		$caption = wfMsgHtml( 'sp-newimages-uploadby', $ul )."<br />\n".
				  "<i>$timeago</i><br />\n";

		if (count($links)) {
			$caption .= wfMsg( 'sp-newimages-postedin' )."<br />\n".$links[0];
		}

		if ($moreFiles) {
			$caption .= ", ".'<a href="'.$nt->getLocalUrl().
			'#filelinks" class="wikia-gallery-item-more">'.
			wfMsgHtml('sp-newimages-more').'</a>';
		}

		$gallery->add( $nt, $caption );

		$timestamp = wfTimestamp( TS_MW, $s->img_timestamp );
		if( empty( $firstTimestamp ) ) {
			$firstTimestamp = $timestamp;
		}
		$lastTimestamp = $timestamp;
	}

	wfRunHooks( 'SpecialNewImages::beforeDisplay', array( &$images, &$gallery, &$limit ) );

	$titleObj = SpecialPage::getTitleFor( 'Newimages' );
	$action = $titleObj->getLocalURL( $hidebots ? '' : 'hidebots=0' );
	if ( $shownav && !$wgMiserMode ) {
		$wgOut->addHTML(
			Xml::openElement( 'form', array( 'action' => $action, 'method' => 'post', 'id' => 'imagesearch' ) ) .
			Xml::fieldset( wfMsg( 'newimages-legend' ) ) .
			Xml::inputLabel( wfMsg( 'newimages-label' ), 'wpIlMatch', 'wpIlMatch', 20, $wpIlMatch ) . ' ' .
			Xml::submitButton( wfMsg( 'ilsubmit' ), array( 'name' => 'wpIlSubmit' ) ) .
			Xml::closeElement( 'fieldset' ) .
			Xml::closeElement( 'form' )
		 );
	}

	/**
	 * Paging controls...
	 */

	# If we change bot visibility, this needs to be carried along.
	if( !$hidebots ) {
		$botpar = '&hidebots=0';
	} else {
		$botpar = '';
	}
	$now = wfTimestampNow();
	$d = $wgLang->date( $now, true );
	$t = $wgLang->time( $now, true );
	$dateLink = $sk->link( $titleObj, wfMsgHtml( 'sp-newimages-showfrom', $d, $t ),
							array('class' => 'navigation-filesfrom'),
		'from='.$now.$botpar.$searchpar );

	$botLink = $sk->link($titleObj,
						 wfMsgHtml( 'showhidebots', ($hidebots ? wfMsgHtml('show') : wfMsgHtml('hide'))),
						 array('class' => 'navigation-'.($hidebots ? 'showbots' : 'hidebots')),
						 'hidebots='.($hidebots ? '0' : '1').$searchpar);


	$opts = array( 'parsemag', 'escapenoentities' );
	$prevLink = wfMsgExt( 'pager-newer-n', $opts, $wgLang->formatNum( $limit ) );
	if( $firstTimestamp && $firstTimestamp != $latestTimestamp ) {
		$wmu['prev'] = $firstTimestamp;
		$prevLink = $sk->link( $titleObj, $prevLink,
							   array('class' => 'navigation-newer'),
							   'from=' . $firstTimestamp . $botpar . $searchpar );
	}

	$nextLink = wfMsgExt( 'pager-older-n', $opts, $wgLang->formatNum( $limit ) );
	if( $shownImages > $limit && $lastTimestamp ) {
		$wmu['next'] = $lastTimestamp;
		$nextLink = $sk->link( $titleObj, $nextLink,
							   array('class' => 'navigation-older'),
							   'until=' . $lastTimestamp.$botpar.$searchpar );
	}

	$prevnext = '<p id="newfiles-nav">' . $botLink . ' '. wfMsgHtml( 'viewprevnext', $prevLink, $nextLink, $dateLink ) .'</p>';

	if( count( $images ) ) {
		$wmu['gallery'] = $gallery;
		$wgOut->addHTML( $gallery->toHTML() );
		if ($shownav)
			$wgOut->addHTML( $prevnext );
	} else {
		$wgOut->addWikiMsg( 'noimages' );
	}
}

function getLinkedFiles ( $image ) {
	global $wgUser;

	// The ORDER BY ensures we get NS_MAIN pages first
	$dbr = wfGetDB( DB_SLAVE );
	$res = $dbr->select(
				array( 'imagelinks', 'page' ),
				array( 'page_namespace', 'page_title' ),
				array( 'il_to' => $image->img_name, 'il_from = page_id'),
				__METHOD__,
				array( 'LIMIT' => 2, 'ORDER BY' => 'page_namespace ASC')
		   );

	$sk = $wgUser->getSkin();
	$links = array();
	
	while ($s = $res->fetchObject()) {
		$name = Title::makeTitle( $s->page_namespace, $s->page_title );
		$links[] = $sk->link( $name, null, array('class' => 'wikia-gallery-item-posted') );
	}

	return $links;
}
