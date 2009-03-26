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

	// category
	array(
		'name'     => 'Category',
		'wikitext' => "[[Category:Test]]",
		'html'     => "<p _new_lines_before=\"0\"><input type=\"button\" refid=\"0\" _fck_type=\"category\" value=\"[[Category:Test]]\" title=\"[[Category:Test]]\" class=\"wysiwygDisabled wysiwygCategory\" /><!--EOL1-->\n</p>",
		'data'     => array(
				array('type' => 'category', 'href' => 'Category:Test', 'original' => '[[Category:Test]]'),
			),
	),

	// interwiki
	// use Special:InterwikiEdit if needed
	array(
		'name'     => 'Interwiki',
		'wikitext' => "[[bug:123]]",
		'html'     => "<p _new_lines_before=\"0\"><input type=\"button\" refid=\"0\" _fck_type=\"interwiki\" value=\"[[bug:123]]\" title=\"[[bug:123]]\" class=\"wysiwygDisabled wysiwygInterwiki\" /><!--EOL1-->\n</p>",
		'data'     => array(
				array('type' => 'interwiki', 'originalCall' => '[[bug:123]]'),
			),
	),

	// line breaks
	array(
		'name'     => 'Line breaks',
		'wikitext' => "abc\ndef",
		'html'     => "<p _new_lines_before=\"0\">abc<!--EOL1-->\n<!--NEW_LINE_1-->def<!--EOL1-->\n</p>",
	),

	// <pre>
	array(
		'name'     => '<pre>',
		'wikitext' => " 1\n 2\n 3",
		'html'     => "<pre>1<!--EOLPRE--><!--EOL1-->\n2<!--EOLPRE--><!--EOL1-->\n3<!--EOLPRE--><!--EOL1-->\n</pre>",
	),

	// <html>
	array(
		'name'     => '<html> hook',
		'wikitext' => "<html><div>foo</div></html>",
		'html'     => "<p _new_lines_before=\"0\"><input type=\"button\" refid=\"0\" _fck_type=\"html\" value=\"&lt;div&gt;foo&lt;/div&gt;\" title=\"&lt;div&gt;foo&lt;/div&gt;\" class=\"wysiwygDisabled wysiwygHtml\" /><!--EOL1-->\n</p>",
		'data'     => array(
				array('type' => 'html', 'description' => '<div>foo</div>'),
			),
	),

	// <nowiki>
	array(
		'name'     => '<nowiki> hook',
		'wikitext' => "<nowiki>''a''</nowiki>",
		'html'     => "<p _new_lines_before=\"0\"><input type=\"button\" refid=\"0\" _fck_type=\"nowiki\" value=\"''a''\" title=\"''a''\" class=\"wysiwygDisabled wysiwygNowiki\" /><!--EOL1-->\n</p>",
		'data'     => array(
				array('type' => 'nowiki', 'description' => "''a''"),
			),
	),

	// <gallery>
	array(
		'name'     => '<gallery> hook',
		'wikitext' => "<gallery>\nImage:Test.jpg\nImage:Foobar.png\n</gallery>",
		'html'     => "<p _new_lines_before=\"0\"><input type=\"button\" refid=\"0\" _fck_type=\"gallery\" value=\"&lt;gallery&gt;<!--EOL1-->\nImage:Test.jpg<!--EOL1-->\nImage:Foobar.png<!--EOL1-->\n&lt;/gallery&gt;\" title=\"&lt;gallery&gt;<!--EOL1-->\nImage:Test.jpg<!--EOL1-->\nImage:Foobar.png<!--EOL1-->\n&lt;/gallery&gt;\" class=\"wysiwygDisabled wysiwygGallery\" /><!--EOL1-->\n</p>",
		'data'     => array(
				array('type' => 'gallery', 'description' => "<gallery>\nImage:Test.jpg\nImage:Foobar.png\n</gallery>"),
			),
	),

	// <staff />
	array(
		'name'     => '<staff /> hook',
		'wikitext' => "<staff />",
		'html'     => "<p _new_lines_before=\"0\"><input type=\"button\" refid=\"0\" _fck_type=\"hook\" value=\"&lt;staff /&gt;\" title=\"&lt;staff /&gt;\" class=\"wysiwygDisabled wysiwygHook wysiwygHookStaff\" /><!--EOL1-->\n</p>",
		'data'     => array(
				array('type' => 'hook', 'description' => "<staff />", 'name' => 'staff'),
			),
	),

	// __TOC__
	array(
		'name'     => '__TOC__',
		'wikitext' => "__TOC__",
		'html'     => "<p _new_lines_before=\"0\"><input type=\"button\" refid=\"0\" _fck_type=\"double underscore: toc\" value=\"__TOC__\" title=\"__TOC__\" class=\"wysiwygDisabled wysiwygDoubleUnderscoreToc\" /><!--EOL1-->\n</p>",
		'data'     => array(
				array('type' => 'double underscore: toc', 'description' => '__TOC__'),
			),
	),

	// ~~~~
	array(
		'name'     => 'Signature ~~~~',
		'wikitext' => "~~~~",
		'html'     => "<p _new_lines_before=\"0\"><input type=\"button\" refid=\"0\" _fck_type=\"tilde\" value=\"~~~~\" title=\"~~~~\" class=\"wysiwygDisabled wysiwygTilde\" /><!--EOL1-->\n</p>",
		'data'     => array(
				array('type' => 'tilde', 'description' => '~~~~'),
			),
	),

	// indented paragraph
	array(
		'name'     => 'Indented paragraph',
		'wikitext' => "foo\n:: bar\ntest",
		'html'     => "<p _new_lines_before=\"0\">foo<!--EOL1-->\n</p><!--EOL1-->\n<p style=\"margin-left:80px\"> bar<!--EOL1-->\n</p><!--EOL1-->\n<p _new_lines_before=\"0\">test<!--EOL1-->\n</p>",
	),

	// lists
	array(
		'name'     => 'Lists',
		'wikitext' => "#a\n#*a1\n#*a2\n#b",
		'html'     => "<ol _wysiwyg_line_start=\"true\"><li space_after=\"\">a<!--EOL1-->\n<ul _wysiwyg_line_start=\"true\"><li space_after=\"\">a1<!--EOL1-->\n</li><li space_after=\"\">a2<!--EOL1-->\n</li></ul><!--EOL1-->\n</li><li space_after=\"\">b<!--EOL1-->\n</li></ol><!--EOL1-->\n",
	),

	// TODO:
	// image
	// video
	// NS_MEDIA links
	// template

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
