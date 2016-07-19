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
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/EmailsStorage'
);

$dir = dirname(__FILE__);

// autoloaded classes
$wgAutoloadClasses['EmailsStorage'] =  "$dir/EmailsStorage.class.php";
$wgAutoloadClasses['EmailsStorageEntry'] =  "$dir/EmailsStorageEntry.class.php";
$wgAutoloadClasses['EmailsStorageSpecialController'] =  "$dir/EmailsStorageSpecialController.php";
$wgSpecialPages['Emails'] = 'EmailsStorageSpecialController';

// i18n
$wgExtensionMessagesFiles['EmailsStorage'] = "$dir/EmailsStorage.i18n.php";
