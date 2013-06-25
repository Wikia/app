<?php

/**
 * Special page-based tool to review wikis directed at children.
 * 
 * @since June 2013
 * @author Kamil Koterba kamil@wikia-inc.com
 */

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'WDAC Review',
	'desc' => 'Internal tool to help marking wikis directed at children suggested by founders of wiki',
	'authors' => array(
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
$wgGroupPermissions['vstf']['wdacreview'] = true;

$wgGroupPermissions['reviewer']['wdacreview'] = true;
$wgGroupPermissions['reviewer']['edit'] = false;

// i18n
$wgExtensionMessagesFiles['WDACReview'] = $dir . 'WDACReview.i18n.php';
