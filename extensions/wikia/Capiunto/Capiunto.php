<?php
/**
 * Initialization file for the Capiunto extension.
 *
 * @license GPL v2+
 *
 * @author Marius Hoch < hoo@online.de >
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "Not an entry point.\n" );
}

$wgExtensionCredits['parserhook']['Capiunto'] = array(
	'path' => __FILE__,
	'name' => 'Capiunto',
	'author' => 'Marius Hoch',
	'url' => 'https://www.mediawiki.org/wiki/Extension:Capiunto',
	'descriptionmsg' => 'capiunto-desc',
);

// $wgMessagesDirs['Capiunto'] = __DIR__ . '/i18n';
// $wgExtensionMessagesFiles['Capiunto'] = __DIR__ . '/Capiunto.i18n.php';

$wgAutoloadClasses['Capiunto\CapiuntoHooks']		= __DIR__ . '/Capiunto.hooks.php';
// $wgAutoloadClasses['Capiunto\LuaLibrary']					= __DIR__ . '/includes/LuaLibrary.php';
$wgAutoloadClasses['Capiunto\Test\InfoboxModuleTest']		= __DIR__ . '/tests/phpunit/includes/lua/InfoboxTest.php';

$wgHooks['UnitTestsList'][] 				= '\Capiunto\CapiuntoHooks::registerUnitTests';
# XXX: Rather use ScribuntoExternalLibraryPaths ?
$wgHooks['ScribuntoExternalLibraries'][] 	= '\Capiunto\CapiuntoHooks::registerScribuntoLibraries';
$wgHooks['BeforePageDisplay'][]				= '\Capiunto\CapiuntoHooks::onBeforePageDisplay';

$commonModuleInfo = array(
	'localBasePath' => __DIR__ . '/resources',
	'remoteExtPath' => 'Capiunto/resources',
);

$wgResourceModules['capiunto.infobox.main'] = array(
	'styles' => 'infobox.css',
) + $commonModuleInfo;
