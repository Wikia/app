<?php
/**********************************************************************************
Copyright (C) 2007-08 Sean Colombo (sean@lyricwiki.org)
Copyright (C) 2008 Bradley Pesicka (teknomunk@bluebottle.com)

Tested on
# MediaWiki: 1.7.1, 1.11.1
# PHP: 5.0.5-2ubuntu1.5 (apache2handler)
# MySQL: 4.0.24_Debian-10ubuntu2.3-log

Developed for use by LyricWiki (http://lyrics.wikia.com/)


Does the processing for sending mail messages containing links to a LyricWiki page.

Database: 
	To make the 'map' table, please run the following mySQL statement:
	CREATE TABLE map (keyName VARCHAR(255), value VARCHAR(255), PRIMARY KEY(keyName));
	(if the above line doesn't work you might have to change this code to use 'val' instead
	of 'value' for older versions of mySQL.)

Messages:
	Update the system staf-* messages as needed.

***********************************************************************************

Version 0.2.3	2008-04-13
* Bugfix: Encode HTML entities inside of hidden form inputs

Version 0.2.2	2008-03-31
* BUGFIX: links sent in the email were not being created correctly - teknomunk

Version 0.2.1	2008-03-13
* BUGFIX: would not send email because the send function was looking in the wrong place for the page name - teknomunk

Version 0.2.0	2008-03-03
* BUGFIX: found a hook to add the box to the page
* Rewritten as a SpecialPage		- teknomunk

Version 0.1.2	2007-04-18
* BUGFIX: Fixed errors with poorly encoded urls (eg: pages with apostrophes in the title didn't work correctly).

Version 0.1.1	2007-04-04
* BUGFIX: Fixed a vulnerability which let spammers send multiple messages at once (with their spam in the message). - Sean Colombo

Version 0.1.0
* Initial Coding		- Sean Colombo

*/

require_once "extras.php";

/********************************** Configuration **********************************/

$wgNoMailFunc = false;
$wgPlainTextEmails = true;
/***********************************************************************************/

$wgHooks['SiteNoticeAfter'][] = array("lwSendToAFriend");

function lwSendToAFriend( $siteNotice )
{
	global $wgTitle;

	// TODO: Get the button to display correctly in FireFox, then use this instead of the code in Monobook.php.
	/*
	// Trying it back on all namespaces again.  It makes most sense on NS_MAIN, but might be confusing to users who might not be able to figure out why the button is on some pages and not others.
	//if( $wgTitle->getNamespace() == NS_MAIN )
	//{
		$title = Title::newFromText( "Special:SendToAFriend/".$wgTitle->getText() );
		
		$msg = wfMsg("staf-box",$title->getFullURL());
		if( strpos($msg,"staf-box") === FALSE )
		{
			$siteNotice = $siteNotice.$msg;
		};
	//}
	*/
	return true;
}

// Extension Credits Definition
if(isset($wgScriptPath)){
	$wgExtensionCredits["specialpage"][] = array(
	  'name' => 'Send to a Friend',
	  'version' => '0.2.4',
	  'url' => 'http://lyrics.wikia.com/User:Sean_Colombo',
	  'author' => '[http://www.seancolombo.com Sean Colombo], [http://lyrics.wikia.com/User:Teknomunk teknomunk]',
	  'description' => 'Send links to a friend in the body of an email.'
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

$wgAutoloadClasses['SendToAFriend'] = $dir . 'Special_SendToAFriend.body.php'; # Tell MediaWiki to load the extension body.
$wgExtensionMessagesFiles['SendToAFriend'] = $dir . 'Special_SendToAFriend.i18n.php';
$wgSpecialPages['SendToAFriend'] = 'SendToAFriend'; # Let MediaWiki know about your new special page.

