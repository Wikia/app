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

/**
 * special pages
 */
$app->registerSpecialPage('Tracker', 'AccountCreationTrackerController');

/**
 * hooks
 */
$app->registerHook('AddNewAccount', 'AccountCreationTrackerController', 'onAddNewAccount');

/**
 * message files
 */
$app->registerExtensionMessageFile('ACT', $dir . 'ACT.i18n.php' );
