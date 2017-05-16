<?php
$wgAutoloadClasses['AdMixExperimentHooks'] = __DIR__ . '/AdMixExperiment.hooks.php';

$wgHooks['BeforePageDisplay'][] = 'AdMixExperimentHooks::onBeforePageDisplay';
