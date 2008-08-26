<?php
# A very simple skeleton Wikidata script.

define('MEDIAWIKI', true );

require_once("../../../../StartProfiler.php");
require_once("../../../../LocalSettings.php");
require_once("../../php-tools/ProgressBar.php");
require_once("Setup.php");
require_once("../Wikidata.php");


global
$beginTime, $wgCommandLineMode;

$beginTime = time();
$wgCommandLineMode = true;
$dc = "uw";

/* insert code here */

$dataSets=wdGetDataSets();
var_dump($dataSets);


$endTime = time();
echo("\n\nTime elapsed: " . durationToString($endTime - $beginTime)); 

?>
