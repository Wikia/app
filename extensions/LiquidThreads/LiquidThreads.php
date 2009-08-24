<?php

if ( !defined( 'MEDIAWIKI' ) )
	die();

$wgExtensionCredits['other'][] = array(
	'name'           => 'Liquid Threads',
	'version'        => '1.2',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:LiquidThreads',
	'author'         => 'David McCabe',
	'description'    => 'Add threading discussions to talk pages',
	'descriptionmsg' => 'lqt-desc',
);

require( 'LqtFunctions.php' );

define( 'NS_LQT_THREAD', efArrayDefault( 'egLqtNamespaceNumbers', 'Thread', 90 ) );
define( 'NS_LQT_THREAD_TALK', efArrayDefault( 'egLqtNamespaceNumbers', 'Thread_talk', 91 ) );
define( 'NS_LQT_SUMMARY', efArrayDefault( 'egLqtNamespaceNumbers', 'Summary', 92 ) );
define( 'NS_LQT_SUMMARY_TALK', efArrayDefault( 'egLqtNamespaceNumbers', 'Summary_talk', 93 ) );
define( 'LQT_NEWEST_CHANGES', 1 );
define( 'LQT_NEWEST_THREADS', 2 );
define( 'LQT_OLDEST_THREADS', 3 );

// FIXME: would be neat if it was possible to somehow localise this.
$wgCanonicalNamespaceNames[NS_LQT_THREAD]		= 'Thread';
$wgCanonicalNamespaceNames[NS_LQT_THREAD_TALK]	= 'Thread_talk';
$wgCanonicalNamespaceNames[NS_LQT_SUMMARY]		= 'Summary';
$wgCanonicalNamespaceNames[NS_LQT_SUMMARY_TALK]	= 'Summary_talk';

// FIXME: would be neat if it was possible to somehow localise this.
$wgExtraNamespaces[NS_LQT_THREAD]	= 'Thread';
$wgExtraNamespaces[NS_LQT_THREAD_TALK] = 'Thread_talk';
$wgExtraNamespaces[NS_LQT_SUMMARY] = 'Summary';
$wgExtraNamespaces[NS_LQT_SUMMARY_TALK] = 'Summary_talk';

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['LiquidThreads'] = $dir . 'Lqt.i18n.php';
$wgExtensionAliasesFiles['LiquidThreads'] = $dir . 'Lqt.alias.php';

$wgHooks['SpecialWatchlistQuery'][] = 'wfLqtBeforeWatchlistHook';
$wgHooks['MediaWikiPerformAction'][] = 'LqtDispatch::tryPage';
$wgHooks['SpecialMovepageAfterMove'][] = 'LqtDispatch::onPageMove';
$wgHooks['LinkerMakeLinkObj'][] = 'LqtDispatch::makeLinkObj';
$wgHooks['SkinTemplateTabAction'][] = 'LqtDispatch::tabAction';
$wgHooks['OldChangesListRecentChangesLine'][] = 'LqtDispatch::customizeOldChangesList';
$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'LqtDispatch::setNewtalkHTML';
$wgHooks['TitleGetRestrictions'][] = 'Thread::getRestrictionsForTitle';

$wgSpecialPages['DeleteThread'] = 'SpecialDeleteThread';
$wgSpecialPages['MoveThread'] = 'SpecialMoveThread';
$wgSpecialPages['NewMessages'] = 'SpecialNewMessages';
$wgSpecialPageGroups['NewMessages'] = 'wiki';

$wgAutoloadClasses['LqtDispatch'] = $dir . 'LqtBaseView.php';
$wgAutoloadClasses['LqtView'] = $dir . 'LqtBaseView.php';
$wgAutoloadClasses['Date'] = $dir . 'classes/LqtDate.php';
$wgAutoloadClasses['Post'] = $dir . 'classes/LqtPost.php';
$wgAutoloadClasses['ThreadHistoryIterator'] = $dir . 'classes/LqtThreadHistoryIterator.php';
$wgAutoloadClasses['HistoricalThread'] = $dir . 'classes/LqtHistoricalThread.php';
$wgAutoloadClasses['Thread'] = $dir . 'classes/LqtThread.php';
$wgAutoloadClasses['Threads'] = $dir . 'classes/LqtThreads.php';
$wgAutoloadClasses['QueryGroup'] = $dir . 'classes/LqtQueryGroup.php';
$wgAutoloadClasses['NewMessages'] = $dir . 'classes/LqtNewMessages.php';

$wgAutoloadClasses['TalkpageView'] = $dir . 'pages/TalkpageView.php';
$wgAutoloadClasses['TalkpageArchiveView'] = $dir . 'pages/TalkpageArchiveView.php';
$wgAutoloadClasses['ThreadPermalinkView'] = $dir . 'pages/ThreadPermalinkView.php';
$wgAutoloadClasses['TalkpageHeaderView'] = $dir . 'pages/TalkpageHeaderView.php';
$wgAutoloadClasses['IndividualThreadHistoryView'] = $dir . 'pages/IndividualThreadHistoryView.php';
$wgAutoloadClasses['ThreadDiffView'] = $dir . 'pages/ThreadDiffView.php';
$wgAutoloadClasses['ThreadWatchView'] = $dir . 'pages/ThreadWatchView.php';
$wgAutoloadClasses['ThreadProtectionFormView'] = $dir . 'pages/ThreadProtectionFormView.php';
$wgAutoloadClasses['ThreadHistoryListingView'] = $dir . 'pages/ThreadHistoryListingView.php';
$wgAutoloadClasses['ThreadHistoricalRevisionView'] = $dir . 'pages/ThreadHistoricalRevisionView.php';
$wgAutoloadClasses['SummaryPageView'] = $dir . 'pages/SummaryPageView.php';
$wgAutoloadClasses['SpecialMoveThread'] = $dir . 'pages/SpecialMoveThread.php';
$wgAutoloadClasses['SpecialDeleteThread'] = $dir . 'pages/SpecialDeleteThread.php';
$wgAutoloadClasses['NewUserMessagesView'] = $dir . 'pages/NewUserMessagesView.php';
$wgAutoloadClasses['SpecialNewMessages'] = $dir . 'pages/SpecialNewMessages.php';

/** CONFIGURATION SECTION */

/* Number of days a thread needs to have existed to be considered for summarizing and archival */
$wgLqtThreadArchiveStartDays = 14;

/* Number of days a thread needs to be inactive to be considered for summarizing and archival */
$wgLqtThreadArchiveInactiveDays = 5;
