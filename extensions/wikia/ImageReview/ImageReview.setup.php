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
$wgAutoloadClasses['ImageReviewTask'] =  $dir . 'ImageReviewTask.php';
if ( function_exists( 'extAddBatchTask' ) ) {
	extAddBatchTask( $dir . "../ImageReview/ImageReviewTask.php", "imagereview", "ImageReviewTask" );
}

$wgAutoloadClasses['ImageReviewSpecialController'] =  $dir . 'ImageReviewSpecialController.class.php';
$wgAutoloadClasses['ImageReviewHelperBase'] =  $dir . 'ImageReviewHelperBase.class.php';
$wgAutoloadClasses['ImageReviewHelper'] =  $dir . 'ImageReviewHelper.class.php';

$wgSpecialPages['ImageReview'] = 'ImageReviewSpecialController';

// hooks
$wgHooks['WikiFactoryPublicStatusChange'][] = 'ImageReviewHelper::onWikiFactoryPublicStatusChange' ;

// rights
$wgAvailableRights[] = 'imagereview';
$wgGroupPermissions['util']['imagereview'] = true;
$wgGroupPermissions['vstf']['imagereview'] = true;

$wgGroupPermissions['reviewer']['imagereview'] = true;
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
