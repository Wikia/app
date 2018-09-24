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

require ( $IP . '/includes/WebStart.php' );

#var_dump($wgCityId, $_POST, $wgRequest, \Wikia\Tracer\WikiaTracer::instance()->getEnvVariables());

$runner = Wikia\Tasks\TaskRunner::newFromRequest( $wgRequest );
$runner->run();

$result = $runner->format();

if ($runner->runTime() > Wikia\Tasks\TaskRunner::TASK_NOTIFY_TIMEOUT) {
	Http::post( "{$wgFlowerUrl}/api/task/status/{$runner->getTaskId()}", [
		'noProxy' => true,
		'postData' => json_encode( [
			'kwargs' => [
				'completed' => time(),
				'state' => $result->status,
				'result' => ( $result->status == 'success' ? $result->retval : $result->reason ),
			],
		] ),
	] );
}

Wikia\Logger\WikiaLogger::instance()->info( __METHOD__, [
	'took' => $runner->runTime(),
	'delay' => microtime( true ) - (float) $wgRequest->getVal('created_at'),
	'state' => $result->status,
] );

echo json_encode( $result );
