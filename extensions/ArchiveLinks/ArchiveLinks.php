<?php

/**
 * This is an extension to archive preemptively archive external links so that
 * in the even they go down a backup will be available.
 */

$path = dirname( __FILE__ );

$wgExtensionMessagesFiles['ArchiveLinks'] = "$path/ArchiveLinks.i18n.php";
$wgExtensionMessagesFiles['ModifyArchiveBlacklist'] = "$path/ArchiveLinks.i18n.php";
$wgExtensionMessagesFiles['ViewArchive'] = "$path/ArchiveLinks.i18n.php";

$wgAutoloadClasses['ArchiveLinks'] = "$path/ArchiveLinks.class.php";
$wgAutoloadClasses['SpecialModifyArchiveBlacklist'] = "$path/SpecialModifyArchiveBlacklist.php";
$wgAutoloadClasses['SpecialViewArchive'] = "$path/SpecialViewArchive.php";

$wgHooks['ArticleSaveComplete'][] = 'ArchiveLinks::queueExternalLinks';
$wgHooks['LinkerMakeExternalLink'][] = 'ArchiveLinks::rewriteLinks';
$wgHooks['LoadExtensionSchemaUpdates'][] = 'ArchiveLinks::schemaUpdates';

$wgSpecialPages['ModifyArchiveBlacklist'] = 'SpecialModifyArchiveBlacklist';
$wgSpecialPages['ViewArchive'] = 'SpecialViewArchive';

$wgAutoloadClasses['ApiQueryArchiveFeed'] = "$path/ApiQueryArchiveFeed.php";
$wgAPIListModules['archivefeed'] = 'ApiQueryArchiveFeed';

// Tests
/*$wgHooks['UnitTestsList'][] = 'efArchiveLinksUnitTests';

function efArchiveLinksUnitTests( &$files ) {
	$files[] = dirname( __FILE__ ) . '/ArchiveLinksTests.php';
	return true;
}*/

$wgArchiveLinksConfig = array(
	'archive_service' => 'internet_archive',
	'use_multiple_archives' => false,
	'run_spider_in_loop' => false,
	'in_progress_ignore_delay' => 7200,
	'generate_feed' => true,
);

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'ArchiveLinks',
	'description' => 'Enables archival of external links on the wiki to prevent linkrot.',
	'version' => '0.1',
	'author' => 'Kevin Brown',
	'url' => '',
);
