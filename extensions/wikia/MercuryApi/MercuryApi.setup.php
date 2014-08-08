<?php
/**
 * Mercury API Extension
 *
 * @author Evgeniy 'aquilax' Vasilev
 */
$dir = dirname(__FILE__) . '/';

$wgExtensionCredits['api'][] = [
	'name' => 'Mercury API',
	'description' => 'This extensions provides API classes for the Mercury project',
	'authors' => array(
		'Evgeniy "aquilax" Vasilev',
	),
	'version' => 1.0
];

// Load needed classes
$wgAutoloadClasses[ 'MercuryApiController' ] = $dir . '/MercuryApiController.class.php';

// model classes
$wgAutoloadClasses[ 'MercuryApi' ] = $dir . '/models/MercuryApi.class.php';
$wgAutoloadClasses[ 'MercuryAnnotation' ] = $dir . '/models/MercuryAnnotation.class.php';

// Add new API controller to API controllers list
$wgWikiaApiControllers[ 'MercuryApiController' ] = $dir . '/MercuryApiController.class.php';
