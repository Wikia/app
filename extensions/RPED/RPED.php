<?php
/**
 * Remote Page Existence Detection (RPED) extension by Tisane
 * URL: http://www.mediawiki.org/wiki/Extension:RemotePageExistenceDetection
 *
 * This program is free software. You can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version. You can also redistribute it and/or
 * modify it under the terms of the Creative Commons Attribution 3.0 license.
 *
 * This extension looks up all the wikilinks on a page that would otherwise be red and compares them
 * to a table of page titles to determine whether they exist on a remote wiki. If so, the wikilink
 * turns blue and links to the page on the remote wiki.
 */


/* Alert the user that this is not a valid entry point to MediaWiki if they try to access the
special pages file directly.*/

if ( !defined( 'MEDIAWIKI' ) ) {
	echo <<<EOT
		To install the RPED extension, put the following line in LocalSettings.php:
		require( "extensions/RPED/RPED.php" );
EOT;
	exit( 1 );
}

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Remote Page Existence Detection',
	'author' => 'Tisane',
	'url' => 'https://www.mediawiki.org/wiki/Extension:RemotePageExistenceDetection',
	'descriptionmsg' => 'rped-desc',
	'version' => '1.0.2',
);
 
$dir = dirname( __FILE__ ) . '/';
$wgAutoloadClasses['RPEDHooks'] = $dir . 'RPED.hooks.php';
$wgExtensionMessagesFiles['RPED'] = $dir . 'RPED.i18n.php';
$wgAutoloadClasses['ApiRPED'] = $dir.'ApiRPED.php';
$wgAPIModules['rped'] = 'ApiRPED';
$wgGroupPermissions['RPED']['rped']    = true;

$wgHooks['LoadExtensionSchemaUpdates'][] = 'RPEDHooks::RPEDCreateTable';
$wgHooks['LinkBegin'][] = 'RPEDHooks::wikipediaLink';

$wgRPEDBrokenLinkStyle = "color: red";
$wgRPEDExcludeNamespaced = false;
$wgRemoteStyle = 'color: blue';