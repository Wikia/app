<?php

$wgAutoloadClasses['HTTPSSupportHooks'] =  __DIR__ . '/HTTPSSupportHooks.class.php';

$wgHooks['BeforeInitialize'][] = 'HTTPSSupportHooks::onBeforeInitialize';
$wgHooks['LinkerMakeExternalLink'][] = 'HTTPSSupportHooks::onLinkerMakeExternalLink';
$wgHooks['MercuryWikiVariables'][] = 'HTTPSSupportHooks::onMercuryWikiVariables';
$wgHooks['outputMakeExternalImage'][] = 'HTTPSSupportHooks::parserUpgradeVignetteUrls';
$wgHooks['WikiaRobotsBeforeOutput'][] = 'HTTPSSupportHooks::onRobotsBeforeOutput';
$wgHooks['InterwikiLoadBeforeCache'][] = 'HTTPSSupportHooks::onInterwikiLoadBeforeCache';
$wgHooks['BeforeResourceLoaderCSSMinifier'][] = 'HTTPSSupportHooks::onBeforeResourceLoaderCSSMinifier';
