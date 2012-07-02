<?php
/**
 * Frequent Pattern Tag Cloud Plug-in
 * Setup file
 *
 * @file
 * @ingroup Extensions
 * @version 1.0
 * @author Tobias Beck, University of Heidelberg
 * @author Andreas Fay, University of Heidelberg
 */

// Alert the user that this is not a valid entry point to MediaWiki if they try to access the special pages file directly.
if ( !defined( 'MEDIAWIKI' ) ) {
	echo <<<EOT
To install this extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/FreqPatternTagCloud/FreqPatternTagCloud.php" );
EOT;
	exit( 1 );
}

define( 'FPTC_PATH_HOME', dirname( __FILE__  ) . '/' );
define( 'FPTC_PATH_INCLUDES', dirname( __FILE__ ) . '/includes/' );
define( 'FPTC_PATH_RESOURCES', dirname( __FILE__ ) . '/res/' );

// Register extension with Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'author' => array( 'Tobias Beck', 'Andreas Fay' ),
	'version' => '1.0',
	'name' => 'FreqPatternTagCloud',
	'descriptionmsg' => 'freqpatterntagcloud-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:FrequentPatternTagCloud',
);

// Register hook to prepare header files
$wgHooks['BeforePageDisplay'][] = 'fptc_initializeHeaders';

$wgHooks['LoadExtensionSchemaUpdates'][] = 'fptc_applySchemaChanges';

// Register files
$wgAutoloadClasses['FreqPatternTagCloud'] = FPTC_PATH_HOME . 'FreqPatternTagCloud.body.php';
$wgExtensionMessagesFiles['FreqPatternTagCloud'] = FPTC_PATH_HOME . 'FreqPatternTagCloud.i18n.php';
$wgSpecialPages['FreqPatternTagCloud'] = 'FreqPatternTagCloud';

$wgAutoloadClasses['FreqPatternTagCloudMaintenance'] = FPTC_PATH_HOME . 'FreqPatternTagCloudMaintenance.php';
$wgSpecialPages['FreqPatternTagCloudMaintenance'] = 'FreqPatternTagCloudMaintenance';

// Register AJAX functions
$wgAjaxExportList[] = 'FreqPatternTagCloud::getAttributeSuggestions';
$wgAjaxExportList[] = 'FreqPatternTagCloud::getSearchSuggestions';
$wgAjaxExportList[] = 'FreqPatternTagCloud::getSuggestions';

include_once( FPTC_PATH_INCLUDES . 'FrequentPattern.php' );

# Configuration settings
// Add search modification for suggestions using frequent pattern mining
// Configuration
// Activate on default
$wgFreqPatternTagCloudSearchBarModification = true;

/**
 * Initializes page headers
 *
 * @return bool Success
 */
function fptc_initializeHeaders() {
	global $wgOut, $wgScriptPath, $wgFreqPatternTagCloudSearchBarModification;

	// Add jQuery & jQuery UI
	// @todo FIXME: this should use ResourceLoader and the appropriate core
	// functions instead of using its own jQuery etc.
	$wgOut->addExtensionStyle( $wgScriptPath.'/extensions/FreqPatternTagCloud/stylesheets/jquery/ui-lightness/jquery-ui-1.8.custom.css' );
	#$wgOut->addScriptFile( $wgScriptPath . '/extensions/FreqPatternTagCloud/javascripts/jquery-1.4.2.min.js' );
	$wgOut->addScriptFile( $wgScriptPath . '/extensions/FreqPatternTagCloud/javascripts/jquery.parseJSON.js' );
	$wgOut->addScriptFile( $wgScriptPath . '/extensions/FreqPatternTagCloud/javascripts/jquery-ui-1.8.custom.min.js' );

	if ( $wgFreqPatternTagCloudSearchBarModification ) {
		$wgOut->addExtensionStyle( $wgScriptPath.'/extensions/FreqPatternTagCloud/stylesheets/search.css' );
		$wgOut->addScriptFile( $wgScriptPath . '/extensions/FreqPatternTagCloud/javascripts/search.js' );
	}

	// Add freq pattern tag cloud
	$wgOut->addExtensionStyle( $wgScriptPath . '/extensions/FreqPatternTagCloud/stylesheets/jquery.contextMenu.css' );
	$wgOut->addExtensionStyle( $wgScriptPath . '/extensions/FreqPatternTagCloud/stylesheets/main.css' );
	$wgOut->addScriptFile( $wgScriptPath . '/extensions/FreqPatternTagCloud/javascripts/jquery.contextMenu.js' );
	$wgOut->addScriptFile( $wgScriptPath . '/extensions/FreqPatternTagCloud/javascripts/main.js' );

	return true;
}


/**
 * Applies the schema changes when the user runs maintenance/update.php.
 *
 * @param $updater Object: instance of DatabaseUpdater
 * @return Boolean: true
 */
function fptc_applySchemaChanges( $updater = null ) {
	$dir = dirname( __FILE__ );
	$file = "$dir/freqpatterntagcloud.sql";
	if ( $updater === null ) {
		global $wgExtNewTables;
		$wgExtNewTables[] = array( 'fptc_associationrules', $file );
		$wgExtNewTables[] = array( 'fptc_items', $file );
	} else {
		$updater->addExtensionUpdate( array( 'addTable', 'fptc_associationrules', $file, true ) );
		$updater->addExtensionUpdate( array( 'addTable', 'fptc_items', $file, true ) );
	}
	return true;
}