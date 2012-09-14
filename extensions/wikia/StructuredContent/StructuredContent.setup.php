<?php

/**
 * setup
 */

$app = F::app();
$dir = dirname( __FILE__ );
$app->registerClass( 'StructuredContentController', $dir . '/StructuredContentController.class.php' );
$app->registerClass( 'StructuredContentHelper',	$dir . '/StructuredContentHelper.class.php' );


/**
 * messages
 */
$wgExtensionMessagesFiles['StructuredContent'] = "$dir/StructuredContent.i18n.php";
