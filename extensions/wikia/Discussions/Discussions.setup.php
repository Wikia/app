<?php

/**
 * Discussions
 */

$wgExtensionCredits['specialpage'][] = [
	'name' => 'Discussions',
	'author' => 'Wikia',
	'descriptionmsg' => 'discussions-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/SpecialDiscussions',
];

// load classes
$wgAutoloadClasses['SpecialDiscussionsController'] = $dir . 'controllers/SpecialDiscussionsController.class.php';
$wgAutoloadClasses['EnableDiscussionsController'] = $dir . 'controllers/EnableDiscussionsController.class.php';
$wgAutoloadClasses['DiscussionsActivator'] = $dir . 'DiscussionsActivator.class.php';
$wgAutoloadClasses['DiscussionsVarToggler'] = $dir . 'DiscussionsVarToggler.class.php';
$wgAutoloadClasses['DiscussionsVarTogglerException'] = $dir . 'DiscussionsVarToggler.class.php';

// register special page
$wgSpecialPages['Discussions'] = 'SpecialDiscussionsController';

$wgExtensionMessagesFiles['SpecialDiscussions'] = $dir . 'i18n/SpecialDiscussions.i18n.php';

// permissions
$wgAvailableRights[] = 'specialdiscussions';
$wgGroupPermissions['*']['specialdiscussions'] = false;
$wgGroupPermissions['user']['specialdiscussions'] = false;
$wgGroupPermissions['vstf']['specialdiscussions'] = false;
$wgGroupPermissions['helper']['specialdiscussions'] = false;
$wgGroupPermissions['staff']['specialdiscussions'] = true;
