<?php
if ( !defined( 'MEDIAWIKI' ) )
	die();

$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'Liquid Threads',
	'version'        => '2.0-alpha',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:LiquidThreads',
	'author'         => array( 'David McCabe', 'Andrew Garrett' ),
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

// Localisation
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['LiquidThreads'] = $dir . 'i18n/Lqt.i18n.php';
$wgExtensionMessagesFiles['LiquidThreadsMagic'] = $dir . 'i18n/LiquidThreads.magic.php';
$wgExtensionMessagesFiles['LiquidThreadsNamespaces'] = $dir . 'i18n/Lqt.namespaces.php';
$wgExtensionMessagesFiles['LiquidThreadsAlias'] = $dir . 'i18n/Lqt.alias.php';

$lqtMessages = array(
	'lqt-quote-intro',
	'lqt-quote',
	'lqt-ajax-updated',
	'lqt-ajax-update-link',
	'watch',
	'unwatch',
	'lqt-thread-link-url',
	'lqt-thread-link-title',
	'lqt-thread-link-copy',
	'lqt-sign-not-necessary',
	'lqt-marked-as-read-placeholder',
	'lqt-email-undo',
	'lqt-change-subject',
	'lqt-save-subject',
	'lqt-ajax-no-subject',
	'lqt-ajax-invalid-subject',
	'lqt-save-subject-error-unknown',
	'lqt-cancel-subject-edit',
	'lqt-drag-activate',
	'lqt-drag-drop-zone',
	'lqt-drag-confirm',
	'lqt-drag-reparent',
	'lqt-drag-split',
	'lqt-drag-setsortkey',
	'lqt-drag-bump',
	'lqt-drag-save',
	'lqt-drag-reason',
	'lqt-drag-subject',
	'lqt-edit-signature',
	'lqt-preview-signature',
	'lqt_contents_title',
	'lqt-empty-text',
);

// ResourceLoader
$lqtResourceTemplate = array(
	'localBasePath' => "$dir",
	'remoteExtPath' => 'LiquidThreads'
);

$wgResourceModules['ext.liquidThreads'] = $lqtResourceTemplate + array(
	'styles' => array( 'lqt.css', 'jquery/jquery.thread_collapse.css', 'lqt.dialogs.css' ),
	'scripts' => array( 'lqt.js', 'js/lqt.toolbar.js', 'jquery/jquery.thread_collapse.js', 'jquery/jquery.autogrow.js' ),
	'dependencies' => array( 'jquery.ui.dialog', 'jquery.ui.droppable' ),
	'messages' => $lqtMessages
);

$wgResourceModules['ext.liquidThreads.newMessages'] = $lqtResourceTemplate + array(
	'scripts' => array( 'newmessages.js' ),
	'dependencies' => array( 'ext.liquidThreads' )
);

// Hooks
// Parser Function Setup
$wgHooks['ParserFirstCallInit'][] = 'LqtHooks::onParserFirstCallInit';

// Namespaces
$wgHooks['CanonicalNamespaces'][] = 'LqtHooks::onCanonicalNamespaces';

// Main dispatch hook
$wgHooks['MediaWikiPerformAction'][] = 'LqtDispatch::tryPage';
$wgHooks['SkinTemplateTabs'][] = 'LqtDispatch::onSkinTemplateTabs';
$wgHooks['SkinTemplateNavigation'][] = 'LqtDispatch::onSkinTemplateNavigation';
$wgHooks['PageContentLanguage'][] = 'LqtDispatch::onPageContentLanguage';

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

// Import-related
$wgHooks['ImportHandlePageXMLTag'][] = 'LqtHooks::handlePageXMLTag';
$wgHooks['AfterImportPage'][] = 'LqtHooks::afterImportPage';

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

// New User Messages
$wgHooks['SetupNewUserMessageSubject'][] = 'LqtHooks::setupNewUserMessageSubject';
$wgHooks['SetupNewUserMessageBody'][] = 'LqtHooks::setupNewUserMessageBody';

// JS variables
$wgHooks['MakeGlobalVariablesScript'][] = 'LqtHooks::onMakeGlobalVariablesScript';

// Special pages
$wgSpecialPages['MoveThread'] = 'SpecialMoveThread';
$wgSpecialPages['NewMessages'] = 'SpecialNewMessages';
$wgSpecialPages['SplitThread'] = 'SpecialSplitThread';
$wgSpecialPages['MergeThread'] = 'SpecialMergeThread';
// $wgSpecialPages['HotTopics'] = 'SpecialHotTopics';
$wgSpecialPageGroups['NewMessages'] = 'wiki';

