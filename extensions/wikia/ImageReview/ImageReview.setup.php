<?php

/**
 * Special page-based tool to review images post-upload to screen against Terms of Use violations.
 * 
 * @date 2012-03-09
 */

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Image Review',
	'desc' => 'Internal tool to help review images post-upload and remove Terms of Use violations',
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
$app->registerClass('ImageReviewHelper', $dir . 'ImageReviewHelper.class.php');
$app->registerSpecialPage('ImageReview', 'ImageReviewSpecialController');

// rights
$wgAvailableRights[] = 'imagereview';
$wgGroupPermissions['util']['imagereview'] = true;
$wgGroupPermissions['vstf']['imagereview'] = true;
$wgGroupPermissions['reviewer']['imagereview'] = true;

$wgAvailableRights[] = 'questionableimagereview';
$wgGroupPermissions['util']['questionableimagereview'] = true;

$wgAvailableRights[] = 'imagereviewstats';
$wgGroupPermissions['util']['imagereviewstats'] = true;

// i18n
$wgExtensionMessagesFiles['ImageReview'] = $dir . 'ImageReview.i18n.php';
