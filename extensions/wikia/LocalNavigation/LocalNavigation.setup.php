<?php
/**
 * Local Navigation
 *
 * @author Bogna 'bognix' Knychala
 *
 */

$wgExtensionCredits[ 'specialpage' ][] = [
	'name' => 'LocalNavigation',
	'author' => 'Bogna Knychala',
	'description' => 'LocalNavigation',
	'version' => 1.0
];

// controller classes
$wgAutoloadClasses[ 'LocalNavigationController' ] =  __DIR__ . '/LocalNavigationController.class.php';
$wgAutoloadClasses[ 'LocalNavigationContributeMenuController' ] =  __DIR__ . '/LocalNavigationContributeMenuController.class.php';
