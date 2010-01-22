<?php
/*
 * This script generates minified JS and CSS file to be used by RTE
 */

ini_set('include_path', dirname(__FILE__).'/../../../maintenance');
require_once('commandLine.inc');

error_reporting(E_ERROR);

// this function takes type (CSS/JS) and list of files
// and saves minified version in file provided
function minify($type, $files, $target) {
	$chute = new StaticChute($type);
	$chute->compress = false;
	$chute->httpCache = false;

	$header = <<<HEAD
/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

HEAD;

	$res = $chute->process($files);

	if ($type == 'js') {
		$rev = trim( `svn info | tail -n 7 | head -n 1 | awk '{ print $2 }'` );
		$res = str_replace('%REV%', $rev, $res);

		$res = str_replace('%VERSION%', date('Ymd'), $res);
	}

	file_put_contents($target, $header.$res);
}


// generate minified version of CSS
echo "Packaging file editor.css...\n";

$files = array();

chdir(dirname(__FILE__) . '/ckeditor/_source/skins/wikia');
$input = file_get_contents('editor.css');

// get all @imports
if (preg_match_all('%@import url\(([^)]+)\);%', $input, $matches, PREG_SET_ORDER)) {
	foreach($matches as $match) {
		$name = trim($match[1], '" ');
		$files[] = getcwd() . '/' . $name;
	}
}

minify('css', $files, 'editor.min.css');


// generate minified version of JS
echo "Packaging file ckeditor.js...\n";

$files = array();

chdir(dirname(__FILE__) . '/ckeditor');

// get list of files from JS packager config
$input = file_get_contents('ckeditor.wikia.pack');
$input = substr($input, strpos($input, 'files :') + 7);
$input = trim($input, " \n\t[]{}");

// CK basic core
$files[] = realpath(getcwd() . '/_source/core/loader.js');
$files[] = realpath(getcwd() . '/_source/core/ckeditor_base.js');

// get all *.js files
if (preg_match_all('%[^/]\'([^\']+).js%', $input, $matches, PREG_SET_ORDER)) {
	foreach($matches as $match) {
		$name = $match[1] . '.js';
		$files[] = realpath(getcwd() . '/' . $name);
	}
}

//var_dump($input);var_dump($files);

minify('js', $files, 'ckeditor.js');


echo "Done!\n\n";
