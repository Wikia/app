<?php
set_time_limit(0);
$options = ['help'];
$optionsWithArgs = [
	'task_id',
	'call_order',
	'task_list',
	'created_by',
];
require_once(__DIR__."/../commandLine.inc");

$runner = new TaskRunner($options['task_id'], $options['task_list'], $options['call_order'], $options['created_by']);

ob_start();
$runner->run();
$result = $runner->format();

// for long-running tasks that end up timing out, we need to notify flower that
// the task actually did complete successfully
Http::post("{$wgFlowerUrl}/api/task/status/{$options['task_id']}", [
	'noProxy' => true,
	'postData' => json_encode([
		'kwargs' => [
			'completed' => time(),
			'state' => $result->status,
			'result' => ($result->status == 'success' ? $result->retval : $result->reason),
		],
	]),
]);
ob_end_clean();

// if the runner completes in time, this will report back to celery immediately
echo json_encode($result);
