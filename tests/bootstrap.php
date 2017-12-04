<?php

// Don't include DevBoxSettings when running unit tests
$wgRunningUnitTests = true;
$wgDevelEnvironment = true;

require_once __DIR__ . '/../maintenance/commandLine.inc';

$wgWikiFactoryCacheType = CACHE_NONE;
$wgMemc = new EmptyBagOStuff();
