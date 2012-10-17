<?php

require_once dirname(__FILE__) . '/bootstrap.php';

require_once 'PHP/CodeCoverage/Filter.php';
PHP_CodeCoverage_Filter::getInstance()->addFileToBlacklist(__FILE__, 'PHPUNIT');

if (extension_loaded('xdebug')) {
    xdebug_disable();
}

if (strpos('/usr/bin/php', '@php_bin') === 0) {
    set_include_path(dirname(__FILE__) . PATH_SEPARATOR . get_include_path());
}

require_once 'PHPUnit/Autoload.php';

define('PHPUnit_MAIN_METHOD', 'PHPUnit_TextUI_Command::main');

// Wikia change - start
error_reporting(E_ALL);
set_error_handler(function($errno, $errstr, $errfile, $errline) {
	echo "$errstr ($errfile @ $errline)\n";
});
// Wikia change - end

PHPUnit_TextUI_Command::main();
