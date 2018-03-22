<?php
$wgExtensionCredits['api'][] = [
	'name' => 'First Contributions',
	'description' => 'Implements API module to list first edits of new editors on a wiki',
	'descriptionmsg' => 'firstcontributions-desc',
	'version' => 1,
	'author' => 'Wikia',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/FirstContributions',
];

$wgExtensionMessagesFiles['FirstContributions'] = __DIR__ . '/FirstContributions.i18n.php';

$wgAutoloadClasses['ApiQueryFirstContributions'] = __DIR__ . '/api/ApiQueryFirstContributions.php';

$wgAPIListModules['firstcontributions'] = 'ApiQueryFirstContributions';
