<?php
$app = F::app();
$dir = dirname(__FILE__) . '/';

$app->registerClass('NewbieExRailController', $dir . 'NewbieExRailController.class.php');
$app->registerClass('NewbieExRailHelper', $dir . 'NewbieExRailHelper.php');
// $app->registerHook('GetRailModuleList', 'NewbieExRailHelper', 'onGetRailModuleList');
$wgHooks['GetRailModuleList'][] = 'NewbieExRailHelper::onGetRailModuleList';
$app->registerExtensionMessageFile('NewbieExRail', $dir . 'NewbieExRail.i18n.php');

