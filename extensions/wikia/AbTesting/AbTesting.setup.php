<?php
/**
 * @author Sean Colombo
 * @author Władysław Bodzek
 * @author Piotr Bablok
 * @date 20120501
 *
 * Extension which helps with running A/B tests or Split Tests (can actually be a/b/c/d/etc. as needed).
 *
 * This is the new system which is powered by our data warehouse.
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This file is part of MediaWiki, it is not a valid entry point.\n";
	exit( 1 );
}

$dir = dirname( __FILE__ );

/**
 * info
 */
$wgExtensionCredits['other'][] =
	array(
		'name' => 'A/B Testing',
		'author' => array(
			'[http://www.seancolombo.com Sean Colombo]',
			'Władysław Bodzek',
			'Kyle Florence',
			'Piotr Bablok'
		),
		'descriptionmsg' => 'abtesting-desc',
		'version' => '1.0',
		'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/AbTesting',
	);

/**
 * classes
 */
$wgAutoloadClasses['AbTesting'] = "{$dir}/AbTesting.class.php";
$wgAutoloadClasses['AbTestingData'] = "{$dir}/AbTestingData.class.php";
$wgAutoloadClasses['ResourceLoaderAbTestingModule'] = "{$dir}/ResourceLoaderAbTestingModule.class.php";
$wgAutoloadClasses['SpecialAbTestingController'] = "{$dir}/SpecialAbTestingController.class.php";
$wgAutoloadClasses['AbTestingController'] = "{$dir}/AbTestingController.class.php";

/**
 * message files
 */
$wgExtensionMessagesFiles['AbTesting'] = "{$dir}/AbTesting.i18n.php";

// Embed the experiment/treatment config in the head scripts.
$wgHooks['WikiaSkinTopScripts'][] =  'AbTesting::onWikiaSkinTopScripts';
$wgHooks['WikiaSkinTopShortTTLModules'][] =  'AbTesting::onWikiaSkinTopShortTTLModules';
$wgHooks['WikiaMobileAssetsPackages'][] = 'AbTesting::onWikiaMobileAssetsPackages';
// Add js code in Oasis
$wgHooks['OasisSkinAssetGroupsBlocking'][] = 'AbTesting::onOasisSkinAssetGroupsBlocking';

// Register Resource Loader module
$wgResourceModules['wikia.ext.abtesting'] = array(
	'class' => 'ResourceLoaderAbTestingModule',
);

$wgResourceModules['wikia.ext.abtest'] = array(
	'scripts' => array(
		'extensions/wikia/AbTesting/js/AbTest.js',
	)
);

$wgResourceModules['wikia.ext.abtesting.edit.styles'] = array(
	'styles' => array(
		'extensions/wikia/AbTesting/css/AbTestEditor.scss',
		'resources/jquery.ui/themes/default/jquery.ui.core.css',
		'resources/jquery.ui/themes/default/jquery.ui.datepicker.css',
		'resources/jquery.ui/themes/default/jquery.ui.slider.css',
		'resources/jquery.ui/themes/default/jquery.ui.theme.css',
		'resources/wikia/libraries/jquery-ui/themes/default/jquery.ui.timepicker.css',
	),
);

$wgResourceModules['wikia.ext.abtesting.edit'] = array(
	'scripts' => array(
		'extensions/wikia/AbTesting/js/AbTestEditor.js',
		'resources/jquery.ui/jquery.ui.core.js',
		'resources/jquery.ui/jquery.ui.widget.js',
		'resources/jquery.ui/jquery.ui.datepicker.js',
		'resources/jquery.ui/jquery.ui.mouse.js',
		'resources/jquery.ui/jquery.ui.slider.js',
		'resources/wikia/libraries/jquery-ui/jquery.ui.timepicker.js',
	),
	'messages' => array(
		'abtesting-add-experiment-title',
		'abtesting-edit-experiment-title'
	)
);

//AbTesting is an Oasis-only experiment for now
//$wgHooks['WikiaMobileAssetsPackages'][] = 'AbTesting::onWikiaMobileAssetsPackages';

$wgSpecialPages[ 'AbTesting'] = 'SpecialAbTestingController';

