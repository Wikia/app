<?php

/**
 * @todo this code is messy and should be reviewed
 */

$wgDBadminuser = $wgDBadminpassword = $wgDBserver = $wgDBname = $wgEnableProfileInfo = false;
define( 'MW_NO_SETUP', 1 );
require_once( dirname(__FILE__) . '/includes/WebStart.php' );
require_once( dirname(__FILE__) . '/includes/Setup.php' );

if ( !empty( $wgEnableRobotsTxtExt ) ) {
	require( __DIR__ . '/wikia-robots-txt.php' );
	exit;
}

require_once( dirname(__FILE__) . '/includes/StreamFile.php' );
require_once( dirname(__FILE__) . '/includes/SpecialPage.php' );
require_once( dirname(__FILE__) . '/languages/Language.php' );

function newrobots(){
	header('Content-Type: text/plain');
	header('Cache-Control: s-maxage=86400');
	header('X-Pass-Cache-Control: public, max-age=86400');
	echo <<<EOT
#
# Please note: There are a lot of pages on this site, and there are
# some misbehaved spiders out there that go _way_ too fast. If you're
# irresponsible, your access to the site may be blocked.
#

# Wikipedia work bots:
User-agent: IsraBot
Disallow: /

User-agent: Orthogaffe
Disallow: /

# Crawlers that are kind enough to obey, but which we'd rather not have
# unless they're feeding search engines.
User-agent: UbiCrawler
Disallow: /

User-agent: DOC
Disallow: /

User-agent: Zao
Disallow: /

# Some bots are known to be trouble, particularly those designed to copy
# entire sites. Please obey robots.txt.
User-agent: sitecheck.internetseer.com
Disallow: /

User-agent: Zealbot
Disallow: /

User-agent: MSIECrawler
Disallow: /

User-agent: SiteSnagger
Disallow: /

User-agent: WebStripper
Disallow: /

User-agent: WebCopier
Disallow: /

User-agent: Fetch
Disallow: /

User-agent: Offline Explorer
Disallow: /

User-agent: Teleport
Disallow: /

User-agent: TeleportPro
Disallow: /

User-agent: WebZIP
Disallow: /

User-agent: linko
Disallow: /

User-agent: HTTrack
Disallow: /

User-agent: Microsoft.URL.Control
Disallow: /

User-agent: Xenu
Disallow: /

User-agent: larbin
Disallow: /

User-agent: libwww
Disallow: /

User-agent: ZyBORG
Disallow: /

User-agent: Download Ninja
Disallow: /

User-agent: sitebot
Disallow: /

#
# Sorry, wget in its recursive mode is a frequent problem.
# Please read the man page and use it properly; there is a
# --wait option you can use to set the delay between hits,
# for instance.
#
User-agent: wget
Disallow: /

#
# Doesn't follow robots.txt anyway, but...
#
User-agent: k2spider
Disallow: /

#
# Hits many times per second, not acceptable
# http://www.nameprotect.com/botinfo.html
User-agent: NPBot
Disallow: /

# A capture bot, downloads gazillions of pages with no public benefit
# http://www.webreaper.net/
User-agent: WebReaper
Disallow: /

EOT;
	echo getDynamicRobots('goog');
	echo getDynamicRobots();
	echo "\n";
	echo getSitemapUrl();
	die;
}

