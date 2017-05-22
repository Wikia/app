<?php
/**
 * This file is the main entry point for PHPUnit commands executed in continuous integration.
 * Since many of our tests rely on monkey patching techniques provided by uopz,
 * we must disable XDebug before firing up MediaWiki and running the actual tests.
 */
if ( extension_loaded( 'xdebug' ) ) {
	xdebug_disable();
}

require_once __DIR__ . '/bootstrap.php';
