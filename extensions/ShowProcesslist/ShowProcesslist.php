<?php
# Not a valid entry point, skip unless MEDIAWIKI is defined
if (!defined('MEDIAWIKI')) {
	echo "This file is part of MediaWiki, it is not a valid entry point.\n";
	exit( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
	'name'           => 'ShowProcesslist',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:Show_Process_List',
	'author'         => 'Brion VIBBER',
	'svn-date'       => '$LastChangedDate: 2008-08-15 22:01:48 +0200 (ptk, 15 sie 2008) $',
	'svn-revision'   => '$LastChangedRevision: 39430 $',
	'description'    => 'Display the output of SHOW FULL PROCESSLIST',
	'descriptionmsg' => 'showprocesslist-desc',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['ShowProcesslist'] = $dir . 'ShowProcesslist.i18n.php';
$wgExtensionAliasesFiles['ShowProcesslist'] = $dir . 'ShowProcesslist.alias.php';
$wgAutoloadClasses['SpecialShowProcesslist'] = $dir . 'ShowProcesslist_body.php';
$wgSpecialPages['ShowProcesslist'] = 'SpecialShowProcesslist';
