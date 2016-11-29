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
$wgAutoloadClasses['ImageReviewSpecialController'] =  $dir . 'ImageReviewSpecialController.class.php';
$wgAutoloadClasses['ImageReviewHelperBase'] =  $dir . 'ImageReviewHelperBase.class.php';
$wgAutoloadClasses['ImageListGetter'] =  $dir . 'ImageListGetter.class.php';
$wgAutoloadClasses['ImageReviewHooks'] =  $dir . 'ImageReview.hooks.php';
$wgAutoloadClasses['ImageStateUpdater'] =  $dir . 'ImageStateUpdater.class.php';
$wgAutoloadClasses['ImageCountGetter'] =  $dir . 'ImageCountGetter.class.php';
$wgAutoloadClasses['AbandonedWorkResetter'] =  $dir . 'AbandonedWorkResetter.class.php';
$wgAutoloadClasses['StatsDataGetter'] =  $dir . 'StatsDataGetter.class.php';
$wgAutoloadClasses['ImageReviewStates'] =  $dir . 'ImageReviewStates.class.php';

$wgSpecialPages['ImageReview'] = 'ImageReviewSpecialController';

// hooks setup
$wgExtensionFunctions[] = 'ImageReviewHooks::setupHooks';

// i18n
$wgExtensionMessagesFiles['ImageReview'] = $dir . 'ImageReview.i18n.php';
