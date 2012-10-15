<?php

/**
 * JS Lint metics tool for CruiseControl
 *
 * This script is called using the following command:
 *
 * SERVER_ID=156 jslint.php
 *	 --log-junit ${project.dir}/build/logs/jslint.xml
 *	 --conf ${project.dir}/config/LocalSettings.php
 * 	 --output ${project.dir}/build/jslint/report.html
 *
 * Deprecated! Please use /maintenance/wikia/codelint.php script!
 *
 * @author Maciej Brencz
 */

require_once('../maintenance/commandLine.inc');

// TODO: create JSLintService
function jslint($file) {
	global $IP;

	$warnings = array();

	// TODO: try nodejs jslint.js
	// @see https://github.com/jquery/jquery/blob/master/Makefile
	exec("java -jar {$IP}/lib/compiler.jar --debug --warning_level DEFAULT --compilation_level WHITESPACE_ONLY --js_output_file /dev/null --js {$file} 2>&1", $out, $res);
	#var_dump($out);

	foreach($out as $line) {
		if (preg_match('#^(/[^:]+):(\d*):(.*)$#', $line, $matches)) {
			$warnings[] = array(
				'file' => str_replace($IP, '', $matches[1]),
				'line' => intval($matches[2]),
				'msg' => trim($matches[3]),
				'isError' => strpos($matches[3], 'ERROR') !== false,
			);
		}
	}

	return $warnings;
}

/**
 * find files matching a pattern
 * using PHP "glob" function and recursion
 *
 * @see http://www.redips.net/php/find-files-with-php/
 *
 * @return array containing all pattern-matched files
 *
 * @param string $dir     - directory to start with
 * @param string $pattern - pattern to glob for
 */
function find($dir, $pattern) {
	// escape any character in a string that might be used to trick
	// a shell command into executing arbitrary commands
	$dir = escapeshellcmd($dir);
	// get a list of all matching files in the current directory
	$files = glob("$dir/$pattern");
	// find a list of all directories in the current directory
	// directories beginning with a dot are also included
	foreach (glob("$dir/{.[^.]*,*}", GLOB_BRACE|GLOB_ONLYDIR) as $sub_dir) {
	    $arr   = find($sub_dir, $pattern);  // resursive call
	    $files = array_merge($files, $arr); // merge array with files from subdirectory
	}
	// return all found files
    return $files;
}

$outputFile = isset($options['output']) ? $options['output'] : '/tmp/jslint.html';

echo "JS lint report will be generated in {$outputFile}...\n";

$files = find($IP, '*.js');
//$files = find("{$IP}/skins/", '*.js');
//$files = find("{$IP}/skins/common/jquery", '*.js');
//$files = find("{$IP}/extensions/wikia/", '*.js');

//var_dump($files); die();

$warnings = array();
$timeStart = time();

foreach($files as $file) {
	echo "\nChecking {$file}...";

	$warnings = array_merge($warnings, jslint($file));
}

$time = time() - $timeStart;

// generate the report
$html = '<p>Checked ' . count($files) . ' files in ' . round($time / 60) .' minutes</p>';

$html .= '<table border="1"><tr><th>File name</th><th>Line</th><th>Message</th></tr>';

foreach($warnings as $warning) {
	$style = $warning['isError'] ? ' style="background: #fd5e53; color: #fff"' : '';
	$html .= "<tr{$style}><td><tt>{$warning['file']}</tt></td><td>{$warning['line']}</td><td>{$warning['msg']}</td></tr>";
}

$html .= '</table>';
$html .= '<hr/><address>Generated on ' . date('r') . '</address>';

// save report
file_put_contents($outputFile, $html);

echo "\n\nDone!\n";

// exit code required by CruiseControl
exit(0);
