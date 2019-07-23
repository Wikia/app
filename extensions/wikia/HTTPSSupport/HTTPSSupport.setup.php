<?php

$wgAutoloadClasses['HTTPSSupportHooks'] =  __DIR__ . '/HTTPSSupportHooks.class.php';

$wgHooks['LinkerMakeExternalLink'][] = 'HTTPSSupportHooks::onLinkerMakeExternalLink';
$wgHooks['outputMakeExternalImage'][] = 'HTTPSSupportHooks::parserUpgradeVignetteUrls';
$wgHooks['outputMakeExternalImage'][] = 'HTTPSSupportHooks::parserUpgradeSpecialFilePathURLs';
$wgHooks['InterwikiLoadBeforeCache'][] = 'HTTPSSupportHooks::onInterwikiLoadBeforeCache';
$wgHooks['BeforeResourceLoaderCSSMinifier'][] = 'HTTPSSupportHooks::onBeforeResourceLoaderCSSMinifier';
