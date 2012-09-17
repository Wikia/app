<?php

include("EvolutionModel.class.php");
include("EvolutionAbstractLogRenderer.class.php");
include("EvolutionGourceLogRenderer.class.php");
include("EvolutionLogstalgiaLogRenderer.class.php");

define("FILENAME_GOURCE", "gource.log");
define("FILENAME_LOGSTALGIA", "logstalgia.log");

$gouRen = new EvolutionGourceLogRenderer();
$logstRen = new EvolutionLogstalgiaLogRenderer();
$model = new EvolutionModel();

print "\n". "Generating log files..." . "\n";

$file_g = FILENAME_GOURCE;
$file_l = FILENAME_LOGSTALGIA;

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
?>
