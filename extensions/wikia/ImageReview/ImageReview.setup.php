<?php

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Image Review',
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
