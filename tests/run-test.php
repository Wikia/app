<?php
$wgNoDBUnits = false;
foreach($argv as $arg) {
	if (strpos($arg, 'UsingDB') !== false) {
		$wgNoDBUnits = true;
	}
}

require_once dirname(__FILE__) . '/bootstrap.php';

require_once 'PHP/CodeCoverage/Filter.php';

if (extension_loaded('xdebug')) {
    xdebug_disable();
}

require_once 'PHPUnit/Autoload.php';

PHPUnit_TextUI_Command::main();
