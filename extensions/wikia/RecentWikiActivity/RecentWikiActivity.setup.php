<?php

/**
 * RecentWikiActivity
 */

$wgExtensionCredits['other'][] = array(
	'name' => 'RecentWikiActivity',
	'author' => array( 'Damian Jozwiak' )
);

$dir = __DIR__ . '/';

//classes
$wgAutoloadClasses['RecentWikiActivityController'] =  $dir . 'RecentWikiActivityController.class.php';

$wgExtensionMessagesFiles['RecentWikiActivity'] = $dir . 'RecentWikiActivity.i18n.php';

$wgHooks['ArticleSaveComplete'][] = 'RecentWikiActivityController::onArticleSaveComplete';
