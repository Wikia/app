<?php

function efAddWikiSticky( &$html ) {
	global $wgOut, $wgExtensionsPath, $wgStyleVersion, $wgJsMimeType;

	wfLoadExtensionMessages( 'WikiStickies' );

	WikiStickies::addWikiStickyResources();
	// Special:MyHome page-specific resources
	$wgOut->addExtensionStyle("{$wgExtensionsPath}/wikia/WikiStickies/css/WikiStickiesMyHome.css?{$wgStyleVersion}");

	// fetch the feeds and rotate them
	$feedWithoutimages = WikiStickies::getWithoutimagesFeed( WikiStickies::INITIAL_FEED_LIMIT * 2 );
	WikiStickies::excludeFromFeed( $feedWithoutimages );
	shuffle( $feedWithoutimages );
	$feedNewpages = WikiStickies::getNewpagesFeed( WikiStickies::INITIAL_FEED_LIMIT );
	shuffle( $feedNewpages );
	$feedWantedpages = WikiStickies::getWantedpagesFeed( WikiStickies::INITIAL_FEED_LIMIT );
	shuffle( $feedWantedpages );

	// custom wikistickies added per RT #34558
	$feedCustompages = WikiStickies::getCustomFeed( WikiStickies::INITIAL_FEED_LIMIT );
	shuffle( $feedCustompages );


	$feeds = array();

        // for custom stickies, display them before everything else, as per RT #34558
	for( $i = 0; $i < count( $feedCustompages ); $i++ ) {
		if( isset( $feedCustompages[$i] ) ) {
			$feeds[] = array(
					'prefix' => 'wikistickies-custompages-st',
					'context' => 'custompages',
					'title' => $feedCustompages[$i],
					'editlinks' => false );
		}
	}	

	for( $i = 0; $i < max( count( $feedWithoutimages ), count( $feedNewpages ), count( $feedWantedpages ) ); $i++ ) {
		if( isset( $feedWithoutimages[$i] ) ) {
			$feeds[] = array(
					'prefix' => 'wikistickies-withoutimages-st',
					'context' => 'withoutimages',
					'title' => $feedWithoutimages[$i],
					'editlinks' => false );
		}
		if( isset( $feedNewpages[$i] ) ) {
			$feeds[] = array(
					'prefix' => 'wikistickies-newpages-st',
					'context' => 'newpages',
					'title' => $feedNewpages[$i],
					'editlinks' => false );
		}
	}

	$js = "WIKIA.WikiStickies.stickies = [\n";
	foreach( $feeds as $f ) {
		$js .= "'" . WikiStickies::renderWikiStickyContent( $f['title'], $f['prefix'], array( 'class' => 'fake_' . $f['context'] ), $f['editlinks'] ) . "',\n";
	}
	$js .= "];\n";
	$wgOut->addInlineScript( $js );
	$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/WikiStickies/js/WikiStickiesMyHome.js?{$wgStyleVersion}\"></script>\n");
	$html = WikiStickies::renderWikiSticky( $feeds[0]['title'], $feeds[0]['prefix'], NULL,  array('class' => 'fake_' . $feeds[0]['context'] ), $feeds[0]['editlinks'] );

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

function WikiStickiesJSVars(&$vars) {
	$vars['wikistickies_msg_hide'] = wfMsg('wikistickies-hide');
	$vars['wikistickies_msg_see_more'] = wfMsg('wikistickies-more');
	return true;
};

