<?php

// Don't include DevBoxSettings when running unit tests
$wgRunningUnitTests = true;
$wgDevelEnvironment = true;
$wgCommandLineMode = true;

$IP = __DIR__ . '/..';

define( 'MEDIAWIKI', true );

require_once "$IP/includes/Init.php";
require_once "$IP/includes/AutoLoader.php";

require_once MWInit::compiledPath( 'includes/profiler/Profiler.php' );
require_once "$IP/StartProfiler.php";

require_once "$IP/includes/Defines.php";

require_once "$IP/LocalSettings.php";

require_once "$IP/includes/Setup.php";

if ( !defined( 'PHPUNIT_COMPOSER_INSTALL' ) ) {
	define( 'PHPUNIT_COMPOSER_INSTALL', "$IP/lib/composer/autoload.php" );
}

$wgWikiFactoryCacheType = CACHE_NONE;
$wgMemc = new EmptyBagOStuff();
