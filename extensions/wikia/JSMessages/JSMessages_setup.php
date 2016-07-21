<?php

/**
 * Adds support for MW messages in JS code
 *
 * Provides a way to register and use packages of messages in JavaScript via $.msg() function
 *
 * @see https://internal.wikia-inc.com/wiki/JSMessages
 * @author macbre
 */

$wgExtensionCredits['other'][] = [
	'name'           => 'JSMessages',
	'version'        => '2.0',
	'author'         => 'Maciej Brencz',
	'descriptionmsg' => 'jsmessages-desc',
	'url'            => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/JSMessages',
];

//i18n
$wgExtensionMessagesFiles['JSMessages'] = __DIR__ . '/JSMessages.i18n.php';

// classes
$wgAutoloadClasses['JSMessages'] = __DIR__ . '/JSMessages.class.php';
$wgAutoloadClasses['JSMessagesHelper'] = __DIR__ . '/JSMessagesHelper.class.php';
$wgAutoloadClasses['JSMessagesController'] = __DIR__ . '/JSMessagesController.class.php';

// hooks
$wgHooks['MessageCacheReplace']          [] = 'JSMessagesHelper::onMessageCacheReplace';
$wgHooks['ResourceLoaderRegisterModules'][] = 'JSMessages::onResourceLoaderRegisterModules';
$wgHooks['BeforePageDisplay']            [] = 'JSMessages::onBeforePageDisplay';

$wgExtensionFunctions[] = function () {
	// This has to be wrapped in a function so it isn't run before we include GlobalSettings.php
	JSMessages::registerPackage( "ConfirmModal", [
		'ok',
		'cancel',
	] );
	JSMessages::enqueuePackage( "ConfirmModal", JSMessages::EXTERNAL ); // We need this to ensure the messages are loaded on every page
};
