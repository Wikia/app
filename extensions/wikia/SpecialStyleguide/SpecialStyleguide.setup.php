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

$wgExtensionCredits['specialpage'][] = [
	'name' => 'Special:Styleguide',
	'description' => 'Extension to present a library of reusable components with usage examples',
	'descriptionmsg' => 'styleguide-descriptionmsg',
	'authors' => [
		'Sebastian Marzjan',
		'Rafał Leszczyński',
		"Andrzej 'nAndy' Łukaszewski",
		"Jacek 'mech' Woźniak",
	],
	'version' => 1.0,
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/SpecialStyleguide'
];

// classes
$wgAutoloadClasses['SpecialStyleguideController'] = $dir . 'SpecialStyleguideController.class.php';
$wgAutoloadClasses['SpecialStyleguideDataModel'] = $dir . 'models/SpecialStyleguideDataModel.class.php';
$wgAutoloadClasses['StyleguideComponents'] = $dir . 'helpers/StyleguideComponents.class.php';

// special page
$wgSpecialPages['Styleguide'] = 'SpecialStyleguideController';
$wgSpecialPageGroups['Styleguide'] = 'wikia';

// message files
$wgExtensionMessagesFiles['SpecialStyleguide'] = $dir . 'SpecialStyleguide.i18n.php';
JSMessages::registerPackage( 'SpecialStyleguide', [
	'styleguide-show-parameters',
	'styleguide-hide-parameters',
	'styleguide-example-modal-*',
] );

$wgHooks['BeforeExtensionMessagesRecache'][] = 'StyleguideComponents::onBeforeExtensionMessagesRecache';
