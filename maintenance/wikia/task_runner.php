<?php
set_time_limit(0);
$options = ['help'];
$optionsWithArgs = [
	'class',
	'data'
];
require_once(__DIR__."/../commandLine.inc");

$data = json_decode($options['data'], true);

/** @var \Wikia\Tasks\Tasks\BaseTask $task */
$task = new $options['class']();
$task->unserialize($data['@context']);
call_user_func_array([$task, $data['@method']], $data['@args']);