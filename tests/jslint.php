<?php

/**
 * JS Lint metics tool for CruiseControl
 *
 * This script is called using the following command:
 *
 * SERVER_ID=156 jslint.php
 *	 --log-junit ${project.dir}/build/logs/jslint.xml
 *	 --conf ${project.dir}/config/LocalSettings.php
 *
 * @author Maciej Brencz
 */

require_once('../maintenance/commandLine.inc');

// TODO: create JSLintService
function jslint($file) {
	global $IP;

	$warnings = array();

	exec("java -jar {$IP}/lib/compiler.jar --debug --warning_level DEFAULT --js_output_file /dev/null --js {$file} 2>&1", $out, $res);
	var_dump($out);

	return $warnings;
}

$file = "{$IP}/extensions/wikia/VideoEmbedTool/js/VET.js";

$ret = jslint)$file);

var_dump($ret);

exit(0);