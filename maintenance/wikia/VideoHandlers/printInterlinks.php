<?php


ini_set( "include_path", dirname(__FILE__)."/.." );
//require_once( 'commandLine.inc' );

ini_set( 'display_errors', 'stdout' );
$options = array('help');
@require_once( '../../commandLine.inc' );

global $IP, $wgCityId, $wgDBname, $wgExternalDatawareDB;
$devboxuser = exec('hostname');

// $IP = '/home/pbablok/video/VideoRefactor/'; // HACK TO RUN ON SANDBOX
// echo( "$IP\n" );


$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalDatawareDB );


$rows = $dbr->query( "SELECT * FROM video_interwiki" );

while( $file = $dbr->fetchObject( $rows ) ) {
	$title = GlobalTitle::newFromId( $file->article_id, $file->city_id );
	if ( $title )
		echo $title->getFullURL() . "\n";
}

?>