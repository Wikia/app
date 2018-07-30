<?php

$wgAutoloadClasses['HTTPSSupportHooks'] =  __DIR__ . '/HTTPSSupportHooks.class.php';

$wgHooks['BeforeInitialize'][] = 'HTTPSSupportHooks::onBeforeInitialize';
$wgHooks['MercuryWikiVariables'][] = 'HTTPSSupportHooks::onMercuryWikiVariables';
$wgHooks['outputMakeExternalImage'][] = 'HTTPSSupportHooks::parserUpgradeVignetteUrls';
$wgHooks['SitemapPageBeforeOutput'][] = 'HTTPSSupportHooks::onSitemapRobotsPageBeforeOutput';
$wgHooks['WikiaRobotsBeforeOutput'][] = 'HTTPSSupportHooks::onSitemapRobotsPageBeforeOutput';
