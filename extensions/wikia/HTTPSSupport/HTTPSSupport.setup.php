<?php

$wgAutoloadClasses['HTTPSSupportHooks'] =  __DIR__ . '/HTTPSSupportHooks.class.php';

$wgHooks['BeforeInitialize'][] = 'HTTPSSupportHooks::onBeforeInitialize';
$wgHooks['WikiaRobotsBeforeOutput'][] = 'HTTPSSupportHooks::onRobotsBeforeOutput';


$wgHooks['LinkerMakeExternalLink'][] = 'HTTPSSupportHooks::onLinkerMakeExternalLink';
$wgHooks['outputMakeExternalImage'][] = 'HTTPSSupportHooks::parserUpgradeVignetteUrls';
$wgHooks['outputMakeExternalImage'][] = 'HTTPSSupportHooks::parserUpgradeSpecialFilePathURLs';
$wgHooks['InterwikiLoadBeforeCache'][] = 'HTTPSSupportHooks::onInterwikiLoadBeforeCache';
$wgHooks['BeforeResourceLoaderCSSMinifier'][] = 'HTTPSSupportHooks::onBeforeResourceLoaderCSSMinifier';
