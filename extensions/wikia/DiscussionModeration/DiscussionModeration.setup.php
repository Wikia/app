<?php

$wgExtensionCredits['other'][] = array(
	'name' => 'DiscussionModeration',
	'author' => array(
		'Fandom',
	),
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/DiscussionModeration',
	'descriptionmsg' => 'feeds-reported-page-api-desc'
);

$dir = dirname(__FILE__) . '/';

$wgAutoloadClasses['ReportedPostsHelper'] =  $dir . 'ReportedPostsHelper.class.php';
$wgAutoloadClasses['DiscussionGateway'] =  $dir . 'DiscussionGateway.class.php';
$wgAutoloadClasses['DiscussionModerationController'] =  $dir . 'DiscussionModerationController.class.php';
$wgAutoloadClasses['DiscussionLeaderboardController'] =  $dir . 'DiscussionLeaderboardController.class.php';
$wgAutoloadClasses['DiscussionImagesController'] =  $dir . 'DiscussionImagesController.class.php';
$wgAutoloadClasses['FeedsReportedPageController'] =  $dir . 'DiscussionModerationController.class.php';
$wgAutoloadClasses['ReportDetailsHelper'] =  $dir . 'ReportDetailsHelper.class.php';
$wgAutoloadClasses['LeaderboardHelper'] =  $dir . 'LeaderboardHelper.class.php';
$wgAutoloadClasses['DiscussionCommonHooks'] =  $dir . 'DiscussionCommonHooks.class.php';
$wgAutoloadClasses['TraceHeadersHelper'] =  $dir . 'TraceHeadersHelper.class.php';

$wgHooks['GetUserTraceHeaders'][] = 'DiscussionCommonHooks::onGetUserTraceHeaders';

$wgGroupPermissions['*']['discussionslog:view'] = false;
$wgGroupPermissions['helper']['discussionslog:view'] = true;
$wgGroupPermissions['soap']['discussionslog:view'] = true;
$wgGroupPermissions['staff']['discussionslog:view'] = true;
$wgGroupPermissions['wiki-manager']['discussionslog:view'] = true;

$wgGroupPermissions['*']['forums:create'] = false;
$wgGroupPermissions['global-discussions-moderator']['forums:create'] = true;
$wgGroupPermissions['helper']['forums:create'] = true;
$wgGroupPermissions['soap']['forums:create'] = true;
$wgGroupPermissions['staff']['forums:create'] = true;
$wgGroupPermissions['sysop']['forums:create'] = true;
$wgGroupPermissions['wiki-manager']['forums:create'] = true;

$wgGroupPermissions['*']['forums:delete'] = false;
$wgGroupPermissions['global-discussions-moderator']['forums:delete'] = true;
$wgGroupPermissions['helper']['forums:delete'] = true;
$wgGroupPermissions['soap']['forums:delete'] = true;
$wgGroupPermissions['staff']['forums:delete'] = true;
$wgGroupPermissions['sysop']['forums:delete'] = true;
$wgGroupPermissions['wiki-manager']['forums:delete'] = true;

$wgGroupPermissions['*']['forums:displayorder'] = false;
$wgGroupPermissions['global-discussions-moderator']['forums:displayorder'] = true;
$wgGroupPermissions['helper']['forums:displayorder'] = true;
$wgGroupPermissions['soap']['forums:displayorder'] = true;
$wgGroupPermissions['staff']['forums:displayorder'] = true;
$wgGroupPermissions['sysop']['forums:displayorder'] = true;
$wgGroupPermissions['wiki-manager']['forums:displayorder'] = true;

$wgGroupPermissions['*']['forums:edit'] = false;
$wgGroupPermissions['global-discussions-moderator']['forums:edit'] = true;
$wgGroupPermissions['helper']['forums:edit'] = true;
$wgGroupPermissions['soap']['forums:edit'] = true;
$wgGroupPermissions['staff']['forums:edit'] = true;
$wgGroupPermissions['sysop']['forums:edit'] = true;
$wgGroupPermissions['wiki-manager']['forums:edit'] = true;

$wgGroupPermissions['*']['forums:read'] = false;
$wgGroupPermissions['helper']['forums:read'] = true;
$wgGroupPermissions['soap']['forums:read'] = true;
$wgGroupPermissions['staff']['forums:read'] = true;
$wgGroupPermissions['user']['forums:read'] = true;

$wgGroupPermissions['*']['forums:viewhidden'] = false;
$wgGroupPermissions['global-discussions-moderator']['forums:viewhidden'] = true;
$wgGroupPermissions['helper']['forums:viewhidden'] = true;
$wgGroupPermissions['soap']['forums:viewhidden'] = true;
$wgGroupPermissions['staff']['forums:viewhidden'] = true;
$wgGroupPermissions['sysop']['forums:viewhidden'] = true;
$wgGroupPermissions['threadmoderator']['forums:viewhidden'] = true;
$wgGroupPermissions['wiki-manager']['forums:viewhidden'] = true;