// Embedding
$wgHooks['OutputPageParserOutput'][] = 'LqtParserFunctions::onAddParserOutput';
$wgHooks['OutputPageBeforeHTML'][] = 'LqtParserFunctions::onAddHTML';

// Permissions
$wgHooks['userCan'][] = 'LqtHooks::onGetUserPermissionsErrors';

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
$wgAutoloadClasses['ThreadRevision'] = $dir . "classes/ThreadRevision.php";
$wgAutoloadClasses['SynchroniseThreadArticleDataJob'] = $dir . 'classes/SynchroniseThreadArticleDataJob.php';
$wgAutoloadClasses['ThreadHistoryPager'] = $dir . 'classes/ThreadHistoryPager.php';
$wgAutoloadClasses['TalkpageHistoryView'] = $dir . 'pages/TalkpageHistoryView.php';
$wgAutoloadClasses['LqtHotTopicsController'] = $dir . 'classes/HotTopics.php';
$wgAutoloadClasses['LqtLogFormatter'] = $dir . 'classes/LogFormatter.php';

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

// Pagers
$wgAutoloadClasses['LqtDiscussionPager'] = $dir . "pages/TalkpageView.php";

// Special pages
$wgAutoloadClasses['ThreadActionPage'] = $dir . 'pages/ThreadActionPage.php';
$wgAutoloadClasses['SpecialMoveThread'] = $dir . 'pages/SpecialMoveThread.php';
$wgAutoloadClasses['SpecialNewMessages'] = $dir . 'pages/SpecialNewMessages.php';
$wgAutoloadClasses['SpecialSplitThread'] = $dir . 'pages/SpecialSplitThread.php';
$wgAutoloadClasses['SpecialMergeThread'] = $dir . 'pages/SpecialMergeThread.php';

// Job queue
$wgJobClasses['synchroniseThreadArticleData'] = 'SynchroniseThreadArticleDataJob';

// Logging
$wgLogTypes[] = 'liquidthreads';
$wgLogNames['liquidthreads']		  = 'lqt-log-name';
$wgLogHeaders['liquidthreads']		  = 'lqt-log-header';

foreach ( array( 'move', 'split', 'merge', 'subjectedit', 'resort' ) as $action ) {
	$wgLogActionsHandlers["liquidthreads/$action"] = 'LqtLogFormatter::formatLogEntry';
}

// Preferences
$wgDefaultUserOptions['lqtnotifytalk'] = false;
$wgDefaultUserOptions['lqtdisplaydepth'] = 5;
$wgDefaultUserOptions['lqtdisplaycount'] = 25;
$wgDefaultUserOptions['lqtcustomsignatures'] = true;

// API
$wgAutoloadClasses['ApiQueryLQTThreads'] = $dir . 'api/ApiQueryLQTThreads.php';
$wgAPIListModules['threads'] = 'ApiQueryLQTThreads';
$wgAutoloadClasses['ApiFeedLQTThreads'] = $dir . 'api/ApiFeedLQTThreads.php';
$wgAPIModules['feedthreads'] = 'ApiFeedLQTThreads';
$wgAutoloadClasses['ApiThreadAction'] = $dir . '/api/ApiThreadAction.php';
$wgAPIModules['threadaction'] = 'ApiThreadAction';

// Path to the LQT directory
$wgLiquidThreadsExtensionPath = "{$wgScriptPath}/extensions/LiquidThreads";

/** CONFIGURATION SECTION */

$wgDefaultUserOptions['lqt-watch-threads'] = true;

$wgGroupPermissions['user']['lqt-split'] = true;
$wgGroupPermissions['user']['lqt-merge'] = true;
$wgGroupPermissions['user']['lqt-react'] = true;

$wgAvailableRights[] = 'lqt-split';
$wgAvailableRights[] = 'lqt-merge';
$wgAvailableRights[] = 'lqt-react';

$wgPageProps['use-liquid-threads'] = 'Whether or not the page is using LiquidThreads';

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

/** Whether or not to allow users to activate/deactivate LiquidThreads
	in specific namespaces.  NULL means either all or none, depending
	on the above. */
$wgLiquidThreadsAllowUserControlNamespaces = null;

/** Allow LiquidThreads embedding */
$wgLiquidThreadsAllowEmbedding = true;

// Namespaces in which to enable LQT
$wgLqtNamespaces = array();

/** Enable/disable the bump checkbox. **/
$wgLiquidThreadsShowBumpCheckbox = false;
