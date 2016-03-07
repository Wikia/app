<?php

if ( !defined( 'MW_NO_SETUP' ) ) {
	define( 'MW_NO_SETUP', 1 );
}

require_once( __DIR__ . '/includes/WebStart.php' );
require_once( __DIR__ . '/includes/Setup.php' );

$robots = new RobotsTxt();
$allowRobots = ( $wgWikiaEnvironment === WIKIA_ENV_PROD || $wgRequest->getBool( 'forcerobots' ) );
$experimentalRobots = null;

if ( !empty( $wgExperimentalRobotsTxt ) && preg_match( '/^[a-z0-9-]+$/m', $wgExperimentalRobotsTxt ) ) {
	$file = __DIR__ . '/robots.txt.d/' . $wgExperimentalRobotsTxt . '.txt';
	if ( is_file( $file ) && is_readable( $file ) ) {
		$experimentalRobots = file_get_contents( $file );
	}
}

if ( !$allowRobots ) {
	// No crawling preview, verify, sandboxes, showcase, etc
	$robots->disallowPath( '/' );
} elseif ( $experimentalRobots ) {
	// Sitemap
	if ( !empty( $wgEnableSpecialSitemapExt ) ) {
		$robots->setSitemap( sprintf( 'http://%s/sitemap-index.xml', $_SERVER['SERVER_NAME'] ) );
	}

	// Experimental content
	$robots->setExperimentalAllowDisallowSection( $experimentalRobots );
} else {
	// Sitemap
	if ( !empty( $wgEnableSpecialSitemapExt ) ) {
		$robots->setSitemap( sprintf( 'http://%s/sitemap-index.xml', $_SERVER['SERVER_NAME'] ) );
	}

	// Special pages
	$robots->disallowNamespace( NS_SPECIAL );
	$robots->disallowNamespace( NS_TEMPLATE );
	$robots->disallowNamespace( NS_TEMPLATE_TALK );

	if ( !empty( $wgEnableLocalSitemap ) ) {
		$robots->allowSpecialPage( 'Allpages' );
	}
	$robots->allowSpecialPage( 'CreateNewWiki' );
	$robots->allowSpecialPage( 'Forum' );
	$robots->allowSpecialPage( 'Sitemap' );
	$robots->allowSpecialPage( 'Videos' );

	if ( !empty( $wgAllowSpecialImagesInRobots ) ) {
		$robots->allowSpecialPage( 'Images' );
	}

	// Params
	$robots->disallowParam( 'action' );
	$robots->disallowParam( 'feed' );
	$robots->disallowParam( 'oldid' );
	$robots->disallowParam( 'printable' );
	$robots->disallowParam( 'useskin' );
	$robots->disallowParam( 'uselang' );

	// SEO-302: Allow Googlebot to crawl Android app contents
	// @see http://developer.android.com/training/app-indexing/enabling-app-indexing.html)
	// The order of precedence between those two is undefined:
	// "Disallow: /*?*action=" and "Allow: /api.php"
	// @see https://developers.google.com/webmasters/control-crawl-index/docs/robots_txt#order-of-precedence-for-group-member-records
	// That's why we're adding quite explicit "Allow: /api.php?*action=" (even though it's redundant)
	// robots.txt Tester in Google Search Console shows this will do:
	// @see https://www.google.com/webmasters/tools/robots-testing-tool?hl=en&siteUrl=http://muppet.wikia.com/
	$robots->allowPath( '/api.php?' );
	$robots->allowPath( '/api.php?*action=' );

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
