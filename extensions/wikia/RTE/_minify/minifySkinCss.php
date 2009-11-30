#!/usr/bin/php
<?php

/**
 * This script is used to concatenate and minify CSS files of Wikia CK skin
 * Output will be saved in editor.min.css
 *
 * @author Maciej Brencz <macbre@wikia-inc.com>
 */

require('./Minify_CSS_Compressor.php');

chdir(dirname(__FILE__) . '/../ckeditor/_source/skins/wikia');
$input = file_get_contents('editor.css');

echo "Packaging file editor.css\n";

// get all @imports and include those files
if (preg_match_all('%@import url\(([^)]+)\);%', $input, $imports, PREG_SET_ORDER)) {
	foreach($imports as $import) {
		$name = trim($import[1], '" ');
		$css = file_get_contents($name);

		// remove utf BOM markers
		$css = str_replace("\xEF\xBB\xBF", '', $css);

		$input = str_replace($import[0], $css, $input);

		echo "\n * {$name}";
	}
}

// minify
$input = Minify_CSS_Compressor::process($input);

// extra changes
// RT #11257 - add ? to images included in CSS
$cb = date('Ymd');
$input = preg_replace("#\.(png|gif)([\"'\)]+)#s", '.\\1?'. $cb . '\\2', $input);

// add header
$header = <<<HEAD
/*
Copyright (c) 2003-2009, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

HEAD;

$input = $header . $input;

// save results
file_put_contents('editor.min.css', $input);

echo "\n\nDone\n";
