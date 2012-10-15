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

// WikiaApp
$app = F::app();

// autoloaded classes
$app->registerClass('EmailsStorage', "$dir/EmailsStorage.class.php");
$app->registerClass('EmailsStorageEntry', "$dir/EmailsStorageEntry.class.php");
$app->registerClass('EmailsStorageSpecialController', "$dir/EmailsStorageSpecialController.php");
$app->registerSpecialPage('Emails', 'EmailsStorageSpecialController');

// i18n
$wgExtensionMessagesFiles['EmailsStorage'] = "$dir/EmailsStorage.i18n.php";

F::addClassConstructor('EmailsStorage', array('app' => $app));

// rights
$wgAvailableRights[] = 'emailsstorage';
$wgGroupPermissions['staff']['emailsstorage'] = true;
