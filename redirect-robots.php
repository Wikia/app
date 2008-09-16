<?php

/*
* This file produces equiualent of robots.txt for a given wiki
* Author Andrew Yasinsky andrewy at wikia dot com
*
*/

$wgDBadminuser = $wgDBadminpassword = $wgDBserver = $wgDBname = $wgEnableProfileInfo = false;

define( 'MW_NO_SETUP', 1 );
require_once( dirname(__FILE__) . '/includes/WebStart.php' );
require_once( dirname(__FILE__) . '/includes/Setup.php' );
require_once( dirname(__FILE__) . '/includes/StreamFile.php' );
require_once( dirname(__FILE__) . '/includes/SpecialPage.php' );
require_once( dirname(__FILE__) . '/languages/Language.php' );


header("Content-Type: text/plain");
header("Pragma: no-cache");
header("Expires: 0");
echo <<<EOT
#
# robots.txt for http://www.wikipedia.org/ and friends
#
# Please note: There are a lot of pages on this site, and there are
# some misbehaved spiders out there that go _way_ too fast. If you're
# irresponsible, your access to the site may be blocked.
#

# advertising-related bots:
User-agent: Mediapartners-Google*
Disallow: /

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

echo getDynamicRobots();
exit(0);

function getDynamicRobots(){
	global $wgOut, $wgCat, $wgLanguageNames, $wgContLang;
	$procCodes = array();
	
	$r = "\n";

		$r .= "User-agent: *\n";
		$r .= "Disallow: /w/\n";
		$r .= "Disallow: /trap/\n";
		$r .= "Disallow: /dbdumps/\n";
		$r .= "Disallow: /wikistats/\n";
		$r .= "Disallow: /wiki/*printable=yes*\n";
		$r .= "Disallow: /wiki/*feed=rss*\n";
		$r .= "Disallow: /wiki/*action=edit*\n";
		$r .= "Disallow: /wiki/*action=history*\n";
		$r .= "Disallow: /wiki/*action=delete*\n";
		$r .= "Disallow: /wiki/*action=watch*\n";
		
	    $lang = new Language();
		
		//process english first

		$code = $wgContLang->getCode();
		if($code!='en'){
			$r .= getLangSpecificNamespace( $lang, "en", $procCodes );			
		}
		
		if( trim( $code ) == ''){
 			return;
		}

		$r .= getLangSpecificNamespace( $lang, $code, $procCodes);
		
		$hostel = explode('.',$_SERVER['SERVER_NAME']);
		//delete tdlportion
		unset($hostel[count($hostel)-1]);
		unset($hostel[count($hostel)-1]);
		$r .= "# sitemap\n";
		$r .= 'Sitemap: http://' . $_SERVER['SERVER_NAME'] . '/' . "sitemap-index-" . implode('',$hostel) . ".xml"; 

	return $r;
}

function getLangSpecificNamespace( &$lang, $code, &$procCodes ){
 global $wgSpecialPages;
  
   $r = '';	
   
   //we only want new codes
   if( in_array( $code, $procCodes ) || ( $code == '' ) ){
   	return;
   }else{
   	 //is its fallback there
	 $fb = $lang->getFallbackFor( $code );
	 if( in_array( $fb, $procCodes ) ){
	   	$procCodes[] = $code;
		return;
	 }
   }
   
   //else lets get it
   
   $procCodes[] = $code;
   
   $rs = $lang->getLocalisationArray( $code ); //store em in memcache
   $ns = $rs['namespaceNames'];
  
   if( empty( $ns ) || ( $ns[NS_SPECIAL] == 'Special' ) && $code != 'en'){
   	if($code != 'en'){
     return;
	} 
   }
   
    $r .= "# " . $code . "\n" ;
	$r .= 'Disallow: /wiki/' . urlencode( $ns[NS_SPECIAL] )."*\n";
	$r .= 'Disallow: /wiki/' . urlencode( $ns[NS_HELP] )."*\n";
	$r .= 'Disallow: /wiki/' . urlencode( $ns[NS_HELP_TALK] )."*\n";
	$r .= 'Disallow: /wiki/' . urlencode( $ns[NS_TEMPLATE] )."*\n";
	$r .= 'Disallow: /wiki/' . urlencode( $ns[NS_TEMPLATE_TALK] )."*\n";
	
	return $r;
}
?>