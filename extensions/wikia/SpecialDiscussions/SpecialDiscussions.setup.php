<?php

/**
 * Special:Discussions
 */

$dir = dirname( __FILE__ ) . '/';

$wgExtensionCredits['specialpage'][] = [
	'name' => 'Discussions',
	'author' => 'Wikia',
	'descriptionmsg' => 'discussions-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/SpecialDiscussions',
];

// classes
$wgAutoloadClasses['SpecialDiscussionsController'] = $dir . 'SpecialDiscussionsController.class.php';
$wgAutoloadClasses['SpecialDiscussionsHooks'] = $dir . 'SpecialDiscussionsHooks.class.php';

// special page
$wgSpecialPages['Discussions'] = 'SpecialDiscussionsController';

// message files
$wgExtensionMessagesFiles['SpecialDiscussions'] = $dir . 'SpecialDiscussions.i18n.php';

// permissions
$wgAvailableRights[] = 'specialdiscussions';
$wgGroupPermissions['*']['specialdiscussions'] = false;
$wgGroupPermissions['user']['specialdiscussions'] = false;
$wgGroupPermissions['vstf']['specialdiscussions'] = false;
$wgGroupPermissions['helper']['specialdiscussions'] = false;
$wgGroupPermissions['staff']['specialdiscussions'] = true;
