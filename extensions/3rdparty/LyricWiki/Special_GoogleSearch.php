<?php
////
// Author: Sean Colombo
// Date: 20080719
//
// Special page to display the new integrated Google Site Search results.
////

// Extension Credits Definition
if(isset($wgScriptPath)){
	$wgExtensionCredits["specialpage"][] = array(
	  'name' => 'Google Search-Results',
	  'version' => '0.0.1',
	  'url' => 'http://lyrics.wikia.com/User:Sean_Colombo',
	  'author' => '[http://www.seancolombo.com Sean Colombo]',
	  'description' => 'Special page to display the results of a Google Site-Search.'
	);
}

# Alert the user that this is not a valid entry point to MediaWiki if they try to access the skin file directly.
if (!defined('MEDIAWIKI')) {
        echo <<<EOT
To install my extension, put the following line in LocalSettings.php:
require_once( "$IP/extensions/MyExtension/MyExtension.php" );
EOT;
        exit( 1 );
}

$dir = dirname(__FILE__) . '/';

$wgAutoloadClasses['GoogleSearchResults'] = $dir . 'Special_GoogleSearch.body.php'; # Tell MediaWiki to load the extension body.
$wgExtensionMessagesFiles['GoogleSearchResults'] = $dir . 'Special_GoogleSearch.i18n.php';
$wgSpecialPages['GoogleSearchResults'] = 'GoogleSearchResults'; # Let MediaWiki know about your new special page.

