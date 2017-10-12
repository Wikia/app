<?php
/**
 * Qualaroo
 *
 * @author Damian Jóźwiak
 */

$dir = dirname( __FILE__ ) . '/';

$wgExtensionCredits['other'][] = array(
	'name'           => 'Qualaroo',
	'author'         => 'Damian Jóźwiak',
	'descriptionmsg' => 'qualaroo-desc',
	'version'        => 1,
	'url'            => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/Qualaroo'
);

$wgAutoloadClasses['QualarooHooks'] = $dir . 'QualarooHooks.class.php';

//i18n

// hooks
$wgHooks['OasisSkinAssetGroupsBlocking'][] = 'QualarooHooks::onOasisSkinAssetGroupsBlocking';
$wgHooks['OasisSkinAssetGroups'][] = 'QualarooHooks::onOasisSkinAssetGroups';
$wgHooks['MakeGlobalVariablesScript'][] = 'QualarooHooks::onMakeGlobalVariablesScript';
$wgHooks['WikiaAssetsPackages'][]  = 'QualarooHooks::onWikiaAssetsPackages';
