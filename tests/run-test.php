<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$wgNoDBUnits = false;

$params = getopt('', ['exclude-group::', 'slow-list']);
if (isset($params['exclude-group'])) {
	foreach(explode(',', $params['exclude-group']) as $group) {
		if (trim($group) == 'UsingDB') {
			$wgNoDBUnits = true;
		}
	}
}

$wgAnnotateTestSpeed = (getenv('ANNOTATE_TEST_SPEED') === '1');

require_once dirname(__FILE__) . '/bootstrap.php';

if (extension_loaded('xdebug')) {
    xdebug_disable();
}

if ( !isset( $params['slow-list'] ) ) {
	PHPUnit_TextUI_Command::main();
} else {
	include_once( 'SlowTestsFinder.php' );
	SlowTestsFinder::main();
}
