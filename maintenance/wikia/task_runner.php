<?php
set_time_limit( 0 );
$wgCommandLineSilentMode = true; // suppress output from Wikia::log calls
$options = ['help'];
$optionsWithArgs = [
	'task_id',
	'call_order',
	'task_list',
	'created_by',
];
require_once( __DIR__ . "/../commandLine.inc" );

global $wgDevelEnvironment;
if ( $wgDevelEnvironment ) {
	\Wikia\Logger\WikiaLogger::instance()->setDevModeWithES();
}

\Wikia\Logger\WikiaLogger::instance()->pushContext( [
	'task_id' => $options['task_id']
] );

$runner = new TaskRunner( $wgCityId, $options['task_id'], $options['task_list'], $options['call_order'], $options['created_by'] );

ob_start();
$runner->run();
$result = $runner->format();

if ($runner->runTime() > TaskRunner::TASK_NOTIFY_TIMEOUT) {
	Http::post( "{$wgFlowerUrl}/api/task/status/{$options['task_id']}", [
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

ob_end_clean();

// if the runner completes in time, this will report back to celery immediately
echo json_encode( $result );
