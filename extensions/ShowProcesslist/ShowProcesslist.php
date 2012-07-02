<?php
# Not a valid entry point, skip unless MEDIAWIKI is defined
if (!defined('MEDIAWIKI')) {
	echo "This file is part of MediaWiki, it is not a valid entry point.\n";
	exit( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
	'path'           => __FILE__,
	'name'           => 'ShowProcesslist',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:ShowProcesslist',
	'author'         => 'Tim Starling',
	'descriptionmsg' => 'showprocesslist-desc',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['ShowProcesslist'] = $dir . 'ShowProcesslist.i18n.php';
$wgExtensionMessagesFiles['ShowProcesslistAlias'] = $dir . 'ShowProcesslist.alias.php';
$wgAutoloadClasses['SpecialShowProcesslist'] = $dir . 'ShowProcesslist_body.php';
$wgSpecialPages['ShowProcesslist'] = 'SpecialShowProcesslist';
