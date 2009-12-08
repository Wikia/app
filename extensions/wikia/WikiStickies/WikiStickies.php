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

	// fetch the feeds and shuffle them
	$feeds = array();
	foreach( WikiStickies::getWithoutimagesFeed( WikiStickies::INITIAL_FEED_LIMIT ) as $title ) {
		$feeds[] = array(
			'prefix' => wfMsg( 'wikistickies-withoutimages-st' ),
			'title' => $title );
	}
	foreach( WikiStickies::getNewpagesFeed( WikiStickies::INITIAL_FEED_LIMIT ) as $title ) {
		$feeds[] = array(
			'prefix' => wfMsg( 'wikistickies-newpages-st' ),
			'title' => $title );
	}
	foreach( WikiStickies::getWantedpagesFeed( WikiStickies::INITIAL_FEED_LIMIT ) as $title ) {
		$feeds[] = array(
			'prefix' => wfMsg( 'wikistickies-wantedpages-st' ),
			'title' => $title );
	}
	//shuffle( $feeds );

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
