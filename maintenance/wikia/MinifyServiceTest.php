<?php

/**
 * This script is used for benchmarking different CSS/JS minifiers
 *
 * @author macbre
 */

error_reporting(E_ALL);
require_once(dirname(__FILE__)."/../commandLine.inc");

$staticChute = new StaticChute('js');

// get JS/CSS code from StaticChute
$package = 'oasis_anon_article_js';
$files = $staticChute->getFileList(array('packages' => $package));
$count = count($files);

echo "Got {$count} files from '{$package}' package\n\n";

// concat those files
$code = MinifyService::mergeFiles($files);
$size = strlen($code);

echo 'Original code size: ' . round($size / 1024, 2) . " kB\n";

// run the minifier and measure the time
$time = wfTime();
$minified = MinifyService::minifyJS($code);
$time = wfTime() - $time;

$minifiedSize = strlen($minified);

// run gzip
$gzippedSize = strlen(gzcompress($minified));

// results
echo 'Minified code size: ' . round($minifiedSize / 1024, 2). " kB\n";
echo 'Gzipped code size:  ' . round($gzippedSize / 1024, 2). " kB\n";

echo "\nMinified in " . round($time * 1000) . " ms\n\n";

$ratio = round($size / $minifiedSize, 2);
$ratioGzipped = round($size / $gzippedSize, 2);

echo "Compression ratio:        {$ratio}x\n";
echo "Compression ratio (gzip): {$ratioGzipped}x\n";

// debug
/**
file_put_contents('code.js', $code);
file_put_contents('code-min.js', $minified);
**/
