<?php

$wgExtensionCredits['other'][] = array(
	'name' => 'DiscussionPermissions',
	'author' => array(
		'Fandom',
	),
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/DiscussionPermissions',
	'descriptionmsg' => 'Manages discussion related APIs permissions'
);

$dir = dirname(__FILE__) . '/';

$wgAutoloadClasses['Post'] =  $dir . 'Post.class.php';
$wgAutoloadClasses['PostBuilder'] =  $dir . 'PostBuilder.class.php';
$wgAutoloadClasses['DiscussionPermissionsManager'] =  $dir . 'DiscussionPermissionsManager.class.php';
$wgAutoloadClasses['DiscussionBadgesManager'] =  $dir . 'DiscussionBadgesManager.class.php';
$wgAutoloadClasses['DiscussionPermissionsHooks'] =  $dir . 'DiscussionPermissionsHooks.class.php';

$wgHooks['UserPermissionsRequired'][] = 'DiscussionPermissionsHooks::onUserPermissionsRequired';
$wgHooks['BadgePermissionsRequired'][] = 'DiscussionPermissionsHooks::onBadgePermissionsRequired';
$wgHooks['UserRights'][] = 'DiscussionPermissionsHooks::onUserRights';
