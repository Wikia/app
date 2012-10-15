<?php

ini_set( 'display_errors', 'stdout' );

require_once("../commandLine.inc");
require_once("../../extensions/wikia/AchievementsII/Ach_setup.php");

$dbw = wfGetDB(DB_MASTER);

global $wgDBname;

echo "Adding tables to: $wgDBname\n";

$tables = file_get_contents("../../extensions/wikia/AchievementsII/schema_local.sql");

$split = explode( "\n\n", $tables );

foreach( $split as $table ) {
	//echo "executing '$table' \n\n";
	$dbw->query( $table );
}

wfWaitForSlaves(2);