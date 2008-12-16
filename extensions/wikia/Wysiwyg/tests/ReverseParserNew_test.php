<?php
require_once('../ReverseParserNew.php');

function wfProfileIn($a) {}
function wfProfileOut($a) {}
function wfDebug($a) {}
function wfSuppressWarnings() {}
function wfRestoreWarnings() {}

$htmlFiles = glob('html_*');
foreach($htmlFiles as $htmlFile) {
	$testNo = substr($htmlFile, 5);

	$reverseParser = new ReverseParser();
	$out = $reverseParser->parse(file_get_contents($htmlFile), json_decode(file_get_contents('data_'.$testNo), true));

	if($out != file_get_contents('wikitext_'.$testNo)) {
		file_put_contents('out_'.$testNo, $out);
		echo "\n\nERROR, TEST NO: $testNo\n\n";
		//exit();
	} else {
		echo "\n\nSUCCESS, TEST NO: $testNo\n\n";
	}

}
