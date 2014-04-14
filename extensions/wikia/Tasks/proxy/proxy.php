<?php
set_time_limit(0);

$script = __DIR__.'/../../../../maintenance/wikia/task_runner.php';

$wikiId = $_POST['wiki_id'];
$list = $_POST['task_list'];
$order = $_POST['call_order'];
$createdBy = $_POST['created_by'];

$command = "SERVER_ID=$wikiId php $script --task_list=".json_encode($list)." --call_order=".json_encode($order)." --created_by=$createdBy";

echo shell_exec($command);