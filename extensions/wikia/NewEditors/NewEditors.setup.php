<?php
$wgExtensionCredits['api'][] = [
	'name' => 'New Editors',
	'description' => 'Implements API to list information about new editors who have edited the wiki recently',
	'descriptionmsg' => 'neweditors-desc',
	'version' => 1,
	'author' => 'TK-999',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/NewEditors',
];

$wgExtensionMessagesFiles['NewEditors'] = __DIR__ . '/NewEditors.i18n.php';

$wgAutoloadClasses['ApiQueryNewEditors'] = __DIR__ . '/api/ApiQueryNewEditors.php';

$wgAPIListModules['neweditors'] = 'ApiQueryNewEditors';

$wgHooks['RevisionInsertComplete'][] = 'NewEditorsHooks::onRevisionInsertComplete';

return true; // ...to the single purpose of the moment.
