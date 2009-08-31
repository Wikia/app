<?php
/**********************************************************************************

Copyright (C) 2008 Bradley Pesicka (teknomunk@bluebottle.com)

Tested on
# MediaWiki: 1.7.1,1.11.1
# PHP: 5.0.5-2ubuntu1.5 (apache2handler)
# MySQL: 4.0.24_Debian-10ubuntu2.3-log

Developed for use by LryicWiki.org (http://www.lyricwiki.org/)

***********************************************************************************

Version 0.3 2008-04-13
* Bugfix: Encode HTML entities inside of hidden form inputs

Version 0.1	2008-??-??
* Created - teknomunk

*/

// Extension Credits Definition
if(isset($wgScriptPath)){
	$wgExtensionCredits["specialpage"][] = array(
	  'name' => 'Wikify',
	  'version' => '0.0.3',
	  'url' => 'http://lyricwiki.org/User:Sean_Colombo',
	  'author' => '[http://lyricwiki.org/User:Sean_Colombo Sean Colombo], [http://lyricwiki.org/User:Teknomunk teknomunk]',
	  'description' => 'Convert common album listing formats to LyricWiki format.'
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

$wgAutoloadClasses['Wikify'] = $dir . 'Special_Wikify.body.php'; # Tell MediaWiki to load the extension body.
$wgExtensionMessagesFiles['Wikify'] = $dir . 'Special_Wikify.i18n.php';
$wgSpecialPages['Wikify'] = 'Wikify'; # Let MediaWiki know about your new special page.

?>