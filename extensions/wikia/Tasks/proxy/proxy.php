<?php
// proxy to run tasks in development.

$script = __DIR__.'/../../../../maintenance/wikia/task_runner.php';

$wikiId = $_POST['wiki_id'];
$list = $_POST['task_list'];
$order = $_POST['call_order'];

$command = "SERVER_ID=$wikiId php $script --task_list=".json_encode($list)." --call_order=".json_encode($order);

echo shell_exec($command);