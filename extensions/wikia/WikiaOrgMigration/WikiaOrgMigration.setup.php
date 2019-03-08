<?php
$wgExtensionCredits['other'][] = [
	'name' => 'WikiaOrgMigration Extension',
	'author' => [
		'Przemysław Czaus',
	],
	'description' => 'Display notification about the wikia.org migration, based on fandom.com extension',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/WikiaOrgMigration'
];

$wgAutoloadClasses['WikiaOrgMigrationHooks'] = __DIR__ . '/WikiaOrgMigrationHooks.class.php';

$wgHooks['BeforePageDisplay'][] = 'WikiaOrgMigrationHooks::onBeforePageDisplay';
$wgHooks['MercuryWikiVariables'][] = 'WikiaOrgMigrationHooks::onMercuryWikiVariables';
$wgHooks['OasisSkinAssetGroups'][] = 'WikiaOrgMigrationHooks::onOasisSkinAssetGroups';
$wgHooks['WikiaSkinTopScripts'][] = 'WikiaOrgMigrationHooks::onWikiaSkinTopScripts';

$wgExtensionMessagesFiles['WikiaOrgMigration'] = __DIR__ . '/WikiaOrgMigration.i18n.php';

$wgResourceModules['ext.WikiaOrgMigration'] = [
	'messages' => [
		'wikia-org-migration-after',
		'wikia-org-migration-before'
	]
];
