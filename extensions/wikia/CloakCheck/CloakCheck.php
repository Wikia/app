<?php
if (!defined('MEDIAWIKI')) {
	echo "This is a MediaWiki extension.\n";
	exit(1);
}

$dir = dirname(__FILE__);

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'IRC CloakCheck',
	'author' => 'Chris \'Uberfuzzy\' Stafford',
	'version' => '1.1 (Summer 2011)',
	'description' => 'cloakcheck-desc'
);

$wgAutoloadClasses['CloakCheck'] = $dir . '/CloakCheck.body.php'; # Tell MediaWiki to load the extension body.
$wgExtensionMessagesFiles['CloakCheck'] = $dir . '/CloakCheck.i18n.php';
$wgExtensionMessagesFiles['CloakCheckAliases'] = $dir . '/CloakCheck.alias.php';
$wgSpecialPages['CloakCheck'] = 'CloakCheck'; # Let MediaWiki know about your new special page.

$wgSpecialPageGroups['CloakCheck'] = 'users';

// New user right, required to use the extension.
$wgAvailableRights[] = 'cloakcheck';
$wgGroupPermissions['*']['cloakcheck'] = false;
$wgGroupPermissions['staff']['cloakcheck'] = true;
