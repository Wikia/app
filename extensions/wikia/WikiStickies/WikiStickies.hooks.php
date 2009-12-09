<?php

function efAddWikiSticky( &$html ) {
	global $wgOut, $wgExtensionsPath, $wgStyleVersion, $wgJsMimeType;

	wfLoadExtensionMessages( 'WikiStickies' );

	WikiStickies::addWikiStickyResources();
	// Special:MyHome page-specific resources
	$wgOut->addExtensionStyle("{$wgExtensionsPath}/wikia/WikiStickies/css/WikiStickiesMyHome.css?{$wgStyleVersion}");

	// fetch the feeds and rotate them
	$feedWithoutimages = WikiStickies::getWithoutimagesFeed( WikiStickies::INITIAL_FEED_LIMIT );
	$feedNewpages = WikiStickies::getNewpagesFeed( WikiStickies::INITIAL_FEED_LIMIT );
	$feedWantedpages = WikiStickies::getWantedpagesFeed( WikiStickies::INITIAL_FEED_LIMIT );

	$feeds = array();
	for( $i = 0; $i < max( count( $feedWithoutimages ), count( $feedNewpages ), count( $feedWantedpages ) ); $i++ ) {
		if( isset( $feedWithoutimages[$i] ) ) {
			$feeds[] = array(
					'prefix' => wfMsg( 'wikistickies-withoutimages-st' ),
					'title' => $feedWithoutimages[$i] );
		}
		if( isset( $feedNewpages[$i] ) ) {
			$feeds[] = array(
					'prefix' => wfMsg( 'wikistickies-newpages-st' ),
					'title' => $feedNewpages[$i] );
		}
		if( isset( $feedWantedpages[$i] ) ) {
			$feeds[] = array(
					'prefix' => wfMsg( 'wikistickies-wantedpages-st' ),
					'title' => $feedWantedpages[$i] );
		}
	}

	$js = "WIKIA.WikiStickies.stickies = [\n";
	foreach( $feeds as $f ) {
		$js .= "'" . WikiStickies::renderWikiStickyContent( $f['title'], $f['prefix'] ) . "',\n";
	}
	$js .= "];\n";
	$wgOut->addInlineScript( $js );
	$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/WikiStickies/js/WikiStickiesMyHome.js?{$wgStyleVersion}\"></script>\n");
	$html = WikiStickies::renderWikiSticky( $feeds[0]['title'], $feeds[0]['prefix'] );

	return true;
}

// TODO find (or create) a good hook for this
// it should be on article save, scan if there was added a new imagelink
// and the imagelink should have less than 20 references
// Special:MyHome uses such tricks
function efRemoveFromSpecialWithoutimages( ) {
	$dbw = wfGetDB( DB_MASTER );
	$dbw->delete( 'querycache', array( 
		'qc_type'      => 'Withoutimages',
		'qc_title'     => $title->getDBkey(),
		'qc_namespace' => $title->getNamespace(),
	) );

	return true;
}

function efRemoveFromSpecialWantedpages( &$rc ) {
	if( $rc->mAttribs['rc_type'] == RC_NEW ) {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete( 'querycache', array( 
			'qc_type'      => 'Wantedpages',
			'qc_title'     => $rc->mAttribs['rc_title'],
			'qc_namespace' => $rc->mAttribs['rc_namespace'],
		) );
	}
	return true;
}
