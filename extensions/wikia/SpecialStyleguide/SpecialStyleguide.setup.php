<?php

/**
 * Special:Styleguide
 * extension to present a library of reusable components with usage examples
 *
 * @author Rafał Leszczyński
 * @author Sebastian Marzjan
 *
 */

$dir = dirname( __FILE__ ) . '/';
$app = F::app();

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Special:Styleguide',
	'description' => 'Extension to present a library of reusable components with usage examples',
	'descriptionmsg' => 'styleguide-descriptionmsg',
	'authors' => array(
		'Rafał Leszczyński',
		'Sebastian Marzjan',
	),
	'version' => 1.0
);

// classes
$app->registerController( 'SpecialStyleguideController', $dir . 'SpecialStyleguideController.class.php' );

// special page
$app->registerSpecialPage( 'Styleguide', 'SpecialStyleguideController', 'wikia' );

// message files
$app->registerExtensionMessageFile( 'SpecialStyleguide', $dir . 'SpecialStyleguide.i18n.php' );
