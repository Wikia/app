<?php

$wgAutoloadClasses['FlowTrackingHooks'] =  __DIR__ . '/FlowTracking.hooks.php';
$wgHooks['ArticleInsertComplete'][] = 'FlowTrackingHooks::onArticleInsertComplete';
$wgHooks['BeforePageDisplay'][] = 'FlowTrackingHooks::onBeforePageDisplay';
$wgHooks['BeforePrepareActionButtons'][] = 'FlowTrackingHooks::onBeforePrepareActionButtons';
$wgHooks['ContributeMenuAfterDropdownItems'][] = 'FlowTrackingHooks::onContributeMenuAfterDropdownItems';
$wgHooks['MakeGlobalVariablesScript'][] = 'FlowTrackingHooks::onMakeGlobalVariablesScript';
$wgHooks['PageHeaderAfterAddNewPageButton'][] = 'FlowTrackingHooks::onPageHeaderAfterAddNewPageButton';
