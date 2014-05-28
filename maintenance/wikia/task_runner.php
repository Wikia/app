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
$postData = array(
	'kwargs' => array(
		'state' => $result->status,
		'completed' => time(),
	),
);
if ($result->status == 'success') {
	$postData['kwargs']['result'] = $result->retval;
} else {
	$postData['kwargs']['result'] = $result->reason;
}
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "{$wgFlowerUrl}/api/task/status/{$options['task_id']}");
curl_setopt($ch, CURLOPT_POST, count($postData));
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

curl_exec($ch);
curl_close($ch);
ob_end_clean();

// if the runner completes in time, this will report back to celery immediately
echo json_encode($result);
