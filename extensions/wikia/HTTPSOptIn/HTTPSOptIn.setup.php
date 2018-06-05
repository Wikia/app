<?php

$wgAutoloadClasses['HTTPSOptInHooks'] =  __DIR__ . '/HTTPSOptInHooks.class.php';

$wgHooks['BeforeInitialize'][] = 'HTTPSOptInHooks::onBeforeInitialize';
$wgHooks['MercuryWikiVariables'][] = 'HTTPSOptInHooks::onMercuryWikiVariables';
