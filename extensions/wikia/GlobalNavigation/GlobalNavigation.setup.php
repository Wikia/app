<?php
/**
 * GlobalNavigation
 *
 * @author Damian 'kvas' Jóźwiak
 *
 */

$wgExtensionCredits[ 'specialpage' ][] = [
	'name' => 'GlobalNavigation',
	'author' => 'Damian "kvas" Jóźwiak',
	'description' => 'GlobalNavigation',
	'version' => 1.0
];

// controller classes
$wgAutoloadClasses[ 'GlobalNavigationController' ] =  __DIR__ . '/GlobalNavigationController.class.php';
$wgAutoloadClasses[ 'GlobalNavigationAccountNavigationController' ] =  __DIR__ . '/GlobalNavigationAccountNavigationController.class.php';
$wgAutoloadClasses[ 'GlobalNavigationHooks' ] =  __DIR__ . '/GlobalNavigationHooks.class.php';

$wgHooks['OutputPageParserOutput'][] = 'GlobalNavigationHooks::onOutputPageParserOutput';

$wgExtensionMessagesFiles[ 'GlobalNavigation' ] = __DIR__ . '/GlobalNavigation.i18n.php';
