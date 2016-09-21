<?php
/**
 * This extension is for the Special:Tasks page, and for the proxy executor.
 */
if (!defined('MEDIAWIKI')) {
	exit(1);
}

$wgExtensionCredits[ 'specialpage' ][ ] = array(
	'name' => 'Tasks',
	'author' => 'Wikia',
	'descriptionmsg' => 'tasks-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/Tasks',
);

$dir = __DIR__;

$wgAutoloadClasses['TasksModel'] = "$dir/TasksModel.class.php";
$wgAutoloadClasses['TasksSpecialController'] = "$dir/TasksSpecialController.class.php";

$wgSpecialPages['Tasks'] = 'TasksSpecialController';

$wgExtensionMessagesFiles['Tasks'] = "$dir/Tasks.i18n.php";