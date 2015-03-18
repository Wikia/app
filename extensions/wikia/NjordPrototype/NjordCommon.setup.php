<?php
/**
 * This setup provides backwards-compatibility in case Njord extension gets disabled
 * It should be always enabled regardless Njord extension is enabled or not
 * @see DAT-2583
 * prototype
 */
$dir = dirname( __FILE__ );

$wgAutoloadClasses['WikiDataModel'] =  $dir . '/models/WikiDataModel.class.php';
$wgHooks[ 'ParserFirstCallInit' ][ ] = 'NjordHooks::onParserFirstCallInit';
