<?php
if ( !defined('MEDIAWIKI') ) {
	echo "This is a MediaWiki extension.\n";
	exit(1);
}

/*
 * @author Federico "Lox" Lucignano
 * This extension is meant for debugging the "Download index.php" issue as
 * reported in RT#139312, it's meant to be enable only on Development/Staging environments
 */

$dir = dirname(__FILE__) . '/';

// RIGHTS
$wgAvailableRights[] = 'forcedownloadindex';
$wgGroupPermissions['*']['forcedownloadindex'] = false;
$wgGroupPermissions['staff']['forcedownloadindex'] = true;

$wgAutoloadClasses['ForceDownloadIndex'] = $dir . 'SpecialForceDownloadIndex.body.php'; # Tell MediaWiki to load the extension body.

#$wgSpecialPages['ContactForm'] = 'ContactForm'; # Let MediaWiki know about your new special page.
extAddSpecialPage( $dir . 'SpecialForceDownloadIndex.body.php', 'ForceDownloadIndex', 'SpecialForceDownloadIndex' );

$wgSpecialPageGroups['Contact'] = 'wikia';

//$wgHooks['ArticleSave'][] = 'forceDownloadIndexOnArticleSave';

function forceDownloadIndexOnArticleSave( &$article, &$user, &$text, &$summary,
 $minor, &$watchthis, $sectionanchor, &$flags, &$status ) {
	global $wgOut;
	
	$wgOut->disable();

	header("Content-type: application/octet-stream");
	return true;
}