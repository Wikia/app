<?php
$wgHooks['ResourceLoaderUserModule::getPages'][] = 'wfGlobalWikiaCSSJS';

$wgExtensionCredits['other'][] = array(
	'name' => 'Global CSS/JS',
	'author' => array(
		'[http://www.wikia.com/wiki/User:Datrio Dariusz Siedlecki]',
		'Wladyslaw Bodzek',
	),
	'description' => 'Adds global user CSS and JavaScript to a page, fetched from the Central Wikia.',
  	'version' => "1.0"
  );

/**
 * Adds custom user CSS and JavaScript to a page
 *
 * @param $module Module instance
 * @param $context Resource Loader context
 * @param $userpage User page title text
 * @param $pages array array to operate on
 * @return bool True (hook handler)
 */
function wfGlobalWikiaCSSJS( $module, $context, $userpage, &$pages ) {
	$COMMUNITY_ID = 177;
	$username = substr( $userpage, strpos( $userpage, ':' ) + 1 );
	if ( $username ) {
		$pages = array_merge( array(
			'globalcss' => array( 'type' => 'style', 'city_id' => $COMMUNITY_ID, 'title' => "User:{$username}/global.css",
				'originalName' => "w:c:User:{$username}/global.css"),
			'globaljs'  => array( 'type' => 'script', 'city_id' => $COMMUNITY_ID, 'title' => "User:{$username}/global.js",
				'originalName' => "w:c:User:{$username}/global.js"),
		), $pages );
	}

	return true;
}
