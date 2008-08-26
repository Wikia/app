<?php
 
function loadEC2GoMapping($fileName) {
	$mapping=array();
	$fileHandle = fopen($fileName, "r");
	
	while (!feof($fileHandle)) {
		$buffer = fgets($fileHandle);
	    $buffer = rtrim($buffer,"\n");
	    $currentPrefix = substr($buffer, 0, 1);
	    if(($currentPrefix != "!") and (substr($buffer, 0, 2) == "EC")) {
			$startPositionEC = strpos($buffer, "EC:");
			$endPositionEC = strpos($buffer, ">");
			$startPositionGO = strpos($buffer, "; GO:");
			$endPositionGO = strlen($buffer);
			$EC = substr($buffer, $startPositionEC + 3, $endPositionEC - $startPositionEC - 4);
//			Modify EC code to match 4 digit notation: "EC 6.5.-.-"
			$EC = "EC " . $EC;
			$numberOfDigits = substr_count($EC, ".") + 1;
			while($numberOfDigits < 4) {
				$EC = $EC . ".-";
				$numberOfDigits++;
			}
			$GO = substr($buffer, $startPositionGO + 2, $endPositionGO - $startPositionGO - 2);

			$mapping[$EC] = $GO;   	
	    }
 	 }
	
	fclose($fileHandle);
	return $mapping;	
}

function loadSwissProtKeyWord2GoMapping($fileName) {
	$mapping=array();
	$fileHandle = fopen($fileName, "r");

	while (!feof($fileHandle)) {
		$buffer = fgets($fileHandle);
	    $buffer = rtrim($buffer,"\n");
	    $currentPrefix = substr($buffer, 0, 1);
	    if(($currentPrefix != "!") and (substr($buffer, 0, 5) == "SP_KW")) {
			$startPositionSP_KW = strpos($buffer, "SP_KW:");
			$endPositionSP_KW = strpos($buffer, ">");
			$startPositionGO = strpos($buffer, "; GO:");
			$endPositionGO = strlen($buffer);
			$SP_KW = substr($buffer, $startPositionSP_KW + 6, $endPositionSP_KW - $startPositionSP_KW - 7);
//			just keep 7 digit code (without description):
			$SP_KW = substr($SP_KW, 0, 7);
			$GO = substr($buffer, $startPositionGO + 2, $endPositionGO - $startPositionGO - 2);

			$mapping[$SP_KW] = $GO;   	
	    }
 	 }
	
	fclose($fileHandle);
	return $mapping;	
}

