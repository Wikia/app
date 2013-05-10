<?php

ini_set( "include_path", dirname( __FILE__ )."/../../../maintenance/" );
require_once( "commandLine.inc" );

define("FILENAME_GOURCE", "gource.log");
define("FILENAME_LOGSTALGIA", "logstalgia.log");

$gouRen = new EvolutionGourceLogRenderer();
$logstRen = new EvolutionLogstalgiaLogRenderer();
$model = new EvolutionModel($wgDBname);

print "\n". "Generating log files..." . "\n";

$folder_path = $wgDBname ;
if (!is_dir($folder_path)) {
	mkdir($folder_path, 0700);
}
$file_g = $folder_path . '/' . FILENAME_GOURCE;
$file_l = $folder_path . '/' . FILENAME_LOGSTALGIA;

$fg = fopen($file_g, "w");
$fl = fopen($file_l, "w");

while ( $row = $model->formARow() ) {
	if ($row == 'skip') {
		continue;
	}
	fwrite($fg, $gouRen->renderOneRow( $row ) );
	fwrite($fl, $logstRen->renderOneRow( $row ) );
}
fclose($fg);
fclose($fl);

print "\n". "Done." . "\n";
