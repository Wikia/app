<?php

/**
 * JS Lint metics tool for CruiseControl
 *
 * This script is called using the following command:
 *
 * SERVER_ID=156 jslint.php
 *	 --log-junit ${project.dir}/build/logs/jslint.xml
 *	 --conf ${project.dir}/config/LocalSettings.php
 * 	 --output ${project.build}/jslint/report.html
 *
 * @author Maciej Brencz
 */

require_once('../maintenance/commandLine.inc');

// TODO: create JSLintService
function jslint($file) {
	global $IP;

	$warnings = array();

	exec("java -jar {$IP}/lib/compiler.jar --debug --warning_level DEFAULT --js_output_file /dev/null --js {$file} 2>&1", $out, $res);
	#var_dump($out);

	foreach($out as $line) {
		if (preg_match('#^(/[^:]+):(\d*):(.*)$#', $line, $matches)) {
			$warnings[] = array(
				'file' => str_replace($IP, '', $matches[1]),
				'line' => intval($matches[2]),
				'msg' => trim($matches[3]),
			);
		}
	}

	return $warnings;
}

$outputFile = isset($options['output']) ? $options['output'] : '/tmp/jslint.html';

echo "JS lint report will be generated in {$outputFile}...\n";

$files = glob("{$IP}/skins/common/*.js");
#$files = glob("{$IP}/skins/common/jquery/*.js");
#$files = array("{$IP}/extensions/wikia/VideoEmbedTool/js/VET.js");

$warnings = array();

foreach($files as $file) {
	echo "\nChecking {$file}...";

	$warnings = array_merge($warnings, jslint($file));
}

// TODO: use nice HTML and CSS
$html = '<table><tr><th>File name</th><th>Line</th></th>Message</th></tr>';

foreach($warnings as $warning) {
	$html .= "<tr><td><tt>{$warning['file']}</tt></td><td>{$warning['line']}</td><td>{$warning['msg']}</td></tr>";
}

$html .= '</table>';

// save report
file_put_contents($outputFile, $html);

echo "\n\nDone!\n";

exit(0);