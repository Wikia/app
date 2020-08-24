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

$wgAutoloadClasses['Post'] =  $dir . 'Post.class.php';
$wgAutoloadClasses['PostBuilder'] =  $dir . 'PostBuilder.class.php';
$wgAutoloadClasses['DiscussionPermissionManager'] =  $dir . 'DiscussionPermissionManager.class.php';
$wgAutoloadClasses['DiscussionGateway'] =  $dir . 'DiscussionGateway.class.php';
$wgAutoloadClasses['DiscussionModerationController'] =  $dir . 'DiscussionModerationController.class.php';
$wgAutoloadClasses['FeedsReportedPageController'] =  $dir . 'DiscussionModerationController.class.php';

$wgGroupPermissions['*']['posts:delete']                               = false;
$wgGroupPermissions['threadmoderator']['posts:delete']                 = true;
$wgGroupPermissions['wiki-manager']['posts:delete']                    = true;
$wgGroupPermissions['sysop']['posts:delete']                           = true;
$wgGroupPermissions['staff']['posts:delete']                           = true;
$wgGroupPermissions['global-discussions-moderator']['posts:delete']    = true;
$wgGroupPermissions['helper']['posts:delete']                          = true;
$wgGroupPermissions['vstf']['posts:delete']                            = true;
$wgGroupPermissions['soap']['posts:delete']                            = true;

$wgGroupPermissions['*']['posts:validate']                               = false;
$wgGroupPermissions['threadmoderator']['posts:validate']                 = true;
$wgGroupPermissions['wiki-manager']['posts:validate']                    = true;
$wgGroupPermissions['sysop']['posts:validate']                           = true;
$wgGroupPermissions['staff']['posts:validate']                           = true;
$wgGroupPermissions['global-discussions-moderator']['posts:validate']    = true;
$wgGroupPermissions['helper']['posts:validate']                          = true;
$wgGroupPermissions['vstf']['posts:validate']                            = true;
$wgGroupPermissions['soap']['posts:validate']                            = true;

$wgGroupPermissions['*']['posts:viewhidden']                               = false;
$wgGroupPermissions['threadmoderator']['posts:viewhidden']                 = true;
$wgGroupPermissions['wiki-manager']['posts:viewhidden']                    = true;
$wgGroupPermissions['sysop']['posts:viewhidden']                           = true;
$wgGroupPermissions['staff']['posts:viewhidden']                           = true;
$wgGroupPermissions['global-discussions-moderator']['posts:viewhidden']    = true;
$wgGroupPermissions['helper']['posts:viewhidden']                          = true;
$wgGroupPermissions['vstf']['posts:viewhidden']                            = true;
$wgGroupPermissions['soap']['posts:viewhidden']                            = true;

$wgGroupPermissions['*']['posts:superedit']                               = false;
$wgGroupPermissions['threadmoderator']['posts:superedit']                 = true;
$wgGroupPermissions['wiki-manager']['posts:superedit']                    = false;
$wgGroupPermissions['sysop']['posts:superedit']                           = true;
$wgGroupPermissions['staff']['posts:superedit']                           = false;
$wgGroupPermissions['global-discussions-moderator']['posts:superedit']    = true;
$wgGroupPermissions['helper']['posts:superedit']                          = false;
$wgGroupPermissions['vstf']['posts:superedit']                            = false;
$wgGroupPermissions['soap']['posts:superedit']                            = false;

$wgGroupPermissions['*']['threads:delete']                               = false;
$wgGroupPermissions['threadmoderator']['threads:delete']                 = true;
$wgGroupPermissions['wiki-manager']['threads:delete']                    = false;
$wgGroupPermissions['sysop']['threads:delete']                           = true;
$wgGroupPermissions['staff']['threads:delete']                           = false;
$wgGroupPermissions['global-discussions-moderator']['threads:delete']    = true;
$wgGroupPermissions['helper']['threads:delete']                          = false;
$wgGroupPermissions['vstf']['threads:delete']                            = false;
$wgGroupPermissions['soap']['threads:delete']                            = false;

$wgGroupPermissions['*']['threads:lock']                               = false;
$wgGroupPermissions['threadmoderator']['threads:lock']                 = true;
$wgGroupPermissions['wiki-manager']['threads:lock']                    = false;
$wgGroupPermissions['sysop']['threads:lock']                           = true;
$wgGroupPermissions['staff']['threads:lock']                           = false;
$wgGroupPermissions['global-discussions-moderator']['threads:lock']    = true;
$wgGroupPermissions['helper']['threads:lock']                          = false;
$wgGroupPermissions['vstf']['threads:lock']                            = false;
$wgGroupPermissions['soap']['threads:lock']                            = false;

$wgGroupPermissions['*']['threads:move']                               = false;
$wgGroupPermissions['threadmoderator']['threads:move']                 = true;
$wgGroupPermissions['wiki-manager']['threads:move']                    = false;
$wgGroupPermissions['sysop']['threads:move']                           = true;
$wgGroupPermissions['staff']['threads:move']                           = false;
$wgGroupPermissions['global-discussions-moderator']['threads:move']    = true;
$wgGroupPermissions['helper']['threads:move']                          = false;
$wgGroupPermissions['vstf']['threads:move']                            = false;
$wgGroupPermissions['soap']['threads:move']                            = false;

$wgGroupPermissions['*']['threads:superedit']                               = false;
$wgGroupPermissions['threadmoderator']['threads:superedit']                 = true;
$wgGroupPermissions['wiki-manager']['threads:superedit']                    = false;
$wgGroupPermissions['sysop']['threads:superedit']                           = true;
$wgGroupPermissions['staff']['threads:superedit']                           = false;
$wgGroupPermissions['global-discussions-moderator']['threads:superedit']    = true;
$wgGroupPermissions['helper']['threads:superedit']                          = false;
$wgGroupPermissions['vstf']['threads:superedit']                            = false;
$wgGroupPermissions['soap']['threads:superedit']                            = false;
