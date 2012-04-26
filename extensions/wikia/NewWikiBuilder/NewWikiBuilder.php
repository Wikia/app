<?php
if (!defined('MEDIAWIKI')) {
        echo "To install my extension, put the following line in LocalSettings.php:\n
require_once('" . __FILE__ . "');";
        exit(1);
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'NewWikiBuilder',
	'author' => 'Nick Sullivan',
	'description' => 'Wizard to walk new founders through the wiki setup process',
	'version' => '0.0.1',
);

// New user right, required to use the extension.
$wgAvailableRights[] = 'newwikibuilder';
$wgGroupPermissions['*']['newwikibuilder'] = false;
$wgGroupPermissions['sysop']['newwikibuilder'] = true;
$wgGroupPermissions['bureaucrat']['newwikibuilder'] = true;
$wgGroupPermissions['staff']['newwikibuilder'] = true;

$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['NewWikiBuilder'] = $dir . 'NewWikiBuilder.body.php';
$wgExtensionMessagesFiles['NewWikiBuilder'] = $dir . 'NewWikiBuilder.i18n.php';
$wgExtensionAliasesFiles['NewWikiBuilder'] = $dir . 'NewWikiBuilder.alias.php';
$wgSpecialPages['NewWikiBuilder'] = 'NewWikiBuilder';