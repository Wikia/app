<?php

$dir = dirname(__FILE__) . '/';
$app = F::app();

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'WikiaStats',
	'author' => 'Bogna "bognix" Knychala',
	'description' => 'WikiaStats',
	'version' => 1.0
);

$wgAutoloadClasses['WikiaStatsController'] =  $dir . 'WikiaStatsController.class.php';
$wgAutoloadClasses['WikiaStatsModel'] =  $dir . 'WikiaStatsModel.class.php';

$wgExtensionMessagesFiles['WikiaStats'] = $dir . 'WikiaStats.i18n.php';
