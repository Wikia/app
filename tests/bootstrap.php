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

// base classes for tests
$wgAutoloadClasses['ApiIntegrationTestTrait'] = $IP . '/includes/wikia/tests/core/ApiIntegrationTestTrait.php';
$wgAutoloadClasses['WikiaBaseTest'] = $IP . '/includes/wikia/tests/core/WikiaBaseTest.class.php';
$wgAutoloadClasses['WikiaDatabaseTest'] = $IP . '/includes/wikia/tests/core/WikiaDatabaseTest.php';
$wgAutoloadClasses['HttpIntegrationTest'] = "$IP/includes/wikia/tests/core/HttpIntegrationTest.php";
$wgAutoloadClasses['WikiaMockProxy'] = $IP . '/includes/wikia/tests/core/WikiaMockProxy.class.php';
$wgAutoloadClasses['WikiaMockProxyAction'] = $IP . '/includes/wikia/tests/core/WikiaMockProxyAction.class.php';
$wgAutoloadClasses['WikiaMockProxyInvocation'] = $IP . '/includes/wikia/tests/core/WikiaMockProxyInvocation.class.php';
$wgAutoloadClasses['MockGlobalVariableTrait'] = $IP . '/includes/wikia/tests/core/MockGlobalVariableTrait.php';

// This is needed to properly support PHPUnit's process isolation feature
// We are not using the official PHPUnit entry point, so we need to tell PHPUnit that it was installed via composer.
if ( !defined( 'PHPUNIT_COMPOSER_INSTALL' ) ) {
	define( 'PHPUNIT_COMPOSER_INSTALL', "$IP/lib/composer/autoload.php" );
}

$wgWikiFactoryCacheType = CACHE_NONE;
$wgMemc = new EmptyBagOStuff();
