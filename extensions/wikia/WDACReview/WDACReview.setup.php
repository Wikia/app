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
);

$dir = __DIR__ . '/';

// classes

$wgAutoloadClasses['WDACReviewSpecialController'] =  $dir . 'WDACReviewSpecialController.class.php';
$wgAutoloadClasses['WDACReviewHelper'] =  $dir . 'WDACReviewHelper.class.php';

$wgSpecialPages['WDACReview'] = 'WDACReviewSpecialController';

// rights
$wgAvailableRights[] = 'wdacreview';
$wgGroupPermissions['util']['wdacreview'] = true;

$wgGroupPermissions['wdacreviewer']['wdacreview'] = true;
$wgGroupPermissions['wdacreviewer']['edit'] = false;

// i18n
$wgExtensionMessagesFiles['WDACReview'] = $dir . 'WDACReview.i18n.php';
