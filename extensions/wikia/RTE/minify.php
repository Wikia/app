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
	global $wgCacheBuster;
	$count = count($files);
	echo "Packaging {$target} ({$count} files)...";

	$chute = new StaticChute($type);
	$chute->compress = false;
	$chute->httpCache = false;

	$revision = SpecialVersion::getSvnRevision(dirname(__FILE__));
	$cb = $wgCacheBuster;

	$header = <<<HEAD
/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license

DO NOT modify this file by hand! Use minify.sh maintenance script to regenerate this file!
*/

HEAD;

	// concatenate files
	$res = '';
	foreach($files as $file) {
		$res .= file_get_contents($file);
	}

	// remove BOM UTF-8 marker
	$res = str_replace("\xEF\xBB\xBF", '', $res);

	// add cache buster to images
	$res = preg_replace("#\.(png|gif)([\"'\)]+)#s", '.\\1?' . $cb . '\\2', $res);

	// minify
	switch($type) {
		case 'css':
			// remove @import url("foo") lines
			$res = preg_replace('#^@import url.*$#m', '', $res);

			$res = $chute->minifyCSSData($res);
			break;

		case 'js':
			// remove lines marked with "@Packager.RemoveLine" comment
			$res = preg_replace('#^.*@Packager\\.RemoveLine.*$#m', '', $res);

			// minify
			$res = $chute->minifyJSData($res);

			// add date and revision data
			$res = str_replace('%REV%', "r{$revision}", $res);
			$res = str_replace('%VERSION%', date('Ymd'), $res);
			break;
	}

	file_put_contents($target, $header.$res);

	echo " done!\n";
}


// generate minified version of CSS
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

// add root CSS too
$files[] = getcwd() . '/editor.css';

minify('css', $files, 'editor.min.css');


// generate minified version of JS
$files = array();

chdir(dirname(__FILE__) . '/ckeditor');

// get list of files from JS packager config
$input = file_get_contents('ckeditor.wikia.pack');
$input = substr($input, strpos($input, 'files :') + 7);
$input = trim($input, " \n\t[]{}");

// CK core files
$files[] = realpath(getcwd() . '/_source/core/ckeditor_base.js');

// get all *.js files
if (preg_match_all('%[^/]\'([^\']+).js%', $input, $matches, PREG_SET_ORDER)) {
	foreach($matches as $match) {
		$name = $match[1] . '.js';
		$files[] = realpath(getcwd() . '/' . $name);
	}
}

//var_dump($files);

minify('js', $files, 'ckeditor.js');

echo "Done!\n\n";
