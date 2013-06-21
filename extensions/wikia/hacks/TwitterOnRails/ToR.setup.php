<?php
/**
 * TwitterOnRails - Twitter Feed inside Oasis left rail module
 *
 * @author ADi
 */

$dir = dirname(__FILE__) . '/';
/* @var $app WikiaApp */
$app = F::app();

/**
 * classes
 */
$wgAutoloadClasses['ToRController'] =  $dir . 'ToRController.class.php';


/**
 * message files
 */
$app->registerExtensionMessageFile('ToR', $dir . 'ToR.i18n.php' );

/**
 * hooks
 */
$app->registerHook( 'GetRailModuleList', 'ToRModule', 'onGetRailModuleList' );
$app->registerHook( 'ParserFirstCallInit', 'ToRModule', 'onParserFirstCallInit' );
