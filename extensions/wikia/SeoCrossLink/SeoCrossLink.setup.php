<?php

$dir = dirname( __FILE__ ) . '/';

/**
 * controllers
 */
$wgAutoloadClasses['SeoCrossLinkController'] =  $dir . 'SeoCrossLinkController.class.php';

/**
 * classes
 */
$wgAutoloadClasses['SeoCrossLinkHelper'] =  $dir . 'SeoCrossLinkHelper.class.php';
$wgAutoloadClasses['SeoCrossLinkHooks'] =  $dir . 'SeoCrossLinkHooks.class.php';

/**
 * hooks
 */
$wgHooks['GetRailModuleList'][] = 'SeoCrossLinkHooks::onGetRailModuleList';

/**
 * messages
 */
$wgExtensionMessagesFiles['SeoCrossLink'] = $dir . 'SeoCrossLink.i18n.php';
