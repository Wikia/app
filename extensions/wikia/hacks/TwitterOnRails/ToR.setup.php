<?php
/**
 * TwitterOnRails - Twitter Feed inside Oasis left rail module
 *
 * @author ADi
 */

$dir = dirname(__FILE__) . '/';
/* @var $app WikiaApp */
$app = F::build('App');

/**
 * classes
 */
$app->registerClass('ToRModule', $dir . 'ToRModule.class.php');

/**
 * Factory config
 */
F::addClassConstructor( 'ToRModule', array( 'app' => $app ) );

/**
 * message files
 */
$app->registerExtensionMessageFile('ToR', $dir . 'ToR.i18n.php' );

/**
 * hooks
 */
$app->registerHook( 'GetRailModuleList', 'ToRModule', 'onGetRailModuleList' );
$app->registerHook( 'ParserFirstCallInit', 'ToRModule', 'onParserFirstCallInit' );
