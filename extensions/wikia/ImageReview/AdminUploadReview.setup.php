<?php

/**
 * Special page-based tool to review images uploaded by Wiki Admins
 * to Wikia Visualization
 */

// dependency on main component
if(!class_exists('ImageReviewSpecialController')) {
	include( "{$IP}/extensions/wikia/ImageReview/ImageReview.setup.php" );
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

$dir = dirname(__FILE__) . '/modules/AdminUpload/';
$app = F::app();

// classes

$app->registerClass('AdminUploadReviewSpecialController', $dir . 'AdminUploadReviewSpecialController.class.php');
$app->registerClass('AdminUploadReviewHelper', $dir . 'AdminUploadReviewHelper.class.php');
$app->registerSpecialPage('AdminUploadReview', 'AdminUploadReviewSpecialController');

// rights
$wgAvailableRights[] = 'adminuploaddirt';
$wgGroupPermissions['util']['adminuploaddirt'] = true;
$wgGroupPermissions['vstf']['adminuploaddirt'] = true;

$wgAvailableRights[] = 'admindirtquestionableimagereview';
$wgGroupPermissions['util']['admindirtquestionableimagereview'] = true;

$wgAvailableRights[] = 'admindirtrejectedimagereview';
$wgGroupPermissions['util']['admindirtrejectedimagereview'] = true;

$wgAvailableRights[] = 'adminuploaddirtstats';
$wgGroupPermissions['util']['adminuploaddirtstats'] = true;

$wgAvailableRights[] = 'adminuploaddirtcontrols';
$wgGroupPermissions['util']['adminuploaddirtcontrols'] = true;

// i18n
$wgExtensionMessagesFiles['AdminUploadReview'] = $dir . 'AdminUploadReview.i18n.php';
