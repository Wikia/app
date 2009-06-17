<?php

/**
 * @author Piotr Molski <moli@wikia.com>
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
 * @copyright © 2007-2009, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 *
 * Hook which add additional info about uploaded picture to dataware database
 */
if ( ! defined( 'MEDIAWIKI' ) ) {
    die();
}

$wgHooks['UploadComplete'][]  = 'wfSpecialUploadPutInformation';

function wfSpecialUploadPutInformation( $uploadForm ) {
	global $wgRequest, $wgCityId, $wgExternalDatawareDB;

	$title = $uploadForm->mLocalFile->getTitle();
	if( !($title instanceof Title) ) {
		return true;
	}
	if( !($uploadForm->mLocalFile instanceof LocalFile) ) {
		return true;
	}

	wfProfileIn( __METHOD__ );

	$mTitle = $title->getText();
	$relPath = $uploadForm->mLocalFile->getRel();
	$fullPath = $uploadForm->mLocalFile->getFullPath();

	$aHistory = $uploadForm->mLocalFile->getHistory(1);
	$oldFileName = false;
	if ( isset($aHistory) && isset($aHistory[0]) ) {
		$oOldLocalFile = $aHistory[0];
		if ( isset($oOldLocalFile) && ($oOldLocalFile instanceof OldLocalFile) ) {
			$oldFileName = $oOldLocalFile->getArchiveName();
		}
	}

	if ( !empty($oldFileName) ) {
		$oldFileName = sprintf("%s/%s", $uploadForm->mLocalFile->getArchivePath(), $oldFileName);
	}

	$dbw = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );
	$dbw->insert(
		"upload_log",
		array(
			/** up_id is autoincrement **/
			"up_page_id"    => $title->getArticleId(),
			"up_path"       => $fullPath,
			"up_imgpath"    => $relPath,
			"up_flags"      => 0,
			"up_title"      => $mTitle,
			"up_created"    => wfTimestampNow(),
			"up_city_id"    => $wgCityId,
			"up_old_path"   => $oldFileName
		),
		__METHOD__
	);

	wfProfileOut( __METHOD__ );

	return true;
}
