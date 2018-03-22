<?php
$wgExtensionCredits['other'][] = [
	'name' => 'Facebook Preferences',
	'author' => 'Wikia, Inc.',
	'descriptionmsg' => 'fbconnect-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/FacebookPreferences',
];

$wgExtensionMessagesFiles['FacebookPreferences'] = __DIR__ . '/FacebookPreferences.i18n.php';

$wgAutoloadClasses['FacebookPreferencesController'] = __DIR__ . '/FacebookPreferencesController.php';
$wgAutoloadClasses['FacebookPreferencesModuleService'] = __DIR__ . '/FacebookPreferencesModuleService.php';
$wgAutoloadClasses['FacebookPreferencesHooks'] = __DIR__ . '/FacebookPreferencesHooks.php';

$wgHooks['GetPreferences'][] = 'FacebookPreferencesHooks::onGetPreferences';

$wgResourceModules['ext.wikia.facebookPreferences'] = [
	'scripts' => [
		'modules/ext.wikia.facebookPreferences.js',
	],
	'styles' => [
		'modules/ext.wikia.facebookPreferences.css',
	],
	'messages' => [
		'fbconnect-preferences-connected',
		'fbconnect-preferences-connected-error',
		'fbconnect-disconnect-info',
		'fbconnect-unknown-error',
		'fbconnect-error-fb-account-in-use',
	],
	
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'wikia/FacebookPreferences',
];
