<?php
/**
 * @author Sean Colombo
 * @date 20120501
 *
 * Extension which helps with running A/B tests or Split Tests (can actually be a/b/c/d/etc. as needed).
 *
 * This is the new system which is powered by our data warehouse.
 */

if ( !defined( 'MEDIAWIKI' ) ) die();

$dir = dirname( __FILE__ );
$wgAutoloadClasses['AbTesting'] = "$dir/AbTesting.class.php";
$wgExtensionMessagesFiles['AbTesting'] = "$dir/AbTesting.i18n.php";
$wgExtensionCredits['other'][] = array(
	'name' => 'A/B Testing',
	//'url' => '',
	'author' => '[http://www.seancolombo.com Sean Colombo]',
	'descriptionmsg' => 'abtesting-desc',
	'version' => '1.0',
);

// Embed the experiment/treatment config in the head scripts.
$wgHooks['SkinGetHeadScripts'][] = 'AbTesting::onSkinGetHeadScripts';
$wgHooks['WikiaMobileAssetsPackages'][] = 'AbTesting::onWikiaMobileAssetsPackages';

$app = F::app();
$app->registerClass('SpecialAbTestingController', $dir . '/SpecialAbTestingController.class.php' );
$app->registerSpecialPage('AbTesting', 'SpecialAbTestingController');
$wgAvailableRights[] = 'abtestpanel';
$wgGroupPermissions['staff']['abtestpanel'] = true;

