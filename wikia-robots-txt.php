<?php

if ( !defined( 'MW_NO_SETUP' ) ) {
	define( 'MW_NO_SETUP', 1 );
}

require_once( __DIR__ . '/includes/WebStart.php' );
require_once( __DIR__ . '/includes/Setup.php' );

$allowRobots = ( $wgWikiaEnvironment === WIKIA_ENV_PROD || $wgRequest->getBool( 'forcerobots' ) );

$robots = new RobotsTxt();

if ( !$allowRobots ) {
	// No crawling preview, verify, sandboxes, showcase, etc
	$robots->disallowPath( '/' );
} else {
	// Sitemap
	$robots->setSitemap( sprintf( 'http://%s/sitemap-index.xml', $_SERVER['SERVER_NAME'] ) );

	// Special pages
	$robots->disallowNamespace( NS_SPECIAL );
	$robots->disallowNamespace( NS_TEMPLATE );
	$robots->disallowNamespace( NS_TEMPLATE_TALK );

	//$robots->allowSpecialPage( 'Allpages' ); // TODO: SEO-64
	$robots->allowSpecialPage( 'CreateNewWiki' );
	$robots->allowSpecialPage( 'Forum' );
	$robots->allowSpecialPage( 'Sitemap' );
	$robots->allowSpecialPage( 'Videos' );

	// Params
	$robots->disallowParam( 'action' );
	$robots->disallowParam( 'feed' );
	$robots->disallowParam( 'oldid' );
	$robots->disallowParam( 'printable' );
	$robots->disallowParam( 'useskin' );
	$robots->disallowParam( 'uselang' );

	// Nasty robots
	$robots->blockRobot( 'IsraBot' );
	$robots->blockRobot( 'Orthogaffe' );
	$robots->blockRobot( 'UbiCrawler' );
	$robots->blockRobot( 'DOC' );
	$robots->blockRobot( 'Zao' );
	$robots->blockRobot( 'sitecheck.internetseer.com' );
	$robots->blockRobot( 'Zealbot' );
	$robots->blockRobot( 'MSIECrawler' );
	$robots->blockRobot( 'SiteSnagger' );
	$robots->blockRobot( 'WebStripper' );
	$robots->blockRobot( 'WebCopier' );
	$robots->blockRobot( 'Fetch' );
	$robots->blockRobot( 'Offline Explorer' );
	$robots->blockRobot( 'Teleport' );
	$robots->blockRobot( 'TeleportPro' );
	$robots->blockRobot( 'WebZIP' );
	$robots->blockRobot( 'linko' );
	$robots->blockRobot( 'HTTrack' );
	$robots->blockRobot( 'Microsoft.URL.Control' );
	$robots->blockRobot( 'Xenu' );
	$robots->blockRobot( 'larbin' );
	$robots->blockRobot( 'libwww' );
	$robots->blockRobot( 'ZyBORG' );
	$robots->blockRobot( 'Download Ninja' );
	$robots->blockRobot( 'sitebot' );
	$robots->blockRobot( 'wget' );
	$robots->blockRobot( 'k2spider' );
	$robots->blockRobot( 'NPBot' );
	$robots->blockRobot( 'WebReaper' );

	// Deprecated items, probably we should delete them
	$robots->disallowPath( '/w/' );
	$robots->disallowPath( '/trap/' );
	$robots->disallowPath( '/dbdumps/' );
	$robots->disallowPath( '/wikistats/' );
}

foreach ( $robots->getHeaders() as $header ) {
	header( $header );
}

echo join( PHP_EOL, $robots->getContents() ) . PHP_EOL;
