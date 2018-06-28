<?php

$wgAutoloadClasses['HTTPSSupportHooks'] =  __DIR__ . '/HTTPSSupportHooks.class.php';

$wgHooks['AfterInitialize'][] = 'HTTPSSupportHooks::onAfterInitialize';
$wgHooks['MercuryWikiVariables'][] = 'HTTPSSupportHooks::onMercuryWikiVariables';
$wgHooks['outputMakeExternalImage'][] = 'HTTPSSupportHooks::parserUpgradeVignetteUrls';
$wgHooks['SitemapPageBeforeOutput'][] = 'HTTPSSupportHooks::onSitemapPageBeforeOutput';
$wgHooks['WikiaRobotsBeforeOutput'][] = 'HTTPSSupportHooks::onWikiaRobotsBeforeOutput';
