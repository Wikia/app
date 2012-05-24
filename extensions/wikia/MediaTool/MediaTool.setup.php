<?php
/**
 * MediaTool setup
 *
 * @author mech
 *
 */ 
$dir = dirname(__FILE__) . '/';
$app = F::app();
//classes
$app->registerClass('MediaToolHelper', $dir . 'MediaToolHelper.class.php');
$app->registerClass('MediaToolController', $dir . 'MediaToolController.class.php');

// hooks

// i18n mapping
$wgExtensionMessagesFiles['MediaTool'] = $dir . 'MediaTool.i18n.php';