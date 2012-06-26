<?php
/**
 * @author Sean Colombo
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

$app = F::app();
$dir = dirname( __FILE__ );

/**
 * info
 */
$app->wg->append(
	'wgExtensionCredits',
	array(
		'name' => 'A/B Testing',
		'author' => '[http://www.seancolombo.com Sean Colombo]',
		'descriptionmsg' => 'abtesting-desc',
		'version' => '1.0',
	),
	'other'
);

/**
 * classes
 */
$app->wg->set( 'wgAutoloadClasses', "{$dir}/AbTesting.class.php", 'AbTesting' );

/**
 * message files
 */
$app->wg->set( 'wgExtensionMessagesFiles', "{$dir}/AbTesting.i18n.php", 'AbTesting' );

/**
 * special pages
 */
$app->registerClass('SpecialAbTestingController', $dir . '/SpecialAbTestingController.class.php' );
$app->registerSpecialPage('AbTesting', 'SpecialAbTestingController');

/**
 * rights
 */
$wgAvailableRights[] = 'abtestpanel';
$wgGroupPermissions['staff']['abtestpanel'] = true;

/**
 * hooks
 */
$app->registerHook( 'SkinGetHeadScripts', 'AbTesting', 'onSkinGetHeadScripts');

//AbTesting is an Oasis-only experiment for now
//$app->registerHook( 'WikiaMobileAssetsPackages', 'AbTesting', 'onWikiaMobileAssetsPackages' );