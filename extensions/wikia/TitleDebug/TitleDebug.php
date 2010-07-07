<?php
if (!defined('MEDIAWIKI')) {
	echo "This is a MediaWiki extension.\n";
	exit(1);
}

$wgExtensionCredits['specialpage'][] = array(
       'name' => 'wgTitle debugger',
       'author' => 'Chris \'Uberfuzzy\' Stafford', 
	   'version' => '0.1',
       'description' => 'helps you check which member function of wgTitle you need to use'
       );

$dir = dirname(__FILE__);

$wgSpecialPages['TitleDebug'] = 'TitleDebug'; # Let MediaWiki know about your new special page.
$wgAutoloadClasses['TitleDebug'] = $dir . '/TitleDebug.body.php'; # Tell MediaWiki to load the extension body.
$wgExtensionMessagesFiles['TitleDebug'] = $dir . '/TitleDebug.i18n.php';

$wgSpecialPageGroups['TitleDebug'] = 'other';
