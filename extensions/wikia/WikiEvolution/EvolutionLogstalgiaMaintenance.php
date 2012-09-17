<?php

include("EvolutionModel.class.php");
include("EvolutionAbstractLogRenderer.class.php");
include("EvolutionLogstalgiaLogRenderer.class.php");

define("FILENAME", "logstalgia.log");

$logstRen = new EvolutionLogstalgiaLogRenderer();
$model = new EvolutionModel();

print "\n". "Generating log file..." . "\n";

$file = FILENAME;
$f = fopen($file, "w");

while ( $row = $model->formARow() ) {
	if ($row == 'skip') {
		continue;
	}
	fwrite($f, $logstRen->renderOneRow( $row ) );	
}
fclose($f);

print "\n". "Done." . "\n";
?>
