<?php

if (!defined('MEDIAWIKI')) {
        exit( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
        'name' => 'Wiki Stickies',
        'author' => 'Bartek Lapinski',
        'url' => 'http://www.mediawiki.org/wiki/Extension:MyExtension',
        'description' => 'The big, sticky Wiki Stickies to capture your eye!',
        'descriptionmsg' => 'The extension that will capture your attention!',
        'version' => '0.1.5',
);

$dir = dirname(__FILE__) . '/';

// autoloader
$wgAutoloadClasses['ApiQueryWithoutimages'] = $dir . 'ApiQueryWithoutimages.php';
$wgAutoloadClasses['ApiQueryWantedpages'] = $dir . 'ApiQueryWantedpages.php';
$wgAutoloadClasses['SpecialWikiStickies'] = $dir.'SpecialWikiStickies.class.php';
$wgAutoloadClasses['WikiStickies'] = $dir.'WikiStickies.class.php';

// special page
$wgSpecialPages['WikiStickies'] = 'SpecialWikiStickies';
$wgSpecialPageGroups['WikiStickies'] = 'users';

// i18n
$wgExtensionAliasesFiles['WikiStickies'] = $dir . 'SpecialWikiStickies.alias.php';
$wgExtensionMessagesFiles['WikiStickies'] = $dir . 'WikiStickies.i18n.php';

// API
$wgAPIListModules['wantedpages'] = 'ApiQueryWantedpages';
$wgAPIListModules['withoutimages'] = 'ApiQueryWithoutimages';

// Hooks
$wgHooks['MyHome::sidebarBeforeContent'][] = 'efAddWikiSticky';

function efAddWikiSticky( &$html ) {
	global $wgOut, $wgExtensionsPath, $wgStyleVersion;

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
	$wgOut->addScriptFile("{$wgExtensionsPath}/wikia/WikiStickies/js/WikiStickiesMyHome.js");

	$html = WikiStickies::renderWikiSticky( $feeds[0]['title'], $feeds[0]['prefix'] );

	return true;
}

include( $dir . 'SpecialWithoutimages.php' );
