<?php

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Image Review',
	'authors' => array(
		'[http://www.wikia.com/wiki/User:OwenDavis Owen Davis]',
		'[http://www.wikia.com/wiki/User:TomekO Tomasz Odrobny]',
		'Saipetch Kongkatong',
		"[http://www.wikia.com/wiki/User:Macbre Maciej 'Macbre' Brencz]",
		'[http://www.wikia.com/wiki/User:Mech.wikia Jacek Woźniak]',
		"[http://community.wikia.com/wiki/User:TOR Lucas 'TOR' Garczewski]",
	),
);

$dir = dirname(__FILE__) . '/';
$app = F::app();

// classes
$app->registerClass('ImageReviewTask', $dir . 'ImageReviewTask.php');
$app->registerClass('ImageReviewSpecialController', $dir . 'ImageReviewSpecialController.class.php');
$app->registerSpecialPage('ImageReview', 'ImageReviewSpecialController');

// rights
$wgAvailableRights[] = 'imagereview';
$wgGroupPermissions['util']['imagereview'] = true;
$wgGroupPermissions['vstf']['imagereview'] = true;
$wgGroupPermissions['reviewer']['imagereview'] = true;

// i18n
$wgExtensionMessagesFiles['ImageReview'] = $dir . 'ImageReview.i18n.php';
