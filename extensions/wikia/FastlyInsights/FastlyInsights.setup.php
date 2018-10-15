<?php

$wgAutoloadClasses[ 'FastlyInsightsHooks' ] = __DIR__ . '/FastlyInsightsHooks.class.php';

// load Fastly insights script
$wgHooks[ 'SkinAfterBottomScripts' ][] = 'FastlyInsightsHooks::onSkinAfterBottomScripts';
