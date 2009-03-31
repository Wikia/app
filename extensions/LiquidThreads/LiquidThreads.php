<?php

if (!defined('MEDIAWIKI'))
	die();

$wgExtensionCredits['other'][] = array(
	'name'           => 'Liquid Threads',
	'version'        => '1.1',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:LiquidThreads',
	'author'         => 'David McCabe',
	'description'    => 'Add threading discussions to talk pages',
	'descriptionmsg' => 'lqt-desc',
);

require( 'LqtFunctions.php');

define('NS_LQT_THREAD', efArrayDefault('egLqtNamespaceNumbers', 'Thread', 90));
define('NS_LQT_THREAD_TALK', efArrayDefault('egLqtNamespaceNumbers', 'Thread_talk', 91));
define('NS_LQT_SUMMARY', efArrayDefault('egLqtNamespaceNumbers', 'Summary', 92));
define('NS_LQT_SUMMARY_TALK', efArrayDefault('egLqtNamespaceNumbers', 'Summary_talk', 93));
define('LQT_NEWEST_CHANGES',1);
define('LQT_NEWEST_THREADS',2);
define('LQT_OLDEST_THREADS',3);

$wgCanonicalNamespaceNames[NS_LQT_THREAD]		= 'Thread';
$wgCanonicalNamespaceNames[NS_LQT_THREAD_TALK]	= 'Thread_talk';
$wgCanonicalNamespaceNames[NS_LQT_SUMMARY]		= 'Summary';
$wgCanonicalNamespaceNames[NS_LQT_SUMMARY_TALK]	= 'Summary_talk';

$wgExtraNamespaces[NS_LQT_THREAD]	= 'Thread';
$wgExtraNamespaces[NS_LQT_THREAD_TALK] = 'Thread_talk';
$wgExtraNamespaces[NS_LQT_SUMMARY] = 'Summary';
$wgExtraNamespaces[NS_LQT_SUMMARY_TALK] = 'Summary_talk';

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['LiquidThreads'] = $dir . 'Lqt.i18n.php';
$wgExtensionAliasesFiles['LiquidThreads'] = $dir . 'Lqt.alias.php';

$wgHooks['SpecialWatchlistQuery'][] = 'wfLqtBeforeWatchlistHook';
$wgHooks['MediaWikiPerformAction'][] = 'LqtDispatch::tryPage';
$wgHooks['SpecialMovepageAfterMove'][] = 'LqtDispatch::onPageMove';
$wgHooks['LinkerMakeLinkObj'][] = 'LqtDispatch::makeLinkObj';
$wgHooks['SkinTemplateTabAction'][] = 'LqtDispatch::tabAction';
$wgHooks['OldChangesListRecentChangesLine'][] = 'LqtDispatch::customizeOldChangesList';
$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'LqtDispatch::setNewtalkHTML';

$wgSpecialPages['DeleteThread'] = 'SpecialDeleteThread';
$wgSpecialPages['MoveThread'] = 'SpecialMoveThread';
$wgSpecialPages['NewMessages'] = 'SpecialNewMessages';

// Obtained with $ grep -ir 'class .*' *.php | perl -n -e 'if (/(\w+\.php):\s*class (\w+)/) {print "\$wgAutoloadClasses['\''$2'\''] = \$dir.'\''$1'\'';\n";}'
$wgAutoloadClasses['LqtDispatch'] = $dir.'LqtBaseView.php';
$wgAutoloadClasses['LqtView'] = $dir.'LqtBaseView.php';
$wgAutoloadClasses['Date'] = $dir.'LqtModel.php';
$wgAutoloadClasses['Post'] = $dir.'LqtModel.php';
$wgAutoloadClasses['ThreadHistoryIterator'] = $dir.'LqtModel.php';
$wgAutoloadClasses['HistoricalThread'] = $dir.'LqtModel.php';
$wgAutoloadClasses['Thread'] = $dir.'LqtModel.php';
$wgAutoloadClasses['Threads'] = $dir.'LqtModel.php';
$wgAutoloadClasses['QueryGroup'] = $dir.'LqtModel.php';
$wgAutoloadClasses['NewMessages'] = $dir.'LqtModel.php';
$wgAutoloadClasses['TalkpageView'] = $dir.'LqtPages.php';
$wgAutoloadClasses['TalkpageArchiveView'] = $dir.'LqtPages.php';
$wgAutoloadClasses['ThreadPermalinkView'] = $dir.'LqtPages.php';
$wgAutoloadClasses['TalkpageHeaderView'] = $dir.'LqtPages.php';
$wgAutoloadClasses['IndividualThreadHistoryView'] = $dir.'LqtPages.php';
$wgAutoloadClasses['ThreadDiffView'] = $dir.'LqtPages.php';
$wgAutoloadClasses['ThreadWatchView'] = $dir.'LqtPages.php';
$wgAutoloadClasses['ThreadProtectionFormView'] = $dir.'LqtPages.php';
$wgAutoloadClasses['ThreadHistoryListingView'] = $dir.'LqtPages.php';
$wgAutoloadClasses['ThreadHistoricalRevisionView'] = $dir.'LqtPages.php';
$wgAutoloadClasses['SummaryPageView'] = $dir.'LqtPages.php';
$wgAutoloadClasses['SpecialMoveThread'] = $dir.'LqtPages.php';
$wgAutoloadClasses['SpecialDeleteThread'] = $dir.'LqtPages.php';
$wgAutoloadClasses['NewUserMessagesView'] = $dir.'LqtPages.php';
$wgAutoloadClasses['SpecialNewMessages'] = $dir.'LqtPages.php';
