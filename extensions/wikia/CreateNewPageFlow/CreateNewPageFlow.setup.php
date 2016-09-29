<?php

$wgAutoloadClasses['CreateNewPageFlowHooks'] =  __DIR__ . '/CreateNewPageFlow.hooks.php';
$wgHooks['BeforePageDisplay'][] = 'CreateNewPageFlowHooks::onBeforePageDisplay';
