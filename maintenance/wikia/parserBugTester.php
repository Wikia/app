<?php
/**
 * @author Garrett Bruin
 * @contributor Sean Colombo
 *
 * This maintenance script is a test runner for the fixes to:
 * https://bugzilla.wikimedia.org/show_bug.cgi?id=17031
 *
 * It will be run before and after the fixes are applied.
 */

 
ini_set( "include_path", dirname(__FILE__)."/../" );
require_once( 'commandLine.inc' );

 

//Avoid unstubbing $wgParser on setHook() too early on modern (1.12+) MW versions, as per r35980
if ( defined( 'MW_SUPPORTS_PARSERFIRSTCALLINIT' ) ) {
	$wgHooks['ParserFirstCallInit'][] = 'efSampleParserInit';
} else { // Otherwise do things the old fashioned way
	$wgExtensionFunctions[] = 'efSampleParserInit';
}

function efSampleParserInit() {
	global $wgParser;
	$wgParser->setHook( 'stest', 'efSampleRender' );
	$wgParser->setHook( 'fb:like-box', 'efSampleRender' );
	return true;
}

function efSampleRender( $text, $args, $parser ) {
	$attrs = "";
	foreach( $args as $name => $value ) {
		$attrs .= " $name=\"" . htmlspecialchars($value) . '"';
	}
	return "<stest{$attrs}>" . $parser->recursiveTagParse($text) . "</stest>";
}

///// TEST DATA /////
$inputOutputPairs = array(
	'<stest facebook-logo="true" a:b="c" z_-.Z="val" A:B-c.1_2:3="val" _1="2">These attribs should be passed through</stest>' =>
	'<stest facebook-logo="true" a:b="c" z_-.z="val" a:b-c.1_2:3="val" _1="2">These attribs should be passed through</stest>',

	'<stest -a="no" .b="no" 0c="no" 9d="no" don\'t="no" a=b="c" a%="no" hi"="no" a$="no" a@="no" ^a="no" a*="no" a(b)="no">Denied</stest>' =>
	'<stest>Denied</stest>',

	'<stest profile-id="107399782623294"></stest>' =>
	'<stest profile-id="107399782623294"></stest>',

	'<stest profile-id="107399782623294"/>' =>
	'<stest profile-id="107399782623294"></stest>',

	'<stest name="Wikia"></stest>' =>
	'<stest name="Wikia"></stest>'
);
///// TEST DATA /////


print "Testing parser tag examples...\n";
print count($inputOutputPairs)." test cases.\n";

global $wgParser, $wgUser;
$parserOptions = ParserOptions::newFromUser( $wgUser );
$title = Title::makeTitle( NS_MAIN, "Main_Page");

$numSuccesses = 0;
$numFailures = 0;
foreach($inputOutputPairs as $input => $expectedOutput){

	$actualOutput = $wgParser->parse($input, $title, $parserOptions)->getText();
	
	// The parser wraps the tags in paragraphs.
	$expectedOutput = "<p>$expectedOutput\n</p>";
	
	if($actualOutput != $expectedOutput){
		print "\n------------------------------------------\n";
		print "                 MISMATCH!\n";
		print "------------------------------------------\n";
		print "INPUT:    $input\n";
		print "EXPECTED: $expectedOutput\n";
		print "ACTUAL:   $actualOutput\n";
		print "------------------------------------------\n";
		$numFailures++;
	} else {
		print "Test passed.\n";
		$numSuccesses++;
	}
}

print "\n\n\n== RESULTS ==\n";
print "Number of failures: $numFailures\n";
print "Number of successes: $numSuccesses\n";
if($numFailures > 0){
	print "THE TESTS FAILED!! <--------------- BAD BAD BAD\n";
} else {
	print "All tests passed.\n";
}
