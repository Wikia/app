<?php

$wgExtensionCredits['other'][] = array(
	'name' => 'feeds-reported-page-api',
	'author' => array(
		'Fandom',
	),
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/FeedsReportedPage',
	'descriptionmsg' => 'feeds-reported-page-api-desc'
);

$dir = dirname(__FILE__) . '/';

$wgAutoloadClasses['FeedsReportedPageController'] =  $dir . 'FeedsReportedPageController.class.php';
$wgAutoloadClasses['FeedsReportedPageGateway'] =  $dir . 'FeedsReportedPageGateway.class.php';

$wgGroupPermissions['*']['posts:validate']                               = false;
$wgGroupPermissions['threadmoderator']['posts:validate']                 = true;
$wgGroupPermissions['wiki-manager']['posts:validate']                    = true;
$wgGroupPermissions['sysop']['posts:validate']                           = true;
$wgGroupPermissions['staff']['posts:validate']                           = true;
$wgGroupPermissions['global-discussions-moderator']['posts:validate']    = true;
