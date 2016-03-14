<?php

$dir = dirname(__FILE__) . '/';

$wgExtensionCredits[ 'other' ][ ] = array(
	'name' => 'UserRollback',
	'author' => 'Wikia',
	'descriptionmsg' => 'userrollback-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/UserRollback',
);

/**
 * controllers
 */
$wgAutoloadClasses['UserRollbackSpecialController'] =  $dir . 'UserRollbackSpecialController.class.php';
$wgAutoloadClasses['UserRollbackRequest'] =  $dir . 'UserRollbackRequest.class.php';
$wgAutoloadClasses['UserRollbackTask'] = $dir . 'UserRollbackTask.class.php';

/**
 * special pages
 */
$wgSpecialPages['UserRollback'] = 'UserRollbackSpecialController';

/**
 * message files
 */
$wgExtensionMessagesFiles['UserRollback'] = $dir . 'UserRollback.i18n.php';
