<?php

/**
 * setup
 */

$app = F::app();
$dir = dirname( __FILE__ );
$wgAutoloadClasses[ 'StructuredContentController'] =  $dir . '/StructuredContentController.class.php' ;
$wgAutoloadClasses[ 'StructuredContentHelper'] = 	$dir . '/StructuredContentHelper.class.php' ;


/**
 * messages
 */
$wgExtensionMessagesFiles['StructuredContent'] = "$dir/StructuredContent.i18n.php";
