<?php
$wgHooks['ResourceLoaderUserModule::getPages'][] = 'wfGlobalWikiaCSSJS';

$wgExtensionCredits['other'][] = array(
	'name' => 'Global CSS/JS',
	'author' => array(
		'[http://www.wikia.com/wiki/User:Datrio Dariusz Siedlecki]',
		'Wladyslaw Bodzek',
	),
	'descriptionmsg' => 'globalcssjs-desc',
  	'version' => "1.0",
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/GlobalCSSJS'
  );
  
  //i18n
$wgExtensionMessagesFiles['GlobalCSSJS'] = __DIR__ . '/GlobalCSSJS.i18n.php';

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