$wgGroupPermissions['*']['leaderboard:view'] = false;
$wgGroupPermissions['global-discussions-moderator']['leaderboard:view'] = true;
$wgGroupPermissions['helper']['leaderboard:view'] = true;
$wgGroupPermissions['soap']['leaderboard:view'] = true;
$wgGroupPermissions['staff']['leaderboard:view'] = true;
$wgGroupPermissions['sysop']['leaderboard:view'] = true;
$wgGroupPermissions['threadmoderator']['leaderboard:view'] = true;
$wgGroupPermissions['wiki-manager']['leaderboard:view'] = true;

$wgGroupPermissions['*']['moderatorTools:use'] = false;
$wgGroupPermissions['global-discussions-moderator']['moderatorTools:use'] = true;
$wgGroupPermissions['helper']['moderatorTools:use'] = true;
$wgGroupPermissions['soap']['moderatorTools:use'] = true;
$wgGroupPermissions['staff']['moderatorTools:use'] = true;
$wgGroupPermissions['sysop']['moderatorTools:use'] = true;
$wgGroupPermissions['threadmoderator']['moderatorTools:use'] = true;
$wgGroupPermissions['wiki-manager']['moderatorTools:use'] = true;

$wgGroupPermissions['*']['opengraph:create'] = false;
$wgGroupPermissions['helper']['opengraph:create'] = true;
$wgGroupPermissions['soap']['opengraph:create'] = true;
$wgGroupPermissions['staff']['opengraph:create'] = true;
$wgGroupPermissions['user']['opengraph:create'] = true;

$wgGroupPermissions['*']['polls:vote'] = false;
$wgGroupPermissions['helper']['polls:vote'] = true;
$wgGroupPermissions['soap']['polls:vote'] = true;
$wgGroupPermissions['staff']['polls:vote'] = true;
$wgGroupPermissions['user']['polls:vote'] = true;

$wgGroupPermissions['*']['posts:create'] = false;
$wgGroupPermissions['helper']['posts:create'] = true;
$wgGroupPermissions['soap']['posts:create'] = true;
$wgGroupPermissions['staff']['posts:create'] = true;
$wgGroupPermissions['user']['posts:create'] = true;

$wgGroupPermissions['*']['posts:delete'] = false;
$wgGroupPermissions['global-discussions-moderator']['posts:delete'] = true;
$wgGroupPermissions['helper']['posts:delete'] = true;
$wgGroupPermissions['soap']['posts:delete'] = true;
$wgGroupPermissions['staff']['posts:delete'] = true;
$wgGroupPermissions['sysop']['posts:delete'] = true;
$wgGroupPermissions['threadmoderator']['posts:delete'] = true;
$wgGroupPermissions['wiki-manager']['posts:delete'] = true;

$wgGroupPermissions['*']['posts:deleteall'] = false;
$wgGroupPermissions['global-discussions-moderator']['posts:deleteall'] = true;
$wgGroupPermissions['helper']['posts:deleteall'] = true;
$wgGroupPermissions['soap']['posts:deleteall'] = true;
$wgGroupPermissions['staff']['posts:deleteall'] = true;
$wgGroupPermissions['sysop']['posts:deleteall'] = true;
$wgGroupPermissions['threadmoderator']['posts:deleteall'] = true;
$wgGroupPermissions['wiki-manager']['posts:deleteall'] = true;

$wgGroupPermissions['*']['posts:edit'] = false;
$wgGroupPermissions['helper']['posts:edit'] = true;
$wgGroupPermissions['soap']['posts:edit'] = true;
$wgGroupPermissions['staff']['posts:edit'] = true;
$wgGroupPermissions['user']['posts:edit'] = true;

$wgGroupPermissions['*']['posts:lock'] = false;
$wgGroupPermissions['global-discussions-moderator']['posts:lock'] = true;
$wgGroupPermissions['helper']['posts:lock'] = true;
$wgGroupPermissions['soap']['posts:lock'] = true;
$wgGroupPermissions['staff']['posts:lock'] = true;
$wgGroupPermissions['sysop']['posts:lock'] = true;
$wgGroupPermissions['threadmoderator']['posts:lock'] = true;
$wgGroupPermissions['wiki-manager']['posts:lock'] = true;

$wgGroupPermissions['*']['posts:report'] = false;
$wgGroupPermissions['helper']['posts:report'] = true;
$wgGroupPermissions['soap']['posts:report'] = true;
$wgGroupPermissions['staff']['posts:report'] = true;
$wgGroupPermissions['user']['posts:report'] = true;

$wgGroupPermissions['*']['posts:superedit'] = false;
$wgGroupPermissions['global-discussions-moderator']['posts:superedit'] = true;
$wgGroupPermissions['helper']['posts:superedit'] = true;
$wgGroupPermissions['soap']['posts:superedit'] = true;
$wgGroupPermissions['staff']['posts:superedit'] = true;
$wgGroupPermissions['sysop']['posts:superedit'] = true;
$wgGroupPermissions['threadmoderator']['posts:superedit'] = true;
$wgGroupPermissions['wiki-manager']['posts:superedit'] = true;

