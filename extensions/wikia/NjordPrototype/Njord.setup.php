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
JSMessages::registerPackage( 'HeroImage', [ 'hero-image-*' ] );

/**
 * classes
 */

$wgAutoloadClasses[ 'NjordHooks' ] = $dir . '/NjordHooks.class.php';
$wgAutoloadClasses[ 'NjordModel' ] = $dir . '/models/NjordModel.class.php';
$wgAutoloadClasses[ 'WikiDataModel' ] = $dir . '/models/WikiDataModel.class.php';
$wgAutoloadClasses[ 'NjordController' ] = $dir . '/NjordController.class.php';

$wgHooks[ 'ParserFirstCallInit' ][ ] = 'NjordHooks::onParserFirstCallInit';

if ( !empty( $wgEnableNjordExtOnNewWikias ) ) {
	$wgHooks[ 'CreateWikiLocalJob-complete' ][ ] = 'NjordHooks::onCreateNewWikiComplete';
}

$wgAvailableRights[ ] = 'njordeditmode';

$wgGroupPermissions[ '*' ][ 'njordeditmode' ] = false;
$wgGroupPermissions[ 'staff' ][ 'njordeditmode' ] = true;
$wgGroupPermissions[ 'sysop' ][ 'njordeditmode' ] = true;
$wgGroupPermissions[ 'bureaucrat' ][ 'njordeditmode' ] = true;
$wgGroupPermissions[ 'helper' ][ 'njordeditmode' ] = true;

NjordHooks::$templateDir = $dir . '/templates';
