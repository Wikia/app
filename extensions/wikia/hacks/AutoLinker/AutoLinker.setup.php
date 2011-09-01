<?php

/**
 * AutoLinker
 *
 * Additional rail module for the new editor creating links
 * in the currently edit article
 *
 * @author macbre
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     include("$IP/extensions/wikia/hacks/AutoLinker/AutoLinker.setup.php");
 */

$wgExtensionCredits['other'][] = array(
	'name' => 'Auto Linker',
	'version' => '0.1',
	'author' => 'Maciej Brencz',
);

$dir = dirname(__FILE__);

$app = F::app();

$app->registerClass('AutoLinker', "$dir/AutoLinker.class.php");
$app->registerClass('AutoLinkerController', "$dir/AutoLinkerController.class.php");

$app->registerHook('EditPageLayoutExecute', 'AutoLinker', 'onEditPageLayoutExecute');

// register messages package
$app->registerExtensionMessageFile('AutoLinker', $dir . '/AutoLinker.i18n.php');
F::build('JSMessages')->registerPackage('AutoLinker', array(
	'wikia-editor-modules-autolinker-*',
));