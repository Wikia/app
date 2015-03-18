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


$wgAvailableRights[] = 'njordeditmode';

$wgGroupPermissions[ '*' ][ 'njordeditmode' ] = false;
$wgGroupPermissions[ 'staff' ][ 'njordeditmode' ] = true;
$wgGroupPermissions[ 'sysop' ][ 'njordeditmode' ] = true;
$wgGroupPermissions[ 'bureaucrat' ][ 'njordeditmode' ] = true;
$wgGroupPermissions[ 'helper' ][ 'njordeditmode' ] = true;

NjordHooks::$templateDir = $dir . '/templates';


