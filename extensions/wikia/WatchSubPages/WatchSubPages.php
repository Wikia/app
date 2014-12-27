<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die( 1 );

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Watch subpages',
	'author' => 'Jakub Kurcek',
	'descriptionmsg' => 'wikia-watchsubpages-desc',
	'version' => '1.0.0',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/WatchSubPages'
);

$dir = dirname( __FILE__ ) . '/';

/* Auto loader setup */
$wgAutoloadClasses['WatchSubPagesHelper']  = $dir . 'WatchSubPagesHelper.class.php';
$wgExtensionMessagesFiles['WatchSubPages'] = $dir . 'WatchSubPages.i18n.php';

/* Hooks setup */
$wgHooks['GetPreferences'][] = 'WatchSubPagesHelper::onGetPreferences';
$wgHooks['NotifyOnSubPageChange'][] = 'WatchSubPagesHelper::NotifyOnSubPageChange';
$wgHooks['AfterViewUpdates'][] = 'WatchSubPagesHelper::ClearParentNotification';
