<?php
/**
 * This file handles initializing MediaWiki stack and setting global flags
 * before handing over execution to PHPUnit that executes the tests
 * provided in its configuration file set via the command line.
 */

error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

// don't include DevBoxSettings when running unit tests
$wgRunningUnitTests = true;
$wgDevelEnvironment = true;
$wgAnnotateTestSpeed = ( getenv( 'ANNOTATE_TEST_SPEED' ) === '1' );

require_once __DIR__ . '/../maintenance/Maintenance.php';

class PhpUnit extends Maintenance {
	public function __construct() {
		parent::__construct();

		$this->addOption( 'slow-list', 'Whether to find and mark slow tests' );
	}

	public function execute() {
		// TODO: Broken. Fix.
		if ( $this->hasOption( 'slow-list' ) ) {
			require_once 'SlowTestsFinder.php';
			SlowTestsFinder::main();
			return;
		}

		\PHPUnit\TextUI\Command::main();
	}
}

$maintClass = PhpUnit::class;
require_once RUN_MAINTENANCE_IF_MAIN;
