<?php

/**
 * @author Piotr Molski <moli@wikia.com>
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
 *
 * Hook which add additional info to dataware
 */
if ( ! defined( 'MEDIAWIKI' ) ) {
    die();
}

$wgHooks['UploadComplete'][]  = 'wfSpecialUploadPutInformation';


function wfSpecialUploadPutInformation( $uploadForm ) {
	global $wgRequest, $wgCityId;

	$title = $uploadForm->mLocalFile->getTitle();
	if( !($title instanceof Title) ) {
		return true;
	}
	if( !($uploadForm->mLocalFile instanceof LocalFile) ) {
		return true;
	}
	$mTitle = $title->getText();
	$relPath = $uploadForm->mLocalFile->getRel();
	$fullPath = $uploadForm->mLocalFile->getFullPath();

	$dbw = wfGetDBExt( DB_MASTER );
	$dbw->insert(
		"upload_log",
		array(
			"up_id" 	=> $title->getArticleId(),
			"up_path" 	=> $fullPath,
			"up_imgpath"=> $relPath,
			"up_flags"	=> 0,
			"up_title" 	=> $mTitle,
			"up_created"=> wfTimestampNow(),
			"up_city_id"=> $wgCityId
		),
		__METHOD__
	);

	return true;
}
