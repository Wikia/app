<?php
$app = F::app();
$dir = __DIR__;

$app->registerClass('Tasks', "$dir/Tasks.class.php");
$app->registerClass('TasksSpecialController', "$dir/TasksSpecialController.class.php");
$app->registerSpecialPage('Tasks', 'TasksSpecialController');
$app->registerExtensionMessageFile('Tasks', "$dir/Tasks.i18n.php");