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
$app->registerClass('DummyExtension', $dir . 'DummyExtension.class.php');
$app->registerClass('DummyExtensionSpecialPageController', $dir . 'DummyExtensionSpecialPageController.class.php');

/**
 * hooks
 */
//$app->registerHook('OutputPageBeforeHTML', 'DummyExtension', 'onOutputPageBeforeHTML');

/**
 * controllers
 */
$app->registerClass('DummyExtensionController', $dir . 'DummyExtensionController.class.php');

/**
 * special pages
 */
$app->registerSpecialPage('DummyExtension', 'DummyExtensionSpecialPageController');

/**
 * message files
 */
$app->registerExtensionMessageFile('DummyExtension', $dir . 'DummyExtension.i18n.php');

/**
 * setup functions
 */
//$app->registerExtensionFunction('wfDummyExtensionInit');

function wfDummyExtensionInit() {
	// place extension init stuff here
}
