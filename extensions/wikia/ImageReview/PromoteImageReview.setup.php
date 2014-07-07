<?php

/**
 * Special page-based tool to review images uploaded by Wiki Admins
 * to Wikia Visualization
 */

// dependency on main component
if (!class_exists('ImageReviewSpecialController')) {
	include("{$IP}/extensions/wikia/ImageReview/ImageReview.setup.php");
}

// extension setup
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Admin Upload Tool Image Review',
	'desc' => 'Internal tool to enable reviewing of images uploaded by Wiki Admins
				Before putting them to Wikia Visualization',
	'authors' => array(
		'Andrzej "nAndy" Łukaszewski',
		'Marcin Maciejewski',
		'Sebastian Marzjan'
	),
);

$dir = dirname(__FILE__) . '/modules/PromoteImage/';
$app = F::app();

// classes
$wgAutoloadClasses['PromoteImageReviewTask'] =  $dir . 'PromoteImageReviewTask.php';
if( function_exists('extAddBatchTask') ) {
	extAddBatchTask($dir . "PromoteImageReviewTask.php", "promoteimagereview", "PromoteImageReviewTask");
}

$wgAutoloadClasses['PromoteImageReviewSpecialController'] =  $dir . 'PromoteImageReviewSpecialController.class.php';
$wgAutoloadClasses['PromoteImageReviewHelper'] =  $dir . 'PromoteImageReviewHelper.class.php';
$wgSpecialPages[ 'PromoteImageReview'] = 'PromoteImageReviewSpecialController';

// hooks
$wgHooks['WikiFactory::onPostChangesApplied'][] = 'CityVisualization::onWikiDataUpdated';

// rights
$wgAvailableRights[] = 'promoteimagereview';
$wgGroupPermissions['util']['promoteimagereview'] = true;
$wgGroupPermissions['vstf']['promoteimagereview'] = true;

$wgAvailableRights[] = 'promoteimagereviewquestionableimagereview';
$wgGroupPermissions['util']['promoteimagereviewquestionableimagereview'] = true;

$wgAvailableRights[] = 'promoteimagereviewrejectedimagereview';
$wgGroupPermissions['util']['promoteimagereviewrejectedimagereview'] = true;

$wgAvailableRights[] = 'promoteimagereviewstats';
$wgGroupPermissions['util']['promoteimagereviewstats'] = true;

$wgAvailableRights[] = 'promoteimagereviewcontrols';
$wgGroupPermissions['util']['promoteimagereviewcontrols'] = true;

// i18n
$wgExtensionMessagesFiles['PromoteImageReview'] = $dir . 'PromoteImageReview.i18n.php';
