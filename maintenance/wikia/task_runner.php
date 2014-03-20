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
$retval = $task->execute($data['@method'], $data['@args']);
echo json_encode($retval);