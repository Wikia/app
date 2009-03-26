#!/usr/bin/env php
<?php

/*
 * This file is used to test Wikia changes in MW parser files
 * related to Wysiwyg editor
 *
 * Please note that test cases related to external links whitelist
 * may fail if connection to white list server will timeout
 *
 * You should also have [[Test]] page on your wiki
 *
 * @auhtor Maciej Brencz <macbre@wikia-inc.com>
 */

require('t/Test.php');
require('maintenance/parserTests.inc');

// run wysiwyg parser and compare its output with given HTML and meta-data array
function parseOk($wikitext, $html, $data) {
	// clean meta-data before test case run
	global $wgWysiwygMetaData;
	$wgWysiwygMetaData = NULL;

	// parse wikitext
	list($outputHtml, $outputData) = Wysiwyg_WikiTextToHtml($wikitext, 1);

	// test it
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
	),

	// paragraphs
	array(
		'name'     => 'Paragraphs',
		'wikitext' => "1\n2\n\n3\n\n\n4\n\n\n\n5\n\n\n\n\n6",
		'html'     => "<p _new_lines_before=\"0\">1<!--EOL1-->\n<!--NEW_LINE_1-->2<!--EOL1-->\n</p><p>3<!--EOL1-->\n</p><p><br /><!--EOL1-->\n<!--NEW_LINE_1-->4<!--EOL1-->\n</p><p><br /><!--EOL1-->\n</p><p>5<!--EOL1-->\n</p><p><br /><!--EOL1-->\n</p><p><br /><!--EOL1-->\n<!--NEW_LINE_1-->6<!--EOL1-->\n</p>",
	),

	// headers
	array(
		'name'     => 'Headers',
		'wikitext' => "== h==",
		'html'     => "<h2 _wysiwyg_line_start=\"true\" refid=0> h</h2><!--EOL1-->\n",
		'data'     => array(array('level' => 2, 'linesBefore' => 0, 'linesAfter' => 1)),
	),

	// external links
	array(
		'name'     => 'External links',
		'wikitext' => "[http://wp.pl] abc [http://foo.com foo] raw http://bar.net",
		'html'     => "<p _new_lines_before=\"0\"><a href=\"http://wp.pl\" class=\"external autonumber\" rel=\"nofollow\" refid=\"0\">[1]</a> abc <a href=\"http://foo.com\" class=\"external text\" rel=\"nofollow\" refid=\"2\">foo</a> raw <a href=\"http://bar.net\" class=\"external free\" rel=\"nofollow\" refid=\"1\">http://bar.net</a><!--EOL1-->\n</p>",
		'data'     => array(
				array('type' => 'external link', 'href' => 'http://wp.pl'),
				array('type' => 'external link: raw', 'href' => 'http://bar.net'),
				array('type' => 'external link', 'href' => 'http://foo.com'),
			),
	),

	// external white list images
	array(
		'name'     => 'External white list images',
		'wikitext' => "http://upload.wikimedia.org/wikipedia/commons/thumb/9/98/Melanargia_galathea-polowiec_szachownica.JPG/250px-Melanargia_galathea-polowiec_szachownica.JPG",
		'html'     => "<p _new_lines_before=\"0\"><a href=\"http://upload.wikimedia.org/wikipedia/commons/thumb/9/98/Melanargia_galathea-polowiec_szachownica.JPG/250px-Melanargia_galathea-polowiec_szachownica.JPG\"   refid=\"1\">http://upload.wikimedia.org/wikipedia/commons/thumb/9/98/Melanargia_galathea-polowiec_szachownica.JPG/250px-Melanargia_galathea-polowiec_szachownica.JPG</a><!--EOL1-->\n</p>",
		'data'     => array(
				array('type' => 'external link: raw image', 'href' => 'http://upload.wikimedia.org/wikipedia/commons/thumb/9/98/Melanargia_galathea-polowiec_szachownica.JPG/250px-Melanargia_galathea-polowiec_szachownica.JPG'),
				array('type' => 'external link: raw', 'href' => 'http://upload.wikimedia.org/wikipedia/commons/thumb/9/98/Melanargia_galathea-polowiec_szachownica.JPG/250px-Melanargia_galathea-polowiec_szachownica.JPG'),
			),
	),

	// external not white list images
	array(
		'name'     => 'External not white list images',
		'wikitext' => "http://www.google.pl/intl/en_com/images/logo_plain.png",
		'html'     => "<p _new_lines_before=\"0\"><a href=\"http://www.google.pl/intl/en_com/images/logo_plain.png\" class=\"external free\" rel=\"nofollow\" refid=\"0\">http://www.google.pl/intl/en_com/images/logo_plain.png</a><!--EOL1-->\n</p>",
		'data'     => array(
				array('type' => 'external link: raw', 'href' => 'http://www.google.pl/intl/en_com/images/logo_plain.png'),
			),
	),

	// internal links
	array(
		'name'     => 'Internal links',
		'wikitext' => "[[Test]] [[Test|foo]] [[Test]]s",
		'html'     => "<p _new_lines_before=\"0\"><a href=\"/index.php/Test\" refid=\"0\">Test</a> <a href=\"/index.php/Test\" refid=\"1\">foo</a> <a href=\"/index.php/Test\" refid=\"2\">Tests</a><!--EOL1-->\n</p>",
		'data'     => array(
				array('type' => 'internal link', 'href' => 'Test', 'description' => '', 'original' => '[[Test]]'),
				array('type' => 'internal link', 'href' => 'Test', 'description' => 'foo', 'original' => '[[Test|foo]]'),
				array('type' => 'internal link', 'href' => 'Test', 'description' => '', 'trial' => 's', 'original' => '[[Test]]'),
			),
	),


);

// how many tests to run
plan(count($testCases) * 2);

// diagnostic message
diag('Parser test');
diag('');

foreach($testCases as $testCase) {
	diag($testCase['name']);
	parseOk($testCase['wikitext'], $testCase['html'], isset($testCase['data']) ? $testCase['data'] : NULL);
}

// finish the test
