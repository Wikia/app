<?php
/**
 * Design System Extension
 */

$wgExtensionCredits['api'][] = [
	'name' => 'Design System',
	'descriptionmsg' => 'design-system-desc',
	'version' => 1.0,
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/DesignSystem'
];

// i18n
$wgExtensionMessagesFiles['DesignSystem'] = __DIR__ . '/DesignSystem.i18n.php';

// services
$wgAutoloadClasses[ 'DesignSystemGlobalFooterService' ] = __DIR__ . '/services/DesignSystemGlobalFooterService.class.php';
$wgAutoloadClasses[ 'DesignSystemGlobalNavigationService' ] = __DIR__ . '/services/DesignSystemGlobalNavigationService.class.php';
$wgAutoloadClasses[ 'DesignSystemGlobalNavigationOnSiteNotificationsService' ] = __DIR__ . '/services/DesignSystemGlobalNavigationOnSiteNotificationsService.class.php';
$wgAutoloadClasses[ 'DesignSystemGlobalNavigationWallNotificationsService' ] = __DIR__ . '/services/DesignSystemGlobalNavigationWallNotificationsService.class.php';

// helpers
$wgAutoloadClasses[ 'DesignSystemHelper' ] = __DIR__ . '/DesignSystemHelper.class.php';
$wgAutoloadClasses[ 'DesignSystemHooks' ] = __DIR__ . '/DesignSystemHooks.class.php';

// hooks
$wgHooks[ 'BeforePageDisplay' ][] = 'DesignSystemHooks::onBeforePageDisplay';
$wgHooks[ 'WikiaSkinTopScripts' ][] = 'addJsVariables';

/**
 * MW1.19 - ResourceLoaderStartUpModule class adds more variables
 * @param array $vars JS variables to be added at the bottom of the page
 * @param OutputPage $out
 * @return bool return true - it's a hook
 */
function addJsVariables( Array &$vars, &$scripts ) {
	wfProfileIn( __METHOD__ );

	$vars[ 'wgOnSiteNotificationsApiUrl' ] = F::app()->wg->OnSiteNotificationsApiUrl;

	wfProfileOut( __METHOD__ );

	return true;
}

/**
 * ResourceLoader module
 */
$wgResourceModules['ext.designSystem'] = [
	'messages' => [
		'notifications-no-notifications-message',
		'notifications-mark-all-as-read',
		'notifications-replied-by-multiple-users-with-title',
		'notifications-replied-by-multiple-users-no-title',
		'notifications-replied-by-two-users-with-title',
		'notifications-replied-by-two-users-no-title',
		'notifications-replied-by-with-title',
		'notifications-replied-by-no-title',
		'notifications-post-upvote-single-user-with-title',
		'notifications-post-upvote-single-user-no-title',
		'notifications-post-upvote-multiple-users-with-title',
		'notifications-post-upvote-multiple-users-no-title',
		'notifications-reply-upvote-single-user-with-title',
		'notifications-reply-upvote-single-user-no-title',
		'notifications-reply-upvote-multiple-users-with-title',
		'notifications-reply-upvote-multiple-users-no-title',
		'notifications-notifications'
	]
];
