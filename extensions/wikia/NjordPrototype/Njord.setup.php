<?php
/**
 * This extension handles Modular Main Pages
 * prototype
 */
$dir = dirname( __FILE__ );

/**
 * classes
 */

$wgAutoloadClasses['NjordHooks'] =  $dir . '/NjordHooks.class.php';
$wgAutoloadClasses['NjordModel'] =  $dir . '/models/NjordModel.class.php';
$wgAutoloadClasses['WikiDataModel'] =  $dir . '/models/WikiDataModel.class.php';

$wgHooks['ParserFirstCallInit'][] = 'NjordHooks::onParserFirstCallInit';
