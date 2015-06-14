<?php
/**
 * GlobalNavigation
 *
 * @author Damian 'kvas' Jóźwiak
 *
 */

$wgExtensionCredits[ 'specialpage' ][] = [
	'name' => 'GlobalNavigation',
	'author' => [
		'Damian "kvas" Jóźwiak',
		'Bogna "bognix" Knychała',
		'Bartosz "V." Bentkowski',
	],
	'descriptionmsg' => 'global-navigation-desc',
	'version' => 1.0,
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/GlobalNavigation'
];

// controller classes
$wgAutoloadClasses[ 'GlobalNavigationController' ] =  __DIR__ . '/GlobalNavigationController.class.php';
$wgAutoloadClasses[ 'GlobalNavigationAccountNavigationController' ] =  __DIR__ . '/GlobalNavigationAccountNavigationController.class.php';
$wgAutoloadClasses[ 'GlobalNavigationHelper' ] =  __DIR__ . '/GlobalNavigationHelper.class.php';
$wgAutoloadClasses[ 'GlobalNavigationHooks' ] =  __DIR__ . '/GlobalNavigationHooks.class.php';


$wgHooks['ResourceLoaderGetConfigVarsWithContext'][] = 'GlobalNavigationHooks::onResourceLoaderGetConfigVarsWithContext';
$wgHooks['OutputPageParserOutput'][] = 'GlobalNavigationHooks::onOutputPageParserOutput';

$wgExtensionMessagesFiles[ 'GlobalNavigation' ] = __DIR__ . '/GlobalNavigation.i18n.php';

