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

$wgExtensionCredits['specialpage'][] = [
	'name' => 'Special:Styleguide',
	'description' => 'Extension to present a library of reusable components with usage examples',
	'descriptionmsg' => 'styleguide-descriptionmsg',
	'authors' => [
		'Rafał Leszczyński',
		'Sebastian Marzjan',
	],
	'version' => 1.0
];

// classes
$wgAutoloadClasses['SpecialStyleguideController'] = $dir . 'SpecialStyleguideController.class.php';
$wgAutoloadClasses['SpecialStyleguideDataModel'] = $dir . 'models/SpecialStyleguideDataModel.class.php';

// special page
$wgSpecialPages['Styleguide'] = 'SpecialStyleguideController';
$wgSpecialPageGroups['Styleguide'] = 'wikia';

// message files
$wgExtensionMessagesFiles['SpecialStyleguide'] = $dir . 'SpecialStyleguide.i18n.php';
