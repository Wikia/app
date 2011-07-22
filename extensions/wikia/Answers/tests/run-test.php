<?php
/**
 * unit test launch script (with MW stack enabled)
 *
 * how to use:
 *
 * SERVER_ID=177 php run-test.php --conf=/path_to/LocalSettings.php --aconf=/path_to/AdminSettings.php --verbose TestClass.php [or directory]
 *
 */
require_once( dirname(__FILE__) . '/../../wikia-pubsvn/maintenance/commandLine.inc' );

// remove "--conf" and "--aconf" from argv before calling PHPUnit
for($i = 0; $i < count($_SERVER['argv']); $i++) {
	if(eregi('--conf', $_SERVER['argv'][$i]) || eregi('--aconf', $_SERVER['argv'][$i])) {
		unset($_SERVER['argv'][$i]);
	}
}
$_SERVER['argc'] = count($_SERVER['argv']);

ini_set( 'include_path', get_include_path() . PATH_SEPARATOR . /*$_SERVER['PHP_PEAR_INSTALL_DIR']*/ 'C:\php\pear' );
require( 'PHPUnit/TextUI/Command.php' );
define('PHPUnit_MAIN_METHOD', 'PHPUnit_TextUI_Command::main');
PHPUnit_TextUI_Command::main();
