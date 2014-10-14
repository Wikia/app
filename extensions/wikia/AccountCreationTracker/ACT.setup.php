<?php
/**
 * Account Creation Tracker
 *
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia.com>
 */


$app = F::app();
$dir = dirname(__FILE__) . '/';

/**
 * classes
 */
$app->registerClass('AccountCreationTracker', $dir . 'ACT.class.php');
$app->registerClass('AccountCreationTrackerController', $dir . 'ACTController.class.php');
$app->registerClass('AccountCreationTrackerExternalController', $dir . 'ACTExternalController.class.php');

/**
 * special pages
 */
$app->registerSpecialPage('Tracker', 'AccountCreationTrackerController');

/**
 * hooks
 */
$app->registerHook('AddNewAccount', 'AccountCreationTrackerController', 'onAddNewAccount');
$app->registerHook('UserLoginComplete', 'AccountCreationTrackerController', 'onUserLoginComplete');

/**
 * message files
 */
$app->registerExtensionMessageFile('ACT', $dir . 'ACT.i18n.php' );

/**
 * rights
 */
$wgAvailableRights[] = 'accounttracker';
$wgGroupPermissions['*']['accounttracker'] = false;
$wgGroupPermissions['util']['accounttracker'] = true;

$wgAvailableRights[] = 'rollbacknuke';
$wgGroupPermissions['*']['rollbacknuke'] = false;
$wgGroupPermissions['staff']['rollbacknuke'] = true;
