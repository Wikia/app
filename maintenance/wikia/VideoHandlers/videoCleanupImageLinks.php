<?php
$_SERVER['QUERY_STRING'] = 'VideoCleanup';

ini_set( "include_path", dirname(__FILE__)."/.." );

ini_set( 'display_errors', 'stdout' );
$options = array('help');
require_once( '../../commandLine.inc' );

global $wgCityId, $wgExternalDatawareDB;

echo "*** ImageLinks Cleanup script running for $wgCityId ***\n";

$dbw = wfGetDB( DB_MASTER );
$dbw_dataware = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );

echo "-- Deleteing old style video links ... ";
$dbw->query( "DELETE FROM imagelinks WHERE il_to like ':%'", 'videoCleanup' );
echo "done";

wfWaitForSlaves( 2 );
