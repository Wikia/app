<?php

/**
 * Emails storage
 *
 * Provides storage for user emails for various engagement projects
 */

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Emails storage',
	'version' => '1.0',
	'author' => 'Maciej Brencz',
	'descriptionmsg' => 'emailsstorage-desc',
);

$dir = dirname(__FILE__);

// autoloaded classes
$wgAutoloadClasses['EmailsStorage'] =  "$dir/EmailsStorage.class.php";
$wgAutoloadClasses['EmailsStorageEntry'] =  "$dir/EmailsStorageEntry.class.php";
$wgAutoloadClasses['EmailsStorageSpecialController'] =  "$dir/EmailsStorageSpecialController.php";
$wgSpecialPages['Emails'] = 'EmailsStorageSpecialController';

// i18n
$wgExtensionMessagesFiles['EmailsStorage'] = "$dir/EmailsStorage.i18n.php";

// rights
$wgAvailableRights[] = 'emailsstorage';
$wgGroupPermissions['staff']['emailsstorage'] = true;
