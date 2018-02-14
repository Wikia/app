<?php

// Don't include DevBoxSettings when running unit tests
$wgRunningUnitTests = true;
$wgDevelEnvironment = true;

require_once __DIR__ . '/../maintenance/commandLine.inc';

$wgWikiFactoryCacheType = CACHE_NONE;
$wgMemc = new EmptyBagOStuff();

LBFactory::destroyInstance();

$wgLBFactoryConf = [ 'class' => LBFactory_Simple::class ];

$wgDBserver = 'localhost';
$wgDBuser = 'root';
$wgDBpassword = '';
$wgDBname = 'mw_integration_tests';
$wgDBtype = 'mysql';