function getDynamicRobots($bot=''){
	global $wgContLang;

	if($bot == 'goog'){
		$r = "\n";
		$r .= "User-agent: Googlebot\n";
		$r .= "Disallow: /w/\n";
		$r .= "Disallow: /trap/\n";
		$r .= "Disallow: /dbdumps/\n";
		$r .= "Disallow: /wikistats/\n";
		$r .= "Disallow: /*feed=rss*\n";
		$r .= "Disallow: /*action=history*\n";
		$r .= "Disallow: /*action=delete*\n";
		$r .= "Disallow: /*action=watch*\n";
		$r .= "Disallow: /*action=purge*\n";
		$r .= "Noindex: /w/\n";
		$r .= "Noindex: /trap/\n";
		$r .= "Noindex: /dbdumps/\n";
		$r .= "Noindex: /wikistats/\n";
		$r .= "Noindex: /*printable=yes*\n";
		$r .= "Noindex: /*feed=rss*\n";
		$r .= "Noindex: /*action=edit*\n";
		$r .= "Noindex: /*action=history*\n";
		$r .= "Noindex: /*action=delete*\n";
		$r .= "Noindex: /*action=watch*\n";
	}else{
		$r  = "\n";
		$r .= "User-agent: *\n";
		$r .= "Disallow: /w/\n";
		$r .= "Disallow: /trap/\n";
		$r .= "Disallow: /dbdumps/\n";
		$r .= "Disallow: /wikistats/\n";
		$r .= "Disallow: /*feed=rss*\n";
		$r .= "Disallow: /*action=history*\n";
		$r .= "Disallow: /*action=delete*\n";
		$r .= "Disallow: /*action=watch*\n";
		$r .= "Disallow: /*action=purge*\n";
	}

	//process english first
	$code = trim( $wgContLang->getCode() );

	//always add english since its' namespaces are always working as aliases
	$r .= getLangSpecificNamespace( new Language(), "en", $bot );

	if ( !empty( $code ) && $code != 'en' ) {
		$r .= getLangSpecificNamespace( $wgContLang, $code, $bot );
	}

	return $r;
}

function getSitemapUrl(){
	$r = '';

	$r .= "# sitemap\n";
	$r .= sprintf( "Sitemap: http://%s/sitemap-index.xml\n",  $_SERVER['SERVER_NAME'] );

	return $r;
}

