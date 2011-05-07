<?php
/**
 * Example Extension setup file
 *
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia.com>
 *
 */

$app = F::app();
$dir = dirname(__FILE__) . '/';

/**
 * classes
 */
$app->registerClass('Extension', $dir . 'Extension.class.php');
$app->registerClass('ExtensionController', $dir . 'ExtensionController.class.php');

/**
 * hooks
 */
//$app->registerHook('OutputPageBeforeHTML', 'Extension', 'onOutputPageBeforeHTML');

/**
 * controllers
 */
$app->registerClass('ExtensionController', $dir . 'ExtensionController.class.php');

/**
 * special pages
 */
$app->registerSpecialPage('Extension', 'ExtensionController');

/**
 * message files
 */
$app->registerExtensionMessageFile('Extension', $dir . 'Extension.i18n.php');

/**
 * setup functions
 */
$app->registerExtensionFunction('wfExtensionInit');

function wfExtensionInit() {
	// place extension init stuff here
}
