<?php
$wgExtensionCredits['other'][] = [
	'name' => 'FandomComMigration Extension',
	'author' => [
		'Igor Rogatty',
	],
	'description' => 'Display notification about the fandom.com migration',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/FandomComMigration'
];

$wgAutoloadClasses['FandomComMigrationHooks'] = __DIR__ . '/FandomComMigrationHooks.class.php';

$wgHooks['BeforePageDisplay'][] = 'FandomComMigrationHooks::onBeforePageDisplay';
$wgHooks['MercuryWikiVariables'][] = 'FandomComMigrationHooks::onMercuryWikiVariables';
$wgHooks['OasisSkinAssetGroups'][] = 'FandomComMigrationHooks::onOasisSkinAssetGroups';
$wgHooks['WikiaSkinTopScripts'][] = 'FandomComMigrationHooks::onWikiaSkinTopScripts';

$wgExtensionMessagesFiles['FandomComMigration'] = __DIR__ . '/FandomComMigration.i18n.php';

$wgResourceModules['ext.fandomComMigration'] = [
	'messages' => [
		'fandom-com-migration-after',
		'fandom-com-migration-before',
		'fandom-ucp-migration-before',
		'ucp-migration-banner-fandom-message-scheduled-fandom-wikis',
		'ucp-migration-banner-fandom-message-complete'
	]
];
