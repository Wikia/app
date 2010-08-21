<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die( 1 );

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Watch subpages',
	'author' => 'Jakub Kurcek',
	'descriptionmsg' => 'wikia-watchsubpages-desc',
	'version' => '1.0.0',
);

$dir = dirname( __FILE__ ) . '/';

/*	Auto loader setup */
	$wgAutoloadClasses['WatchSubPagesHelper']  = $dir . 'WatchSubPagesHelper.class.php';
	$wgExtensionMessagesFiles['WatchSubPages'] = $dir . 'WatchSubPages.i18n.php';

/*	Hooks setup */
if ( !empty( $wgEnableWikiaWatchSubPages ) && $wgEnableWikiaWatchSubPages ) {

	$wgHooks['UserToggles'][] = 'WatchSubPagesHelper::AddToUserMenu';
	$whHooks['getWatchlistPreferencesCustomHtml'][] = 'WatchSubPagesHelper::AddUsedToggles';
	$wgHooks['NotifyOnSubPageChange'][] = 'WatchSubPagesHelper::NotifyOnSubPageChange';
	$wgHooks['AfterViewUpdates'][] = 'WatchSubPagesHelper::ClearParentNotification';
}
