<?php

$dir = dirname( __FILE__ ) . '/';

/**
 * controllers
 */
$wgAutoloadClasses['CrosslinkModuleController'] =  $dir . 'CrosslinkModuleController.class.php';

/**
 * classes
 */
$wgAutoloadClasses['CrosslinkModuleHelper'] =  $dir . 'CrosslinkModuleHelper.class.php';
$wgAutoloadClasses['CrosslinkModuleHooks'] =  $dir . 'CrosslinkModuleHooks.class.php';

/**
 * hooks
 */
$wgHooks['GetRailModuleList'][] = 'CrosslinkModuleHooks::onGetRailModuleList';

/**
 * messages
 */
$wgExtensionMessagesFiles['CrosslinkModule'] = $dir . 'CrosslinkModule.i18n.php';
