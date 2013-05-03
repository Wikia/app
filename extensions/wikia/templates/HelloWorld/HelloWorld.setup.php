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
$wgAutoloadClasses['HelloWorld'] =  $dir . 'HelloWorld.class.php';

/**
 * hooks
 */
//$app->registerHook('OutputPageBeforeHTML', 'HelloWorld', 'onOutputPageBeforeHTML');

/**
 * controllers
 */
$wgAutoloadClasses['HelloWorldController'] =  $dir . 'HelloWorldController.class.php';
$wgAutoloadClasses['HelloWorldSpecialController'] =  $dir . 'HelloWorldSpecialController.class.php';

/**
 * special pages
 */
$wgSpecialPages['HelloWorld'] = 'HelloWorldSpecialController';

/**
 * message files
 */
$app->registerExtensionMessageFile('HelloWorld', $dir . 'HelloWorld.i18n.php');

/**
 * setup functions
 */
$app->registerExtensionFunction('wfExtensionInit');

function wfExtensionInit() {
	// place extension init stuff here
}
