<?php
/**
 * This extension handles Modular Main Pages
 * prototype
 */
$dir = dirname( __FILE__ );

/**
 * messages
 */
$wgExtensionMessagesFiles[ 'Njord' ] = $dir . '/Njord.i18n.php';

/**
 * classes
 */
$wgAutoloadClasses['NjordModel'] =  $dir . '/models/NjordModel.class.php';
$wgAutoloadClasses['NjordController'] =  $dir . '/NjordController.class.php';

/**
 * Hooks
 */
$wgHooks['WikiFeatures::onToggleFeature'][] = 'NjordHooks::purgeMainPage';
$wgHooks[ 'SkinAfterBottomScripts' ][] = 'NjordHooks::onSkinAfterBottomScripts';

NjordHooks::$templateDir = $dir . '/templates';


