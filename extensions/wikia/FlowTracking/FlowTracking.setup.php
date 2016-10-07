<?php

$wgAutoloadClasses['FlowTrackingHooks'] =  __DIR__ . '/FlowTracking.hooks.php';
$wgHooks['BeforePageDisplay'][] = 'FlowTrackingHooks::onBeforePageDisplay';
$wgHooks['ArticleInsertComplete'][] = 'FlowTrackingHooks::onArticleInsertComplete';
$wgHooks['MakeGlobalVariablesScript'][] = 'FlowTrackingHooks::onMakeGlobalVariablesScript';
$wgHooks['BeforePrepareActionButtons'][] = 'FlowTrackingHooks::onBeforePrepareActionButtons';
