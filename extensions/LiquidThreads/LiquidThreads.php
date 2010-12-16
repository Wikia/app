<?php
if ( !defined( 'MEDIAWIKI' ) )
	die();

$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'Liquid Threads',
	'version'        => '2.0-alpha',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:LiquidThreads',
	'author'         => array( 'David McCabe', 'Andrew Garrett' ),
	'description'    => 'Add threading discussions to talk pages',
	'descriptionmsg' => 'lqt-desc',
);

require( 'LqtFunctions.php' );

define( 'NS_LQT_THREAD', efArrayDefault( 'egLqtNamespaceNumbers', 'Thread', 90 ) );
define( 'NS_LQT_THREAD_TALK', efArrayDefault( 'egLqtNamespaceNumbers', 'Thread_talk', 91 ) );
define( 'NS_LQT_SUMMARY', efArrayDefault( 'egLqtNamespaceNumbers', 'Summary', 92 ) );
define( 'NS_LQT_SUMMARY_TALK', efArrayDefault( 'egLqtNamespaceNumbers', 'Summary_talk', 93 ) );
define( 'LQT_NEWEST_CHANGES', 'nc' );
define( 'LQT_NEWEST_THREADS', 'nt' );
define( 'LQT_OLDEST_THREADS', 'ot' );

// FIXME: would be neat if it was possible to somehow localise this.
$wgCanonicalNamespaceNames[NS_LQT_THREAD]       = 'Thread';
$wgCanonicalNamespaceNames[NS_LQT_THREAD_TALK]  = 'Thread_talk';
$wgCanonicalNamespaceNames[NS_LQT_SUMMARY]      = 'Summary';
$wgCanonicalNamespaceNames[NS_LQT_SUMMARY_TALK] = 'Summary_talk';

// FIXME: would be neat if it was possible to somehow localise this.
$wgExtraNamespaces[NS_LQT_THREAD]       = 'Thread';
$wgExtraNamespaces[NS_LQT_THREAD_TALK]  = 'Thread_talk';
$wgExtraNamespaces[NS_LQT_SUMMARY]      = 'Summary';
$wgExtraNamespaces[NS_LQT_SUMMARY_TALK] = 'Summary_talk';

// Localisation
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['LiquidThreads'] = $dir . 'i18n/Lqt.i18n.php';
$wgExtensionMessagesFiles['LiquidThreadsMagic'] = $dir . 'i18n/LiquidThreads.magic.php';
$wgExtensionAliasesFiles['LiquidThreads'] = $dir . 'i18n/Lqt.alias.php';

// Parser Function Setup
$wgHooks['ParserFirstCallInit'][] = 'lqtSetupParserFunctions';

// Hooks
// Main dispatch hook
$wgHooks['MediaWikiPerformAction'][] = 'LqtDispatch::tryPage';
$wgHooks['SkinTemplateTabs'][] = 'LqtDispatch::onSkinTemplateTabs';
$wgHooks['SkinTemplateNavigation'][] = 'LqtDispatch::onSkinTemplateNavigation';

// Customisation of recentchanges
$wgHooks['OldChangesListRecentChangesLine'][] = 'LqtHooks::customizeOldChangesList';

// Notification (watchlist, newtalk)
$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'LqtHooks::setNewtalkHTML';
$wgHooks['SpecialWatchlistQuery'][] = 'LqtHooks::beforeWatchlist';
$wgHooks['ArticleEditUpdateNewTalk'][] = 'LqtHooks::updateNewtalkOnEdit';
$wgHooks['PersonalUrls'][] = 'LqtHooks::onPersonalUrls';

// Preferences
$wgHooks['GetPreferences'][] = 'LqtHooks::getPreferences';

// Export-related
$wgHooks['XmlDumpWriterOpenPage'][] = 'LqtHooks::dumpThreadData';
$wgHooks['ModifyExportQuery'][] = 'LqtHooks::modifyExportQuery';
$wgHooks['OAIFetchRowsQuery'][] = 'LqtHooks::modifyOAIQuery';
$wgHooks['OAIFetchRecordQuery'][] = 'LqtHooks::modifyOAIQuery';

// Deletion
$wgHooks['ArticleDeleteComplete'][] = 'LqtDeletionController::onArticleDeleteComplete';
$wgHooks['ArticleRevisionUndeleted'][] = 'LqtDeletionController::onArticleRevisionUndeleted';
$wgHooks['ArticleUndelete'][] = 'LqtDeletionController::onArticleUndelete';
$wgHooks['ArticleConfirmDelete'][] = 'LqtDeletionController::onArticleConfirmDelete';
$wgHooks['ArticleDelete'][] = 'LqtDeletionController::onArticleDelete';

