<?php
if (!defined('MEDIAWIKI')) {
	echo "This is a MediaWiki extension.\n";
	exit(1);
}


$wgExtensionCredits['specialpage'][] = array(
       'name' => 'Sitenotice Center',
       'author' => 'Chris \'Uberfuzzy\' Stafford  <uberfuzzy@wikia.com>', 
	   'version' => '1.0',
       #'url' => 'http://wikia.com/wiki/User:Uberfuzzy', 
       'description' => 'Provides easy access to pages controling Sitenotice and allows users to undismiss a message'
       );

$dir = dirname(__FILE__);

$wgAutoloadClasses['SitenoticeCenter']        = $dir . '/sitenotice.body.php'; # Tell MediaWiki to load the extension body.
$wgExtensionMessagesFiles['SitenoticeCenter'] = $dir . '/sitenotice.i18n.php';
$wgExtensionAliasesFiles['SitenoticeCenter']  = $dir . '/sitenotice.alias.php';
$wgSpecialPages['SitenoticeCenter'] = 'SitenoticeCenter'; # Let MediaWiki know about your new special page.

$wgSpecialPageGroups['SitenoticeCenter'] = 'other';
