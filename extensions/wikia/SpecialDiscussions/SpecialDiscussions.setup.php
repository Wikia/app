<?php

/**
 * Special:Discussions
 */

$wgExtensionCredits['specialpage'][] = [
	'name' => 'Discussions',
	'author' => 'Wikia',
	'descriptionmsg' => 'discussions-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/SpecialDiscussions',
];

// classes
$wgAutoloadClasses['SpecialDiscussionsController'] = __DIR__ . '/SpecialDiscussionsController.class.php';
$wgAutoloadClasses['SpecialDiscussionsHelper'] = __DIR__ . '/SpecialDiscussionsHelper.php';

// special page
$wgSpecialPages['Discussions'] = 'SpecialDiscussionsController';

// message files
$wgExtensionMessagesFiles['SpecialDiscussions'] = __DIR__ . '/SpecialDiscussions.i18n.php';

// permissions
$wgAvailableRights[] = 'specialdiscussions';
$wgGroupPermissions['*']['specialdiscussions'] = false;
$wgGroupPermissions['user']['specialdiscussions'] = false;
$wgGroupPermissions['vstf']['specialdiscussions'] = false;
$wgGroupPermissions['helper']['specialdiscussions'] = false;
$wgGroupPermissions['staff']['specialdiscussions'] = true;
