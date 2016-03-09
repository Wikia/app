<?php

/**
 * Special page-based tool to review wikis directed at children.
 * 
 * @since June 2013
 * @author Kamil Koterba kamil@wikia-inc.com
 */

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'WDAC Review',
	'descriptionmsg' => 'wdacreview-tool-description',
	'author' => array(
		"[http://community.wikia.com/wiki/User:R-Frank Kamil 'R-Frank' Koterba]"
	),
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/WDACReview'
);

$dir = __DIR__ . '/';

// classes

$wgAutoloadClasses['WDACReviewSpecialController'] =  $dir . 'WDACReviewSpecialController.class.php';
$wgAutoloadClasses['WDACReviewHelper'] =  $dir . 'WDACReviewHelper.class.php';

$wgSpecialPages['WDACReview'] = 'WDACReviewSpecialController';

// i18n
$wgExtensionMessagesFiles['WDACReview'] = $dir . 'WDACReview.i18n.php';
