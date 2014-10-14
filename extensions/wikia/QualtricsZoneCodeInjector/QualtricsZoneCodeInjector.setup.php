<?php
/**
 * QualtricsZoneCodeInjector
 *
 * @author Bartosz 'V.' Bentkowski
 */

$dir = dirname( __FILE__ ) . '/';

$wgExtensionCredits['other'][] = array(
	'name'        => 'QualtricsZoneCodeInjector',
	'author'      => 'Bartosz "V." Bentkowski',
	'description' => 'QualtricsZoneCodeInjector',
	'version'     => 1
);

$wgAutoloadClasses['QualtricsZoneCodeInjectorHooks'] = $dir . 'QualtricsZoneCodeInjectorHooks.class.php';

	// hooks
$wgHooks['MakeGlobalVariablesScript'][] = 'QualtricsZoneCodeInjectorHooks::onMakeGlobalVariablesScript';
$wgHooks['GetHTMLAfterBody'][]            = 'QualtricsZoneCodeInjectorHooks::onGetHTMLAfterBody';
$wgHooks['OasisSkinAssetGroups'][]        = 'QualtricsZoneCodeInjectorHooks::onOasisSkinAssetGroups';
