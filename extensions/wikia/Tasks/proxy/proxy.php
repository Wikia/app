<?php

/**
 * This file is requested by celery-workers. Requested wiki is passed via X-Mw-Wiki-Id HTTP header.
 *
 * @see SUS-5816
 *
 * @var WebRequest $wgRequest
 */

set_time_limit( 3600 );
ini_set('display_errors', 0);

# SEC-21: make sure that this is called internally
if ( empty( $_SERVER['HTTP_X_WIKIA_INTERNAL_REQUEST'] ) ) {
	$ip = isset( $_SERVER['REMOTE_ADDR'] ) ? $_SERVER['REMOTE_ADDR'] : null;
	trigger_error( "X-Wikia-Internal-Request header is missing (request from {$ip})", E_USER_WARNING );

	header( 'HTTP/1.1 403 Forbidden' );
	echo json_encode( [
		'status' => 'failure',
		'reason' => 'X-Wikia-Internal-Request header is missing'
	] );
	die;
}

// PLATFORM-2034: Forward client data to tasks spawned by MediaWiki
$traceEnv = json_decode( $_POST['trace_env'] );
foreach($traceEnv as $key => $val) {
	$_ENV[$key] = $val;
}

// Initialise common MediaWiki code
$IP = realpath( __DIR__ . '/../../../../' );

// see a comment in WebStart.php on why MW_MSTALL_PATH is set here
putenv('MW_INSTALL_PATH=' . $IP);

/**
 * SUS-5862 | set a flag to put MediaWiki database access layer in auto-commit mode
 * i.e. mimic the behaviour of command-line maintenance scripts
 *
 * Database-heavy offline tasks will have problems with large transactions
 * being committed at the end of the proxy.php processing
 */
$wgCommandLineMode = true;

/**
 * SUS-5867 | follow up to hack from SUS-5862, if script is not invoked via command line then the $argv and $argc are
 * set to null. Since the mentioned hack mimics the command line mode, these two should be set as well
 */
$argv = [];
$argc = 1;

require ( $IP . '/includes/WebStart.php' );

// we forced command line mode, explicitly construct a WebRequest object
// instead of relying on $wgRequest
$request = new FauxRequest( $_POST, true );

// finally, execute the task
ob_start();

try {
	$runner = Wikia\Tasks\TaskRunner::newFromRequest( $request );
	$runner->run();
	$resp = $runner->format();
} catch ( Throwable $ex ) {
	$resp = [
		'status' => 'failure',
		'reason' => sprintf('%s: %s', get_class( $ex ), $ex->getMessage() ),
	];
}

ob_end_clean();

// wrap JSON response in AjaxResponse class so that we will emit consistent set of headers
$response = new AjaxResponse( json_encode( $resp ) );

header('X-Served-By: ' . wfHostname() );
$response->setContentType('application/json; charset=utf-8');
$response->sendHeaders();

$response->printText();

// Execute common request shutdown procedure
$mw = new MediaWiki();
$mw->restInPeace();
