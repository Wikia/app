<?php
set_time_limit(0);

$script = dirname(__FILE__).'/../../../../maintenance/wikia/task_runner.php';

$taskId = escapeshellarg($_POST['task_id']);
$wikiId = escapeshellarg($_POST['wiki_id']);
$list = $_POST['task_list'];
$order = $_POST['call_order'];
$createdBy = escapeshellarg($_POST['created_by']);

$command = "SERVER_ID=$wikiId php $script --task_id=".$taskId." --task_list=".json_encode($list)." --call_order=".json_encode($order)." --created_by=$createdBy";

echo shell_exec($command);
