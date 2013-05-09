<?php

ini_set( "include_path", dirname( __FILE__ )."/../../../maintenance/" );
require_once( "commandLine.inc" );

define("FILENAME", 'gource.log');

$gouRen = new EvolutionGourceLogRenderer();
$model = new EvolutionModel($wgDBname);

print "\n". "Generating log file..." . "\n";

$folder_path = $wgDBname ;
if (!is_dir($folder_path)) {
	mkdir($folder_path, 0700);
}
$file = $folder_path . '/' . FILENAME;
$f = fopen($file, "w");

while ( $row = $model->formARow() ) {
	if ($row == 'skip') {
		continue;
	}
	fwrite($f, $gouRen->renderOneRow( $row ) );	
}
fclose($f);


print "\n". "Done." . "\n";

