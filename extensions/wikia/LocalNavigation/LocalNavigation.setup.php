<?php
/**
 * Local Navigation
 *
 * @author Bogna 'bognix' Knychala
 * @author Bartosz 'V.' Bentkowski
 * @author Łukasz Konieczny
 * @author Mateusz 'Warkot' Warkocki
 *
 */

$wgExtensionCredits[ 'specialpage' ][] = [
	'name' => 'LocalNavigation',
	'author' => [
		'Bogna \'bognix\' Knychala',
		'Bartosz \'V.\' Bentkowski',
		'Łukasz Konieczny',
	],
	'description' => 'LocalNavigation',
	'version' => 1.0
];

// controller classes
$wgAutoloadClasses[ 'LocalNavigationController' ] =  __DIR__ . '/LocalNavigationController.class.php';
$wgAutoloadClasses[ 'LocalNavigationContributeMenuController' ] =  __DIR__ . '/LocalNavigationContributeMenuController.class.php';

$wgExtensionMessagesFiles[ 'LocalNavigation' ] = __DIR__ . '/LocalNavigation.i18n.php';
