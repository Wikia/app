<?php

$wgAutoloadClasses['FlowTrackingHooks'] =  __DIR__ . '/FlowTracking.hooks.php';
$wgHooks['BeforePageDisplay'][] = 'FlowTrackingHooks::onBeforePageDisplay';
$wgHooks['ArticleInsertComplete'][] = 'FlowTrackingHooks::onArticleInsertComplete';
$wgHooks['MakeGlobalVariablesScript'][] = 'FlowTrackingHooks::onMakeGlobalVariablesScript';
$wgHooks['ContributeMenuAfterDropdownItems'][] = 'FlowTrackingHooks::onContributeMenuAfterDropdownItems';
$wgHooks['BeforePrepareActionButtons'][] = 'FlowTrackingHooks::onBeforePrepareActionButtons';
