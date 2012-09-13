<?php

$dir = dirname(__FILE__);

$app = F::app();

$app->registerClass('AdEngine2Controller', "$dir/AdEngine2Controller.class.php");

$app->registerHook('WikiaSkinTopScripts', 'AdEngine2Controller', 'onWikiaSkinTopScripts');

// Decide where to load JavaScript files:
if (!empty($wgLoadAdsInHead)) {
	/*
	 * At the top. Here is what we do:
	 *
	 * Remove oasis_shared_core_js from OasisSkinAssetGroups
	 * Add oasis_shared_core_js and adengine2_js to OasisSkinAssetGroupsBlocking
	 */
	$app->registerHook('OasisSkinAssetGroupsBlocking', 'AdEngine2Controller', 'addBlockingAssetGroup');
	$app->registerHook('OasisSkinAssetGroups', 'AdEngine2Controller', 'removeCoreAssetGroup');
} else {
	/*
	 * At the bottom. Here is what we do:
	 *
	 * Add adengine2_js just after oasis_shared_core_js in OasisSkinAssetGroupsBlocking
	 */
	$app->registerHook('OasisSkinAssetGroups', 'AdEngine2Controller', 'addNonBlockingAssetGroup');
}
