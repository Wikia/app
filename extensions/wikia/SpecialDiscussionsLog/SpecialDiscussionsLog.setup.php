<?php

/**
 * Special:DiscussionsLog
 */

$dir = dirname( __FILE__ ) . '/';

$wgExtensionCredits['specialpage'][] = [
	'name' => 'DiscussionsLog',
	'author' => 'Wikia',
	'descriptionmsg' => 'discussionslog-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/SpecialDiscussionsLog',
];

// classes
$wgAutoloadClasses['SpecialDiscussionsLogController'] = $dir . 'SpecialDiscussionsLogController.class.php';
$wgAutoloadClasses['SpecialDiscussionsLogHooks'] = $dir . 'SpecialDiscussionsLogHooks.class.php';

// hooks
$wgHooks['ContributionsToolLinks'][] = 'SpecialDiscussionsLogHooks::onContributionsToolLinks';

// special page
$wgSpecialPages['DiscussionsLog'] = 'SpecialDiscussionsLogController';

// message files
$wgExtensionMessagesFiles['SpecialDiscussionsLog'] = $dir . 'SpecialDiscussionsLog.i18n.php';

// permissions
$wgAvailableRights[] = 'specialdiscussionslog';
$wgGroupPermissions['*']['specialdiscussionslog'] = false;
$wgGroupPermissions['user']['specialdiscussionslog'] = false;
$wgGroupPermissions['staff']['specialdiscussionslog'] = true;
$wgGroupPermissions['soap']['specialdiscussionslog'] = true;
$wgGroupPermissions['helper']['specialdiscussionslog'] = true;
$wgGroupPermissions['wiki-manager']['specialdiscussionslog'] = true;
