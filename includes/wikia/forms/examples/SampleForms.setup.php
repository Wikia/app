<?php
/**
 * This includes a Wikia Forms usage example, include this file in your devbox setting in order to enable it
 *
 */

$dir = dirname( __FILE__ ) . '/';

global $wgSpecialPages, $wgAutoloadClasses, $wgExtensionMessagesFiles;

$wgAutoloadClasses['ExampleForm'] = $dir . 'ExampleForm.class.php';
$wgAutoloadClasses['ExampleFormController'] = $dir . 'ExampleFormController.class.php';

$wgSpecialPages['ExampleForm'] =  'ExampleFormController';

$wgExtensionMessagesFiles['ExampleForm'] = $dir . 'ExampleForm.i18n.php';
