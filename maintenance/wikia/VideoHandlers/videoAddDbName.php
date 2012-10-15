<?php
ini_set( 'display_errors', 'stdout' );
$options = array('help');

require_once( '../../commandLine.inc' );

global $IP, $wgCityId, $wgExternalDatawareDB;

#$IP = '/home/pbablok/video/VideoRefactor/'; // HACK TO RUN ON SANDBOX
echo( "Check migration for $wgCityId\n" );

$dbr = wfGetDB( DB_SLAVE );
$dbw_dataware = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );

$rows = $dbw_dataware->select('video_migration_log',
	array( 'distinct wiki_id' )
);

$rowCount = $rows->numRows();

while($wiki = $dbw_dataware->fetchObject( $rows ) ) {
	$v = WikiFactory::getWikiByID($wiki->wiki_id);

	$dbw_dataware->update(
		'video_migration_log',
		array(
			'wiki_dbname' => $v->city_dbname,
		),
		array(
			'wiki_id' => $wiki->wiki_id
		)
	);
}


?>
