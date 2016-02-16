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
$wgAutoloadClasses['UserLogRecord'] = $dir . 'UserLogRecord.class.php';

// special page
$wgSpecialPages['DiscussionsLog'] = 'SpecialDiscussionsLogController';

// message files
$wgExtensionMessagesFiles['SpecialDiscussionsLog'] = $dir . 'SpecialDiscussionsLog.i18n.php';

