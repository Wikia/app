<?php

// Don't include DevBoxSettings when running unit tests
$wgRunningUnitTests = true;
$wgDevelEnvironment = true;
$wgCommandLineMode = true;

// Evil MediaWiki bootstrap 👹

$IP = __DIR__ . '/..';

define( 'MEDIAWIKI', true );

require_once "$IP/includes/Init.php";
require_once "$IP/includes/AutoLoader.php";

require_once "$IP/includes/profiler/Profiler.php";
require_once "$IP/StartProfiler.php";

require_once "$IP/includes/Defines.php";

require_once "$IP/LocalSettings.php";

require_once "$IP/includes/Setup.php";

// This is needed to properly support PHPUnit's process isolation feature
// We are not using the official PHPUnit entry point, so we need to tell PHPUnit that it was installed via composer.
if ( !defined( 'PHPUNIT_COMPOSER_INSTALL' ) ) {
	define( 'PHPUNIT_COMPOSER_INSTALL', "$IP/lib/composer/autoload.php" );
}

$wgWikiFactoryCacheType = CACHE_NONE;
$wgMemc = new EmptyBagOStuff();
