<?php
/**
 * Local Navigation
 *
 * @author Bogna 'bognix' Knychala
 * @author Bartosz 'V.' Bentkowski
 *
 */

$wgExtensionCredits[ 'specialpage' ][] = [
	'name' => 'LocalNavigation',
	'author' => ['Bogna \'bognix\' Knychala',
		'Bartosz \'V.\' Bentkowski'],
	'description' => 'LocalNavigation',
	'version' => 1.0
];

// controller classes
$wgAutoloadClasses[ 'LocalNavigationController' ] =  __DIR__ . '/LocalNavigationController.class.php';
