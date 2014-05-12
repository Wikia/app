<?php
set_time_limit(0);
$options = ['help'];
$optionsWithArgs = [
	'call_order',
	'task_list',
	'created_by',
];
require_once(__DIR__."/../commandLine.inc");

$runner = new TaskRunner($options['task_list'], $options['call_order'], $options['created_by']);

ob_start();
$runner->run();
ob_end_clean();

echo json_encode($runner->format());