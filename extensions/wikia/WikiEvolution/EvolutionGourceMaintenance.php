<?php

include("EvolutionModel.class.php");
include("EvolutionAbstractLogRenderer.class.php");
include("EvolutionGourceLogRenderer.class.php");

define("FILENAME", "gource.log");

$gouRen = new EvolutionGourceLogRenderer();
$model = new EvolutionModel();

print "\n". "Generating log file..." . "\n";

$file = FILENAME;
$f = fopen($file, "w");

while ( $row = $model->formARow() ) {
	if ($row == 'skip') {
		continue;
	}
	fwrite($f, $gouRen->renderOneRow( $row ) );	
}
fclose($f);

//$output = shell_exec('cat gource.log | gource -o');
//echo $output;

print "\n". "Done." . "\n";
?>
