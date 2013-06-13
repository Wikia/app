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
$wgAutoloadClasses['SpecialStyleguideController'] = $dir . 'SpecialStyleguideController.class.php';
$wgAutoloadClasses['SpecialStyleguideDataModel'] = $dir . 'models/SpecialStyleguideDataModel.class.php';
$wgAutoloadClasses['iStyleguideSectionDataProvider'] = $dir . 'models/sectiondataproviders/iStyleguideSectionDataProvider.php';
$wgAutoloadClasses['StyleguideFooterSectionDataProvider'] = $dir . 'models/sectiondataproviders/StyleguideFooterSectionDataProvider.class.php';
$wgAutoloadClasses['StyleguideHeaderSectionDataProvider'] = $dir . 'models/sectiondataproviders/StyleguideHeaderSectionDataProvider.class.php';
$wgAutoloadClasses['StyleguideHomePageSectionDataProvider'] = $dir . 'models/sectiondataproviders/StyleguideHomePageSectionDataProvider.class.php';
$wgAutoloadClasses['StyleguideNullSectionDataProvider'] = $dir . 'models/sectiondataproviders/StyleguideNullSectionDataProvider.class.php';

// special page
$wgSpecialPages['Styleguide'] = 'SpecialStyleguideController';
$wgSpecialPageGroups['Styleguide'] = 'wikia';

// message files
$wgExtensionMessagesFiles['SpecialStyleguide'] = $dir . 'SpecialStyleguide.i18n.php';
