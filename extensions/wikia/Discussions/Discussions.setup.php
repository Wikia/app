<?php

/**
 * Discussions
 */

$dir = dirname( __FILE__ ) . '/';

$wgExtensionCredits['specialpage'][] = [
	'name' => 'Discussions',
	'author' => 'Wikia',
	'descriptionmsg' => 'discussions-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/SpecialDiscussions',
];

// load classes
$wgAutoloadClasses['SpecialDiscussionsController'] = $dir . 'controllers/SpecialDiscussionsController.class.php';
$wgAutoloadClasses['EnableDiscussionsController'] = $dir . 'controllers/EnableDiscussionsController.class.php';
$wgAutoloadClasses['DiscussionsApi'] = $dir . 'utils/DiscussionsApi.class.php';
$wgAutoloadClasses['DiscussionsVarToggler'] = $dir . 'utils/DiscussionsVarToggler.class.php';
$wgAutoloadClasses['DiscussionsVarTogglerException'] = $dir . 'utils/DiscussionsVarToggler.class.php';

// register special page
$wgSpecialPages['Discussions'] = 'SpecialDiscussionsController';

// message files
$wgExtensionMessagesFiles['SpecialDiscussions'] = $dir . 'i18n/SpecialDiscussions.i18n.php';

// permissions
$wgAvailableRights[] = 'specialdiscussions';
$wgGroupPermissions['*']['specialdiscussions'] = false;
$wgGroupPermissions['user']['specialdiscussions'] = false;
$wgGroupPermissions['vstf']['specialdiscussions'] = false;
$wgGroupPermissions['helper']['specialdiscussions'] = false;
$wgGroupPermissions['staff']['specialdiscussions'] = true;
