<?php

$wgAutoloadClasses['HTTPSSupportHooks'] =  __DIR__ . '/HTTPSSupportHooks.class.php';

$wgHooks['AfterInitialize'][] = 'HTTPSSupportHooks::onAfterInitialize';
$wgHooks['MercuryWikiVariables'][] = 'HTTPSSupportHooks::onMercuryWikiVariables';
$wgHooks['SitemapPageBeforeOutput'][] = 'HTTPSSupportHooks::onSitemapRobotsPageBeforeOutput';
$wgHooks['WikiaRobotsBeforeOutput'][] = 'HTTPSSupportHooks::onSitemapRobotsPageBeforeOutput';
$wgHooks['outputMakeExternalImage'][] = 'HTTPSSupportHooks::parserUpgradeVignetteUrls';
$wgHooks['LinkerMakeExternalLink'][] = 'HTTPSSupportHooks::onLinkerMakeExternalLink';