// Moving
$wgHooks['SpecialMovepageAfterMove'][] = 'LqtHooks::onArticleMoveComplete';
$wgHooks['AbortMove'][] = 'LqtHooks::onArticleMove';

// Search
$wgHooks['ShowSearchHitTitle'][] = 'LqtHooks::customiseSearchResultTitle';
$wgHooks['SpecialSearchProfiles'][] = 'LqtHooks::customiseSearchProfiles';

// Updates
$wgHooks['LoadExtensionSchemaUpdates'][] = 'LqtHooks::onLoadExtensionSchemaUpdates';

// Rename
$wgHooks['RenameUserSQL'][] = 'LqtHooks::onUserRename';

// Edit-related
$wgHooks['EditPageBeforeEditChecks'][] = 'LqtHooks::editCheckBoxes';
$wgHooks['ArticleSaveComplete'][] = 'LqtHooks::onArticleSaveComplete';

// Blocking
$wgHooks['UserIsBlockedFrom'][] = 'LqtHooks::userIsBlockedFrom';

// Protection
$wgHooks['TitleGetRestrictionTypes'][] = 'LqtHooks::getProtectionTypes';

// Special pages
$wgSpecialPages['MoveThread'] = 'SpecialMoveThread';
$wgSpecialPages['NewMessages'] = 'SpecialNewMessages';
$wgSpecialPages['SplitThread'] = 'SpecialSplitThread';
$wgSpecialPages['MergeThread'] = 'SpecialMergeThread';
// $wgSpecialPages['HotTopics'] = 'SpecialHotTopics';
$wgSpecialPageGroups['NewMessages'] = 'wiki';

// Classes
$wgAutoloadClasses['LqtDispatch'] = $dir . 'classes/Dispatch.php';
$wgAutoloadClasses['LqtView'] = $dir . 'classes/View.php';
$wgAutoloadClasses['HistoricalThread'] = $dir . 'classes/HistoricalThread.php';
$wgAutoloadClasses['Thread'] = $dir . 'classes/Thread.php';
$wgAutoloadClasses['Threads'] = $dir . 'classes/Threads.php';
$wgAutoloadClasses['NewMessages'] = $dir . 'classes/NewMessagesController.php';
$wgAutoloadClasses['LqtParserFunctions'] = $dir . 'classes/ParserFunctions.php';
$wgAutoloadClasses['LqtDeletionController'] = $dir . 'classes/DeletionController.php';
$wgAutoloadClasses['LqtHooks'] = $dir . 'classes/Hooks.php';
$wgAutoloadClasses['ThreadRevision'] = $dir . "/classes/ThreadRevision.php";
$wgAutoloadClasses['SynchroniseThreadArticleDataJob'] = "$dir/classes/SynchroniseThreadArticleDataJob.php";
$wgAutoloadClasses['ThreadHistoryPager'] = "$dir/classes/ThreadHistoryPager.php";
$wgAutoloadClasses['TalkpageHistoryView'] = "$dir/pages/TalkpageHistoryView.php";
$wgAutoloadClasses['LqtHotTopicsController'] = "$dir/classes/HotTopics.php";
$wgAutoloadClasses['LqtLogFormatter'] = "$dir/classes/LogFormatter.php";

// View classes
$wgAutoloadClasses['TalkpageView'] = $dir . 'pages/TalkpageView.php';
$wgAutoloadClasses['ThreadPermalinkView'] = $dir . 'pages/ThreadPermalinkView.php';
$wgAutoloadClasses['TalkpageHeaderView'] = $dir . 'pages/TalkpageHeaderView.php';
$wgAutoloadClasses['IndividualThreadHistoryView'] = $dir . 'pages/IndividualThreadHistoryView.php';
$wgAutoloadClasses['ThreadDiffView'] = $dir . 'pages/ThreadDiffView.php';
$wgAutoloadClasses['ThreadWatchView'] = $dir . 'pages/ThreadWatchView.php';
$wgAutoloadClasses['ThreadProtectionFormView'] = $dir . 'pages/ThreadProtectionFormView.php';
$wgAutoloadClasses['ThreadHistoryListingView'] = $dir . 'pages/ThreadHistoryListingView.php';
$wgAutoloadClasses['ThreadHistoricalRevisionView'] = $dir . 'pages/ThreadHistoricalRevisionView.php';
$wgAutoloadClasses['SummaryPageView'] = $dir . 'pages/SummaryPageView.php';
$wgAutoloadClasses['NewUserMessagesView'] = $dir . 'pages/NewUserMessagesView.php';

