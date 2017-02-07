<?php
$wgAutoloadClasses['PageHeaderExperimentsHooks'] =  __DIR__ . '/PageHeaderExperiments.hooks.php';
$wgHooks['BeforePageDisplay'][] = 'PageHeaderExperimentsHooks::onBeforePageDisplay';