<?php

/**
 * RecentWikiActivity
 */

$wgExtensionCredits['other'][] = array(
	'name' => 'RecentWikiActivity',
	'author' => array( 'Damian Jozwiak' ),
	'descriptionmsg' => 'recent-wiki-activity-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/RecentWikiActivity'
);

$dir = __DIR__ . '/';

//classes
$wgAutoloadClasses['RecentWikiActivityController'] =  $dir . 'RecentWikiActivityController.class.php';

$wgExtensionMessagesFiles['RecentWikiActivity'] = $dir . 'RecentWikiActivity.i18n.php';

$wgHooks['ArticleSaveComplete'][] = 'RecentWikiActivityController::onArticleSaveComplete';
