<?php

$wgAutoloadClasses['SpotlightsController'] = __DIR__ . '/SpotlightsController.class.php';
$wgAutoloadClasses['SpotlightsHooks'] = __DIR__ . '/SpotlightsHooks.class.php';

$wgHooks['OasisSkinAssetGroups'][] = 'SpotlightsHooks::onOasisSkinAssetGroups';
$wgHooks['WikiaSkinTopScripts'][] = 'SpotlightsHooks::onWikiaSkinTopScripts';
$wgHooks['InstantGlobalsGetVariables'][] = 'SpotlightsHooks::onInstantGlobalsGetVariables';
