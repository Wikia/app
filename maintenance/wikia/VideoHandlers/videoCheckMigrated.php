<?php
ini_set( 'display_errors', 'stdout' );
$options = array('help');

require_once( '../../commandLine.inc' );

global $IP, $wgCityId, $wgExternalDatawareDB;

#$IP = '/home/pbablok/video/VideoRefactor/'; // HACK TO RUN ON SANDBOX
echo( "Check migration for $wgCityId\n" );

$dbr = wfGetDB( DB_SLAVE );
$dbw_dataware = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );

$rows = $dbr->select('image',
	array( 'img_name' ),
	array( "img_name LIKE ':%'" ),
	__METHOD__
);

$rowCount = $rows->numRows();

$dbr->freeResult($rows);

$v = WikiFactory::getVarByName('wgVideoHandlersVideosMigrated', $wgCityId);
$ve = $v->cv_value;
echo(": {$rowCount} old videos found ($ve)\n");

if($rowCount > 0 && $ve != True) {
//if(true) {
	$dbw_dataware->insert(
		'video_notmigrated2',
		array(
			'wiki_id' => $wgCityId,
			'wiki_name' => WikiFactory::getWikiByID($wgCityId)->city_url,
			'video_count' => $rowCount
		)
	);
	echo("$wgCityId has videos but was not migrated!\n");
}


?>
