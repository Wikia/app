<?php

$dir = dirname(__FILE__) . '/';
$app = F::app();

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'WikiaStats',
	'author' => 'Bogna "bognix" Knychala',
	'descriptionmsg' => 'wikiastats-desc',
	'version' => 1.0,
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/WikiaStats'
);

$wgAutoloadClasses['WikiaStatsController'] =  $dir . 'WikiaStatsController.class.php';
$wgAutoloadClasses['WikiaStatsModel'] =  $dir . 'WikiaStatsModel.class.php';

