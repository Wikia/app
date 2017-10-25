<?php

$wgAutoloadClasses['FlowTrackingHooks'] =  __DIR__ . '/FlowTracking.hooks.php';
$wgHooks['ArticleInsertComplete'][] = 'FlowTrackingHooks::onArticleInsertComplete';
$wgHooks['BeforePageDisplay'][] = 'FlowTrackingHooks::onBeforePageDisplay';
$wgHooks['BeforePrepareActionButtons'][] = 'FlowTrackingHooks::onBeforePrepareActionButtons';
$wgHooks['MakeGlobalVariablesScript'][] = 'FlowTrackingHooks::onMakeGlobalVariablesScript';