$wgGroupPermissions['*']['posts:validate'] = false;
$wgGroupPermissions['global-discussions-moderator']['posts:validate'] = true;
$wgGroupPermissions['helper']['posts:validate'] = true;
$wgGroupPermissions['soap']['posts:validate'] = true;
$wgGroupPermissions['staff']['posts:validate'] = true;
$wgGroupPermissions['sysop']['posts:validate'] = true;
$wgGroupPermissions['threadmoderator']['posts:validate'] = true;
$wgGroupPermissions['wiki-manager']['posts:validate'] = true;

$wgGroupPermissions['*']['posts:viewhidden'] = false;
$wgGroupPermissions['global-discussions-moderator']['posts:viewhidden'] = true;
$wgGroupPermissions['helper']['posts:viewhidden'] = true;
$wgGroupPermissions['soap']['posts:viewhidden'] = true;
$wgGroupPermissions['staff']['posts:viewhidden'] = true;
$wgGroupPermissions['sysop']['posts:viewhidden'] = true;
$wgGroupPermissions['threadmoderator']['posts:viewhidden'] = true;
$wgGroupPermissions['wiki-manager']['posts:viewhidden'] = true;

$wgGroupPermissions['*']['posts:vote'] = false;
$wgGroupPermissions['helper']['posts:vote'] = true;
$wgGroupPermissions['soap']['posts:vote'] = true;
$wgGroupPermissions['staff']['posts:vote'] = true;
$wgGroupPermissions['user']['posts:vote'] = true;

$wgGroupPermissions['*']['threads:create'] = false;
$wgGroupPermissions['helper']['threads:create'] = true;
$wgGroupPermissions['soap']['threads:create'] = true;
$wgGroupPermissions['staff']['threads:create'] = true;
$wgGroupPermissions['user']['threads:create'] = true;

$wgGroupPermissions['*']['threads:delete'] = false;
$wgGroupPermissions['global-discussions-moderator']['threads:delete'] = true;
$wgGroupPermissions['helper']['threads:delete'] = true;
$wgGroupPermissions['soap']['threads:delete'] = true;
$wgGroupPermissions['staff']['threads:delete'] = true;
$wgGroupPermissions['sysop']['threads:delete'] = true;
$wgGroupPermissions['threadmoderator']['threads:delete'] = true;
$wgGroupPermissions['wiki-manager']['threads:delete'] = true;

$wgGroupPermissions['*']['threads:edit'] = false;
$wgGroupPermissions['helper']['threads:edit'] = true;
$wgGroupPermissions['soap']['threads:edit'] = true;
$wgGroupPermissions['staff']['threads:edit'] = true;
$wgGroupPermissions['user']['threads:edit'] = true;

$wgGroupPermissions['*']['threads:lock'] = false;
$wgGroupPermissions['global-discussions-moderator']['threads:lock'] = true;
$wgGroupPermissions['helper']['threads:lock'] = true;
$wgGroupPermissions['soap']['threads:lock'] = true;
$wgGroupPermissions['staff']['threads:lock'] = true;
$wgGroupPermissions['sysop']['threads:lock'] = true;
$wgGroupPermissions['threadmoderator']['threads:lock'] = true;
$wgGroupPermissions['wiki-manager']['threads:lock'] = true;

$wgGroupPermissions['*']['threads:move'] = false;
$wgGroupPermissions['global-discussions-moderator']['threads:move'] = true;
$wgGroupPermissions['helper']['threads:move'] = true;
$wgGroupPermissions['soap']['threads:move'] = true;
$wgGroupPermissions['staff']['threads:move'] = true;
$wgGroupPermissions['sysop']['threads:move'] = true;
$wgGroupPermissions['threadmoderator']['threads:move'] = true;
$wgGroupPermissions['wiki-manager']['threads:move'] = true;

$wgGroupPermissions['*']['threads:superedit'] = false;
$wgGroupPermissions['global-discussions-moderator']['threads:superedit'] = true;
$wgGroupPermissions['helper']['threads:superedit'] = true;
$wgGroupPermissions['soap']['threads:superedit'] = true;
$wgGroupPermissions['staff']['threads:superedit'] = true;
$wgGroupPermissions['sysop']['threads:superedit'] = true;
$wgGroupPermissions['threadmoderator']['threads:superedit'] = true;
$wgGroupPermissions['wiki-manager']['threads:superedit'] = true;

$wgGroupPermissions['*']['threads:viewhidden'] = false;
$wgGroupPermissions['global-discussions-moderator']['threads:viewhidden'] = true;
$wgGroupPermissions['helper']['threads:viewhidden'] = true;
$wgGroupPermissions['soap']['threads:viewhidden'] = true;
$wgGroupPermissions['staff']['threads:viewhidden'] = true;
$wgGroupPermissions['sysop']['threads:viewhidden'] = true;
$wgGroupPermissions['threadmoderator']['threads:viewhidden'] = true;
$wgGroupPermissions['wiki-manager']['threads:viewhidden'] = true;

$wgGroupPermissions['*']['wall:edit'] = false;
$wgGroupPermissions['helper']['wall:edit'] = true;
$wgGroupPermissions['soap']['wall:edit'] = true;
$wgGroupPermissions['staff']['wall:edit'] = true;
$wgGroupPermissions['user']['wall:edit'] = true;
