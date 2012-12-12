<?php
  $wgHooks['ParserFirstCallInit'][] = "wfFieldset";

/**
 * @param Parser $parser
 * @return bool
 */
function wfFieldset( $parser ) {
     $parser->setHook( "fieldset", "renderFieldset" );
     return true;
 }

 # The callback function for converting the input text to HTML output
 function renderFieldset( $input, $argv, &$parser) {
 	 #global $wgOut;
     # $argv is an array containing any arguments passed to the extension like <example argument="foo" bar>..

     $localParser = new Parser();
     $outputObj = $localParser->Parse($input, $parser->mTitle, $parser->mOptions);

     $output = "<fieldset>\n";
	 if(!empty($argv['legend']))
	   	 $output .= "<legend><b>".$argv['legend']."</b></legend>\n";
     $output .= $outputObj->getText() . '</fieldset>';
     return $output;
 }
