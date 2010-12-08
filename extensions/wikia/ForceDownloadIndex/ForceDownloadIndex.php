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

$wgHooks['ArticleSave'][] = 'forceDownloadIndexOnArticleSave';

function forceDownloadIndexOnArticleSave( &$article, &$user, &$text, &$summary,
 $minor, &$watchthis, $sectionanchor, &$flags, &$status ) {
	global $wgOut;
	
	$wgOut->disable();
	/* here the following are triggering the same behaviour
	 * - setting it to application/octet-stream
	 * - setting it with an empty value
	 * - setting a malformed content type header
	 * Beware that all this are valid only for Firefox, Chrome is still able
	 * to show a blank page for no header and empty value
	 */
	
	header("Content-type: ");
	
	return true;
}