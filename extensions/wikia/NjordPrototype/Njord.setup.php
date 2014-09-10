<?php
/**
 * This extension handles Modular Main Pages
 * prototype
 */
$dir = dirname( __FILE__ );

/**
 * classes
 */

$wgAutoloadClasses['NjordHooks'] =  $dir . '/NjordHooks.class.php';
$wgAutoloadClasses['NjordModel'] =  $dir . '/models/NjordModel.class.php';
$wgAutoloadClasses['WikiDataModel'] =  $dir . '/models/WikiDataModel.class.php';
$wgAutoloadClasses['NjordController'] =  $dir . '/NjordController.class.php';

$wgHooks['ParserFirstCallInit'][] = 'NjordHooks::onParserFirstCallInit';

if ( !empty( $wgEnableNjordExtOnNewWikias ) ) {
	$wgHooks['CreateWikiLocalJob-complete'][] = 'NjordHooks::onCreateNewWikiComplete';
}

NjordHooks::$templateDir = $dir . '/templates';
