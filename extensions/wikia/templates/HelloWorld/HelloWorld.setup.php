<?php
/**
 * Example Extension setup file
 *
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia.com>
 *
 */

$dir = dirname(__FILE__) . '/';

/**
 * classes
 */
$wgAutoloadClasses['HelloWorld'] =  $dir . 'HelloWorld.class.php';

/**
 * hooks
 */
//$wgHooks['OutputPageBeforeHTML'][] = 'HelloWorld::onOutputPageBeforeHTML';

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
$wgExtensionMessagesFiles['HelloWorld'] = $dir . 'HelloWorld.i18n.php';

/**
 * setup functions
 */
$wgExtensionFunctions[] = 'wfExtensionInit';

function wfExtensionInit() {
	// place extension init stuff here
}
