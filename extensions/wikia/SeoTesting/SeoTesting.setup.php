<?php

// Autoload
$wgAutoloadClasses['SeoTesting'] =  __DIR__ . '/SeoTesting.class.php';

// Hooks
$wgHooks['WikiaSkinTopScripts'][] = 'SeoTesting::onWikiaSkinTopScripts';
