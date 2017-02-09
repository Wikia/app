<?php
$wgExtensionCredits['api'][] = [
	'name' => 'First Edits API',
	'description' => 'API module to list users\' first edits on a wiki, including date, diff id and user name',
	'descriptionmsg' => 'apifirstedits-desc',
	'version' => 1,
	'author' => 'TK-999',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/ApiFirstEdits',
];

$wgExtensionMessagesFiles['ApiFirstEdits'] = __DIR__ . '/ApiFirstEdits.i18n.php';

$wgAutoloadClasses['ApiQueryFirstEdits'] = __DIR__ . '/ApiQueryFirstEdits.php';

$wgAPIListModules['firstedits'] = 'ApiQueryFirstEdits';

return true; // ...to the single purpose of the moment.
