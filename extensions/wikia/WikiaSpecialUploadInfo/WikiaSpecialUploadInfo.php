<?php
if ( ! defined( 'MEDIAWIKI' ) )
    die();

$wgHooks['UploadComplete'][]  = 'wfSpecialUploadPutInformation';

/*
create table _wikialogs_.upload_path (
  up_id int(8) unsigned not null,
  up_title varchar(255) not null,
  up_path varchar(255) not null,
  up_created char(14) default '',
  up_sent char(14) default '',
  up_flags int(8) default 0,
  KEY  (up_id),
  KEY up_title (up_title)
);
*/ 

function wfSpecialUploadPutInformation($uploadForm) {
	global $wgRequest;

	$title = $uploadForm->mLocalFile->getTitle();
	if ( !($title instanceof Title) ) {
		return true;
	}
	if ( !($uploadForm->mLocalFile instanceof LocalFile) ) {
		return true;
	}
	$mTitle = $title->getText();
	$fullPath = $uploadForm->mLocalFile->getFullPath();

	$dbw = wfGetDB( DB_MASTER );
	$imgRow = array(
		'up_id' => $title->getArticleId(),
		'up_title' => $mTitle,
		'up_path' => $fullPath,
		'up_created' => wfTimestampNow()
	);
	$dbw->insert( "`_wikialogs_`.`upload_path`", $imgRow, __METHOD__ );

	return true;
}
