<?php

ini_set( "include_path", dirname(__FILE__)."/.." );

ini_set( 'display_errors', 'stdout' );
$options = array('help');
require_once( '../../commandLine.inc' );

global $IP, $wgCityId, $wgExternalDatawareDB;

echo "***Cleanup*** script running for $wgCityId\n";


$dbw = wfGetDB( DB_MASTER );
$dbw_dataware = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );



$rows = $dbw->query( "SELECT * FROM image WHERE img_name like ':%' OR img_name like 'Video:%'" );
$rowCount = $rows->numRows();
echo( ": {$rowCount} old-style videos found\n" );

while( $file = $dbw->fetchObject( $rows ) ) {
	echo $file->img_name . "\n";
	$dbw_dataware->insert('video_imagetable_backup',
		array(
			'wiki_id' => $wgCityId,
			'img_name' => $file->img_name,
			'img_metadata' => $file->img_metadata,
			'img_user' => $file->img_user,
			'img_user_text' => $file->img_user_text,
			'img_timestamp' => $file->img_timestamp
		)
	);
}
$dbw->freeResult( $rows );

$dbw->query( "DELETE FROM image WHERE img_name like ':%' OR img_name like 'Video:%'" );

$rows = $dbw->query( "SELECT page_id, page_namespace, page_title
					  FROM page
					  WHERE page_namespace = " . NS_LEGACY_VIDEO );
$rowCount = $rows->numRows();

echo( ": {$rowCount} articles found\n" );

while( $page = $dbw->fetchObject( $rows ) ) {
	$article = Article::newFromID( $page->page_id );
	$article->doDeleteArticle('VideoRefactoring cleanup', true);
}

$dbw->freeResult( $rows );


wfWaitForSlaves( 2 );



?>