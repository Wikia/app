<?php

/**
 * Special page-based tool to review images post-upload to screen against Terms of Use violations.
 *
 * @date 2012-03-09
 *
 * @todo add logging of actions
 */


$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Image Review',
	'descriptionmsg' => 'imagereview-desc',
	'author' => array(
		'[http://www.wikia.com/wiki/User:OwenDavis Owen Davis]',
		'[http://www.wikia.com/wiki/User:TomekO Tomasz Odrobny]',
		'Saipetch Kongkatong',
		"[http://www.wikia.com/wiki/User:Macbre Maciej 'Macbre' Brencz]",
		'[http://www.wikia.com/wiki/User:Mech.wikia Jacek Woźniak]',
		"[http://community.wikia.com/wiki/User:TOR Lucas 'TOR' Garczewski]",
	),
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/ImageReview'
);

$dir = dirname(__FILE__) . '/';
$app = F::app();

// classes
$wgAutoloadClasses['Wikia\\Tasks\\Tasks\\ImageReviewTask'] = "{$dir}ImageReviewTask.class.php";

$wgAutoloadClasses['ImageReviewSpecialController'] =  $dir . 'ImageReviewSpecialController.class.php';
$wgAutoloadClasses['ImageReviewHelperBase'] =  $dir . 'ImageReviewHelperBase.class.php';
$wgAutoloadClasses['ImageReviewHelper'] =  $dir . 'ImageReviewHelper.class.php';
$wgAutoloadClasses['ImageReviewDatabaseHelper'] =  $dir . 'ImageReviewDatabaseHelper.class.php';
$wgAutoloadClasses['ImageReviewHooks'] =  $dir . 'ImageReview.hooks.php';

$wgSpecialPages['ImageReview'] = 'ImageReviewSpecialController';

// hooks setup
$wgExtensionFunctions[] = 'ImageReviewHooks::setupHooks';

// rights
$wgAvailableRights[] = 'imagereview';
$wgGroupPermissions['util']['imagereview'] = true;
$wgGroupPermissions['vstf']['imagereview'] = true;

$wgGroupPermissions['reviewer']['imagereview'] = true;
$wgGroupPermissions['reviewer']['deletedhistory'] = true;
$wgGroupPermissions['reviewer']['deletedtext'] = true;
$wgGroupPermissions['reviewer']['edit'] = false;

$wgAvailableRights[] = 'questionableimagereview';
$wgGroupPermissions['util']['questionableimagereview'] = true;

$wgAvailableRights[] = 'rejectedimagereview';
$wgGroupPermissions['util']['rejectedimagereview'] = true;

$wgAvailableRights[] = 'imagereviewstats';
$wgGroupPermissions['util']['imagereviewstats'] = true;

$wgAvailableRights[] = 'imagereviewcontrols';
$wgGroupPermissions['util']['imagereviewcontrols'] = true;

// i18n
$wgExtensionMessagesFiles['ImageReview'] = $dir . 'ImageReview.i18n.php';
