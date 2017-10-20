<?php
/**
 * Gadgets extension - lets users select custom javascript gadgets
 *
 * For more info see http://mediawiki.org/wiki/Extension:Gadgets
 *
 * @file
 * @ingroup Extensions
 * @author Daniel Kinzler, brightbyte.de
 * @copyright © 2007 Daniel Kinzler
 * @license GNU General Public Licence 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

if ( version_compare( $wgVersion, '1.18alpha', '<' ) ) {
	die( "This version of Extension:Gadgets requires MediaWiki 1.18+\n" );
}

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Gadgets',
	'author' => array( 'Daniel Kinzler', 'Max Semenik' ),
	'url' => 'http://mediawiki.org/wiki/Extension:Gadgets',
	'descriptionmsg' => 'gadgets-desc',
);

$wgHooks['ArticleSaveComplete'][]           = 'GadgetHooks::articleSaveComplete';
$wgHooks['BeforePageDisplay'][]             = 'GadgetHooks::beforePageDisplay';
$wgHooks['UserGetDefaultOptions'][]         = 'GadgetHooks::userGetDefaultOptions';
$wgHooks['GetPreferences'][]                = 'GadgetHooks::getPreferences';
$wgHooks['ResourceLoaderRegisterModules'][] = 'GadgetHooks::registerModules';
$wgHooks['UnitTestsList'][]                 = 'GadgetHooks::unitTestsList';

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['Gadgets'] = $dir . 'Gadgets.i18n.php';
$wgExtensionMessagesFiles['GadgetsAlias'] = $dir . 'Gadgets.alias.php';

$wgAutoloadClasses['ApiQueryGadgetCategories'] = $dir . 'ApiQueryGadgetCategories.php';
$wgAutoloadClasses['ApiQueryGadgets'] = $dir . 'ApiQueryGadgets.php';
$wgAutoloadClasses['Gadget'] = $dir . 'Gadgets_body.php';
$wgAutoloadClasses['GadgetHooks'] = $dir . 'Gadgets_body.php';
$wgAutoloadClasses['GadgetResourceLoaderModule'] = $dir . 'Gadgets_body.php';
$wgAutoloadClasses['SpecialGadgets'] = $dir . 'SpecialGadgets.php';

$wgSpecialPages['Gadgets'] = 'SpecialGadgets';
$wgSpecialPageGroups['Gadgets'] = 'wiki';

$wgAPIListModules['gadgetcategories'] = 'ApiQueryGadgetCategories';
$wgAPIListModules['gadgets'] = 'ApiQueryGadgets';
