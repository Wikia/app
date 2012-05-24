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
$app->registerClass('MediaToolController', $dir . 'MediaTool.class.php');

// hooks

// special pages
$app->registerClass('MediaToolSpecialController', $dir . 'MediaToolSpecialController.class.php');
$app->registerSpecialPage('MediaTool', 'MediaToolSpecialController');

// i18n mapping
$wgExtensionMessagesFiles['MediaTool'] = $dir . 'MediaTool.i18n.php';