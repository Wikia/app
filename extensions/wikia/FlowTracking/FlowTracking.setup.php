<?php

$wgAutoloadClasses['FlowTracking'] =  __DIR__ . '/FlowTracking.hooks.php';
$wgHooks['BeforePageDisplay'][] = 'FlowTrackingHooks::onBeforePageDisplay';
