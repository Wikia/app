<?php
if (!defined('MEDIAWIKI')) {
	echo "This is a MediaWiki extension.\n";
	exit(1);
}

$dir = dirname(__FILE__);

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'IRC CloakCheck',
	'author' => 'Chris \'Uberfuzzy\' Stafford',
	'version' => '1.0 (fall 2010)',
	'description' => 'cloakcheck-desc'
);

$wgAutoloadClasses['CloakCheck'] = $dir . '/CloakCheck.body.php'; # Tell MediaWiki to load the extension body.
$wgExtensionMessagesFiles['CloakCheck'] = $dir . '/CloakCheck.i18n.php';
$wgExtensionAliasesFiles['CloakCheck'] = $dir . '/CloakCheck.alias.php';
$wgSpecialPages['CloakCheck'] = 'CloakCheck'; # Let MediaWiki know about your new special page.

$wgSpecialPageGroups['CloakCheck'] = 'users';
