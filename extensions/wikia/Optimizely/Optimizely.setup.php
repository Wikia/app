<?php
/**
 * Optimizely setup
 *
 * @author Damian Jóźwiak
 * @author Bartosz "V." Bentkowski
 *
 */
$dir = dirname(__FILE__) . '/';

$wgExtensionCredits['other'][] = array(
	'name'        => 'Optimizely',
	'author'      => ['Damian Jóźwiak', 'Bartosz "V." Bentkowski'],
	'description' => 'Optimizely loader',
	'version'     => 1
);

//classes
$wgAutoloadClasses['Optimizely'] =  $dir . 'Optimizely.class.php';

// hooks
$wgHooks['WikiaSkinTopScripts'][] = 'Optimizely::onWikiaSkinTopScripts';
$wgHooks['OasisSkinAssetGroupsBlocking'][] = 'Optimizely::onOasisSkinAssetGroupsBlocking';
$wgHooks['WikiaMobileAssetsPackages'][] = 'Optimizely::onWikiaMobileAssetsPackages';
