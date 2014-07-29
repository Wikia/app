<?php

$dir = dirname(__FILE__) . '/';

//classes
$wgAutoloadClasses['QuestDetailsController'] =  $dir . 'QuestDetailsController.class.php';

$wgWikiaApiControllers['QuestDetailsController'] = $dir . 'QuestDetailsController.class.php';