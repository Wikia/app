<?php

/**
 * Adds support for MW messages in JS code
 *
 * Provides a way to register and use packages of messages in JavaScript via $.msg() function
 *
 * @see https://internal.wikia-inc.com/wiki/JSMessages
 * @author macbre
 */

$wgExtensionCredits['other'][] = array(
	'name' => 'JSMessages',
	'version' => '1.1',
	'author' => 'Maciej Brencz',
	'description' => 'Adds support for MW messages in JS code',
);

$dir = dirname(__FILE__);

// WikiaApp
$app = F::app();

// classes
$app->registerClass('JSMessages', $dir . '/JSMessages.class.php');
$app->registerClass('JSMessagesHelper', $dir . '/JSMessagesHelper.class.php');
$app->registerClass('JSMessagesController', $dir . '/JSMessagesController.class.php');

// hooks
$app->registerHook('WikiaSkinTopScripts', 'JSMessages', 'onWikiaSkinTopScripts');
$app->registerHook('MessageCacheReplace', 'JSMessagesHelper', 'onMessageCacheReplace');

// register instances
F::setInstance('JSMessages', new JSMessages());
F::setInstance('JSMessagesHelper', new JSMessagesHelper());
