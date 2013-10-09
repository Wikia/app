<?php
/**
 * This includes a few Wikia Forms usage examples, include this file in your devbox setting in order to enable them
 *
 */

$dir = dirname( __FILE__ ) . '/';

global $wgSpecialPages, $wgAutoloadClasses;

$wgAutoloadClasses['ExampleForm'] = $dir . 'ExampleForm.class.php';
$wgAutoloadClasses['ExampleController'] = $dir . 'ExampleController.class.php';

$wgSpecialPages['Example'] =  'ExampleController';
