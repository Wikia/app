<?php
/**
 * Sailthru Extension
 * For interaction with the Sailthru API
 *
 * @author Matt K <mattk@fandom.com>
 */

$dir = __DIR__ . '/';

// Autoload
$wgAutoloadClasses['SailthruGateway'] = $dir . 'SailthruGateway.class.php';
$wgAutoloadClasses['SailthruHooks'] = $dir . 'SailthruHooks.class.php';

// Hooks
$wgHooks['AddNewAccount'][] = 'SailthruHooks::onAddNewAccount';
$wgHooks['CloseAccount'][] = 'SailthruHooks::onCloseAccount';
$wgHooks['ReactivateAccount'][] = 'SailthruHooks::onReactivateAccount';
$wgHooks['RtbfGlobalDataRemovalStart'][] = 'SailthruHooks::onRtbfGlobalDataRemovalStart';
$wgHooks['UserRenamed'][] = 'SailthruHooks::onUserRenamed';
$wgHooks['UserSaveSettings'][] = 'SailthruHooks::onUserSaveSettings';
