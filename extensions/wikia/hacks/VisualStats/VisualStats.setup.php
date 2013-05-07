<?php

$dir = dirname(__FILE__) . '/';

$wgExtensionCredits['specialpage'][] = array(
    'path' => __FILE__,
    'name' => '[[Special:VisualStats|VisualStats]]',
    'author' => 'Piotr Ożga',
    'descriptionmsg' => 'visualStats-desc'
);

$wgExtensionMessagesFiles['VisualStatsAliases'] = $dir . 'VisualStats.alias.php';

$wgAutoloadClasses['VisualStats'] =  $dir . 'VisualStats.class.php';
$wgAutoloadClasses['VisualStatsSpecialController'] =  $dir . 'VisualStatsSpecialController.class.php';
$wgSpecialPages['VisualStats'] = 'VisualStatsSpecialController';
$wgExtensionMessagesFiles['VisualStats'] = $dir . 'VisualStats.i18n.php';