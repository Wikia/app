<?php

/**
 * Special:DiscussionsLog
 */

$dir = dirname( __FILE__ ) . '/';

$wgExtensionCredits['specialpage'][] = [
	'name' => 'DiscussionsLog',
	'author' => 'Wikia',
	'descriptionmsg' => 'discussions-log-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/SpecialDiscussionsLog',
];

// classes
$wgAutoloadClasses['SpecialDiscussionsLogController'] = $dir . 'SpecialDiscussionsLogController.class.php';
$wgAutoloadClasses['SpecialDiscussionsLogHooks'] = $dir . 'SpecialDiscussionsLogHooks.class.php';
$wgAutoloadClasses['UserLogRecord'] = $dir . 'UserLogRecord.class.php';
$wgAutoloadClasses['Wikia\SpecialDiscussionsLog\Search\SearchQuery'] = $dir . 'search/SearchQuery.php';
$wgAutoloadClasses['Wikia\SpecialDiscussionsLog\Search\UserQuery'] = $dir . 'search/UserQuery.php';
$wgAutoloadClasses['Wikia\SpecialDiscussionsLog\Search\IpAddressQuery'] = $dir . 'search/IpAddressQuery.php';

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
$wgGroupPermissions['vstf']['specialdiscussionslog'] = true;
$wgGroupPermissions['helper']['specialdiscussionslog'] = true;

// resources Loader module
$wgResourceModules['ext.wikia.SpecialDiscussionsLog'] = [
	'scripts' => [
		'js/SpecialDiscussionsLog.js',
	],
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'wikia/SpecialDiscussionsLog'
];

