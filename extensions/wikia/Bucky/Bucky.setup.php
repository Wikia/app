<?php
/**
 * Real User Monitoring
 *
 * @author wladek
 */

$dir = dirname(__FILE__) . '/';

$wgAutoloadClasses['Bucky'] =  $dir . 'Bucky.class.php';

$wgHooks['SkinAfterBottomScripts'][] = 'Bucky::onSkinAfterBottomScripts';
$wgHooks['OasisSkinAssetGroups'][] = 'Bucky::onOasisSkinAssetGroups';
