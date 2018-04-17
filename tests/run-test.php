<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('memory_limit', '256M');

$wgNoDBUnits = false;

$params = getopt('', ['exclude-group::', 'slow-list']);
if (isset($params['exclude-group'])) {
	foreach(explode(',', $params['exclude-group']) as $group) {
		if (trim($group) == 'UsingDB') {
			$wgNoDBUnits = true;
		}
	}
}

require_once __DIR__ . '/bootstrap.php';

\PHPUnit\TextUI\Command::main();
