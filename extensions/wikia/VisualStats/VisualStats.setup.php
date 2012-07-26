<?php

$app = F::app();
$dir = dirname(__FILE__) . '/';

$wgExtensionCredits['specialpage'][] = array(
    'path' => __FILE__,
    'name' => '[[Special:VisualStats|VisualStats]]',
    'author' => 'Piotr Ożga',
    'descriptionmsg' => 'visualStats-desc'
);

$wgExtensionMessagesFiles['VisualStatsAliases'] = $dir . 'VisualStats.alias.php';

$app->registerClass('VisualStats', $dir . 'VisualStats.class.php');
$app->registerClass('VisualStatsSpecialController', $dir . 'VisualStatsSpecialController.class.php');
$app->registerSpecialPage('VisualStats', 'VisualStatsSpecialController');
$app->registerExtensionMessageFile('VisualStats', $dir . 'VisualStats.i18n.php');