function getLangSpecificNamespace( &$lang, $code, $bot='' ){
	global $wgArticleRobotPolicies;

	$r = '';

	/* @var Language $lang */
	$ns = $lang->getNamespaces();

	if($bot == 'goog'){
		$r .= "# " . $code . "\n" ;
		if ( $code == "en" && !empty( $wgArticleRobotPolicies['Special:WhatLinksHere'] ) ) {
			$r .= "Allow: /Special:WhatLinksHere\n";
			$r .= "Allow: /wiki/Special:WhatLinksHere\n";
		}
		if ( $code == "en" && !empty( $wgArticleRobotPolicies['Special:Newwikis'] ) ) {
			$r .= "Allow: /Special:Newwikis\n";
			$r .= "Allow: /wiki/Special:Newwikis\n";
		}
		/**
		 * always allow Special:Sitemap
		 */
		$r .= "Allow: /Special:Sitemap*\n";
		$r .= "Allow: /wiki/Special:Sitemap*\n";
		$r .= sprintf( "Allow: /%s:Sitemap*\n", urlencode( $ns[NS_SPECIAL] ) );
		$r .= sprintf( "Allow: /wiki/%s:Sitemap*\n", urlencode( $ns[NS_SPECIAL] ) );
		$r .= sprintf( "Allow: /%s:CreateNewWiki*\n", urlencode( $ns[NS_SPECIAL] ) );
		$r .= sprintf( "Allow: /wiki/%s:CreateNewWiki*\n", urlencode( $ns[NS_SPECIAL] ) );
		$r .= sprintf( "Allow: /%s:CreateWiki*\n", urlencode( $ns[NS_SPECIAL] ) );
		$r .= sprintf( "Allow: /wiki/%s:CreateWiki*\n", urlencode( $ns[NS_SPECIAL] ) );
		$r .= sprintf( "Allow: /%s*\n", $lang->specialPage("Videos") );
		$r .= sprintf( "Allow: /wiki/%s*\n", $lang->specialPage("Videos") );
		$r .= sprintf( "Allow: /%s*\n", $lang->specialPage("Forum") );
		$r .= sprintf( "Allow: /wiki/%s*\n", $lang->specialPage("Forum") );
		$r .= 'Disallow: /wiki/' . urlencode( $ns[NS_SPECIAL] ) .":*\n";
		$r .= 'Disallow: /' . urlencode( $ns[NS_SPECIAL] ) .":*\n";
		$r .= 'Disallow: /*title=' . urlencode( $ns[NS_SPECIAL] ) .":*\n";
		$r .= 'Disallow: /wiki/' . urlencode( $ns[NS_SPECIAL] ) ."%3A*\n";
		$r .= 'Disallow: /*title=' . urlencode( $ns[NS_SPECIAL] ) ."%3A*\n";
		$r .= "# " . $code . "\n" ;
		$r .= 'Noindex: /wiki/' . urlencode( $ns[NS_SPECIAL] ) .":*\n";
		$r .= 'Noindex: /' . urlencode( $ns[NS_SPECIAL] ) .":*\n";
		$r .= 'Noindex: /*title=' . urlencode( $ns[NS_SPECIAL] ) .":*\n";
		$r .= 'Noindex: /wiki/' . urlencode( $ns[NS_SPECIAL] ) ."%3A*\n";
		$r .= 'Noindex: /' . urlencode( $ns[NS_SPECIAL] ) ."%3A*\n";
		$r .= 'Noindex: /*title=' . urlencode( $ns[NS_SPECIAL] ) ."%3A*\n";
	}
	else {
		$r .= "# " . $code . "\n" ;
		$r .= "Allow: /Special:Sitemap*\n";
		$r .= "Allow: /wiki/Special:Sitemap*\n";
		$r .= sprintf( "Allow: /%s:Sitemap*\n", urlencode( $ns[NS_SPECIAL] ) );
		$r .= sprintf( "Allow: /wiki/%s:Sitemap*\n", urlencode( $ns[NS_SPECIAL] ) );
		$r .= sprintf( "Allow: /%s:CreateNewWiki*\n", urlencode( $ns[NS_SPECIAL] ) );
		$r .= sprintf( "Allow: /wiki/%s:CreateNewWiki*\n", urlencode( $ns[NS_SPECIAL] ) );
		$r .= sprintf( "Allow: /%s:CreateWiki*\n", urlencode( $ns[NS_SPECIAL] ) );
		$r .= sprintf( "Allow: /wiki/%s:CreateWiki*\n", urlencode( $ns[NS_SPECIAL] ) );
		$r .= sprintf( "Allow: /%s*\n", $lang->specialPage("Videos") );
		$r .= sprintf( "Allow: /wiki/%s*\n", $lang->specialPage("Videos") );
		$r .= sprintf( "Allow: /%s*\n", $lang->specialPage("Forum") );
		$r .= sprintf( "Allow: /wiki/%s*\n", $lang->specialPage("Forum") );
		$r .= 'Disallow: /wiki/' . urlencode( $ns[NS_SPECIAL] ) .":*\n";
		$r .= 'Disallow: /' . urlencode( $ns[NS_SPECIAL] ) .":*\n";
		$r .= 'Disallow: /*title=' . urlencode( $ns[NS_SPECIAL] ) .":*\n";
		$r .= 'Disallow: /wiki/' . urlencode( $ns[NS_SPECIAL] ) ."%3A*\n";
		$r .= 'Disallow: /' . urlencode( $ns[NS_SPECIAL] ) ."%3A*\n";
		$r .= 'Disallow: /*title=' . urlencode( $ns[NS_SPECIAL] ) ."%3A*\n";
	}
	return $r;
}

/**
 * deny all robots
 */
function deny( ) {
	header("Content-Type: text/plain");
	echo "User-agent: *\n";
	echo "Disallow: /\n";
}

/**
 * check for staging machines (for example: preview or verify)
 */
$headers = function_exists('apache_request_headers') ? apache_request_headers() : array();

$isdeny = !empty( $headers[ "X-Staging" ] );

if( $isdeny ) {
	deny();
} else {
	newrobots();
}
