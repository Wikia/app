<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die( 1 );

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'CorporatePageStatistic',
	'author' => 'Tomasz Odrobny',
	'url' => '',
	'description' => 'statistic provider and collector for global page for wikia.com',
	'descriptionmsg' => 'myextension-desc',
	'version' => '1.0.0',
);

$dir = dirname(__FILE__) . '/';

$wgAutoloadClasses['HomePageStatisticCollector'] = $dir . 'HomePageStatisticCollector.class.php';
$wgAutoloadClasses['HomePageMemAdapter']  = $dir . 'HomePageMemAdapter.class.php';
$wgAutoloadClasses['HomePageStatistic']  = $dir . 'HomePageStatistic.class.php';
$wgHooks['ArticleSaveComplete'][] = 'HomePageStatisticCollector::articleCountPagesAddedInLastHour';