// Special pages
$wgAutoloadClasses['ThreadActionPage'] = $dir . 'pages/ThreadActionPage.php';
$wgAutoloadClasses['SpecialMoveThread'] = $dir . 'pages/SpecialMoveThread.php';
$wgAutoloadClasses['SpecialNewMessages'] = $dir . 'pages/SpecialNewMessages.php';
$wgAutoloadClasses['SpecialSplitThread'] = $dir . 'pages/SpecialSplitThread.php';
$wgAutoloadClasses['SpecialMergeThread'] = $dir . 'pages/SpecialMergeThread.php';
$wgAutoloadClasses['SpecialHotTopics'] = "$dir/pages/SpecialHotTopics.php";

// Job queue
$wgJobClasses['synchroniseThreadArticleData'] = 'SynchroniseThreadArticleDataJob';

// Backwards-compatibility
$wgAutoloadClasses['Article_LQT_Compat'] = $dir . 'compat/LqtCompatArticle.php';
if ( version_compare( $wgVersion, '1.16', '<' ) ) {
	$wgAutoloadClasses['HTMLForm'] = "$dir/compat/HTMLForm.php";
	$wgExtensionMessagesFiles['Lqt-Compat'] = "$dir/compat/Lqt-compat.i18n.php";
}

// Logging
$wgLogTypes[] = 'liquidthreads';
$wgLogNames['liquidthreads']          = 'lqt-log-name';
$wgLogHeaders['liquidthreads']        = 'lqt-log-header';

foreach ( array( 'move', 'split', 'merge', 'subjectedit', 'resort' ) as $action ) {
	$wgLogActionsHandlers["liquidthreads/$action"] = 'LqtLogFormatter::formatLogEntry';
}

// Preferences
$wgDefaultUserOptions['lqtnotifytalk'] = false;
$wgDefaultUserOptions['lqtdisplaydepth'] = 2;
$wgDefaultUserOptions['lqtdisplaycount'] = 25;
$wgDefaultUserOptions['lqtcustomsignatures'] = true;

// API
$wgAutoloadClasses['ApiQueryLQTThreads'] = "$dir/api/ApiQueryLQTThreads.php";
$wgAPIListModules['threads'] = 'ApiQueryLQTThreads';
$wgAutoloadClasses['ApiFeedLQTThreads'] = "$dir/api/ApiFeedLQTThreads.php";
$wgAPIModules['feedthreads'] = 'ApiFeedLQTThreads';
$wgAutoloadClasses['ApiThreadAction'] = "$dir/api/ApiThreadAction.php";
$wgAPIModules['threadaction'] = 'ApiThreadAction';

// Name of the extension (wmf-specific, for splitting to versions)
$wgLiquidThreadsExtensionName = 'LiquidThreads';

/** CONFIGURATION SECTION */

$wgDefaultUserOptions['lqt-watch-threads'] = true;

$wgGroupPermissions['user']['lqt-split'] = true;
$wgGroupPermissions['user']['lqt-merge'] = true;

$wgAvailableRights[] = 'lqt-split';
$wgAvailableRights[] = 'lqt-merge';

/* Allows activation of LiquidThreads on individual pages */
$wgLqtPages = array();

/* Allows switching LiquidThreads off for regular talk pages
	(intended for testing and transition) */
$wgLqtTalkPages = true;

/* Whether or not to activate LiquidThreads email notifications */
$wgLqtEnotif = true;

/* Thread actions which do *not* cause threads to be "bumped" to the top */
/* Using numbers because the change type constants are defined in Threads.php, don't
	want to have to parse it on every page view */
$wgThreadActionsNoBump = array(
	3 /* Edited summary */,
	10 /* Merged from */,
	12 /* Split from */,
	2 /* Edited root */,
	14 /* Adjusted sortkey */
);

/** Switch this on if you've migrated from a version before around May 2009 */
$wgLiquidThreadsMigrate = false;

/** The default number of threads per page */
$wgLiquidThreadsDefaultPageLimit = 20;

/** Whether or not to allow users to activate/deactivate LiquidThreads per-page */
$wgLiquidThreadsAllowUserControl = true;

/** Whether or not to allow users to activate/deactivate LiquidThreads in specific namespaces.
	NULL means either all or none, depending on the above. */
$wgLiquidThreadsAllowUserControlNamespaces = null;
