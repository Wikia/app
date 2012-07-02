<?php
/**
 * InterwikiIntegration extension by Tisane
 * URL: http://www.mediawiki.org/wiki/Extension:InterwikiIntegration
 *
 * This program is free software. You can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version. You can also redistribute it and/or
 * modify it under the terms of the Creative Commons Attribution 3.0 license
 * or any later version.
 * 
 * This extension causes interwiki links to turn blue if the target page exists on
 * the target wiki, and red if it does not. It only works when the target wiki
 * is on the same wiki farm and is set up with this same extension.
 */
 
/* Alert the user that this is not a valid entry point to MediaWiki if they try to access the
special pages file directly.*/
if ( !defined( 'MEDIAWIKI' ) ) {
	echo <<<EOT
		To install the InterwikiIntegration extension, put the following line in LocalSettings.php:
		require( "extensions/InterwikiIntegration/InterwikiIntegration.php" );
EOT;
	exit( 1 );
}
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Interwiki Integration',
	'author' => 'Tisane',
	'url' => 'https://www.mediawiki.org/wiki/Extension:InterwikiIntegration',
	'descriptionmsg' => 'integration-desc',
	'version' => '1.0.4',
);
$dir = dirname( __FILE__ ) . '/';
$wgAutoloadClasses['InterwikiIntegrationHooks'] = $dir . 'InterwikiIntegration.hooks.php';
$wgAutoloadClasses['PopulateInterwikiIntegrationTable'] = "$dir/SpecialInterwikiIntegration.php";
$wgAutoloadClasses['PopulateInterwikiWatchlistTable'] = "$dir/SpecialInterwikiIntegration.php";
$wgAutoloadClasses['PopulateInterwikiRecentChangesTable'] = "$dir/SpecialInterwikiIntegration.php";
$wgAutoloadClasses['PopulateInterwikiPageTable'] = "$dir/SpecialInterwikiIntegration.php";
$wgAutoloadClasses['InterwikiWatchlist'] = "$dir/SpecialInterwikiWatchlist.php";
$wgAutoloadClasses['InterwikiRecentChanges'] = "$dir/SpecialInterwikiRecentChanges.php";
$wgAutoloadClasses['InterwikiIntegrationFunctions'] = "$dir/InterwikiIntegration.body.php";
$wgAutoloadClasses['InterwikiIntegrationRecentChange'] = "$dir/InterwikiIntegrationRecentChange.php";
$wgAutoloadClasses['InterwikiIntegrationChangesList'] = "$dir/InterwikiIntegrationChangesList.php";
$wgAutoloadClasses['EnhancedInterwikiIntegrationChangesList'] = "$dir/InterwikiIntegrationChangesList.php";
$wgAutoloadClasses['OldInterwikiIntegrationChangesList'] = "$dir/InterwikiIntegrationChangesList.php";
$wgExtensionMessagesFiles['InterwikiIntegration'] = $dir . 'InterwikiIntegration.i18n.php';
$wgHooks['LoadExtensionSchemaUpdates'][] = 'InterwikiIntegrationHooks::InterwikiIntegrationCreateTable';
$wgHooks['ArticleEditUpdates'][] = 'InterwikiIntegrationHooks::InterwikiIntegrationArticleEditUpdates';
$wgHooks['LinkBegin'][] = 'InterwikiIntegrationHooks::InterwikiIntegrationLink';
$wgHooks['ArticleInsertComplete'][] = 'InterwikiIntegrationHooks::InterwikiIntegrationArticleInsertComplete';
$wgHooks['ArticleDeleteComplete'][] = 'InterwikiIntegrationHooks::InterwikiIntegrationArticleDeleteComplete';
$wgHooks['ArticleUndelete'][] = 'InterwikiIntegrationHooks::InterwikiIntegrationArticleUndelete';
$wgHooks['TitleMoveComplete'][] = 'InterwikiIntegrationHooks::InterwikiIntegrationTitleMoveComplete';
$wgHooks['PureWikiDeletionArticleBlankComplete'][] = 'InterwikiIntegrationHooks::InterwikiIntegrationArticleBlankComplete';
$wgHooks['PureWikiDeletionArticleUnblankComplete'][] = 'InterwikiIntegrationHooks::InterwikiIntegrationArticleUnblankComplete';
$wgHooks['ArticleEditUpdatesDeleteFromRecentchanges'][] = 'InterwikiIntegrationHooks::InterwikiIntegrationArticleEditUpdatesDeleteFromRecentchanges';
$wgHooks['RecentChange_save'][] = 'InterwikiIntegrationHooks::InterwikiIntegrationRecentChange_save';
$wgHooks['WatchArticleComplete'][] = 'InterwikiIntegrationHooks::InterwikiIntegrationWatchArticleComplete';
$wgHooks['UnwatchArticleComplete'][] = 'InterwikiIntegrationHooks::InterwikiIntegrationUnwatchArticleComplete';
$wgHooks['ArticleSaveComplete'][] = 'InterwikiIntegrationHooks::InterwikiIntegrationArticleSaveComplete';
$wgSpecialPages['PopulateInterwikiIntegrationTable'] = 'PopulateInterwikiIntegrationTable';
$wgSpecialPages['PopulateInterwikiWatchlistTable'] = 'PopulateInterwikiWatchlistTable';
$wgSpecialPages['PopulateInterwikiRecentChangesTable'] = 'PopulateInterwikiRecentChangesTable';
$wgSpecialPages['PopulateInterwikiPageTable'] = 'PopulateInterwikiPageTable';
$wgSpecialPages['InterwikiWatchlist'] = 'InterwikiWatchlist';
$wgSpecialPages['InterwikiRecentChanges'] = 'InterwikiRecentChanges';
$wgSpecialPageGroups['InterwikiWatchlist'] = 'changes';
$wgSpecialPageGroups['InterwikiRecentChanges'] = 'changes';
$wgSpecialPageGroups['PopulateInterwikiIntegrationTable'] = 'wiki';
$wgSpecialPageGroups['PopulateInterwikiWatchlistTable'] = 'wiki';
$wgSpecialPageGroups['PopulateInterwikiRecentChangesTable'] = 'wiki';
$wgSpecialPageGroups['PopulateInterwikiPageTable'] = 'wiki';
$wgSharedTables[] = 'integration_prefix';
$wgSharedTables[] = 'integration_namespace';
$wgSharedTables[] = 'integration_iwlinks';
$wgSharedTables[] = 'integration_watchlist';
$wgSharedTables[] = 'integration_recentchanges';
$wgSharedTables[] = 'integration_page';
$wgInterwikiIntegrationBrokenLinkStyle = "color: red";
$wgAvailableRights[] = 'integration';
$wgGroupPermissions['bureaucrat']['integration']    = true;