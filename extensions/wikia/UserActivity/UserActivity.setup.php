<?php

/**
 * UserActivity
 *
 * Shows the current user's activity across all of Wikia
 *
 * @author Garth Webb
 * @author George Marbulcanti
 * @author Tim Quievryn
 */

$wgExtensionCredits['UserActivity'][] = [
	'name' => 'UserActivity',
	'author' => [
		'Garth Webb <garth@wikia-inc.com>',
		'George Marbulcanti <kirkburn@wikia-inc.com>',
		'Tim Quievryn <timq@wikia-inc.com>'
	],
	'descriptionmsg' => 'user-activity-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/UserActivity'
];

$dir = dirname( __FILE__ ) . '/';

/**
 * classes
 */
$wgAutoloadClasses['UserActivity\Controller'] =  $dir . 'UserActivityController.class.php';
$wgAutoloadClasses['UserActivity\SpecialController'] =  $dir . 'SpecialUserActivityController.class.php';

/**
 * special pages
 */
$wgSpecialPages['UserActivity'] = 'UserActivity\SpecialController';

/**
 * messages
 */
$wgExtensionMessagesFiles['UserActivity'] = $dir . 'UserActivity.i18n.php';
