<?php
$wgExtensionCredits['api'][] = [
	'name' => 'New Editors',
	'description' => 'Implements API module and special page to list first edits of new editors on a wiki',
	'descriptionmsg' => 'neweditors-desc',
	'version' => 1,
	'author' => 'TK-999',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/NewEditors',
];

$wgExtensionMessagesFiles['NewEditors'] = __DIR__ . '/NewEditors.i18n.php';

$wgAutoloadClasses['ApiQueryNewEditors'] = __DIR__ . '/api/ApiQueryNewEditors.php';
$wgAutoloadClasses['SpecialNewEditors'] = __DIR__ . '/SpecialNewEditors.php';

$wgAPIListModules['neweditors'] = 'ApiQueryNewEditors';

$wgSpecialPages['NewEditors'] = 'SpecialNewEditors';

return true; // ...to the single purpose of the moment.
