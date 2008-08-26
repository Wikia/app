<?php

define('MEDIAWIKI', true );

require_once("../../../../LocalSettings.php");
require_once("../../php-tools/ProgressBar.php");
require_once("DatabaseUtilities.php");
require_once("Setup.php");

ob_end_flush();

global
	$beginTime, $wgCommandLineMode;

$beginTime = time();
$wgCommandLineMode = true;

for ($i = 1; $i < $argc; $i++) {
	$tableName = $argv[$i];
	echo "\nDropping indices from table: " . $tableName . "\n";
	dropAllIndicesFromTable($tableName);
}

$endTime = time();
echo("\n\nTime elapsed: " . durationToString($endTime - $beginTime)); 


