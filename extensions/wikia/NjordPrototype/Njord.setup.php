<?php
/**
 * Created by adam
 * Date: 02.09.14
 */
$dir = dirname( __FILE__ );

/**
 * classes
 */

$wgAutoloadClasses['NjordHooks'] =  $dir . '/NjordHooks.class.php';
$wgAutoloadClasses['NjordModel'] =  $dir . '/NjordModel.class.php';

$wgHooks['ParserFirstCallInit'][] = 'NjordHooks::onParserFirstCallInit';