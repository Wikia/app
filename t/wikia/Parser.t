#!/usr/bin/env php
<?php

/*
 * This file is used to test Wikia changes in MW parser files
 * related to Wysiwyg editor
 *
 * @auhtor Maciej Brencz <macbre@wikia-inc.com>
 */

require('t/Test.php');
require('maintenance/parserTests.inc');
//require('extensions/wikia/Wysiwyg/Wysiwyg.php');

// run wysiwyg parser and compare its output and given HTML and meta-data array
function parseOk($wikitext, $html, $data = NULL) {
	list($outputHtml, $outputData) = Wysiwyg_WikiTextToHtml($wikitext, 1);

	//var_dump($outputHtml);var_dump($outputData);

	//diag('wikitext: ' . $wikitext);
	is($outputHtml,$html,  'comparing HTML');
	is_deeply($outputData, $data, 'comparing meta-data');
}

// set of wikitext test cases
$testCases = array(

	// simple formatting
	array(
		'name'     => 'Simple formatting',
		'wikitext' => "''foo'' '''bar'''",
		'html'     => "<p _new_lines_before=\"0\"><i>foo</i> <b>bar</b><!--EOL1-->\n</p>",
		'data'     => NULL,
	),

	// paragraphs
	array(
		'name'     => 'Paragraphs',
		'wikitext' => "1\n2\n\n3\n\n\n4\n\n\n\n5\n\n\n\n\n6",
		'html'     => "<p _new_lines_before=\"0\">1<!--EOL1-->\n<!--NEW_LINE_1-->2<!--EOL1-->\n</p><p>3<!--EOL1-->\n</p><p><br /><!--EOL1-->\n<!--NEW_LINE_1-->4<!--EOL1-->\n</p><p><br /><!--EOL1-->\n</p><p>5<!--EOL1-->\n</p><p><br /><!--EOL1-->\n</p><p><br /><!--EOL1-->\n<!--NEW_LINE_1-->6<!--EOL1-->\n</p>",
		'data'     => NULL,
	),

	// headers
	array(
		'name'     => 'Headers',
		'wikitext' => "== h==",
		'html'     => "<h2 _wysiwyg_line_start=\"true\" refid=0> h</h2><!--EOL1-->\n",
		'data'     => array(array('level' => 2, 'linesBefore' => 0, 'linesAfter' => 1)),
	),

);

// how many tests to run
plan(count($testCases) * 2);

// diagnostic message
diag('Parser test');
diag('');

foreach($testCases as $testCase) {
	diag($testCase['name']);
	parseOk($testCase['wikitext'], $testCase['html'], $testCase['data']);
}

// finish the test
